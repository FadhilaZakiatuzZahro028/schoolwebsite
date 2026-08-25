<?php

namespace Tests\Feature\Filament\FeaturedPrograms;

use App\Filament\Resources\FeaturedProgramSettings\FeaturedProgramSettingResource;
use App\Filament\Resources\FeaturedProgramSettings\Pages\CreateFeaturedProgramSetting;
use App\Filament\Resources\FeaturedProgramSettings\Pages\EditFeaturedProgramSetting;
use App\Filament\Resources\FeaturedPrograms\FeaturedProgramResource;
use App\Filament\Resources\FeaturedPrograms\Pages\CreateFeaturedProgram;
use App\Models\FeaturedProgram;
use App\Models\FeaturedProgramImage;
use App\Models\FeaturedProgramSetting;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class FeaturedProgramIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        Filament::setCurrentPanel('admin');

        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ])
        );
    }

    public function test_it_creates_and_updates_featured_program_setting(): void
    {
        Livewire::test(CreateFeaturedProgramSetting::class)
            ->fillForm([
                'introduction' => 'Program keterampilan untuk mengembangkan potensi siswa.',
                'collaboration_text' => 'Kegiatan dikembangkan melalui kolaborasi dengan LPK dan BLK.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $setting = FeaturedProgramSetting::query()
            ->firstOrFail();

        $this->assertDatabaseHas(
            'featured_program_settings',
            [
                'id' => $setting->getKey(),
                'introduction' => 'Program keterampilan untuk mengembangkan potensi siswa.',
                'collaboration_text' => 'Kegiatan dikembangkan melalui kolaborasi dengan LPK dan BLK.',
            ],
        );

        $this->assertFalse(
            FeaturedProgramSettingResource::canCreate(),
        );

        Livewire::test(
            EditFeaturedProgramSetting::class,
            [
                'record' => $setting->getRouteKey(),
            ],
        )
            ->fillForm([
                'introduction' => 'Pengantar Program Unggulan yang diperbarui.',
                'collaboration_text' => 'Informasi kolaborasi keterampilan yang diperbarui.',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(
            'featured_program_settings',
            [
                'id' => $setting->getKey(),
                'introduction' => 'Pengantar Program Unggulan yang diperbarui.',
                'collaboration_text' => 'Informasi kolaborasi keterampilan yang diperbarui.',
            ],
        );
    }

    public function test_featured_program_setting_is_hidden_from_navigation_and_cannot_be_deleted(): void
    {
        $setting = FeaturedProgramSetting::query()->create([
            'introduction' => 'Pengantar.',
            'collaboration_text' => 'Kolaborasi.',
        ]);

        $this->assertFalse(
            FeaturedProgramSettingResource::shouldRegisterNavigation(),
        );

        foreach (['admin', 'super_admin'] as $role) {
            $this->actingAs(
                User::factory()->create([
                    'role' => $role,
                ])
            );

            $this->assertTrue(
                FeaturedProgramSettingResource::canViewAny(),
            );

            $this->assertTrue(
                FeaturedProgramSettingResource::canEdit(
                    $setting,
                ),
            );

            $this->assertFalse(
                FeaturedProgramSettingResource::canDelete(
                    $setting,
                ),
            );

            $this->assertFalse(
                FeaturedProgramSettingResource::canDeleteAny(),
            );
        }
    }

    public function test_it_creates_featured_program_with_webp_main_and_documentation_images(): void
    {
        $mainImage = UploadedFile::fake()
            ->image(
                'bahasa-korea.jpg',
                1200,
                900,
            )
            ->size(1024);

        $documentationOne = UploadedFile::fake()
            ->image(
                'bahasa-korea-1.png',
                1200,
                900,
            )
            ->size(1024);

        $documentationTwo = UploadedFile::fake()
            ->image(
                'bahasa-korea-2.jpg',
                1200,
                900,
            )
            ->size(1024);

        Livewire::test(CreateFeaturedProgram::class)
            ->fillForm([
                'name' => 'Bahasa Korea',
                'summary' => 'Mengembangkan kemampuan bahasa asing siswa.',
                'description' => 'Siswa memperoleh pengalaman belajar Bahasa Korea secara terarah.',
                'image' => $mainImage,
                'is_active' => true,
                'sort_order' => 1,
                'images' => [
    [
        'image' => [
            $documentationOne,
        ],
        'alt_text' => 'Siswa mengikuti kegiatan Bahasa Korea.',
    ],
    [
        'image' => [
            $documentationTwo,
        ],
        'alt_text' => 'Dokumentasi pembelajaran Bahasa Korea.',
    ],
],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $program = FeaturedProgram::query()
            ->with('images')
            ->firstOrFail();

        $this->assertSame(
            'Bahasa Korea',
            $program->name,
        );

        $this->assertTrue(
            $program->is_active,
        );

        $this->assertSame(
            1,
            $program->sort_order,
        );

        $this->assertStringStartsWith(
            'featured-programs/',
            $program->image,
        );

        $this->assertStringEndsWith(
            '.webp',
            $program->image,
        );

        Storage::disk('public')->assertExists(
            $program->image,
        );

        $this->assertCount(
            2,
            $program->images,
        );

        foreach ($program->images as $image) {
            $this->assertStringStartsWith(
                'featured-programs/',
                $image->image,
            );

            $this->assertStringEndsWith(
                '.webp',
                $image->image,
            );

            Storage::disk('public')->assertExists(
                $image->image,
            );
        }

        $mainImageContents = Storage::disk('public')->get(
            $program->image,
        );

        $mainImageInformation = getimagesizefromstring(
            $mainImageContents,
        );

        $this->assertIsArray(
            $mainImageInformation,
        );

        $this->assertSame(
            'image/webp',
            $mainImageInformation['mime'],
        );

        $this->assertLessThanOrEqual(
            1600,
            $mainImageInformation[0],
        );
    }

    public function test_it_rejects_more_than_two_documentation_images(): void
    {
        Livewire::test(CreateFeaturedProgram::class)
            ->fillForm([
                'name' => 'Desain Grafis',
                'summary' => 'Mengembangkan kreativitas visual dan keterampilan digital.',
                'description' => 'Program keterampilan desain grafis bagi siswa.',
                'image' => UploadedFile::fake()
                    ->image(
                        'desain-main.jpg',
                        1200,
                        900,
                    )
                    ->size(1024),
                'is_active' => true,
                'sort_order' => 2,
                'images' => [
    [
        'image' => [
            UploadedFile::fake()
                ->image(
                    'desain-1.jpg',
                    1200,
                    900,
                )
                ->size(512),
        ],
    ],
    [
        'image' => [
            UploadedFile::fake()
                ->image(
                    'desain-2.jpg',
                    1200,
                    900,
                )
                ->size(512),
        ],
    ],
    [
        'image' => [
            UploadedFile::fake()
                ->image(
                    'desain-3.jpg',
                    1200,
                    900,
                )
                ->size(512),
        ],
    ],
],
            ])
            ->call('create')
            ->assertHasFormErrors([
                'images',
            ]);

        $this->assertDatabaseCount(
            'featured_programs',
            0,
        );
    }

    public function test_active_and_ordered_scopes_return_expected_programs(): void
    {
        $this->createProgram([
            'name' => 'Otomotif',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $this->createProgram([
            'name' => 'Tata Boga',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->createProgram([
            'name' => 'Tata Kecantikan',
            'sort_order' => 0,
            'is_active' => false,
        ]);

        $programNames = FeaturedProgram::query()
            ->active()
            ->ordered()
            ->pluck('name')
            ->all();

        $this->assertSame(
            [
                'Tata Boga',
                'Otomotif',
            ],
            $programNames,
        );
    }

    public function test_replacing_documentation_image_deletes_old_file(): void
    {
        $program = $this->createProgram();

        $oldPath = 'featured-programs/old-documentation.webp';
        $newPath = 'featured-programs/new-documentation.webp';

        Storage::disk('public')->put(
            $oldPath,
            'old image contents',
        );

        Storage::disk('public')->put(
            $newPath,
            'new image contents',
        );

        $image = $program->images()->create([
            'image' => $oldPath,
            'alt_text' => 'Dokumentasi lama.',
            'sort_order' => 0,
        ]);

        $image->update([
            'image' => $newPath,
        ]);

        Storage::disk('public')->assertMissing(
            $oldPath,
        );

        Storage::disk('public')->assertExists(
            $newPath,
        );
    }

    public function test_deleting_documentation_record_deletes_its_file(): void
    {
        $program = $this->createProgram();

        $imagePath = 'featured-programs/deleted-documentation.webp';

        Storage::disk('public')->put(
            $imagePath,
            'image contents',
        );

        $image = $program->images()->create([
            'image' => $imagePath,
            'alt_text' => 'Dokumentasi untuk dihapus.',
            'sort_order' => 0,
        ]);

        $image->delete();

        $this->assertDatabaseMissing(
            'featured_program_images',
            [
                'id' => $image->getKey(),
            ],
        );

        Storage::disk('public')->assertMissing(
            $imagePath,
        );
    }

    public function test_soft_delete_keeps_main_and_documentation_media(): void
    {
        $mainPath = 'featured-programs/soft-main.webp';
        $documentationPath = 'featured-programs/soft-documentation.webp';

        Storage::disk('public')->put(
            $mainPath,
            'main image',
        );

        Storage::disk('public')->put(
            $documentationPath,
            'documentation image',
        );

        $program = $this->createProgram([
            'image' => $mainPath,
        ]);

        $image = $program->images()->create([
            'image' => $documentationPath,
            'alt_text' => 'Dokumentasi.',
            'sort_order' => 0,
        ]);

        $program->delete();

        $this->assertSoftDeleted(
            'featured_programs',
            [
                'id' => $program->getKey(),
            ],
        );

        $this->assertDatabaseHas(
            'featured_program_images',
            [
                'id' => $image->getKey(),
                'featured_program_id' => $program->getKey(),
            ],
        );

        Storage::disk('public')->assertExists(
            $mainPath,
        );

        Storage::disk('public')->assertExists(
            $documentationPath,
        );
    }

    public function test_restore_keeps_existing_media(): void
    {
        $mainPath = 'featured-programs/restore-main.webp';
        $documentationPath = 'featured-programs/restore-documentation.webp';

        Storage::disk('public')->put(
            $mainPath,
            'main image',
        );

        Storage::disk('public')->put(
            $documentationPath,
            'documentation image',
        );

        $program = $this->createProgram([
            'image' => $mainPath,
        ]);

        $program->images()->create([
            'image' => $documentationPath,
            'alt_text' => 'Dokumentasi.',
            'sort_order' => 0,
        ]);

        $program->delete();
        $program->restore();

        $this->assertDatabaseHas(
            'featured_programs',
            [
                'id' => $program->getKey(),
                'deleted_at' => null,
            ],
        );

        Storage::disk('public')->assertExists(
            $mainPath,
        );

        Storage::disk('public')->assertExists(
            $documentationPath,
        );
    }

    public function test_force_delete_removes_parent_children_and_all_media(): void
    {
        $mainPath = 'featured-programs/force-main.webp';
        $documentationOne = 'featured-programs/force-documentation-1.webp';
        $documentationTwo = 'featured-programs/force-documentation-2.webp';

        foreach (
            [
                $mainPath,
                $documentationOne,
                $documentationTwo,
            ] as $path
        ) {
            Storage::disk('public')->put(
                $path,
                'image contents',
            );
        }

        $program = $this->createProgram([
            'image' => $mainPath,
        ]);

        $firstImage = $program->images()->create([
            'image' => $documentationOne,
            'alt_text' => 'Dokumentasi pertama.',
            'sort_order' => 0,
        ]);

        $secondImage = $program->images()->create([
            'image' => $documentationTwo,
            'alt_text' => 'Dokumentasi kedua.',
            'sort_order' => 1,
        ]);

        $programId = $program->getKey();

        $program->delete();

        FeaturedProgram::withTrashed()
            ->findOrFail($programId)
            ->forceDelete();

        $this->assertDatabaseMissing(
            'featured_programs',
            [
                'id' => $programId,
            ],
        );

        $this->assertDatabaseMissing(
            'featured_program_images',
            [
                'id' => $firstImage->getKey(),
            ],
        );

        $this->assertDatabaseMissing(
            'featured_program_images',
            [
                'id' => $secondImage->getKey(),
            ],
        );

        Storage::disk('public')->assertMissing(
            $mainPath,
        );

        Storage::disk('public')->assertMissing(
            $documentationOne,
        );

        Storage::disk('public')->assertMissing(
            $documentationTwo,
        );
    }

    public function test_force_delete_is_limited_to_super_admin(): void
    {
        $program = $this->createProgram();

        $program->delete();

        $this->actingAs(
            User::factory()->create([
                'role' => 'admin',
            ])
        );

        $this->assertFalse(
            FeaturedProgramResource::canForceDelete(
                $program,
            ),
        );

        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ])
        );

        $this->assertTrue(
            FeaturedProgramResource::canForceDelete(
                $program,
            ),
        );
    }

    public function test_admin_and_super_admin_can_manage_featured_programs(): void
    {
        $program = $this->createProgram();

        foreach (['admin', 'super_admin'] as $role) {
            $this->actingAs(
                User::factory()->create([
                    'role' => $role,
                ])
            );

            $this->assertTrue(
                FeaturedProgramResource::canViewAny(),
            );

            $this->assertTrue(
                FeaturedProgramResource::canCreate(),
            );

            $this->assertTrue(
                FeaturedProgramResource::canEdit(
                    $program,
                ),
            );

            $this->assertTrue(
                FeaturedProgramResource::canDelete(
                    $program,
                ),
            );

            $this->assertTrue(
                FeaturedProgramResource::canRestore(
                    $program,
                ),
            );

            $this->assertFalse(
                FeaturedProgramResource::canDeleteAny(),
            );

            $this->assertFalse(
                FeaturedProgramResource::canForceDeleteAny(),
            );
        }
    }

    private function createProgram(
        array $attributes = [],
    ): FeaturedProgram {
        return FeaturedProgram::query()->create(
            array_merge([
                'name' => 'Bahasa Korea',
                'summary' => 'Ringkasan Program Unggulan.',
                'description' => 'Deskripsi Program Unggulan untuk kebutuhan pengujian.',
                'image' => 'featured-programs/default.webp',
                'is_active' => true,
                'sort_order' => 0,
            ], $attributes),
        );
    }
}