# System Architecture - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.3 | Status: Revised Approved Baseline (Laravel 13 + Filament)

## 1. Arsitektur Umum & Alur Data
Sistem dibagi menjadi dua area: Public Website (Blade + Bootstrap 5) dan Admin Panel (Filament Admin). Alur data mengikuti pola standard pencarian berlapis:

`Browser` → `Routes` → `Form Request (Validation)` → `Controller` → `Service Layer` → `Eloquent Model` → `Database`

Penggunaan Service Layer disesuaikan dengan kebutuhan. Logic sederhana dapat ditangani melalui Controller dan Model secara terstruktur, sedangkan business logic kompleks dan reusable wajib dipisahkan ke Service Class.

Pendataan Alumni tidak diproses atau disimpan melalui database Laravel. Website hanya menyediakan akses menuju Google Forms milik sekolah, sedangkan hasil pendataan dikelola melalui Google Sheets.

---

## 2. Struktur Folder Proyek (Laravel 13 Modern)

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Public/           # Controller khusus halaman depan publik
│   └── Requests/             # Form Request untuk validasi input
├── Models/                   # Eloquent Models & Relasi Database
├── Services/                 # Business Logic Layer jika diperlukan
│   ├── NewsService.php
│   ├── ContactService.php
│   └── ChatbotService.php
└── Policies/                 # Authorization Rule untuk Admin/Super Admin

resources/
├── views/
│   ├── public/               # Halaman publik
│   ├── components/           # Komponen Blade reusable
│   └── layouts/              # Master layout halaman publik

database/
├── migrations/               # Skema database siap produksi
└── seeders/                  # Data awal sistem

routes/
└── web.php                   # Rute publik, sedangkan rute admin ditangani Filament
```

---

## 3. Tanggung Jawab Setiap Lapisan (Layer Responsibility)

 Route: Hanya memetakan URL ke Controller. Dilarang menulis logic bisnis atau query database di file rute.

 Controller: Bertugas menerima request, mengambil atau meneruskan data yang diperlukan, memanggil Service jika terdapat business logic kompleks, dan mengembalikan response/view (Thin Controller).

 Form Request: Memisahkan aturan validasi input publik dari controller agar kode lebih bersih dan aman.

 Service Layer: Digunakan untuk business logic yang kompleks, proses reusable, pengolahan file, atau operasi yang digunakan oleh lebih dari satu bagian sistem.

 Model: Merepresentasikan tabel, mengatur relasi antar tabel, query scopes, casting, dan mutator data sederhana.

---

## 4. Standar Rute Publik (`routes/web.php`)

```php
use App\Http\Controllers\Public\{
    AchievementController,
    AlumniController,
    ChatbotController,
    ContactController,
    CurriculumController,
    ExtracurricularController,
    FacilityController,
    HomeController,
    NewsController,
    ProfileController,
    SpmbController,
    StaffController
};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
Route::get('/sejarah', [ProfileController::class, 'history'])->name('history');

Route::get('/guru', [StaffController::class, 'teachers'])->name('staff.teachers');
Route::get('/karyawan', [StaffController::class, 'employees'])->name('staff.employees');

Route::get('/kurikulum', [CurriculumController::class, 'index'])->name('curriculums.index');
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities.index');

Route::prefix('berita')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

Route::get('/spmb', [SpmbController::class, 'index'])->name('spmb.index');

Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievements.index');
Route::get('/ekstrakurikuler', [ExtracurricularController::class, 'index'])->name('extracurriculars.index');

Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');

Route::prefix('kontak')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])
        ->name('store')
        ->middleware('throttle:3,1');
});

Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])
    ->name('chatbot.ask')
    ->middleware('throttle:20,1');
