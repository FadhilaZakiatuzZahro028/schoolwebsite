# Functional Requirements Specification (FRS) - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.3 | Status: Revised Approved Baseline (Production-Ready)

## 1. Aktor Sistem & Hak Akses Kontrol

 Guest: Publik tanpa login. Hak akses: Membaca seluruh konten publik, melihat Profil Sekolah dan Sejarah, melihat Data Guru dan Data Karyawan, melihat dan mengunduh informasi Kurikulum dan SPMB, melihat Alumni Pilihan, mengakses Google Forms pendataan Alumni, mengirim pesan kontak, dan berinteraksi dengan widget Chatbot FAQ.

 Admin Konten: Pengguna terautentikasi. Hak akses: Mengelola konten website sesuai hak akses yang diberikan, termasuk Profil Sekolah, SPMB, Kurikulum, Guru & Karyawan, Alumni Pilihan, serta pangkalan data FAQ Chatbot.

 Super Admin: Pengguna terautentikasi level tertinggi. Hak akses: Memiliki seluruh hak akses Admin Konten, ditambah hak akses CRUD User Admin, hapus permanen pada data yang mendukung fitur tersebut, dan konfigurasi sistem serta SEO global.

---

## 2. Spesifikasi Fungsional Per Modul

### Modul 1: Authentication & Dashboard

 Fungsi Login: Admin memasukkan `email` dan `password` melalui panel Filament.

 Validasi:
 - Input wajib diisi.
 - Format email harus valid.
 - Akun harus terdaftar pada sistem.
 - Jika gagal, sistem menampilkan pesan login yang aman dan mudah dipahami.
 - Jika berhasil, pengguna diarahkan ke halaman Dashboard.

 Fungsi Dashboard: Menampilkan ringkasan statistik dari modul yang tersedia, seperti Total Berita Aktif, Total Prestasi, Total Ekstrakurikuler, Total Fasilitas, Jumlah Pesan Kontak Belum Dibaca, dan informasi sistem lain sesuai kebutuhan.

---

### Modul 2: Manajemen Profil Sekolah

 Fungsi Pembaruan Profil: Admin dapat mengubah data utama sekolah yang tersedia pada `school_profiles`, termasuk identitas sekolah, Visi, Misi, Sambutan Kepala Sekolah, informasi kontak, media sosial, dan data profil lainnya.

 Fungsi Sejarah: Informasi Sejarah Sekolah dikelola sebagai bagian dari data Profil Sekolah tetapi ditampilkan pada halaman publik yang terpisah.

 Halaman Profil Sekolah: Menampilkan informasi profil utama, Visi & Misi, Tujuan Sekolah jika tersedia, dan Sambutan Kepala Sekolah.

 Halaman Sejarah: Menampilkan konten sejarah dan perkembangan sekolah secara terpisah agar halaman Profil Sekolah tetap ringkas.

 Aturan Data: Seluruh informasi yang tersedia pada halaman publik wajib berasal dari database dan tidak boleh ditulis secara hardcode pada Blade.

---

### Modul 3: Manajemen Guru & Karyawan

 Fungsi Pengelolaan: Admin dapat melakukan CRUD data Guru dan Karyawan melalui satu fondasi data `staff_members`.

 Data yang dapat dikelola:
 - Nama
 - Jenis Staf (`teacher` atau `employee`)
 - Foto opsional
 - Jabatan
 - Mata Pelajaran opsional
 - Bagian atau Unit opsional
 - Status Aktif
 - Urutan Tampil

 Aturan Jenis Staf:
 - Data dengan `staff_type = teacher` ditampilkan pada halaman Data Guru.
 - Data dengan `staff_type = employee` ditampilkan pada halaman Data Karyawan.

 Tampilan Publik:
 - Data Guru dan Data Karyawan ditampilkan pada halaman yang berbeda.
 - Tampilan menggunakan kartu profil.
 - Data Guru dapat menampilkan Foto, Nama, Jabatan, dan Mata Pelajaran.
 - Data Karyawan dapat menampilkan Foto, Nama, Jabatan, dan Bagian/Unit.
 - Hanya data berstatus aktif yang ditampilkan kepada publik.

 Aturan Foto:
 - Foto bersifat opsional.
 - Jika foto tidak tersedia, frontend wajib menampilkan placeholder yang konsisten.
 - Foto yang diunggah untuk tampilan website menggunakan sistem optimasi dan konversi WebP yang sudah tersedia.

