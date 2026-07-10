# Functional Requirements Specification (FRS) - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

## 1. Aktor Sistem & Hak Akses Kontrol
 Guest: Publik tanpa login. Hak akses: Membaca seluruh konten publik, mengirim pesan kontak, dan berinteraksi dengan widget Chatbot FAQ.
 Admin Konten: Pengguna terautentikasi. Hak akses: Mengelola CRUD seluruh konten dinamis, profil, dokumen PPDB, dan pangkalan data FAQ Chatbot.
 Super Admin: Pengguna terautentikasi level tertinggi. Hak akses: Memiliki seluruh hak akses Admin Konten, ditambah hak akses CRUD User Admin, hapus permanen data (force delete), dan konfigurasi SEO global.

---

## 2. Spesifikasi Fungsional Per Modul

### Modul 1: Authentication & Dashboard
 Fungsi Login: Admin memasukkan `email` dan `password` via panel Filament. 
   Validasi: Input wajib diisi, format email valid, dan wajib terdaftar. Jika gagal, tampilkan pesan: "Email atau password yang Anda masukkan salah." Jika sukses, arahkan ke halaman Dashboard.
 Fungsi Dashboard: Menampilkan metrik agregat statis: Total Berita Aktif, Total Prestasi, Total Ekskul, Total Fasilitas, Jumlah Pesan Kontak (Belum Dibaca), status Hero Banner aktif, dan statistik tren pencarian kata kunci chatbot.

### Modul 2: Manajemen Profil & Informasi PPDB Statis
 Fungsi Pembaruan Profil: Admin dapat mengubah satu baris data identitas sekolah (Sejarah, Visi, Misi, Sambutan Kepala Sekolah, Telepon, Email, Media Sosial).
 Fungsi Pengaturan PPDB: Admin dapat memperbarui teks panduan alur PPDB dan mengunggah 1 file dokumen brosur baru berformat `.pdf` (Sistem otomatis menghapus file PDF lama dari storage untuk menghemat ruang).

### Modul 3: CRUD Konten Dinamis (Berita, Kategori, Prestasi, Ekskul, Fasilitas, Galeri)
 Validasi & Pemrosesan Input Umum:
   Field Judul/Nama entitas wajib diisi. Sistem otomatis membuat string `slug` unik berdasarkan judul menggunakan `Str::slug()`.
   Pada modul Berita, field `meta_title` dibatasi maksimal 60 karakter dan `meta_description` maksimal 160 karakter.
   Aturan Konversi Gambar: Semua input file gambar (`thumbnail`, `image`) wajib divalidasi maksimal 2 MB dengan format `.jpg`, `.png`, atau `.webp`. Saat disimpan, backend Laravel wajib mengonversi paksa gambar tersebut menjadi format `.webp` dengan tingkat kompresi optimal.
 Logika Bisnis Konten (Business Rules):
   Status Berita: Hanya berita berstatus `published` dengan `published_at` <= waktu sekarang yang muncul di halaman depan. Berita berstatus `draft` disembunyikan.
   Slug Lock: Jika berita atau konten sudah berstatus `published`, perubahan judul berikutnya tidak boleh mengubah string `slug` yang lama demi menjaga kestabilan indeks SEO URL.
   Soft Deletes: Penghapusan data Berita, Prestasi, Ekskul, dan Fasilitas menggunakan metode `SoftDeletes`. Data dipindahkan ke tempat sampah sementara; hanya Super Admin yang memiliki tombol untuk menghapus data secara permanen dari database (force delete).

### Modul 4: Manajemen Hero Banner Slider
 Logika Banner Utama: Admin dapat melakukan CRUD gambar banner slider beranda depan (Input: Judul, Subjudul, Gambar Latar, Teks Tombol CTA, URL Link CTA, Status Aktif, Urutan).
 Aturan Eksklusivitas: Hanya diperbolehkan ada 1 Hero Banner dengan status `is_active = true` dalam satu waktu. Jika Admin mengaktifkan banner baru, sistem backend wajib otomatis mengubah status banner aktif sebelumnya menjadi `false` (automatic toggle override).

### Modul 5: Formulir Hubungi Kami (Kontak Publik)
 Sisi Frontend (Guest): Input wajib diisi: Nama, Email (format valid), Subjek, dan Pesan (minimal 10 karakter).
 Sisi Backend & Triggers: Setelah form lolos validasi keras, data wajib disimpan ke tabel `contact_messages`, memicu pengiriman notifikasi email otomatis ke alamat resmi sekolah, dan memunculkan notifikasi alert badge baru di dashboard admin.
 Proteksi Anti-Spam (Rate Limiting): Membatasi pengiriman formulir dari alamat IP Guest yang sama maksimal 3 kali pesan per 1 menit (diatur via Laravel Middleware Throttle).

### Modul 6: Chatbot FAQ Lokal (Rule-Based Keyword Matching)
 Mekanisme Respon: Widget chat menerima input teks dari Guest. `ChatbotService` melakukan normalisasi teks menjadi huruf kecil (lowercase) dan memotong karakter simbol.
 Logika Kueri Database: Sistem memindai kolom `keywords` pada tabel `chatbot_knowledges` menggunakan kueri pencarian teks (`LIKE %keyword%`). Jika ada kata kunci yang cocok, tampilkan kolom `answer` terkait ke layar chat dalam waktu < 1 detik.
 Aturan Penolakan (Fallback Rule): Jika sistem tidak menemukan kecocokan kata kunci sama sekali di database, atau jika user memasukkan pertanyaan di luar topik sekolah (politik, SARA, pemrograman, matematika), chatbot wajib menampilkan jawaban penolakan standar: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."
 Proteksi Beban Server (Rate Limiting): Maksimal 20 pertanyaan per IP per 1 jam.

### Modul 7: Optimasi SEO Otomatis & Sistem Logging
 Logika SEO Cadangan (Fallback SEO): Jika Admin mengosongkan kolom `meta_title` saat menulis konten berita/prestasi, sistem wajib otomatis mengisi meta title menggunakan judul konten. Jika `meta_description` kosong, sistem otomatis memotong teks konten sebanyak 150 karakter sebagai deskripsi (auto-excerpt fallback).
 Sistem Pencatatan Aktivitas (Logging): Laravel wajib mencatat log aktivitas krusial yang dilakukan oleh akun admin ke dalam file log sistem (`storage/logs/laravel.log`). Aktivitas yang wajib dicatat meliputi: Riwayat Login, Tambah/Edit Berita, Perubahan Profil Sekolah, Pengaktifan Hero Banner, dan Penghapusan Data.

---

## 3. Arsitektur Penanganan Eror (Error Handling Strategy)
 Isolasi Eror Teknis: Mode `.env` `APP_DEBUG` wajib diatur menjadi `false` pada lingkungan produksi. 
 Pengunjung umum dilarang melihat pesan kegagalan mentah dari database (raw database error Exception seperti SQLSTATE Code). Seluruh kegagalan sistem wajib dialihkan ke halaman custom error page (404 / 500) dengan pesan ramah pengguna: "Terjadi kesalahan sistem. Silakan coba beberapa saat lagi."

---

## 4. Kriteria Keberhasilan Rilis (Definition of Success)
Fitur atau modul dianggap selesai dan valid jika memenuhi kriteria: Lolos seluruh validasi Form Request, lulus pengujian fungsionalitas, tampilan adaptif-responsif di layar mobile, kontras warna lulus aksesibilitas (a11y), meta data SEO terisi lengkap, dan tidak menyisakan bug mayor.