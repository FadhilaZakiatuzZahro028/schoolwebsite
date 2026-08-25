<?php

namespace Tests\Feature\Public;

use App\Models\ChatbotKnowledge;
use App\Services\ChatbotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_returns_answer_from_active_knowledge(): void
    {
        $knowledge = $this->createKnowledge([
            'keywords' => 'alamat sekolah, lokasi sekolah',
            'answer' => 'Alamat sekolah tersedia pada halaman Kontak.',
            'is_active' => true,
        ]);

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.21',
            ])
            ->postJson(route('chatbot.reply'), [
                'message' => 'Di mana lokasi sekolah?',
            ])
            ->assertSuccessful()
            ->assertJson([
                'answer' => $knowledge->answer,
            ]);
    }

    public function test_chatbot_does_not_use_inactive_knowledge(): void
    {
        $this->createKnowledge([
            'keywords' => 'biaya sekolah',
            'answer' => 'Jawaban FAQ yang sudah dinonaktifkan.',
            'is_active' => false,
        ]);

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.22',
            ])
            ->postJson(route('chatbot.reply'), [
                'message' => 'Berapa biaya sekolah?',
            ])
            ->assertSuccessful()
            ->assertJson([
                'answer' => ChatbotService::FALLBACK_ANSWER,
            ]);
    }

    public function test_chatbot_prefers_more_specific_keyword(): void
    {
        $this->createKnowledge([
            'keywords' => 'spmb',
            'answer' => 'Informasi umum SPMB.',
        ]);

        $specificKnowledge = $this->createKnowledge([
            'keywords' => 'jadwal spmb',
            'answer' => 'Jadwal SPMB tersedia pada halaman SPMB.',
        ]);

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.23',
            ])
            ->postJson(route('chatbot.reply'), [
                'message' => 'Kapan jadwal SPMB dibuka?',
            ])
            ->assertSuccessful()
            ->assertJson([
                'answer' => $specificKnowledge->answer,
            ]);
    }

    public function test_chatbot_keyword_matching_is_case_insensitive(): void
    {
        $knowledge = $this->createKnowledge([
            'keywords' => 'FASILITAS SEKOLAH',
            'answer' => 'Informasi fasilitas tersedia pada halaman Fasilitas.',
        ]);

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.24',
            ])
            ->postJson(route('chatbot.reply'), [
                'message' => 'Apa saja fasilitas sekolah?',
            ])
            ->assertSuccessful()
            ->assertJson([
                'answer' => $knowledge->answer,
            ]);
    }

    public function test_chatbot_returns_fallback_for_unknown_question(): void
    {
        $this->createKnowledge([
            'keywords' => 'alamat sekolah',
            'answer' => 'Alamat sekolah tersedia pada halaman Kontak.',
        ]);

        $this
            ->withServerVariables([
                'REMOTE_ADDR' => '198.51.100.25',
            ])
            ->postJson(route('chatbot.reply'), [
                'message' => 'Bagaimana kondisi cuaca di luar negeri?',
            ])
            ->assertSuccessful()
            ->assertJson([
                'answer' => ChatbotService::FALLBACK_ANSWER,
            ]);
    }

    public function test_chatbot_message_is_validated(): void
{
    $this
        ->withServerVariables([
            'REMOTE_ADDR' => '198.51.100.26',
        ])
        ->postJson(route('chatbot.reply'), [
            'message' => '',
        ])
        ->assertStatus(422)
        ->assertJsonPath(
            'errors.message.0',
            'Pertanyaan wajib diisi.',
        );
}

    public function test_chatbot_submission_is_rate_limited(): void
    {
        $knowledge = $this->createKnowledge([
            'keywords' => 'profil sekolah',
            'answer' => 'Profil sekolah tersedia pada halaman Profil.',
        ]);

        $this->withServerVariables([
            'REMOTE_ADDR' => '198.51.100.99',
        ]);

        foreach (range(1, 10) as $requestNumber) {
            $this
                ->postJson(route('chatbot.reply'), [
                    'message' => 'Profil sekolah',
                ])
                ->assertSuccessful()
                ->assertJson([
                    'answer' => $knowledge->answer,
                ]);
        }

        $this
            ->postJson(route('chatbot.reply'), [
                'message' => 'Profil sekolah',
            ])
            ->assertStatus(429);
    }

    public function test_chatbot_widget_is_available_on_public_layout(): void
    {
        $this->get(route('contact.index'))
            ->assertSuccessful()
            ->assertSee('data-chatbot-widget', false)
            ->assertSee('data-chatbot-trigger', false)
            ->assertSee(route('chatbot.reply'), false)
            ->assertSee('Tanya Kami');
    }

    private function createKnowledge(
        array $attributes = [],
    ): ChatbotKnowledge {
        return ChatbotKnowledge::query()->create(array_merge([
            'keywords' => 'informasi sekolah',
            'answer' => 'Silakan lihat informasi pada website sekolah.',
            'category' => 'umum',
            'is_active' => true,
        ], $attributes));
    }
}