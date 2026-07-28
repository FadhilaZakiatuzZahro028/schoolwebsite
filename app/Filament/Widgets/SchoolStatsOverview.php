<?php

namespace App\Filament\Widgets;

use App\Models\Achievement;
use App\Models\ContactMessage;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\News;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SchoolStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Website';

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Berita Aktif',
                News::query()->published()->count(),
            ),

            Stat::make(
                'Total Prestasi',
                Achievement::query()->count(),
            ),

            Stat::make(
                'Total Ekstrakurikuler',
                Extracurricular::query()->count(),
            ),

            Stat::make(
                'Total Fasilitas',
                Facility::query()->count(),
            ),

            Stat::make(
                'Pesan Kontak Belum Dibaca',
                ContactMessage::query()->unread()->count(),
            ),
        ];
    }
}