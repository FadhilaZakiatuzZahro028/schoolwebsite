# Database Design - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.3 | Status: Revised Approved Baseline (Production-Ready)

## 1. Spesifikasi Teknis Database
 Database Engine: MySQL 8.0+ / MariaDB 10.4+
 Character Set & Collation: `utf8mb4` / `utf8mb4_unicode_ci`
 Default Timezone: `Asia/Jakarta` (WIB)

---

## 2. Skema Tabel & Tipe Data (Laravel Migration Blueprint)

### 2.1 Tabel Autentikasi & Profil Utama

 `users` (Data Manajemen Akun Admin)
   `id` (unsignedBigInteger, PK) | `name` (string) | `email` (string, Unique) | `password` (string) | `role` (enum: 'super_admin', 'admin') | `remember_token` | `timestamps`

 `school_profiles` (Informasi Utama Sekolah - Maksimal 1 Row)
   `id` (unsignedBigInteger, PK) | `school_name` (string) | `tagline` (string) | `history` (text) | `vision` (text) | `mission` (text) | `principal_name` (string) | `principal_message` (text) | `logo` (string/nullable) | `favicon` (string/nullable) | `ppdb_info` (text/nullable, legacy) | `ppdb_brochure` (string/nullable, legacy) | `address` (text) | `phone` (string) | `email` (string) | `maps_embed` (text/nullable) | `instagram` (string/nullable) | `facebook` (string/nullable) | `youtube` (string/nullable) | `timestamps`

 Catatan Legacy PPDB:
 Field `ppdb_info` dan `ppdb_brochure` merupakan field dari implementasi backend sebelumnya. Field tersebut tidak perlu dihapus secara destruktif pada tahap ini. Modul publik baru menggunakan SPMB dan dikelola melalui tabel `spmb_settings`.

---

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

 `curriculums` (Informasi Kurikulum Berdasarkan Tahun Ajaran)
   `id` (unsignedBigInteger, PK) | `title` (string) | `academic_year` (string) | `description` (text/nullable) | `pdf_file` (string/nullable) | `image_file` (string/nullable) | `preview_image` (string/nullable) | `is_published` (boolean, default: true) | `sort_order` (integer, default: 0) | `timestamps`

 `staff_members` (Data Guru dan Karyawan)
   `id` (unsignedBigInteger, PK) | `name` (string) | `staff_type` (enum: 'teacher', 'employee') | `photo` (string/nullable) | `position` (string) | `subject` (string/nullable) | `department` (string/nullable) | `is_active` (boolean, default: true) | `sort_order` (integer, default: 0) | `timestamps`

 Aturan `staff_members`:
 - `staff_type = teacher` digunakan untuk halaman Data Guru.
 - `staff_type = employee` digunakan untuk halaman Data Karyawan.
 - `subject` digunakan jika data merupakan Guru dan dapat dikosongkan jika tidak diperlukan.
 - `department` digunakan jika data merupakan Karyawan dan dapat dikosongkan jika tidak diperlukan.
 - `photo` bersifat opsional. Frontend menggunakan placeholder apabila foto tidak tersedia.

 `spmb_settings` (Informasi SPMB - Maksimal 1 Row)
   `id` (unsignedBigInteger, PK) | `description` (longText/nullable) | `information_file` (string/nullable) | `information_preview` (string/nullable) | `brochure_file` (string/nullable) | `brochure_preview` (string/nullable) | `timestamps`

 Aturan `spmb_settings`:
 - `description` menyimpan keterangan atau informasi utama SPMB.
 - `information_file` menyimpan file informasi asli yang dapat diunduh.
 - `information_preview` menyimpan versi WebP untuk preview apabila file informasi berupa gambar.
 - `brochure_file` menyimpan file brosur asli yang dapat diunduh.
 - `brochure_preview` menyimpan versi WebP untuk preview apabila brosur berupa gambar.
 - File informasi dan brosur dapat berupa dokumen PDF atau gambar sesuai kebutuhan sekolah.

 `alumni_highlights` (Profil Alumni Pilihan - Maksimal 4 Aktif)
   `id` (unsignedBigInteger, PK) | `name` (string) | `graduation_year` (year) | `photo` (string/nullable) | `current_activity` (string/nullable) | `institution` (string/nullable) | `quote` (text/nullable) | `is_active` (boolean, default: true) | `sort_order` (integer, default: 0) | `timestamps`

 Aturan `alumni_highlights`:
 - Maksimal 4 data dengan `is_active = true` ditampilkan pada halaman publik.
 - Data Alumni Pilihan dikelola melalui Filament Admin.
 - Data pendataan alumni umum tidak disimpan pada tabel ini.

