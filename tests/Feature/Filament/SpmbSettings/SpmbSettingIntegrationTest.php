<?php

namespace Tests\Feature\Filament\SpmbSettings;

use App\Filament\Resources\SpmbSettings\Pages\CreateSpmbSetting;
use App\Filament\Resources\SpmbSettings\Pages\EditSpmbSetting;
use App\Filament\Resources\SpmbSettings\SpmbSettingResource;
use App\Models\SpmbSetting;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use LogicException;
use Tests\TestCase;

class SpmbSettingIntegrationTest extends TestCase
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

    public function test_it_creates_spmb_setting_with_pdf_and_image_preview(): void
    {
        $informationPdf = UploadedFile::fake()->create(
            'informasi-spmb.pdf',
            1024,
            'application/pdf',
        );

        $brochureImage = UploadedFile::fake()
            ->image('brosur-spmb.png', 1200, 1600)
            ->size(1024);

        Livewire::test(CreateSpmbSetting::class)
            ->fillForm([
                'description' => 'Informasi penerimaan murid baru.',
                'information_file' => $informationPdf,
                'brochure_file' => $brochureImage,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spmbSetting = SpmbSetting::query()->firstOrFail();

        $this->assertStringStartsWith(
            'spmb/',
            $spmbSetting->information_file,
        );

        $this->assertStringEndsWith(
            '.pdf',
            $spmbSetting->information_file,
        );

        $this->assertNull(
            $spmbSetting->information_preview,
        );

        $this->assertStringStartsWith(
            'spmb/',
            $spmbSetting->brochure_file,
        );

        $this->assertStringEndsWith(
            '.png',
            $spmbSetting->brochure_file,
        );

        $this->assertStringEndsWith(
            '.webp',
            $spmbSetting->brochure_preview,
        );

        Storage::disk('public')->assertExists(
            $spmbSetting->information_file,
        );

        Storage::disk('public')->assertExists(
            $spmbSetting->brochure_file,
        );

        Storage::disk('public')->assertExists(
            $spmbSetting->brochure_preview,
        );

        $previewContents = Storage::disk('public')->get(
            $spmbSetting->brochure_preview,
        );

        $previewInformation = getimagesizefromstring(
            $previewContents,
        );

        $this->assertIsArray($previewInformation);

        $this->assertSame(
            'image/webp',
            $previewInformation['mime'],
        );

        $this->assertLessThanOrEqual(
            1600,
            $previewInformation[0],
        );
    }

    public function test_it_replaces_image_with_pdf_and_deletes_old_files(): void
    {
        $oldPaths = app(ImageUploadService::class)
            ->storeOriginalWithWebpPreview(
                file: UploadedFile::fake()
                    ->image('old-information.png', 1200, 800)
                    ->size(1024),
                directory: 'spmb',
                maxWidth: 1600,
                quality: 80,
            );

        $spmbSetting = SpmbSetting::query()->create([
            'description' => 'Informasi SPMB lama.',
            'information_file' => $oldPaths['original'],
            'information_preview' => $oldPaths['preview'],
        ]);

        $newPdf = UploadedFile::fake()->create(
            'informasi-spmb-baru.pdf',
            1024,
            'application/pdf',
        );

        Livewire::test(EditSpmbSetting::class, [
            'record' => $spmbSetting->getRouteKey(),
        ])
            ->set('data.information_file', [])
            ->set('data.information_file', [$newPdf])
            ->call('save')
            ->assertHasNoFormErrors();

        $spmbSetting->refresh();

        $this->assertNotSame(
            $oldPaths['original'],
            $spmbSetting->information_file,
        );

        $this->assertNull(
            $spmbSetting->information_preview,
        );

        $this->assertStringEndsWith(
            '.pdf',
            $spmbSetting->information_file,
        );

        Storage::disk('public')->assertMissing(
            $oldPaths['original'],
        );

        Storage::disk('public')->assertMissing(
            $oldPaths['preview'],
        );

        Storage::disk('public')->assertExists(
            $spmbSetting->information_file,
        );
    }

    public function test_it_keeps_existing_files_when_no_new_files_are_uploaded(): void
    {
        $informationPath = 'spmb/information-existing.pdf';

        Storage::disk('public')->put(
            $informationPath,
            'existing pdf content',
        );

        $brochurePaths = app(ImageUploadService::class)
            ->storeOriginalWithWebpPreview(
                file: UploadedFile::fake()
                    ->image('existing-brochure.png', 1200, 800)
                    ->size(1024),
                directory: 'spmb',
                maxWidth: 1600,
                quality: 80,
            );

        $spmbSetting = SpmbSetting::query()->create([
            'description' => 'Informasi lama.',
            'information_file' => $informationPath,
            'brochure_file' => $brochurePaths['original'],
            'brochure_preview' => $brochurePaths['preview'],
        ]);

        Livewire::test(EditSpmbSetting::class, [
            'record' => $spmbSetting->getRouteKey(),
        ])
            ->fillForm([
                'description' => 'Informasi SPMB diperbarui.',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $spmbSetting->refresh();

        $this->assertSame(
            $informationPath,
            $spmbSetting->information_file,
        );

        $this->assertSame(
            $brochurePaths['original'],
            $spmbSetting->brochure_file,
        );

        $this->assertSame(
            $brochurePaths['preview'],
            $spmbSetting->brochure_preview,
        );

        Storage::disk('public')->assertExists(
            $informationPath,
        );

        Storage::disk('public')->assertExists(
            $brochurePaths['original'],
        );

        Storage::disk('public')->assertExists(
            $brochurePaths['preview'],
        );
    }

    public function test_it_deletes_spmb_setting_and_all_related_files(): void
    {
        $informationPath = 'spmb/information-delete.pdf';

        Storage::disk('public')->put(
            $informationPath,
            'pdf content',
        );

        $brochurePaths = app(ImageUploadService::class)
            ->storeOriginalWithWebpPreview(
                file: UploadedFile::fake()
                    ->image('brochure-delete.png', 1200, 800)
                    ->size(1024),
                directory: 'spmb',
                maxWidth: 1600,
                quality: 80,
            );

        $spmbSetting = SpmbSetting::query()->create([
            'description' => 'Data pengujian penghapusan.',
            'information_file' => $informationPath,
            'brochure_file' => $brochurePaths['original'],
            'brochure_preview' => $brochurePaths['preview'],
        ]);

        Livewire::test(EditSpmbSetting::class, [
            'record' => $spmbSetting->getRouteKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('spmb_settings', [
            'id' => $spmbSetting->getKey(),
        ]);

        Storage::disk('public')->assertMissing(
            $informationPath,
        );

        Storage::disk('public')->assertMissing(
            $brochurePaths['original'],
        );

        Storage::disk('public')->assertMissing(
            $brochurePaths['preview'],
        );
    }

    public function test_it_prevents_creating_second_spmb_setting(): void
    {
        SpmbSetting::query()->create([
            'description' => 'Pengaturan pertama.',
        ]);

        $this->assertFalse(
            SpmbSettingResource::canCreate(),
        );

        $this->expectException(LogicException::class);

        SpmbSetting::query()->create([
            'description' => 'Pengaturan kedua.',
        ]);
    }
}
