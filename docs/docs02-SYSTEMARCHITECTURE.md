# System Architecture - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.4 | Status: Revised Approved Baseline (Laravel 13 + Filament)

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
    FeaturedProgramController,
    HomeController,
    NewsController,
    ProfileController,
    SpmbController,
    GalleryController,
    StaffController
};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
Route::get('/sejarah', [ProfileController::class, 'history'])->name('history');

Route::get('/guru', [StaffController::class, 'teachers'])->name('staff.teachers');
Route::get('/karyawan', [StaffController::class, 'employees'])->name('staff.employees');

Route::get('/kurikulum', [CurriculumController::class, 'index'])->name('curriculums.index');

Route::get('/program-unggulan', [
    FeaturedProgramController::class,
    'index',
])->name('featured-programs.index');

Route::prefix('fasilitas')->name('facilities.')->group(function () {
    Route::get('/', [
        FacilityController::class,
        'index',
    ])->name('index');

    Route::get('/{slug}', [
        FacilityController::class,
        'show',
    ])->name('show');
});

Route::prefix('berita')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

Route::get('/spmb', [SpmbController::class, 'index'])->name('spmb.index');

Route::prefix('prestasi')
    ->name('achievements.')
    ->group(function (): void {
        Route::get('/', [
            AchievementController::class,
            'index',
        ])->name('index');

        Route::get('/{slug}', [
            AchievementController::class,
            'show',
        ])->name('show');
    });

Route::get('/ekstrakurikuler', [ExtracurricularController::class, 'index'])->name('extracurriculars.index');

Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');

Route::get('/galeri', [
    GalleryController::class,
    'index',
])->name('gallery.index');

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

 Model Entitas Utama: `User`, `SchoolProfile`, `SiteSetting`, `News`, `NewsCategory`, `Achievement`, `Extracurricular`, `Facility`, `FeaturedProgramSetting`, `FeaturedProgram`, `FeaturedProgramImage`, `Gallery`, `HeroBanner`, `Curriculum`, `StaffMember`, `StaffEducation`, `AlumniHighlight`, `ContactMessage`, dan `ChatbotKnowledge`.

Staff Member: Data Guru dan Karyawan menggunakan satu model `StaffMember`. Perbedaan jenis data ditentukan melalui field kategori staf seperti `teacher` dan `employee`. Halaman publik tetap dipisahkan menjadi Data Guru dan Data Karyawan.

Staff Education: Riwayat pendidikan staf disimpan melalui model `StaffEducation` yang berelasi one-to-many dengan `StaffMember`. Satu staf dapat memiliki lebih dari satu riwayat pendidikan. Setiap riwayat dapat menyimpan jenjang pendidikan, program studi, nama institusi, dan urutan tampil.

Tampilan Publik Staf: Data Guru dan Karyawan disajikan menggunakan centered horizontal carousel. Halaman Guru menggunakan data Guru aktif berdasarkan `sort_order`, dengan Kepala Sekolah ditempatkan pada urutan paling awal sehingga menjadi slide pertama. Halaman Karyawan menggunakan urutan `sort_order` Karyawan aktif.

Featured Program Setting: Informasi tingkat halaman seperti pengantar Program Unggulan dan keterangan umum kolaborasi LPK/BLK disimpan melalui singleton `FeaturedProgramSetting`. Data ini bersifat dinamis agar informasi sekolah tidak ditulis secara hardcode pada Blade.

Featured Program: Data Program Unggulan menggunakan model `FeaturedProgram`. Setiap program menyimpan nama, ringkasan, deskripsi/manfaat, foto utama, status aktif, dan urutan tampil. Hanya program aktif yang digunakan pada halaman publik dan data ditampilkan berdasarkan `sort_order`.

Featured Program Image: Dokumentasi tambahan Program Unggulan disimpan melalui model `FeaturedProgramImage` yang memiliki relasi one-to-many dengan `FeaturedProgram`. Setiap program dapat memiliki maksimal 2 foto dokumentasi tambahan yang memiliki teks alternatif dan urutan tampil.

Tampilan Publik Program Unggulan: Seluruh Program Unggulan disajikan melalui satu landing page `/program-unggulan`. Versi saat ini tidak menyediakan halaman detail per program sehingga entitas `FeaturedProgram` tidak membutuhkan slug untuk routing publik.

 Alumni: Website hanya menyimpan data `AlumniHighlight` untuk maksimal 4 Alumni Pilihan yang ditampilkan kepada publik. Data hasil pendataan alumni tidak disimpan di database Laravel.

 Soft Deletes: Digunakan pada data yang memang membutuhkan perlindungan dari penghapusan tidak disengaja sesuai desain database masing-masing modul.

  Sistem Slug: Field `slug` wajib unik dan digunakan pada entitas `News`, `Achievement`, `Extracurricular`, dan `Facility` yang memiliki URL detail SEO-friendly. `FeaturedProgram` tidak menggunakan slug pada versi saat ini karena seluruh program ditampilkan melalui satu landing page tanpa route detail per program.

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