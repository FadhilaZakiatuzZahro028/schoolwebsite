<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ChatbotKnowledge extends Model
{
    /** @var array<string, string> */
    public const CATEGORY_OPTIONS = [
        'umum' => 'Umum',
        'profil' => 'Profil Sekolah',
        'sejarah' => 'Sejarah Sekolah',
        'guru' => 'Data Guru',
        'karyawan' => 'Data Karyawan',
        'kurikulum' => 'Kurikulum',
        'spmb' => 'SPMB',
        'berita' => 'Berita',
        'prestasi' => 'Prestasi',
        'ekstrakurikuler' => 'Ekstrakurikuler',
        'fasilitas' => 'Fasilitas',
        'alumni' => 'Alumni',
        'kontak' => 'Kontak',
        'alamat' => 'Alamat',
    ];

    protected $table = 'chatbot_knowledges';

    protected $fillable = [
        'keywords',
        'answer',
        'category',
        'is_active',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $query->when($category, fn (Builder $query): Builder => $query->where('category', $category));
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