---

### 2.3 Tabel Interaksi, Komponen Visual, & Chatbot FAQ

 `hero_banners` (Slider Beranda Depan)
   `id` (unsignedBigInteger, PK) | `title` (string) | `subtitle` (string/nullable) | `image` (string) | `button_text` (string/nullable) | `button_url` (string/nullable) | `sort_order` (integer, default: 0) | `is_active` (boolean, default: true) | `timestamps`

 `contact_messages` (Formulir Kontak Masuk)
   `id` (unsignedBigInteger, PK) | `name` (string) | `email` (string) | `phone` (string/nullable) | `subject` (string) | `message` (text) | `is_read` (boolean, default: false) | `ip_address` (string/nullable) | `timestamps` | `softDeletes`

 `chatbot_knowledges` (Pangkalan Data Kata Kunci Chatbot FAQ Lokal)
   `id` (unsignedBigInteger, PK) | `keywords` (text) | `answer` (text) | `category` (string, default: 'umum') | `is_active` (boolean, default: true) | `timestamps`

 `site_settings` (Konfigurasi SEO & Sistem Global - Maksimal 1 Row)
   `id` (unsignedBigInteger, PK) | `site_name` (string) | `site_description` (text) | `default_meta_keywords` (string) | `default_og_image` (string/nullable) | `copyright_text` (string) | `alumni_form_url` (string/nullable) | `is_maintenance` (boolean, default: false) | `timestamps`

 Aturan `alumni_form_url`:
 - Menyimpan URL Google Forms resmi untuk pendataan alumni.
 - URL tidak boleh ditulis secara hardcode pada Blade.
 - Jika URL belum tersedia, tombol pendataan alumni tidak ditampilkan atau menggunakan fallback informasi yang sesuai.
 - Website tidak menyimpan atau melakukan sinkronisasi otomatis terhadap data hasil Google Forms.

---

## 3. Strategi Indexing & Soft Deletes

 Database Indexes (Kecepatan Query):
   `news.slug` (Unique), `news.status`, `news.published_at`
   `achievements.slug` (Unique), `achievements.year`
   `extracurriculars.slug` (Unique)
   `facilities.slug` (Unique)
   `news.category_id` (Foreign Key Index)
   `curriculums.academic_year`, `curriculums.is_published`
   `staff_members.staff_type`, `staff_members.is_active`, `staff_members.sort_order`
   `alumni_highlights.is_active`, `alumni_highlights.sort_order`

 Soft Deletes Feature:
 Diaktifkan pada tabel yang membutuhkan perlindungan dari penghapusan tidak disengaja:
 `news`, `achievements`, `extracurriculars`, `facilities`, dan `contact_messages`.

 Modul `staff_members`, `curriculums`, `spmb_settings`, dan `alumni_highlights` tidak diwajibkan menggunakan Soft Deletes pada versi awal kecuali kebutuhan implementasi kemudian mengharuskannya.

---

## 4. Aturan Validasi File Storage & Konvensi Direktori

Seluruh aset gambar dan dokumen wajib disimpan menggunakan driver `Storage` Laravel dan tidak disimpan secara langsung ke direktori `public/`.

