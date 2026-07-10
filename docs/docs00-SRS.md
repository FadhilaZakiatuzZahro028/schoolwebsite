# Software Requirements Specification (SRS)
# Website Resmi SMA PGRI 1 Tulungagung

## 1. Identitas Proyek
Nama Proyek: Website Resmi SMA PGRI 1 Tulungagung
 Tujuan: Membangun website sekolah siap produksi yang informatif, mudah dikelola, mobile-friendly, SEO-friendly, aksesibel, dan dilengkapi chatbot FAQ internal untuk informasi sekolah.
 Target Pengguna: Masyarakat umum, calon siswa/orang tua, siswa aktif, guru/staf, dan admin sekolah.
 Platform: Website berbasis Laravel.

## 2. Tech Stack
 Backend: Laravel (PHP) & MySQL
 Frontend: Blade Laravel, Bootstrap 5, JavaScript (Vanilla)
 Admin Panel: Filament Admin
 Chatbot: Rule-based/FAQ Chatbot (Proses lokal di backend Laravel, tanpa API eksternal berbayar)
 Deployment: Shared Hosting / VPS (Support Laravel), Domain: `smapgri1ta.sch.id` (atau menyesuaikan)

## 3. Visi Produk & Desain
 Karakter: Formal, clean, modern, cepat, informatif, dan mobile-first (siap pakai jangka panjang, bukan web demo).
 Palet Warna: Biru (Utama), Putih (Dasar), Emas/Kuning (Aksen).

## 4. Ruang Lingkup Sistem

### 4.1 Public Website (Akses Umum)
Menu Utama: Beranda, Profil, Berita, Informasi PPDB, Pojok Siswa (Prestasi & Ekstrakurikuler), Fasilitas, Kontak, Chatbot Widget.

### 4.2 Admin Panel (Filament)
Manajemen Konten: Autentikasi, Kelola Profil, Berita, PPDB Statis, Prestasi, Ekstrakurikuler, Fasilitas, Banner/Hero, Galeri, Pesan Masuk, Data Chatbot FAQ, dan Konfigurasi SEO Global.

---

## 5. Spesifikasi Fitur Public Website

### 5.1 Beranda
Komponen Halaman:
 Hero Section (Banner, nama sekolah, tagline, tombol cepat ke Profil/Kontak).
 Quick Access Menu & Sambutan Kepala Sekolah.
 Ringkasan: Profil singkat, berita terbaru, prestasi terbaru, ekstrakurikuler pilihan, fasilitas unggulan, dan galeri foto.
 Footer: Kontak singkat, Google Maps, dan Chatbot Widget.

### 5.2 Profil
Konten: Sejarah, visi, misi, tujuan, identitas resmi, alamat, email, nomor telepon, logo, dan dokumentasi foto sekolah.

### 5.3 Berita
 Fitur: List berita (arsip), detail berita, pencarian (search), dan filter kategori (Berita Sekolah, Pengumuman, Kegiatan, Akademik).
 Meta Data: Judul, slug, gambar utama, tanggal rilis, penulis (admin), meta title, dan meta description.

### 5.4 Informasi PPDB (Statis)
Konten: Halaman informasi pendaftaran berisi alur, syarat, jadwal, biaya, brosur (unduhan PDF), dan link eksternal jika diperlukan.

### 5.5 Pojok Siswa
 Prestasi: List & detail prestasi akademik/non-akademik (Nama prestasi, tingkat, tahun, deskripsi, foto).
 Ekstrakurikuler: List & detail program ekskul (Nama, deskripsi, nama pembina, jadwal, foto kegiatan).

### 5.6 Fasilitas
Konten: List sarana prasarana (Nama, deskripsi, foto, kategori seperti Ruang Kelas, Laboratorium, Perpustakaan, dll).

### 5.7 Kontak
 Informasi: Alamat, email, telepon, jam layanan, dan embed Google Maps.
 Form Pesan: Input Nama, Email, No HP (opsional), Subjek, Pesan.
 Sistem: Pesan wajib tersimpan ke database dan mengirim notifikasi ke email sekolah.