---

### Modul 4: CRUD Konten Dinamis (Berita, Kategori, Prestasi, Ekstrakurikuler, Fasilitas, Galeri)

 Validasi & Pemrosesan Input Umum:
 - Field Judul atau Nama wajib diisi sesuai kebutuhan entitas.
 - Sistem menggunakan slug unik pada entitas yang memang membutuhkan URL SEO-friendly.
 - Pada modul Berita, `meta_title` dan `meta_description` mengikuti batas SEO yang telah ditentukan.
 - Gambar tampilan website wajib diproses melalui sistem optimasi gambar WebP yang sudah tersedia.

 Logika Bisnis Konten:
 - Hanya Berita berstatus `published` dan memenuhi waktu publikasi yang dapat ditampilkan kepada publik.
 - Perubahan slug pada konten yang sudah dipublikasikan harus mempertimbangkan kestabilan URL dan SEO.
 - Penghapusan data pada modul yang sudah menggunakan `SoftDeletes` tetap mengikuti implementasi backend yang tersedia.

 Backend lama yang sudah stabil tidak boleh diubah hanya untuk kebutuhan kerapian apabila tidak terdapat masalah fungsional.

---

### Modul 5: Manajemen Kurikulum

 Fungsi Pengelolaan: Admin dapat melakukan CRUD informasi Kurikulum berdasarkan tahun ajaran.

 Data Kurikulum:
 - Judul
 - Tahun Ajaran
 - Deskripsi
 - Dokumen PDF opsional
 - Materi Gambar opsional
 - Preview Gambar opsional
 - Status Publikasi
 - Urutan Tampil

 Fungsi Publikasi: Hanya data Kurikulum dengan `is_published = true` yang ditampilkan pada website publik.

 Fungsi Dokumen: Dokumen PDF disimpan melalui Laravel Storage dan dapat diunduh oleh pengunjung.

 Fungsi Materi Gambar:
 - File gambar asli yang disediakan sebagai file unduhan wajib tetap dipertahankan.
 - Sistem dapat menghasilkan versi WebP teroptimasi untuk preview website.
 - Preview WebP tidak boleh menggantikan file asli yang memang disediakan untuk diunduh.

 Validasi File: Sistem wajib memvalidasi format dan ukuran file sebelum penyimpanan.

---

### Modul 6: Manajemen SPMB

 Fungsi Pengelolaan: Admin dapat mengelola informasi Sistem Penerimaan Murid Baru (SPMB).

 Data yang dapat dikelola:
 - Keterangan atau informasi utama SPMB
 - File Informasi
 - Preview File Informasi jika berupa gambar
 - Brosur
 - Preview Brosur jika berupa gambar

 Fungsi File Informasi:
 - File dapat berupa PDF atau gambar sesuai kebutuhan sekolah.
 - File asli dapat diunduh oleh pengunjung.

 Fungsi Brosur:
 - Brosur dapat berupa PDF atau gambar.
 - File asli tetap disimpan untuk kebutuhan unduhan.

 Aturan Preview Gambar:
 - Jika File Informasi atau Brosur berupa gambar, sistem dapat menghasilkan versi WebP untuk preview website.
 - File gambar asli tetap dipertahankan secara terpisah untuk kebutuhan download.

 Penyimpanan: Seluruh file SPMB disimpan menggunakan Laravel Storage.

 Validasi: Sistem wajib membatasi jenis dan ukuran file sesuai aturan upload yang ditentukan saat implementasi.

 Catatan Legacy: Field PPDB lama yang telah tersedia pada backend sebelumnya tidak perlu dihapus secara destruktif apabila tidak mengganggu implementasi baru. Halaman publik baru menggunakan istilah dan modul SPMB.