Struktur folder:

 `logos/`
 Menampung logo instansi dan favicon sekolah.

 `heroes/`
 Menampung gambar Hero Banner.

 `news/`
 Menampung gambar utama artikel berita dalam format WebP.

 `achievements/`
 Menampung gambar dokumentasi Prestasi.

 `extracurriculars/`
 Menampung gambar kegiatan Ekstrakurikuler.

 `facilities/`
 Menampung gambar Fasilitas.

 `gallery/`
 Menampung gambar Galeri.

 `curriculums/`
 Menampung dokumen PDF, gambar asli untuk unduhan, dan preview WebP Kurikulum.

 `spmb/`
 Menampung file informasi asli, brosur asli, serta preview WebP SPMB jika file berupa gambar.

 `staff/`
 Menampung foto WebP Guru dan Karyawan.

 `alumni/highlights/`
 Menampung foto WebP Alumni Pilihan.

### 4.1 Aturan Media Tampilan Website
Gambar yang digunakan sebagai media tampilan website wajib menggunakan optimasi dan konversi WebP melalui fondasi pemrosesan gambar yang sudah tersedia.

Aturan ini berlaku untuk:
- Berita
- Prestasi
- Ekstrakurikuler
- Fasilitas
- Galeri
- Hero Banner
- Guru & Karyawan
- Alumni Pilihan
- Preview Kurikulum
- Preview SPMB

### 4.2 Aturan File Unduhan
File asli yang memang disediakan untuk kebutuhan unduhan wajib tetap dipertahankan.

Aturan ini berlaku khususnya untuk:
- Dokumen PDF Kurikulum
- Materi gambar asli Kurikulum
- File informasi SPMB
- Brosur SPMB

Jika file asli berupa gambar JPG atau PNG, sistem dapat membuat versi WebP tambahan untuk preview website tanpa mengganti file asli yang digunakan untuk download.

---

## 5. Pendataan Alumni Eksternal

Pendataan alumni umum tidak menggunakan tabel database Laravel.

Alur data:

`Website Alumni` → `Google Forms` → `Google Sheets milik sekolah`

Website hanya menyimpan URL Google Forms pada `site_settings.alumni_form_url`.

Data seperti nama, nomor HP/WhatsApp, email, tahun kelulusan, pekerjaan, instansi, domisili, dan foto opsional dikelola langsung melalui Google Forms dan Google Sheets.

Tidak terdapat tabel:
`alumni_submissions`

Tidak terdapat penyimpanan:
`alumni/submissions/`

---

## 6. Estimasi Volume Data Riil Sekolah (Kapasitas Skala Kecil-Menengah)

| Nama Tabel | Estimasi Jumlah Data Aktual | Sifat Pertumbuhan Data |
| :--- | :--- | :--- |
| `school_profiles` / `site_settings` / `spmb_settings` | 1 Record per Tabel | Statis permanen / diperbarui |
| `users` | 2 - 5 Record | Sangat statis |
| `news` | 50 - 200 Record | Tumbuh berkala |
| `achievements` | 30 - 100 Record | Tumbuh lambat |
| `extracurriculars` / `facilities` | 10 - 25 Record | Relatif statis |
| `galleries` | 100 - 300 Record | Tumbuh moderat |
| `curriculums` | 5 - 20 Record | Bertambah berdasarkan tahun ajaran |
| `staff_members` | 20 - 100 Record | Relatif statis / mengikuti perubahan tenaga sekolah |
| `alumni_highlights` | Maksimal 4 Aktif | Dipilih dan diperbarui oleh sekolah |
| `contact_messages` | 100 - 500 Record | Bertambah berkala |
| `chatbot_knowledges` | 30 - 100 Record | Diperbarui sesuai kebutuhan informasi sekolah |

Data hasil pendataan alumni tidak termasuk dalam estimasi database website karena dikelola melalui Google Forms dan Google Sheets.