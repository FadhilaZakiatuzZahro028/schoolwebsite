<?php

namespace Tests\Feature\Filament\SchoolProfiles;

use App\Filament\Resources\SchoolProfiles\Pages\CreateSchoolProfile;
use App\Filament\Resources\SchoolProfiles\Pages\EditSchoolProfile;
use App\Filament\Resources\SchoolProfiles\SchoolProfileResource;
use App\Models\SchoolProfile;
use App\Models\User;
use App\Services\ImageUploadService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SchoolProfileWebpIntegrationTest extends TestCase
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

    public function test_it_creates_logo_and_favicon_as_webp(): void
    {
        $logoUpload = UploadedFile::fake()
->image('school-logo.png', 1300, 800)
            ->size(1024);

        $faviconUpload = UploadedFile::fake()
->image('school-favicon.jpg', 600, 600)
            ->size(512);

        Livewire::test(CreateSchoolProfile::class)
            ->fillForm([
                ...$this->validProfileData(),
                'logo' => $logoUpload,
                'favicon' => $faviconUpload,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $profile = SchoolProfile::query()->firstOrFail();

        $this->assertNotNull($profile->logo);
        $this->assertNotNull($profile->favicon);

        $this->assertStringStartsWith('logos/', $profile->logo);
        $this->assertStringEndsWith('.webp', $profile->logo);

        $this->assertStringStartsWith('logos/', $profile->favicon);
        $this->assertStringEndsWith('.webp', $profile->favicon);

        $this->assertTrue(
            Storage::disk('public')->exists($profile->logo)
        );

        $this->assertTrue(
            Storage::disk('public')->exists($profile->favicon)
        );

        $this->assertStoredImageIsValidWebp(
            path: $profile->logo,
            maxWidth: 1200,
        );

        $this->assertStoredImageIsValidWebp(
            path: $profile->favicon,
            maxWidth: 512,
        );
    }

    public function test_it_keeps_existing_logo_and_favicon_when_no_new_images_are_uploaded(): void
    {
        $logoPath = $this->storeExistingImage(
            filename: 'existing-logo.png',
            maxWidth: 1200,
        );

        $faviconPath = $this->storeExistingImage(
            filename: 'existing-favicon.png',
            maxWidth: 512,
        );

        $profile = SchoolProfile::query()->create([
            ...$this->validProfileData(),
            'logo' => $logoPath,
            'favicon' => $faviconPath,
        ]);

        Livewire::test(EditSchoolProfile::class, [
            'record' => $profile->getRouteKey(),
        ])
            ->fillForm([
                ...$this->validProfileData([
                    'school_name' => 'SMA PGRI 1 Tulungagung Diperbarui',
                ]),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $profile->refresh();

        $this->assertSame($logoPath, $profile->logo);
        $this->assertSame($faviconPath, $profile->favicon);

        $this->assertTrue(
            Storage::disk('public')->exists($logoPath)
        );

        $this->assertTrue(
            Storage::disk('public')->exists($faviconPath)
        );
    }

    public function test_it_replaces_logo_and_favicon_and_deletes_old_files_after_save(): void
    {
        $oldLogoPath = $this->storeExistingImage(
            filename: 'old-logo.png',
            maxWidth: 1200,
        );

        $oldFaviconPath = $this->storeExistingImage(
            filename: 'old-favicon.png',
            maxWidth: 512,
        );

        $profile = SchoolProfile::query()->create([
            ...$this->validProfileData(),
            'logo' => $oldLogoPath,
            'favicon' => $oldFaviconPath,
        ]);

        $newLogoUpload = UploadedFile::fake()
->image('replacement-logo.jpg', 800, 600)
            ->size(1024);

        $newFaviconUpload = UploadedFile::fake()
->image('replacement-favicon.png', 256, 256)
            ->size(512);

        Livewire::test(EditSchoolProfile::class, [
            'record' => $profile->getRouteKey(),
        ])
            ->set('data.logo', [])
            ->set('data.logo', [$newLogoUpload])
            ->set('data.favicon', [])
            ->set('data.favicon', [$newFaviconUpload])
            ->call('save')
            ->assertHasNoFormErrors();

        $profile->refresh();

        $this->assertNotSame($oldLogoPath, $profile->logo);
        $this->assertNotSame($oldFaviconPath, $profile->favicon);

        $this->assertStringStartsWith('logos/', $profile->logo);
        $this->assertStringEndsWith('.webp', $profile->logo);

        $this->assertStringStartsWith('logos/', $profile->favicon);
        $this->assertStringEndsWith('.webp', $profile->favicon);

        $this->assertFalse(
            Storage::disk('public')->exists($oldLogoPath)
        );

        $this->assertFalse(
            Storage::disk('public')->exists($oldFaviconPath)
        );

        $this->assertTrue(
            Storage::disk('public')->exists($profile->logo)
        );

        $this->assertTrue(
            Storage::disk('public')->exists($profile->favicon)
        );

        $this->assertStoredImageIsValidWebp(
            path: $profile->logo,
            maxWidth: 1200,
        );

        $this->assertStoredImageIsValidWebp(
            path: $profile->favicon,
            maxWidth: 512,
        );
    }

    public function test_it_replaces_ppdb_brochure_and_deletes_old_pdf_after_save(): void
    {
        $oldBrochurePath = 'documents/old-ppdb-brochure.pdf';

        Storage::disk('public')->put(
            $oldBrochurePath,
            'old brochure content',
        );

        $profile = SchoolProfile::query()->create([
            ...$this->validProfileData(),
            'ppdb_brochure' => $oldBrochurePath,
        ]);

        $newBrochure = UploadedFile::fake()->create(
            'new-ppdb-brochure.pdf',
            1024,
            'application/pdf',
        );

        Livewire::test(EditSchoolProfile::class, [
            'record' => $profile->getRouteKey(),
        ])
            ->set('data.ppdb_brochure', [])
            ->set('data.ppdb_brochure', [$newBrochure])
            ->call('save')
            ->assertHasNoFormErrors();

        $profile->refresh();

        $this->assertNotNull($profile->ppdb_brochure);
        $this->assertNotSame(
            $oldBrochurePath,
            $profile->ppdb_brochure,
        );

        $this->assertStringStartsWith(
            'documents/',
            $profile->ppdb_brochure,
        );

        $this->assertStringEndsWith(
            '.pdf',
            $profile->ppdb_brochure,
        );

        $this->assertFalse(
            Storage::disk('public')->exists($oldBrochurePath)
        );

        $this->assertTrue(
            Storage::disk('public')->exists(
                $profile->ppdb_brochure
            )
        );
    }

    public function test_it_prevents_creating_a_second_school_profile(): void
    {
        SchoolProfile::query()->create(
            $this->validProfileData()
        );

        $this->assertFalse(
            SchoolProfileResource::canCreate()
        );

        $this->assertSame(
            1,
            SchoolProfile::query()->count()
        );
    }

    private function validProfileData(array $overrides = []): array
    {
        return array_merge([
            'school_name' => 'SMA PGRI 1 Tulungagung',
            'tagline' => 'Sekolah Unggul dan Berkarakter',
            'history' => 'Sejarah SMA PGRI 1 Tulungagung.',
            'vision' => 'Menjadi sekolah yang unggul dan berkarakter.',
            'mission' => 'Menyelenggarakan pendidikan yang berkualitas.',
            'principal_name' => 'Kepala Sekolah',
            'principal_message' => 'Selamat datang di SMA PGRI 1 Tulungagung.',
            'ppdb_info' => 'Informasi pendaftaran peserta didik baru.',
            'address' => 'Tulungagung, Jawa Timur',
            'phone' => '081234567890',
            'email' => 'info@smapgri1ta.sch.id',
            'maps_embed' => null,
            'instagram' => null,
            'facebook' => null,
            'youtube' => null,
        ], $overrides);
    }

    private function storeExistingImage(
    string $filename,
    int $maxWidth,
): string {
    $sourceSize = min($maxWidth, 640);

    $path = app(ImageUploadService::class)->storeAsWebp(
        file: UploadedFile::fake()->image(
            $filename,
            $sourceSize,
            $sourceSize,
        ),
        directory: 'logos',
        maxWidth: $maxWidth,
        quality: 80,
    );

        $this->assertNotNull($path);

        return $path;
    }

    private function assertStoredImageIsValidWebp(
        string $path,
        int $maxWidth,
    ): void {
        $contents = Storage::disk('public')->get($path);
        $imageInformation = getimagesizefromstring($contents);

        $this->assertIsArray($imageInformation);
        $this->assertSame(
            'image/webp',
            $imageInformation['mime'],
        );
        $this->assertLessThanOrEqual(
            $maxWidth,
            $imageInformation[0],
        );
    }
}