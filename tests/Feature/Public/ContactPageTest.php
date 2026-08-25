<?php

namespace Tests\Feature\Public;

use App\Models\ContactMessage;
use App\Models\SchoolProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_displays_dynamic_school_information(): void
    {
        $schoolProfile = $this->createSchoolProfile();

        $this->get(route('contact.index'))
            ->assertSuccessful()
            ->assertSee('Hubungi Sekolah')
            ->assertSee('Topik Pesan')
            ->assertSee($schoolProfile->address)
            ->assertSee($schoolProfile->phone)
            ->assertSee($schoolProfile->email)
            ->assertSee(
                'https://www.google.com/maps/embed/contact-test',
                false,
            );
    }

    public function test_valid_contact_message_is_stored_as_unread(): void
    {
        $payload = [
            'name' => 'Pengirim Pengujian',
            'email' => 'pengirim@example.com',
            'phone' => '0812 3456 7890',
            'subject' => 'Pertanyaan tentang SPMB',
            'message' => 'Saya ingin menanyakan informasi jadwal SPMB.',
        ];

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.10',
            ])
            ->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'))
            ->assertSessionHas(
                'success',
                'Pesan berhasil dikirim. Pihak sekolah akan menindaklanjutinya secepat mungkin.',
            );

        $this->assertDatabaseHas('contact_messages', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
            'subject' => $payload['subject'],
            'message' => $payload['message'],
            'is_read' => false,
            'ip_address' => '198.51.100.10',
        ]);
    }

    public function test_phone_number_is_optional(): void
    {
        $payload = [
            'name' => 'Pengirim Tanpa Telepon',
            'email' => 'tanpatelepon@example.com',
            'subject' => 'Permohonan Informasi',
            'message' => 'Saya membutuhkan informasi mengenai kegiatan sekolah.',
        ];

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.11',
            ])
            ->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'));

        $this->assertDatabaseHas('contact_messages', [
            'email' => $payload['email'],
            'phone' => null,
            'is_read' => false,
        ]);
    }

    public function test_invalid_contact_message_is_rejected(): void
    {
        $payload = [
            'name' => 'Pengirim Tidak Valid',
            'email' => 'email-tidak-valid',
            'phone' => 'nomor telepon salah',
            'subject' => 'Pertanyaan',
            'message' => 'Pendek',
        ];

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.12',
            ])
            ->from(route('contact.index'))
            ->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'))
            ->assertSessionHasErrors([
                'email',
                'phone',
                'message',
            ]);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_required_contact_fields_are_validated(): void
    {
        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.13',
            ])
            ->from(route('contact.index'))
            ->post(route('contact.store'), [])
            ->assertRedirect(route('contact.index'))
            ->assertSessionHasErrors([
                'name',
                'email',
                'subject',
                'message',
            ]);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_submission_is_rate_limited(): void
    {
        $payload = [
            'name' => 'Pengirim Rate Limit',
            'email' => 'ratelimit@example.com',
            'phone' => null,
            'subject' => 'Pertanyaan Sekolah',
            'message' => 'Pesan pengujian untuk memastikan rate limit berjalan.',
        ];

        $this->withServerVariables([
            'REMOTE_ADDR' => '198.51.100.77',
        ]);

        $this->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'));

        $this->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'));

        $this->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'));

        $this->post(route('contact.store'), $payload)
            ->assertStatus(429);

        $this->assertDatabaseCount('contact_messages', 3);
    }

    private function createSchoolProfile(): SchoolProfile
    {
        return SchoolProfile::query()->create([
            'school_name' => 'SMA PGRI 1 Tulungagung',
            'tagline' => 'Unggul, Berkarakter, dan Berprestasi',
            'history' => 'Sejarah sekolah untuk pengujian.',
            'vision' => 'Terwujudnya sekolah unggul.',
            'mission' => 'Menyelenggarakan pendidikan bermutu.',
            'principal_name' => 'Kepala Sekolah Pengujian',
            'principal_message' => 'Selamat datang di website sekolah.',
            'address' => 'Jalan Pengujian Nomor 1, Tulungagung',
            'phone' => '0355-123456',
            'email' => 'sekolah@example.com',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed/contact-test"></iframe>',
        ]);
    }
}