---

### Modul 7: Manajemen Alumni

#### 7.1 Alumni Pilihan

 Fungsi Pengelolaan: Admin dapat melakukan CRUD profil Alumni Pilihan.

 Data Alumni Pilihan:
 - Nama
 - Tahun Kelulusan
 - Foto
 - Aktivitas atau Pekerjaan Saat Ini
 - Instansi
 - Kutipan Singkat
 - Status Aktif
 - Urutan Tampil

 Batas Tampilan: Maksimal 4 Alumni Pilihan berstatus aktif dapat ditampilkan pada halaman publik.

 Aturan Gambar: Foto Alumni Pilihan menggunakan sistem optimasi WebP yang sudah tersedia.

 Aturan Privasi: Informasi pribadi seperti nomor HP, email pribadi, atau data sensitif lainnya tidak boleh ditampilkan pada kartu Alumni Pilihan.

#### 7.2 Pendataan Alumni melalui Google Forms

 Sistem Pendataan: Pendataan Alumni umum tidak menggunakan form Laravel dan tidak disimpan ke database website.

 Alur:

 `Halaman Alumni` → `Google Forms Resmi Sekolah` → `Google Sheets Milik Sekolah`

 Halaman Alumni menyediakan tombol atau akses menuju Google Forms resmi sekolah.

 Google Forms dapat meminta data:
 - Nama Lengkap
 - Nomor HP/WhatsApp
 - Email
 - Tahun Kelulusan
 - Pekerjaan atau Aktivitas Saat Ini
 - Instansi atau Perusahaan
 - Domisili
 - Foto Alumni opsional
 - Pesan atau informasi tambahan opsional

 Aturan Foto: Upload foto pada Google Forms bersifat opsional dan tidak boleh menjadi syarat wajib untuk menyelesaikan pendataan Alumni.

 Konfigurasi URL: URL Google Forms wajib berasal dari konfigurasi dinamis sistem dan tidak boleh ditulis secara hardcode pada Blade.

 Aturan Data:
 - Laravel tidak menyimpan hasil Google Forms.
 - Laravel tidak melakukan sinkronisasi otomatis dengan Google Sheets pada versi awal.
 - Data hasil pendataan dikelola oleh pihak sekolah melalui akun Google yang digunakan.
 - Data pendataan tidak otomatis ditampilkan pada website publik.

---

### Modul 8: Manajemen Hero Banner Slider

 Logika Banner Utama: Admin dapat melakukan CRUD Hero Banner dengan data Judul, Subjudul, Gambar, Teks Tombol CTA, URL CTA, Status Aktif, dan Urutan Tampil.

 Pengelolaan status aktif mengikuti implementasi backend Hero Banner yang sudah tersedia dan telah dianggap stabil.

 Gambar Hero Banner wajib menggunakan sistem optimasi WebP yang sudah tersedia.

---

### Modul 9: Formulir Hubungi Kami (Kontak Publik)

 Sisi Frontend:
 - Nama wajib diisi.
 - Email wajib diisi dengan format valid.
 - Subjek wajib diisi.
 - Pesan wajib diisi dengan panjang minimum sesuai aturan validasi.
 - Nomor HP dapat bersifat opsional.

 Sisi Backend:
 - Data yang lolos validasi disimpan ke tabel `contact_messages`.
 - Pesan dapat ditandai sebagai Belum Dibaca atau Sudah Dibaca oleh admin.

 Notifikasi Email: Pengiriman notifikasi email dapat dilakukan apabila konfigurasi email sistem tersedia dan berfungsi.

 Proteksi Anti-Spam: Endpoint pengiriman pesan menggunakan rate limiting untuk membatasi pengiriman berulang.

---

