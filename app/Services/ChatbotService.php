<?php

namespace App\Services;

use App\Models\ChatbotKnowledge;
use Illuminate\Support\Collection;

class ChatbotService
{
    public const FALLBACK_ANSWER =
        'Maaf, saya belum menemukan informasi yang sesuai. '
        . 'Silakan gunakan menu website atau hubungi pihak sekolah '
        . 'melalui halaman Kontak.';

    public function answer(string $question): string
    {
        $normalizedQuestion = $this->normalize($question);

        if ($normalizedQuestion === '') {
            return self::FALLBACK_ANSWER;
        }

        $matchedKnowledge = ChatbotKnowledge::query()
            ->active()
            ->get([
                'id',
                'keywords',
                'answer',
            ])
            ->map(function (
                ChatbotKnowledge $knowledge,
            ) use ($normalizedQuestion): array {
                return [
                    'knowledge' => $knowledge,
                    'score' => $this->matchScore(
                        $normalizedQuestion,
                        $knowledge->keywords,
                    ),
                ];
            })
            ->filter(
                fn (array $result): bool => $result['score'] > 0,
            )
            ->sortByDesc('score')
            ->first();

        if ($matchedKnowledge === null) {
            return self::FALLBACK_ANSWER;
        }

        return $matchedKnowledge['knowledge']->answer;
    }

    private function matchScore(
        string $normalizedQuestion,
        string $keywords,
    ): int {
        return $this->splitKeywords($keywords)
            ->map(function (string $keyword) use (
                $normalizedQuestion,
            ): int {
                $normalizedKeyword = $this->normalize($keyword);

                if ($normalizedKeyword === '') {
                    return 0;
                }

                if ($normalizedQuestion === $normalizedKeyword) {
                    return 10_000 + mb_strlen($normalizedKeyword);
                }

                $questionWithBoundary =
                    " {$normalizedQuestion} ";

                $keywordWithBoundary =
                    " {$normalizedKeyword} ";

                if (
                    str_contains(
                        $questionWithBoundary,
                        $keywordWithBoundary,
                    )
                ) {
                    return 1_000 + mb_strlen($normalizedKeyword);
                }

                return 0;
            })
            ->max() ?? 0;
    }

    /**
     * @return Collection<int, string>
     */
    private function splitKeywords(string $keywords): Collection
    {
        return collect(
            preg_split(
                '/[,;\r\n]+/u',
                $keywords,
            ) ?: [],
        )
            ->map(fn (string $keyword): string => trim($keyword))
            ->filter()
            ->values();
    }

    private function normalize(string $value): string
    {
        $normalized = mb_strtolower(trim($value));

        $normalized = preg_replace(
            '/[^\pL\pN\s]+/u',
            ' ',
            $normalized,
        ) ?? '';

        return preg_replace(
            '/\s+/u',
            ' ',
            trim($normalized),
        ) ?? '';
    }
}