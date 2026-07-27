<?php

namespace Tests\Feature\Filament\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class UserIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');

        $this->superAdmin = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $this->actingAs($this->superAdmin);
    }

    public function test_super_admin_can_create_admin_account(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Admin Konten',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => 'password-rahasia',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::query()
            ->where('email', 'admin@example.com')
            ->firstOrFail();

        $this->assertSame('Admin Konten', $user->name);
        $this->assertSame('admin', $user->role);
        $this->assertTrue(
            Hash::check('password-rahasia', $user->password),
        );
    }

    public function test_role_defaults_to_admin_when_creating_account(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Admin Default',
                'email' => 'default@example.com',
                'password' => 'password-rahasia',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'default@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_password_is_required_when_creating_account(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Admin Tanpa Password',
                'email' => 'tanpa-password@example.com',
                'role' => 'admin',
                'password' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'password' => 'required',
            ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'tanpa-password@example.com',
        ]);
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'sama@example.com',
            'role' => 'admin',
        ]);

        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Admin Duplikat',
                'email' => 'sama@example.com',
                'role' => 'admin',
                'password' => 'password-rahasia',
            ])
            ->call('create')
            ->assertHasFormErrors([
                'email' => 'unique',
            ]);
    }

    public function test_edit_without_new_password_keeps_existing_password(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Lama',
            'email' => 'lama@example.com',
            'password' => Hash::make('password-lama'),
            'role' => 'admin',
        ]);

        $oldPassword = $admin->password;

        Livewire::test(EditUser::class, [
            'record' => $admin->getRouteKey(),
        ])
            ->fillForm([
                'name' => 'Admin Baru',
                'email' => 'baru@example.com',
                'role' => 'admin',
                'password' => null,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $admin->refresh();

        $this->assertSame('Admin Baru', $admin->name);
        $this->assertSame('baru@example.com', $admin->email);
        $this->assertSame($oldPassword, $admin->password);
        $this->assertTrue(
            Hash::check('password-lama', $admin->password),
        );
    }

    public function test_password_can_be_changed_when_editing_account(): void
    {
        $admin = User::factory()->create([
            'password' => Hash::make('password-lama'),
            'role' => 'admin',
        ]);

        Livewire::test(EditUser::class, [
            'record' => $admin->getRouteKey(),
        ])
            ->fillForm([
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'admin',
                'password' => 'password-baru',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $admin->refresh();

        $this->assertTrue(
            Hash::check('password-baru', $admin->password),
        );

        $this->assertFalse(
            Hash::check('password-lama', $admin->password),
        );
    }

    public function test_super_admin_cannot_demote_own_role(): void
    {
        Livewire::test(EditUser::class, [
            'record' => $this->superAdmin->getRouteKey(),
        ])
            ->assertFormFieldDisabled('role')
            ->fillForm([
                'name' => $this->superAdmin->name,
                'email' => $this->superAdmin->email,
                'role' => 'admin',
                'password' => null,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(
            'super_admin',
            $this->superAdmin->fresh()->role,
        );
    }

    public function test_super_admin_cannot_delete_own_account(): void
    {
        $this->assertFalse(
            UserResource::canDelete($this->superAdmin),
        );

        $this->assertDatabaseHas('users', [
            'id' => $this->superAdmin->getKey(),
        ]);
    }

    public function test_last_super_admin_cannot_be_deleted(): void
    {
        $this->assertSame(
            1,
            User::query()
                ->where('role', 'super_admin')
                ->count(),
        );

        $this->assertFalse(
            UserResource::canDelete($this->superAdmin),
        );
    }

    public function test_other_admin_account_can_be_deleted(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->assertTrue(
            UserResource::canDelete($admin),
        );

        Livewire::test(EditUser::class, [
            'record' => $admin->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('users', [
            'id' => $admin->getKey(),
        ]);
    }

    public function test_other_super_admin_can_be_deleted_when_another_remains(): void
    {
        $otherSuperAdmin = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $this->assertTrue(
            UserResource::canDelete($otherSuperAdmin),
        );

        Livewire::test(EditUser::class, [
            'record' => $otherSuperAdmin->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('users', [
            'id' => $otherSuperAdmin->getKey(),
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->superAdmin->getKey(),
            'role' => 'super_admin',
        ]);
    }

    public function test_regular_admin_cannot_manage_user_resource(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $this->assertFalse(
            UserResource::canViewAny(),
        );

        $this->assertFalse(
            UserResource::canCreate(),
        );

        $this->assertFalse(
            UserResource::canEdit($this->superAdmin),
        );

        $this->assertFalse(
            UserResource::canDelete($this->superAdmin),
        );
    }

    public function test_super_admin_can_manage_user_resource(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->assertTrue(
            UserResource::canViewAny(),
        );

        $this->assertTrue(
            UserResource::canCreate(),
        );

        $this->assertTrue(
            UserResource::canEdit($admin),
        );

        $this->assertTrue(
            UserResource::canDelete($admin),
        );

        $this->assertFalse(
            UserResource::canDeleteAny(),
        );
    }
}