```

Halaman Alumni hanya memiliki route `GET` karena pendataan alumni dilakukan melalui Google Forms eksternal dan tidak dikirim ke backend Laravel.

---

## 5. Komponen Basis Data & Manajemen Media

 Konvensi Tabel: Menggunakan format plural snake_case dengan primary key `id` auto-increment, `created_at`, dan `updated_at`.

 Model Entitas Utama: `User`, `SchoolProfile`, `SiteSetting`, `News`, `NewsCategory`, `Achievement`, `Extracurricular`, `Facility`, `Gallery`, `HeroBanner`, `Curriculum`, `StaffMember`, `AlumniHighlight`, `ContactMessage`, dan `ChatbotKnowledge`.

 Staff Member: Data Guru dan Karyawan menggunakan satu model `StaffMember`. Perbedaan jenis data ditentukan melalui field kategori staf seperti `teacher` dan `employee`. Halaman publik tetap dipisahkan menjadi Data Guru dan Data Karyawan.

 Alumni: Website hanya menyimpan data `AlumniHighlight` untuk maksimal 4 Alumni Pilihan yang ditampilkan kepada publik. Data hasil pendataan alumni tidak disimpan di database Laravel.

 Soft Deletes: Digunakan pada data yang memang membutuhkan perlindungan dari penghapusan tidak disengaja sesuai desain database masing-masing modul.

 Sistem Slug: Field `slug` wajib unik dan digunakan pada entitas `News`, `Achievement`, `Extracurricular`, dan `Facility` untuk keperluan SEO URL.

 Penyimpanan Media: File dilarang disimpan langsung di direktori `public/`. Seluruh media yang dikelola website wajib menggunakan Laravel Storage pada sub-folder sesuai modul.

 Optimasi Gambar: Gambar yang digunakan sebagai media tampilan website dikonversi menjadi `.webp` menggunakan fondasi optimasi gambar yang sudah tersedia.

 File Unduhan: File gambar asli yang memang disediakan untuk diunduh pada modul Kurikulum dan SPMB tetap dipertahankan secara terpisah dari versi WebP yang digunakan sebagai preview website.

 Foto Guru & Karyawan: Foto disimpan melalui Laravel Storage dan dioptimasi menjadi WebP. Foto bersifat opsional dan frontend menggunakan placeholder apabila foto tidak tersedia.

---

## 6. Arsitektur Modul Alumni & Integrasi Google Forms

Halaman Alumni memiliki dua fungsi utama:

1. Menampilkan maksimal 4 Alumni Pilihan yang dikelola melalui Filament Admin.
2. Menyediakan tombol atau akses menuju Google Forms resmi milik sekolah untuk pendataan alumni.

Alur pendataan:

`Halaman Alumni` → `Google Forms` → `Google Sheets milik sekolah`

URL Google Forms tidak boleh ditulis secara hardcode di Blade. URL harus berasal dari konfigurasi dinamis yang dapat dikelola melalui sistem atau database.

Pendataan alumni dapat mencakup nama, nomor HP/WhatsApp, email, tahun kelulusan, pekerjaan atau aktivitas, instansi, domisili, foto opsional, dan informasi tambahan sesuai kebutuhan sekolah.

Laravel tidak menyimpan, memproses, atau melakukan sinkronisasi otomatis terhadap hasil Google Forms pada versi awal sistem.

---

## 7. Arsitektur Chatbot & SEO Lokal

 Mekanisme Chatbot: Menggunakan metode Rule-Based Keyword Matching yang diproses secara internal oleh `ChatbotService` tanpa API eksternal.

 Alur Eksekusi Chatbot: User Input → Normalisasi Teks → Pencarian kecocokan kata kunci pada tabel `chatbot_knowledges` → Kembalikan jawaban yang sesuai. Jika tidak ditemukan, tampilkan pesan fallback default sekolah.

 Ruang Lingkup Informasi: Chatbot dapat menyediakan jawaban seputar Profil Sekolah, Sejarah, Guru, Karyawan, Kurikulum, SPMB, Berita, Prestasi, Ekstrakurikuler, Fasilitas, Alumni, dan Kontak berdasarkan data FAQ yang tersedia.

 Skema SEO: Data meta SEO digunakan pada konten dinamis yang membutuhkannya, sedangkan halaman lainnya menggunakan konfigurasi SEO global sebagai fallback.

---

## 8. Keamanan, Performa, & Penanganan Error

 Keamanan Produksi: Autentikasi Filament berlapis melalui Policy, hashing password, proteksi CSRF otomatis, validasi dan sanitasi file upload, rate limiting pada endpoint publik yang menerima input, serta isolasi file `.env`.

 Privasi Alumni: Data pribadi hasil pendataan alumni dikelola melalui akun dan layanan Google milik sekolah dan tidak otomatis ditampilkan pada website.

 Keamanan Tautan Eksternal: URL Google Forms harus berasal dari konfigurasi terpercaya yang dikelola admin dan tidak menerima URL bebas dari input pengunjung.

 Strategi Performa: Menggunakan eager loading jika terdapat relasi yang membutuhkan, pagination pada data dalam jumlah besar, optimasi gambar WebP, dan lazy loading aset gambar pada frontend.

 Error Handling: Halaman publik dilarang menampilkan pesan eror sistem atau database secara mentah. Sistem menggunakan halaman error 404/500 yang ramah pengguna dengan pesan:

"Terjadi kesalahan sistem. Silakan coba beberapa saat lagi."