# Database Design - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

## 1. Spesifikasi Teknis Database
 Database Engine: MySQL 8.0+ / MariaDB 10.4+
 Character Set & Collation: `utf8mb4` / `utf8mb4_unicode_ci`
 Default Timezone: `Asia/Jakarta` (WIB)

---

## 2. Skema Tabel & Tipe Data (Laravel Migration Blueprint)

### 2.1 Tabel Autentikasi & Profil Utama
 `users` (Data Manajemen Akun Admin)
   `id` (unsignedBigInteger, PK) | `name` (string) | `email` (string, Unique) | `password` (string) | `role` (enum: 'super_admin', 'admin') | `remember_token` | `timestamps`
 `school_profiles` (Informasi Sekolah & Data PPDB Statis - Maksimal 1 Row)
   `id` (unsignedBigInteger, PK) | `school_name` (string) | `tagline` (string) | `history` (text) | `vision` (text) | `mission` (text) | `principal_name` (string) | `principal_message` (text) | `logo` (string/nullable) | `favicon` (string/nullable) | `ppdb_info` (text/nullable) | `ppdb_brochure` (string/nullable) | `address` (text) | `phone` (string) | `email` (string) | `maps_embed` (text/nullable) | `instagram` (string/nullable) | `facebook` (string/nullable) | `youtube` (string/nullable) | `timestamps`

### 2.2 Tabel Konten Dinamis Publik
 `news_categories` (Kategori Berita)
   `id` (unsignedBigInteger, PK) | `name` (string) | `slug` (string, Unique) | `timestamps`
 `news` (Artikel & Pengumuman Sekolah)
   `id` (unsignedBigInteger, PK) | `category_id` (FK -> `news_categories.id`, Cascade) | `author_id` (FK -> `users.id`, Set Null) | `title` (string) | `slug` (string, Unique) | `excerpt` (text) | `content` (longText) | `thumbnail` (string) | `status` (enum: 'draft', 'published') | `meta_title` (string/nullable) | `meta_description` (text/nullable) | `view_count` (integer, default: 0) | `published_at` (timestamp/nullable) | `timestamps` | `softDeletes`
 `achievements` (Data Prestasi Sekolah)
   `id` (unsignedBigInteger, PK) | `title` (string) | `slug` (string, Unique) | `description` (text) | `level` (enum: 'Sekolah', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional') | `year` (year) | `image` (string) | `timestamps` | `softDeletes`
 `extracurriculars` (Data Organisasi Kesiswaan)
   `id` (unsignedBigInteger, PK) | `name` (string) | `slug` (string, Unique) | `description` (text) | `coach_name` (string) | `schedule` (string) | `image` (string) | `timestamps` | `softDeletes`
 `facilities` (Sarana Prasarana)
   `id` (unsignedBigInteger, PK) | `name` (string) | `slug` (string, Unique) | `description` (text) | `image` (string) | `timestamps` | `softDeletes`
 `galleries` (Album Foto Kegiatan)
   `id` (unsignedBigInteger, PK) | `title` (string) | `description` (string/nullable) | `image` (string) | `timestamps`

### 2.3 Tabel Interaksi, Komponen Visual, & Chatbot FAQ
 `hero_banners` (Slider Beranda Depan)
   `id` (unsignedBigInteger, PK) | `title` (string) | `subtitle` (string/nullable) | `image` (string) | `button_text` (string/nullable) | `button_url` (string/nullable) | `sort_order` (integer, default: 0) | `is_active` (boolean, default: true) | `timestamps`
 `contact_messages` (Formulir Kontak Masuk)
   `id` (unsignedBigInteger, PK) | `name` (string) | `email` (string) | `phone` (string/nullable) | `subject` (string) | `message` (text) | `is_read` (boolean, default: false) | `ip_address` (string/nullable) | `timestamps` | `softDeletes`
 `chatbot_knowledges` (Pangkalan Data Kata Kunci Chatbot FAQ Lokal)
   `id` (unsignedBigInteger, PK) | `keywords` (text) -> Contoh data: "biaya, bayar, spp, uang gedung" | `answer` (text) | `category` (string, default: 'umum') | `is_active` (boolean, default: true) | `timestamps`
 `site_settings` (Konfigurasi SEO & Sistem Global - Maksimal 1 Row)
   `id` (unsignedBigInteger, PK) | `site_name` (string) | `site_description` (text) | `default_meta_keywords` (string) | `default_og_image` (string/nullable) | `copyright_text` (string) | `is_maintenance` (boolean, default: false) | `timestamps`

---

## 3. Strategi Indexing & Soft Deletes
 Database Indexes (Kecepatan Query): Wajib diterapkan pada kolom pencarian dan relasi berikut:
   `news.slug` (Unique), `news.status`, `news.published_at`
   `achievements.slug` (Unique), `achievements.year`
   `extracurriculars.slug` (Unique), `facilities.slug` (Unique)
   `news.category_id` (Foreign Key Index)
 Soft Deletes Feature: Diaktifkan hanya pada tabel transaksional/konten besar untuk keamanan data dari ketidaksengajaan hapus oleh Admin: `news`, `achievements`, `extracurriculars`, `facilities`, dan `contact_messages`.

---

## 4. Aturan Validasi File Storage & Konvensi Direktori
Seluruh aset binary gambar dan dokumen wajib disimpan menggunakan driver `Storage` bawaan Laravel dengan struktur folder publik sebagai berikut:
 `logos/` (Menampung file logo instansi dan favicon sekolah)
 `heroes/` (Gambar latar slider banner utama beranda depan)
 `news/` (Gambar utama artikel berita - dikonversi paksa ke sistem `.webp`)
 `achievements/` / `facilities/` / `extracurriculars/` / `gallery/` (Dokumentasi visual grid)
 `documents/` (Menyimpan file statis unduhan brosur PDF program PPDB)

---

## 5. Estimasi Volume Data Riil Sekolah (Kapasitas Skala Kecil-Menengah)
Database dikonfigurasi secara efisien untuk menangani pertumbuhan data tahunan sekolah tunggal dengan estimasi kapasitas sebagai berikut:

| Nama Tabel | Estimasi Jumlah Data Aktual | Sifat Pertumbuhan Data |
| :--- | :--- | :--- |
| `school_profiles` / `site_settings` | 1 Record | Statis permanen (hanya dilakukan update) |
| `users` (Akses Admin) | 2 - 5 Record | Sangat statis |
| `news` (Berita & Pengumuman) | 50 - 200 Record | Tumbuh berkala (1-2 artikel per minggu) |
| `achievements` (Prestasi) | 30 - 100 Record | Tumbuh lambat (berdasarkan kompetisi tahunan) |
| `extracurriculars` / `facilities` | 10 - 25 Record | Statis (berubah jika ada sarpras baru) |
| `galleries` (Foto Kegiatan) | 100 - 300 Record | Tumbuh moderat |
| `contact_messages` (Pesan Masuk) | 100 - 500 Record | Dinamis (berkala dibersihkan dengan Soft Delete) |
| `chatbot_knowledges` (Data FAQ) | 30 - 80 Record | Statis (diperbarui jika ada kebijakan baru) |