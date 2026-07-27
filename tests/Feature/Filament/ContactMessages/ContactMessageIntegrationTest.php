<?php

namespace Tests\Feature\Filament\ContactMessages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\ContactMessages\Pages\EditContactMessage;
use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Models\ContactMessage;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactMessageIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');

        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ])
        );
    }

    public function test_contact_messages_cannot_be_created_from_resource(): void
    {
        $this->assertFalse(
            ContactMessageResource::canCreate(),
        );

        $this->assertArrayNotHasKey(
            'create',
            ContactMessageResource::getPages(),
        );

        Livewire::test(ListContactMessages::class)
            ->assertSuccessful();
    }

    public function test_new_contact_message_defaults_to_unread(): void
    {
        $message = ContactMessage::query()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'subject' => 'Pertanyaan Sekolah',
            'message' => 'Saya ingin menanyakan informasi sekolah.',
        ]);

        $message->refresh();

        $this->assertFalse($message->is_read);

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->getKey(),
            'is_read' => false,
        ]);
    }

    public function test_sender_and_message_fields_are_read_only(): void
    {
        $message = $this->createMessage([
            'name' => 'Nama Asli',
            'email' => 'asli@example.com',
            'phone' => '081234567890',
            'subject' => 'Subjek Asli',
            'message' => 'Isi pesan asli.',
            'ip_address' => '127.0.0.1',
            'is_read' => false,
        ]);

        Livewire::test(EditContactMessage::class, [
            'record' => $message->getRouteKey(),
        ])
            ->assertFormFieldDisabled('name')
            ->assertFormFieldDisabled('email')
            ->assertFormFieldDisabled('phone')
            ->assertFormFieldDisabled('ip_address')
            ->assertFormFieldDisabled('subject')
            ->assertFormFieldDisabled('message')
            ->fillForm([
                'name' => 'Nama Diubah',
                'email' => 'diubah@example.com',
                'phone' => '089999999999',
                'subject' => 'Subjek Diubah',
                'message' => 'Isi pesan diubah.',
                'ip_address' => '192.168.1.1',
                'is_read' => true,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $message->refresh();

        $this->assertSame('Nama Asli', $message->name);
        $this->assertSame('asli@example.com', $message->email);
        $this->assertSame('081234567890', $message->phone);
        $this->assertSame('Subjek Asli', $message->subject);
        $this->assertSame('Isi pesan asli.', $message->message);
        $this->assertSame('127.0.0.1', $message->ip_address);
        $this->assertTrue($message->is_read);
    }

    public function test_read_status_can_be_changed(): void
    {
        $message = $this->createMessage([
            'is_read' => false,
        ]);

        Livewire::test(EditContactMessage::class, [
            'record' => $message->getRouteKey(),
        ])
            ->fillForm([
                'is_read' => true,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue(
            $message->fresh()->is_read,
        );
    }

    public function test_unread_scope_returns_only_unread_messages(): void
    {
        $unreadMessage = $this->createMessage([
            'subject' => 'Pesan Belum Dibaca',
            'is_read' => false,
        ]);

        $this->createMessage([
            'subject' => 'Pesan Sudah Dibaca',
            'is_read' => true,
        ]);

        $this->assertSame(
            [$unreadMessage->getKey()],
            ContactMessage::query()
                ->unread()
                ->pluck('id')
                ->all(),
        );
    }

    public function test_read_scope_returns_only_read_messages(): void
    {
        $this->createMessage([
            'subject' => 'Pesan Belum Dibaca',
            'is_read' => false,
        ]);

        $readMessage = $this->createMessage([
            'subject' => 'Pesan Sudah Dibaca',
            'is_read' => true,
        ]);

        $this->assertSame(
            [$readMessage->getKey()],
            ContactMessage::query()
                ->read()
                ->pluck('id')
                ->all(),
        );
    }

    public function test_message_can_be_soft_deleted_from_edit_page(): void
    {
        $message = $this->createMessage();

        Livewire::test(EditContactMessage::class, [
            'record' => $message->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertSoftDeleted('contact_messages', [
            'id' => $message->getKey(),
        ]);
    }

    public function test_message_can_be_soft_deleted_from_list_page(): void
    {
        $message = $this->createMessage();

        Livewire::test(ListContactMessages::class)
            ->callTableAction(
                'delete',
                $message,
            );

        $this->assertSoftDeleted('contact_messages', [
            'id' => $message->getKey(),
        ]);
    }

    public function test_soft_deleted_message_can_be_restored_from_list_page(): void
    {
        $message = $this->createMessage();

        $message->delete();

        $this->assertSoftDeleted('contact_messages', [
            'id' => $message->getKey(),
        ]);

        Livewire::test(ListContactMessages::class)
            ->filterTable('trashed', false)
            ->callTableAction(
                'restore',
                $message,
            );

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->getKey(),
            'deleted_at' => null,
        ]);
    }

    public function test_super_admin_can_force_delete_message_from_list_page(): void
    {
        $message = $this->createMessage();

        $message->delete();

        Livewire::test(ListContactMessages::class)
            ->filterTable('trashed', false)
            ->callTableAction(
                'forceDelete',
                $message,
            );

        $this->assertDatabaseMissing('contact_messages', [
            'id' => $message->getKey(),
        ]);
    }

    public function test_force_delete_is_limited_to_super_admin(): void
    {
        $message = $this->createMessage();

        $message->delete();

        $this->actingAs(
            User::factory()->create([
                'role' => 'admin',
            ])
        );

        $this->assertFalse(
            ContactMessageResource::canForceDelete($message),
        );

        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ])
        );

        $this->assertTrue(
            ContactMessageResource::canForceDelete($message),
        );
    }

    public function test_read_status_filter_works(): void
    {
        $unreadMessage = $this->createMessage([
            'subject' => 'Belum Dibaca',
            'is_read' => false,
        ]);

        $readMessage = $this->createMessage([
            'subject' => 'Sudah Dibaca',
            'is_read' => true,
        ]);

        Livewire::test(ListContactMessages::class)
            ->filterTable('is_read', 0)
            ->assertCanSeeTableRecords([
                $unreadMessage,
            ])
            ->assertCanNotSeeTableRecords([
                $readMessage,
            ]);

        Livewire::test(ListContactMessages::class)
            ->filterTable('is_read', 1)
            ->assertCanSeeTableRecords([
                $readMessage,
            ])
            ->assertCanNotSeeTableRecords([
                $unreadMessage,
            ]);
    }

    public function test_trashed_filter_can_show_only_deleted_messages(): void
    {
        $activeMessage = $this->createMessage([
            'subject' => 'Pesan Aktif',
        ]);

        $trashedMessage = $this->createMessage([
            'subject' => 'Pesan Terhapus',
        ]);

        $trashedMessage->delete();

        Livewire::test(ListContactMessages::class)
            ->filterTable('trashed', false)
            ->assertCanSeeTableRecords([
                $trashedMessage,
            ])
            ->assertCanNotSeeTableRecords([
                $activeMessage,
            ]);
    }

    public function test_admin_and_super_admin_can_manage_contact_messages(): void
    {
        $message = $this->createMessage();

        foreach (['admin', 'super_admin'] as $role) {
            $this->actingAs(
                User::factory()->create([
                    'role' => $role,
                ])
            );

            $this->assertTrue(
                ContactMessageResource::canViewAny(),
            );

            $this->assertFalse(
                ContactMessageResource::canCreate(),
            );

            $this->assertTrue(
                ContactMessageResource::canEdit($message),
            );

            $this->assertTrue(
                ContactMessageResource::canDelete($message),
            );

            $this->assertTrue(
                ContactMessageResource::canRestore($message),
            );

            $this->assertFalse(
                ContactMessageResource::canDeleteAny(),
            );

            $this->assertFalse(
                ContactMessageResource::canForceDeleteAny(),
            );
        }
    }

    private function createMessage(
        array $attributes = [],
    ): ContactMessage {
        return ContactMessage::query()->create(
            array_merge([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => null,
                'subject' => fake()->sentence(4),
                'message' => fake()->paragraph(),
                'is_read' => false,
                'ip_address' => '127.0.0.1',
            ], $attributes)
        );
    }
}
