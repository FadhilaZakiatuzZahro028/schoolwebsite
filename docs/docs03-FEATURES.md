# Features Documentation - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

---

## MODUL 1: PUBLIC WEBSITE (FRONTEND)

### 1. Beranda (Home Page)
 Tujuan: Menyajikan impresi pertama yang profesional dan ringkasan informasi sekolah dalam waktu < 3 detik.
 Komponen Fitur: Hero Banner Dinamis (Slider/Single), Menu Navigasi Cepat, Sambutan Kepala Sekolah, Profil Singkat & Statistik (Jumlah Siswa/Guru/Kelas), Widget 3 Berita Terbaru, Widget 3 Prestasi Terkini, Ekstrakurikuler Unggulan, Komponen Galeri Foto, Google Maps Lokasi, dan Widget Chatbot FAQ (Floating).
 Acceptance Criteria: Responsif di semua ukuran layar, gambar terkompresi otomatis, teks dinamis dari database, tombol CTA berfungsi penuh.
 Future Enhancement: Video Profile Sekolah (Embed YouTube).

### 2. Profil Sekolah
 Tujuan: Menyediakan informasi legalitas dan identitas resmi sekolah kepada publik.
 Komponen Fitur: Sejarah Sekolah, Struktur Organisasi, Visi & Misi, Nilai/Tujuan Sekolah, Profil Kepala Sekolah, serta Daftar Guru & Staf Aktif.
 Acceptance Criteria: Seluruh data teks, nama guru, jabatan, dan foto ditarik secara dinamis dari database.

### 3. Berita & Artikel
 Tujuan: Media publikasi resmi mengenai kegiatan, pengumuman, dan prestasi internal sekolah.
 Komponen Fitur: Halaman list berita dengan pagination, pencarian berita berdasarkan judul, filter kategori (Berita, Pengumuman, Kegiatan, Akademik), halaman detail berita (SEO friendly URL via Slug), artikel terkait (Related News), dan tombol share media sosial.
 Acceptance Criteria: Mendukung status Draft/Published, optimasi metadata per berita, gambar utama wajib dikonversi otomatis ke `.webp`.
 Future Enhancement: Kolom komentar (moderated) dan sistem kuesioner/survei singkat.

### 4. Informasi PPDB (Statis)
 Tujuan: Menyediakan pusat informasi pendaftaran siswa baru yang jelas untuk sekolah nyata tanpa sistem seleksi online.
 Komponen Fitur: Informasi Alur Pendaftaran, Syarat Pendaftaran, Biaya Pendidikan, Jadwal Penting, Tombol Unduh Brosur (PDF), dan tautan eksternal (jika ada sistem dinas).
 Acceptance Criteria: File PDF brosur dapat diunggah admin dari backend, teks komponen bersifat dinamis dari database.

### 5. Pojok Siswa: Prestasi & Ekstrakurikuler
 Modul Prestasi: Menampilkan daftar pencapaian (Akademik & Non-Akademik) dilengkapi informasi: Nama Prestasi, Juara ke-Berapa, Tingkat (Kabupaten/Provinsi/Nasional), Tahun, Deskripsi Singkat, dan Foto Dokumentasi.
 Modul Ekstrakurikuler: Menampilkan profil organisasi kesiswaan dilengkapi: Nama Ekskul, Deskripsi Kegiatan, Nama Pembina, Hari & Jam Latihan, serta Foto Kegiatan.
 Acceptance Criteria: Memiliki fitur filter pencarian, layout responsif dalam bentuk grid kartu yang rapi.

### 6. Fasilitas Sekolah
 Tujuan: Menampilkan sarana dan prasarana penunjang kegiatan belajar mengajar.
 Komponen Fitur: Grid foto fasilitas (Ruang Kelas, Laboratorium, Perpustakaan, Mushola, Lapangan Olahraga, dll) disertai judul dan penjelasan fungsi fasilitas.
 Future Enhancement: Integrasi 360° Virtual Tour.

### 7. Kontak & Hubungi Kami
 Tujuan: Menyediakan saluran komunikasi resmi bagi masyarakat umum dan orang tua siswa.
 Komponen Fitur: Detail Kontak (Alamat lengkap, Email resmi, Telepon, WhatsApp Link), Jam Layanan, Embed Google Maps, dan Form Hubungi Kami (Input: Nama, Email, No. HP, Subjek, Pesan).
 Acceptance Criteria: Form memiliki proteksi rate limiting anti-spam, input wajib divalidasi keras, pesan tersimpan ke database dan memicu notifikasi email.

### 8. Chatbot FAQ Lokal
 Tujuan: Otomatisasi layanan informasi 24/7 untuk menjawab pertanyaan seputar sekolah secara gratis dan cepat.
 Komponen Fitur: Antarmuka obrolan (chat widget) di pojok kanan bawah. Memproses input teks user menggunakan metode pencarian kata kunci (rule-based keyword matching) terhadap basis data FAQ lokal.
 Scope Jawaban: Hanya merespon seputar Profil, Alamat, Kontak, Fasilitas, Berita, Ekskul, Prestasi, dan PPDB Statis.
 Fallback Response: Jika tidak ada kata kunci yang cocok, memunculkan teks seragam: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."

---

## MODUL 2: ADMIN PANEL (FILAMENT BACKEND)

 Dashboard Statis: Menampilkan ringkasan data berupa total berita aktif, pesan kontak belum dibaca, total prestasi, total ekskul, dan statistik sederhana penggunaan kata kunci chatbot.
 Manajemen Profil & PPDB: Halaman form tunggal untuk memperbarui data identitas sekolah, visi-misi, susunan guru, serta dokumen/informasi PPDB statis.
 CRUD Konten Dinamis: Pengelolaan penuh (Create, Read, Update, Delete) untuk modul Berita, Kategori, Prestasi, Ekstrakurikuler, Fasilitas, Album Galeri, dan Banner Slider Utama. Setiap form CRUD konten dinamis wajib menyatu dengan input SEO (Slug, Meta Title, Meta Description).
 Manajemen Pesan Kontak: Fitur membaca pesan masuk dari publik, mengubah status pesan (Belum Dibaca / Sudah Dibaca), dan opsi menghapus pesan.
 Manajemen Chatbot FAQ: CRUD pangkalan data pasangan Pertanyaan (Keywords) dan Jawaban yang menjadi acuan respon mesin chatbot lokal.
 Manajemen Pengguna & Sistem: Pengaturan akun admin dengan pembagian role (Super Admin untuk kontrol sistem penuh; Admin Konten untuk kelola konten publik) serta halaman konfigurasi SEO global.

---

## MODUL 3: SYSTEM INTEGRAL FEATURES (NON-FUNCTIONAL)
 Security: Proteksi CSRF, Form Validation, Authentication, Mass Assignment Protection, dan enkripsi password.
 Performance: Eager loading relasi model database, pagination otomatis, caching berkala pengaturan situs, dan konversi otomatis gambar ke `.webp`.
 Error Handling: Menonaktifkan mode debug pada production environment dan menampilkan halaman kustom 404/500 yang aman bagi user awam.

---

## MODUL 4: FUTURE ROADMAP (VERSI LANJUTAN)
 Pengembangan sistem fungsional terintegrasi: Portal Guru & Staf, Portal Nilai Siswa, Sistem Absensi Digital, PPDB Online Penuh (Seleksi Sistem), Platform E-Learning (CBT), Perpustakaan Digital, dan Aplikasi Mobile Native (Android & iOS).