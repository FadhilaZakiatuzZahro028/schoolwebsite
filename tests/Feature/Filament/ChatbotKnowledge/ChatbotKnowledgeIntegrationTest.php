<?php

namespace Tests\Feature\Filament\ChatbotKnowledge;

use App\Filament\Resources\ChatbotKnowledge\ChatbotKnowledgeResource;
use App\Filament\Resources\ChatbotKnowledge\Pages\CreateChatbotKnowledge;
use App\Filament\Resources\ChatbotKnowledge\Pages\EditChatbotKnowledge;
use App\Filament\Resources\ChatbotKnowledge\Pages\ListChatbotKnowledge;
use App\Models\ChatbotKnowledge;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ChatbotKnowledgeIntegrationTest extends TestCase
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

    public function test_admin_can_create_chatbot_knowledge(): void
    {
        $this->actingAs(
            User::factory()->create([
                'role' => 'admin',
            ])
        );

        Livewire::test(CreateChatbotKnowledge::class)
            ->fillForm([
                'keywords' => 'alamat, lokasi sekolah',
                'answer' => 'Alamat sekolah tersedia pada halaman kontak.',
                'category' => 'alamat',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('chatbot_knowledges', [
            'keywords' => 'alamat, lokasi sekolah',
            'category' => 'alamat',
            'is_active' => true,
        ]);
    }

    public function test_super_admin_can_create_chatbot_knowledge(): void
    {
        Livewire::test(CreateChatbotKnowledge::class)
            ->fillForm([
                'keywords' => 'profil, tentang sekolah',
                'answer' => 'Profil sekolah tersedia pada halaman profil.',
                'category' => 'profil',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('chatbot_knowledges', [
            'keywords' => 'profil, tentang sekolah',
            'category' => 'profil',
            'is_active' => true,
        ]);
    }

    public function test_category_defaults_to_umum(): void
    {
        Livewire::test(CreateChatbotKnowledge::class)
            ->fillForm([
                'keywords' => 'informasi sekolah',
                'answer' => 'Silakan tanyakan informasi sekolah yang dibutuhkan.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $knowledge = ChatbotKnowledge::query()->firstOrFail();

        $this->assertSame('umum', $knowledge->category);
    }

    public function test_status_defaults_to_active(): void
    {
        Livewire::test(CreateChatbotKnowledge::class)
            ->fillForm([
                'keywords' => 'jam layanan',
                'answer' => 'Jam layanan dapat dilihat pada halaman kontak.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $knowledge = ChatbotKnowledge::query()->firstOrFail();

        $this->assertTrue($knowledge->is_active);
    }

    public function test_spmb_category_can_be_saved(): void
    {
        Livewire::test(CreateChatbotKnowledge::class)
            ->fillForm([
                'keywords' => 'spmb, pendaftaran siswa baru',
                'answer' => 'Informasi SPMB tersedia pada halaman SPMB.',
                'category' => 'spmb',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('chatbot_knowledges', [
            'category' => 'spmb',
        ]);
    }

    public function test_category_scope_returns_only_selected_category(): void
    {
        $spmbKnowledge = $this->createKnowledge([
            'keywords' => 'informasi spmb',
            'category' => 'spmb',
        ]);

        $this->createKnowledge([
            'keywords' => 'alamat sekolah',
            'category' => 'alamat',
        ]);

        $this->assertSame(
            [$spmbKnowledge->getKey()],
            ChatbotKnowledge::query()
                ->category('spmb')
                ->pluck('id')
                ->all(),
        );
    }

    public function test_active_scope_returns_only_active_knowledge(): void
    {
        $activeKnowledge = $this->createKnowledge([
            'keywords' => 'faq aktif',
            'is_active' => true,
        ]);

        $this->createKnowledge([
            'keywords' => 'faq nonaktif',
            'is_active' => false,
        ]);

        $this->assertSame(
            [$activeKnowledge->getKey()],
            ChatbotKnowledge::query()
                ->active()
                ->pluck('id')
                ->all(),
        );
    }

    public function test_it_edits_chatbot_knowledge(): void
    {
        $knowledge = $this->createKnowledge([
            'keywords' => 'alamat lama',
            'answer' => 'Jawaban lama.',
            'category' => 'alamat',
        ]);

        Livewire::test(EditChatbotKnowledge::class, [
            'record' => $knowledge->getRouteKey(),
        ])
            ->fillForm([
                'keywords' => 'alamat, lokasi, maps',
                'answer' => 'Alamat lengkap sekolah tersedia pada halaman kontak.',
                'category' => 'kontak',
                'is_active' => true,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $knowledge->refresh();

        $this->assertSame(
            'alamat, lokasi, maps',
            $knowledge->keywords,
        );

        $this->assertSame(
            'Alamat lengkap sekolah tersedia pada halaman kontak.',
            $knowledge->answer,
        );

        $this->assertSame('kontak', $knowledge->category);
    }

    public function test_status_can_be_deactivated(): void
    {
        $knowledge = $this->createKnowledge([
            'is_active' => true,
        ]);

        Livewire::test(EditChatbotKnowledge::class, [
            'record' => $knowledge->getRouteKey(),
        ])
            ->fillForm([
                'keywords' => $knowledge->keywords,
                'answer' => $knowledge->answer,
                'category' => $knowledge->category,
                'is_active' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertFalse(
            $knowledge->fresh()->is_active,
        );
    }

    public function test_delete_from_edit_page_succeeds(): void
    {
        $knowledge = $this->createKnowledge();

        Livewire::test(EditChatbotKnowledge::class, [
            'record' => $knowledge->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('chatbot_knowledges', [
            'id' => $knowledge->getKey(),
        ]);
    }

    public function test_delete_from_list_page_succeeds(): void
    {
        $knowledge = $this->createKnowledge();

        Livewire::test(ListChatbotKnowledge::class)
            ->callTableAction(
                'delete',
                $knowledge,
            );

        $this->assertDatabaseMissing('chatbot_knowledges', [
            'id' => $knowledge->getKey(),
        ]);
    }

    public function test_required_fields_are_validated(): void
    {
        Livewire::test(CreateChatbotKnowledge::class)
            ->fillForm([
                'keywords' => null,
                'answer' => null,
                'category' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'keywords' => 'required',
                'answer' => 'required',
                'category' => 'required',
            ]);

        $this->assertDatabaseCount('chatbot_knowledges', 0);
    }

    public function test_category_only_accepts_available_options(): void
    {
        Livewire::test(CreateChatbotKnowledge::class)
            ->fillForm([
                'keywords' => 'pendaftaran lama',
                'answer' => 'Informasi pendaftaran.',
                'category' => 'ppdb',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'category',
            ]);

        $this->assertDatabaseCount('chatbot_knowledges', 0);
    }

    public function test_admin_and_super_admin_can_access_resource(): void
    {
        $knowledge = $this->createKnowledge();

        foreach (['admin', 'super_admin'] as $role) {
            $this->actingAs(
                User::factory()->create([
                    'role' => $role,
                ])
            );

            $this->assertTrue(
                ChatbotKnowledgeResource::canViewAny()
            );

            $this->assertTrue(
                ChatbotKnowledgeResource::canCreate()
            );

            $this->assertTrue(
                ChatbotKnowledgeResource::canEdit($knowledge)
            );

            $this->assertTrue(
                ChatbotKnowledgeResource::canDelete($knowledge)
            );

            $this->assertFalse(
                ChatbotKnowledgeResource::canDeleteAny()
            );
        }
    }

    public function test_category_options_match_current_chatbot_scope(): void
    {
        $this->assertSame([
            'umum',
            'profil',
            'sejarah',
            'guru',
            'karyawan',
            'kurikulum',
            'spmb',
            'berita',
            'prestasi',
            'ekstrakurikuler',
            'fasilitas',
            'alumni',
            'kontak',
            'alamat',
        ], array_keys(ChatbotKnowledge::CATEGORY_OPTIONS));

        $this->assertArrayNotHasKey(
            'ppdb',
            ChatbotKnowledge::CATEGORY_OPTIONS,
        );
    }

    private function createKnowledge(
        array $attributes = [],
    ): ChatbotKnowledge {
        return ChatbotKnowledge::query()->create(
            array_merge([
                'keywords' => fake()->unique()->words(3, true),
                'answer' => fake()->sentence(),
                'category' => 'umum',
                'is_active' => true,
            ], $attributes)
        );
    }
}