### 5.8 Chatbot FAQ
 Sistem: Menjawab otomatis pertanyaan berdasarkan kecocokan kata kunci data FAQ sekolah (Profil, Alamat, Kontak, Fasilitas, Berita, Prestasi, Ekskul, PPDB).
 Fallback: Jika kata kunci tidak dikenali, menampilkan teks: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."

---

## 6. Spesifikasi Fitur Admin Panel (Filament)

Setiap modul CRUD (Create, Read, Update, Delete) menyertakan input manajemen SEO spesifik (Slug, Meta Title, Meta Description) secara langsung di form yang sama.

### 6.1 Autentikasi & Multi-Role
 Super Admin: Akses penuh ke seluruh sistem, manajemen user admin, dan pengaturan global.
 Admin: Hanya dapat mengelola konten website (Berita, Profil, Prestasi, dll).

### 6.2 Modul CRUD Admin
 Dashboard: Ringkasan statistik jumlah berita, prestasi, ekskul, fasilitas, dan pesan masuk baru.
 Kelola Konten Statis: Mengubah data Profil Sekolah, Informasi PPDB Statis, Banner/Hero, dan Galeri.
 Kelola Konten Dinamis: CRUD Berita (termasuk status draft/publish), Prestasi, Ekstrakurikuler, dan Fasilitas.
 Kelola Chatbot FAQ: CRUD data pertanyaan dan jawaban acuan untuk respon chatbot.
 Kelola Pesan Kontak: Membaca pesan masuk, menandai status (belum/sudah dibaca), dan menghapus pesan.
 Kelola Konfigurasi SEO Global: Mengatur default meta title, default meta description, keyword dasar, open graph image, sitemap.xml, dan robots.txt.

---

## 7. Kebutuhan Non-Fungsional

### 7.1 Performance & Mobile-First
 Kecepatan load halaman di bawah 3 detik.
 Kompresi otomatis untuk setiap gambar yang diupload admin.
 Layout responsif dengan prioritas kenyamanan tampilan mobile (HP/Tablet).

### 7.2 SEO & Aksesibilitas
 Struktur heading rapi (H1, H2, H3) dan otomatis menghasilkan sitemap.xml.
 Kontras warna teks minimal 4.5:1 menggunakan font ramah baca (diutamakan Inter atau Lexend) dengan alt text pada gambar.

### 7.3 Keamanan (Security)
 Proteksi bawaan Laravel: CSRF protection, validasi form keras, sanitasi input, password hashing (Bcrypt).
 Pembatasan eksistensi dan ukuran file upload, pembatasan hak akses berbasis role, serta sistem backup database berkala.

---

## 8. Batasan Proyek (Out of Scope)
Versi awal tidak mencakup: Sistem e-learning, login siswa/guru, absensi, sistem nilai akademik, dan pendaftaran/seleksi PPDB online sistem terintegrasi.

## 9. Prinsip Pengembangan
1. Dokumentasi selesai sebelum proses coding.
2. Semua konten informasi sekolah wajib dinamis (diambil dari database via Admin Panel, no hardcode).
3. Kode harus bersih, aman, efisien, dan siap pakai di hosting nyata.

## 10. Roadmap Pengembangan
 Phase 1: Finalisasi Dokumentasi & Struktur Database.
 Phase 2: Setup Laravel, Auth, dan Filament Admin.
 Phase 3: Pembuatan CRUD Backend Admin Panel (Filament).
 Phase 4: Pembuatan Frontend Public Website & Optimasi Mobile.
 Phase 5: Implementasi Engine Chatbot FAQ Lokal & Testing.
 Phase 6: SEO Final, Security Check, dan Deployment ke Hosting.

## 11. Status Dokumen
 Versi: 1.0 (Approved Baseline)
 Status: Siap Produksi
 Catatan: Dokumen ini mengikat sebagai acuan utama pengembangan sistem.