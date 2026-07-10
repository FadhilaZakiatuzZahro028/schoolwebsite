docs/02-system-architecture.md

# System Architecture - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Laravel 13 + Filament)

## 1. Arsitektur Umum & Alur Data
Sistem dibagi menjadi dua area: Public Website (Blade + Bootstrap 5) dan Admin Panel (Filament Admin). Alur data mengikuti pola standard pencarian berlapis:
`Browser` → `Routes` → `Form Request (Validation)` → `Controller` → `Service Layer` → `Eloquent Model` → `Database`

---

## 2. Struktur Folder Proyek (Laravel 13 Modern)
```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Public/           # Controller khusus halaman depan publik
│   └── Requests/             # Form Request untuk validasi input keras
├── Models/                   # Eloquent Models & Relasi Database
├── Services/                 # Business Logic Layer (Reusable untuk Public & Admin)
│   ├── NewsService.php
│   ├── ContactService.php
│   └── ChatbotService.php
└── Policies/                 # Authorization Rule untuk Admin/Super Admin
resources/
├── views/
│   ├── public/               # Halaman publik (beranda, profil, dll)
│   ├── components/           # Komponen Blade reusable
│   └── layouts/              # Master layout halaman publik
database/
├── migrations/               # Skema database siap produksi
└── seeders/                  # Data awal (User, Profil Sekolah default)
routes/
└── web.php                   # Rute publik (Rute admin dihandle otomatis oleh Filament)

```

---

## 3. Tanggung Jawab Setiap Lapisan (Layer Responsibility)

 Route: Hanya memetakan URL ke Controller. Dilarang menulis logic bisnis atau query database di file rute.
 Controller: Bertugas menerima request, memanggil Service yang sesuai, dan mengembalikan response/view (Thin Controller).
 Form Request: Memisahkan seluruh aturan validasi data dari controller agar kode bersih dan aman.
 Service Layer: Menampung seluruh business logic, pengolahan data intensif, dan query database yang kompleks.
 Model: Merepresentasikan tabel, mengatur relasi antar tabel, pencarian lokal (query scopes), dan mutator data sederhana.

---

## 4. Standar Rute Publik (`routes/web.php`)

```php
use App\Http\Controllers\Public\{HomeController, ProfileController, NewsController, PpdbController, AchievementController, ExtracurricularController, FacilityController, ContactController, ChatbotController};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

Route::prefix('berita')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievements.index');
Route::get('/ekstrakurikuler', [ExtracurricularController::class, 'index'])->name('extracurriculars.index');
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities.index');

Route::prefix('kontak')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store')->middleware('throttle:3,1'); // Limit 3 pesan per menit
});

Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask')->middleware('throttle:20,1');

```

---

## 5. Komponen Basis Data & Manajemen Media

 Konvensi Tabel: Menggunakan format plural snake_case dengan primary key `id` auto-increment, `created_at`, dan `updated_at`.
 Model Entitas Utama: `User`, `SchoolProfile`, `News`, `NewsCategory`, `PpdbSetting`, `Achievement`, `Extracurricular`, `Facility`, `Gallery`, `HeroBanner`, `ContactMessage`, `ChatbotKnowledge`.
 Soft Deletes: Wajib diaktifkan pada data krusial: `news`, `achievements`, `extracurriculars`, `facilities`, dan `contact_messages`.
 Sistem Slug: Field `slug` wajib unik dan digunakan pada entitas `News`, `Achievement`, `Extracurricular`, dan `Facility` untuk keperluan SEO URL.
 Penyimpanan Media: File dilarang disimpan di direktori `public/` secara langsung. Wajib menggunakan `Storage::disk('public')` ke sub-folder spesifik (`logos/`, `heroes/`, `news/`, etc.) dan dikonversi otomatis menjadi format `.webp`.

---

## 6. Arsitektur Chatbot & SEO Lokal

 Mekanisme Chatbot: Menggunakan metode Rule-Based Keyword Matching yang diproses secara internal oleh `ChatbotService` tanpa API eksternal.
 Alur Eksekusi Chatbot: User Input → Normalisasi Teks (Lowercase & Strip) → Pencarian kecocokan kata kunci pada tabel `chatbot_knowledges` → Kembalikan teks jawaban terdekat. Jika nihil, tampilkan pesan fallback default sekolah.
 Skema SEO: Data meta SEO (`meta_title`, `meta_description`, `og_image`) menyatu pada tabel konten dinamis masing-masing, sedangkan untuk data halaman statis ditarik dari konfigurasi global di dashboard Filament.

---

## 7. Keamanan, Performa, & Penanganan Error

 Keamanan Produksi: Autentikasi Filament berlapis via Policy, hashing password (Bcrypt), proteksi CSRF otomatis, sanitasi ketat tipe data file upload, dan isolasi file `.env`.
 Strategi Performa: Wajib menerapkan Eager Loading (`with()`) untuk mencegah masalah N+1 Query, menerapkan pagination otomatis pada list berita, optimasi gambar otomatis, dan lazy loading aset gambar pada sisi frontend.
 Error Handling: Halaman publik dilarang keras menampilkan pesan eror sistem/database raw (Gunakan custom error pages 404 / 500 Laravel). Pesan kegagalan untuk user diseragamkan: "Terjadi kesalahan sistem. Silakan coba beberapa saat lagi."

