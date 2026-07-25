<?php

namespace Tests\Feature\Filament\AlumniHighlights;

use App\Filament\Resources\AlumniHighlights\AlumniHighlightResource;
use App\Filament\Resources\AlumniHighlights\Pages\CreateAlumniHighlight;
use App\Filament\Resources\AlumniHighlights\Pages\EditAlumniHighlight;
use App\Filament\Resources\AlumniHighlights\Pages\ListAlumniHighlights;
use App\Models\AlumniHighlight;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class AlumniHighlightIntegrationTest extends TestCase
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

    public function test_it_creates_active_alumni_with_webp_photo(): void
    {
        $photo = UploadedFile::fake()
            ->image('alumni.jpg', 800, 800)
            ->size(1024);

        Livewire::test(CreateAlumniHighlight::class)
            ->fillForm([
                'name' => 'Rina Wulandari',
                'graduation_year' => 2015,
                'photo' => $photo,
                'current_activity' => 'Dokter',
                'institution' => 'RS Tulungagung',
                'quote' => 'Terus belajar dan memberi manfaat.',
                'is_active' => true,
                'sort_order' => 1,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $alumni = AlumniHighlight::query()->firstOrFail();

        $this->assertTrue($alumni->is_active);
        $this->assertNotNull($alumni->photo);

        $this->assertStringStartsWith(
            'alumni/highlights/',
            $alumni->photo,
        );

        $this->assertStringEndsWith(
            '.webp',
            $alumni->photo,
        );

        Storage::disk('public')->assertExists($alumni->photo);

        $imageInformation = getimagesizefromstring(
            Storage::disk('public')->get($alumni->photo),
        );

        $this->assertIsArray($imageInformation);

        $this->assertSame(
            'image/webp',
            $imageInformation['mime'],
        );

        $this->assertLessThanOrEqual(
            1200,
            $imageInformation[0],
        );
    }

    public function test_it_creates_alumni_without_photo(): void
    {
        Livewire::test(CreateAlumniHighlight::class)
            ->fillForm([
                'name' => 'Dian Prasetyo',
                'graduation_year' => 2018,
                'is_active' => true,
                'sort_order' => 2,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $alumni = AlumniHighlight::query()->firstOrFail();

        $this->assertNull($alumni->photo);
        $this->assertNull($alumni->current_activity);
        $this->assertNull($alumni->institution);
        $this->assertNull($alumni->quote);
    }

    public function test_edit_without_new_photo_keeps_existing_photo(): void
    {
        $oldPhoto = $this->storePhoto('existing-alumni.jpg');

        $alumni = $this->createAlumni([
            'name' => 'Siti Aminah',
            'photo' => $oldPhoto,
            'is_active' => true,
        ]);

        Livewire::test(EditAlumniHighlight::class, [
            'record' => $alumni->getRouteKey(),
        ])
            ->fillForm([
                'name' => 'Siti Aminah, S.E.',
                'graduation_year' => 2017,
                'current_activity' => 'Wirausaha',
                'institution' => 'Aminah Collection',
                'quote' => 'Berani mencoba dan terus berkembang.',
                'is_active' => true,
                'sort_order' => 1,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $alumni->refresh();

        $this->assertSame($oldPhoto, $alumni->photo);

        Storage::disk('public')->assertExists($oldPhoto);
    }

    public function test_replacing_photo_deletes_old_photo(): void
    {
        $oldPhoto = $this->storePhoto('old-alumni.jpg');

        $alumni = $this->createAlumni([
            'photo' => $oldPhoto,
            'is_active' => true,
        ]);

        $newPhoto = UploadedFile::fake()
            ->image('new-alumni.png', 800, 800)
            ->size(1024);

        Livewire::test(EditAlumniHighlight::class, [
            'record' => $alumni->getRouteKey(),
        ])
            ->fillForm([
                'name' => 'Alumni Diperbarui',
                'graduation_year' => 2019,
                'current_activity' => 'Pengusaha',
                'institution' => 'Usaha Mandiri',
                'is_active' => true,
                'sort_order' => 1,
            ])
            ->set('data.photo', [])
            ->set('data.photo', [$newPhoto])
            ->call('save')
            ->assertHasNoFormErrors();

        $alumni->refresh();

        $this->assertNotSame($oldPhoto, $alumni->photo);

        Storage::disk('public')->assertMissing($oldPhoto);
        Storage::disk('public')->assertExists($alumni->photo);
    }

    public function test_delete_from_edit_page_deletes_photo(): void
    {
        $photo = $this->storePhoto('delete-from-edit.jpg');

        $alumni = $this->createAlumni([
            'photo' => $photo,
        ]);

        Livewire::test(EditAlumniHighlight::class, [
            'record' => $alumni->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('alumni_highlights', [
            'id' => $alumni->getKey(),
        ]);

        Storage::disk('public')->assertMissing($photo);
    }

    public function test_delete_from_list_page_deletes_photo(): void
    {
        $photo = $this->storePhoto('delete-from-list.jpg');

        $alumni = $this->createAlumni([
            'photo' => $photo,
        ]);

        Livewire::test(ListAlumniHighlights::class)
            ->callTableAction(
                'delete',
                $alumni,
            );

        $this->assertDatabaseMissing('alumni_highlights', [
            'id' => $alumni->getKey(),
        ]);

        Storage::disk('public')->assertMissing($photo);
    }

    public function test_deleting_alumni_without_photo_does_not_error(): void
    {
        $alumni = $this->createAlumni([
            'photo' => null,
        ]);

        Livewire::test(EditAlumniHighlight::class, [
            'record' => $alumni->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('alumni_highlights', [
            'id' => $alumni->getKey(),
        ]);
    }

    public function test_model_prevents_more_than_four_active_alumni(): void
    {
        foreach (range(1, AlumniHighlight::MAX_ACTIVE) as $index) {
            $this->createAlumni([
                'name' => "Alumni Aktif {$index}",
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }

        try {
            $this->createAlumni([
                'name' => 'Alumni Aktif Kelima',
                'is_active' => true,
                'sort_order' => 5,
            ]);

            $this->fail(
                'Alumni aktif kelima seharusnya ditolak.'
            );
        } catch (ValidationException $exception) {
            $this->assertSame(
                'Maksimal 4 alumni pilihan dapat diaktifkan. Nonaktifkan salah satu alumni aktif terlebih dahulu.',
                $exception->errors()['is_active'][0],
            );
        }

        $this->assertSame(
            AlumniHighlight::MAX_ACTIVE,
            AlumniHighlight::query()->active()->count(),
        );
    }

    public function test_fifth_record_can_be_created_when_inactive(): void
    {
        foreach (range(1, AlumniHighlight::MAX_ACTIVE) as $index) {
            $this->createAlumni([
                'name' => "Alumni Aktif {$index}",
                'is_active' => true,
            ]);
        }

        $inactiveAlumni = $this->createAlumni([
            'name' => 'Alumni Tidak Aktif',
            'is_active' => false,
        ]);

        $this->assertFalse($inactiveAlumni->is_active);
        $this->assertSame(5, AlumniHighlight::query()->count());
        $this->assertSame(4, AlumniHighlight::query()->active()->count());
    }

    public function test_inactive_alumni_can_be_activated_when_slot_is_available(): void
    {
        foreach (range(1, 3) as $index) {
            $this->createAlumni([
                'name' => "Alumni Aktif {$index}",
                'is_active' => true,
            ]);
        }

        $inactiveAlumni = $this->createAlumni([
            'name' => 'Calon Alumni Aktif',
            'is_active' => false,
        ]);

        $inactiveAlumni->update([
            'is_active' => true,
        ]);

        $this->assertTrue($inactiveAlumni->fresh()->is_active);
        $this->assertSame(4, AlumniHighlight::query()->active()->count());
    }

    public function test_rejected_fifth_active_record_does_not_store_uploaded_photo(): void
    {
        foreach (range(1, AlumniHighlight::MAX_ACTIVE) as $index) {
            $this->createAlumni([
                'name' => "Alumni Aktif {$index}",
                'is_active' => true,
            ]);
        }

        $photo = UploadedFile::fake()
            ->image('rejected-alumni.jpg', 800, 800)
            ->size(1024);

        Livewire::test(CreateAlumniHighlight::class)
            ->fillForm([
                'name' => 'Alumni Aktif Kelima',
                'graduation_year' => 2020,
                'photo' => $photo,
                'is_active' => true,
                'sort_order' => 5,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'is_active',
            ]);

        $this->assertSame(4, AlumniHighlight::query()->count());

        $this->assertSame(
            [],
            Storage::disk('public')->allFiles(
                'alumni/highlights',
            ),
        );
    }

    public function test_it_validates_graduation_year(): void
    {
        Livewire::test(CreateAlumniHighlight::class)
            ->fillForm([
                'name' => 'Alumni Tahun Masa Depan',
                'graduation_year' => now()->year + 1,
                'is_active' => false,
                'sort_order' => 0,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'graduation_year' => 'max',
            ]);

        Livewire::test(CreateAlumniHighlight::class)
            ->fillForm([
                'name' => 'Alumni Tahun Tidak Wajar',
                'graduation_year' => 1899,
                'is_active' => false,
                'sort_order' => 0,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'graduation_year' => 'min',
            ]);

        $this->assertDatabaseCount('alumni_highlights', 0);
    }

    public function test_active_scope_returns_only_active_alumni(): void
    {
        $activeAlumni = $this->createAlumni([
            'name' => 'Alumni Aktif',
            'is_active' => true,
        ]);

        $this->createAlumni([
            'name' => 'Alumni Tidak Aktif',
            'is_active' => false,
        ]);

        $this->assertSame(
            [$activeAlumni->getKey()],
            AlumniHighlight::query()
                ->active()
                ->pluck('id')
                ->all(),
        );
    }

    public function test_ordered_scope_orders_by_sort_order_then_name(): void
    {
        $last = $this->createAlumni([
            'name' => 'Budi',
            'sort_order' => 2,
        ]);

        $second = $this->createAlumni([
            'name' => 'Zahra',
            'sort_order' => 1,
        ]);

        $first = $this->createAlumni([
            'name' => 'Andi',
            'sort_order' => 1,
        ]);

        $this->assertSame(
            [
                $first->getKey(),
                $second->getKey(),
                $last->getKey(),
            ],
            AlumniHighlight::query()
                ->ordered()
                ->pluck('id')
                ->all(),
        );
    }

    public function test_admin_and_super_admin_can_manage_alumni_highlights(): void
    {
        $alumni = $this->createAlumni();

        foreach (['admin', 'super_admin'] as $role) {
            $this->actingAs(
                User::factory()->create([
                    'role' => $role,
                ])
            );

            $this->assertTrue(
                AlumniHighlightResource::canViewAny()
            );

            $this->assertTrue(
                AlumniHighlightResource::canCreate()
            );

            $this->assertTrue(
                AlumniHighlightResource::canEdit($alumni)
            );

            $this->assertTrue(
                AlumniHighlightResource::canDelete($alumni)
            );

            $this->assertFalse(
                AlumniHighlightResource::canDeleteAny()
            );
        }
    }

    private function createAlumni(
        array $attributes = [],
    ): AlumniHighlight {
        return AlumniHighlight::query()->create(
            array_merge([
                'name' => fake()->unique()->name(),
                'graduation_year' => 2020,
                'photo' => null,
                'current_activity' => null,
                'institution' => null,
                'quote' => null,
                'is_active' => false,
                'sort_order' => 0,
            ], $attributes)
        );
    }

    private function storePhoto(string $filename): string
    {
        $path = app(ImageUploadService::class)->storeAsWebp(
            file: UploadedFile::fake()
                ->image($filename, 800, 800)
                ->size(1024),
            directory: 'alumni/highlights',
            maxWidth: 1200,
            quality: 80,
        );

        $this->assertNotNull($path);

        return (string) $path;
    }
}