### Modul 10: Chatbot FAQ Lokal (Rule-Based Keyword Matching)

 Mekanisme Respon: Widget Chatbot menerima input teks dari Guest dan memprosesnya melalui `ChatbotService`.

 Alur Dasar:

 `Input Pengguna` → `Normalisasi Teks` → `Pencarian Kata Kunci` → `Jawaban dari Database`

 Logika Database: Sistem menggunakan data aktif dari tabel `chatbot_knowledges` sebagai sumber jawaban.

 Ruang Lingkup Jawaban:
 - Profil Sekolah
 - Sejarah
 - Guru
 - Karyawan
 - Kurikulum
 - SPMB
 - Berita
 - Prestasi
 - Ekstrakurikuler
 - Fasilitas
 - Alumni
 - Kontak
 - Informasi sekolah lainnya yang tersedia pada database FAQ

 Aturan Penolakan: Jika sistem tidak menemukan jawaban yang sesuai atau pertanyaan berada di luar konteks sekolah, chatbot menampilkan:

 "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."

 Proteksi Beban Server: Endpoint Chatbot wajib menggunakan rate limiting sesuai konfigurasi sistem.

---

### Modul 11: Optimasi SEO Otomatis & Sistem Logging

 Logika SEO Cadangan: Konten yang membutuhkan metadata SEO menggunakan nilai fallback apabila metadata spesifik tidak tersedia.

 Metadata SEO dapat mencakup:
 - Meta Title
 - Meta Description
 - Open Graph Image
 - Canonical URL

 Halaman yang tidak memiliki metadata khusus menggunakan konfigurasi SEO global dari `site_settings`.

 Sistem Logging: Laravel mencatat aktivitas sistem penting sesuai kebutuhan implementasi, terutama aktivitas yang berkaitan dengan autentikasi, perubahan konten penting, dan error aplikasi.

 Logging tidak boleh menyimpan password atau data sensitif dalam bentuk terbuka.

---

## 3. Aturan Manajemen Media

 Seluruh file yang dikelola website wajib menggunakan Laravel Storage dan tidak disimpan langsung pada direktori `public/`.

 Gambar yang digunakan untuk tampilan website wajib menggunakan optimasi WebP melalui fondasi pemrosesan gambar yang sudah tersedia.

 File asli wajib dipertahankan apabila file tersebut memang disediakan sebagai file unduhan.

 Aturan tersebut berlaku khususnya pada:
 - Kurikulum
 - SPMB

 Foto Guru, Karyawan, Alumni Pilihan, Hero Banner, Berita, Prestasi, Ekstrakurikuler, Fasilitas, dan Galeri menggunakan format teroptimasi untuk kebutuhan tampilan website.

 Sistem dilarang membuat fondasi pemrosesan gambar baru apabila fungsi yang dibutuhkan sudah dapat menggunakan sistem WebP reusable yang tersedia.

---

## 4. Arsitektur Penanganan Eror (Error Handling Strategy)

 Isolasi Eror Teknis: Mode debug wajib dinonaktifkan pada lingkungan produksi.

 Pengunjung umum dilarang melihat pesan kegagalan teknis mentah seperti database exception, stack trace, atau informasi konfigurasi server.

 Sistem menggunakan halaman error khusus seperti 404 dan 500 dengan pesan yang ramah pengguna.

 Pesan kegagalan umum:

 "Terjadi kesalahan sistem. Silakan coba beberapa saat lagi."

---

## 5. Kriteria Keberhasilan Rilis (Definition of Success)

Fitur atau modul dianggap selesai dan valid apabila:

- Sesuai dengan dokumentasi terbaru.
- Lolos validasi dan pengujian fungsional.
- Tidak merusak modul backend lama yang sudah stabil.
- Responsif dan mobile-first.
- Memenuhi aksesibilitas dasar.
- Menggunakan Laravel Storage untuk pengelolaan media.
- Menggunakan fondasi optimasi WebP yang sudah tersedia.
- Tidak menyisakan bug mayor.
- Tidak menyimpan data Alumni Google Forms ke database Laravel.
- Seluruh perubahan telah melalui pengecekan kode dan pengujian sebelum dianggap selesai.