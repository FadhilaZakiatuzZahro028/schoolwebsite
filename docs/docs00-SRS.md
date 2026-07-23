# Software Requirements Specification (SRS)
# Website Resmi SMA PGRI 1 Tulungagung

Version: 1.2 | Status: Revised Approved Baseline

## 1. Identitas Proyek
Nama Proyek: Website Resmi SMA PGRI 1 Tulungagung
 Tujuan: Membangun website sekolah siap produksi yang informatif, mudah dikelola, mobile-friendly, SEO-friendly, aksesibel, dan dilengkapi chatbot FAQ internal untuk informasi sekolah.
 Target Pengguna: Masyarakat umum, calon siswa/orang tua, siswa aktif, alumni, guru/staf, dan admin sekolah.
 Platform: Website berbasis Laravel.

## 2. Tech Stack
 Backend: Laravel (PHP) & MySQL
 Frontend: Blade Laravel, Bootstrap 5, JavaScript (Vanilla)
 Admin Panel: Filament Admin
 Chatbot: Rule-based/FAQ Chatbot (Proses lokal di backend Laravel, tanpa API eksternal berbayar)
 Pendataan Alumni: Google Forms terhubung dengan Google Sheets milik sekolah
 Deployment: Shared Hosting / VPS (Support Laravel), Domain: `smapgri1ta.sch.id` (atau menyesuaikan)

## 3. Visi Produk & Desain
 Karakter: Formal, clean, modern, cepat, informatif, dan mobile-first (siap pakai jangka panjang, bukan web demo).
 Palet Warna: Biru (Utama), Putih (Dasar), Emas/Kuning (Aksen).

## 4. Ruang Lingkup Sistem

### 4.1 Public Website (Akses Umum)
Menu Utama: Beranda, Profil, Akademik, Informasi, Jejak & Karya, Kontak, dan Chatbot Widget.

 Struktur Menu Profil:
 - Profil Sekolah
 - Sejarah
 - Data Guru
 - Data Karyawan

 Struktur Menu Akademik:
 - Kurikulum
 - Fasilitas

 Struktur Menu Informasi:
 - Berita
 - SPMB

 Struktur Menu Jejak & Karya:
 - Prestasi
 - Ekstrakurikuler
 - Alumni

### 4.2 Admin Panel (Filament)
Manajemen Konten: Autentikasi, Kelola Profil, SPMB, Kurikulum, Guru & Karyawan, Berita, Prestasi, Ekstrakurikuler, Fasilitas, Alumni Pilihan, Banner/Hero, Galeri, Pesan Masuk, Data Chatbot FAQ, dan Konfigurasi SEO Global.

---

## 5. Spesifikasi Fitur Public Website

### 5.1 Beranda
Komponen Halaman:
 Hero Section (Banner, nama sekolah, tagline, tombol cepat ke Profil/Kontak).
 Quick Access Menu & Sambutan Kepala Sekolah.
 Ringkasan: Profil singkat, berita terbaru, prestasi terbaru, ekstrakurikuler pilihan, fasilitas unggulan, dan galeri foto.
 Footer: Kontak singkat, Google Maps, dan Chatbot Widget.

### 5.2 Profil Sekolah
Konten: Identitas resmi sekolah, visi, misi, tujuan, Sambutan Kepala Sekolah, alamat, email, nomor telepon, logo, dan informasi pendukung sekolah.

### 5.3 Sejarah
Konten: Halaman khusus yang menampilkan sejarah dan perkembangan SMA PGRI 1 Tulungagung.

### 5.4 Data Guru & Karyawan
 Data Guru: Menampilkan daftar guru dalam bentuk kartu profil berisi foto, nama, jabatan, dan mata pelajaran jika tersedia.
 Data Karyawan: Menampilkan daftar karyawan dalam bentuk kartu profil berisi foto, nama, jabatan, dan bagian/unit jika tersedia.
 Sistem: Data Guru dan Karyawan dikelola menggunakan satu fondasi backend dengan kategori jenis staf yang berbeda. Foto dapat bersifat opsional dan menggunakan placeholder apabila belum tersedia.

### 5.5 Kurikulum
 Konten: Informasi kurikulum sekolah berdasarkan tahun ajaran, dilengkapi judul, deskripsi, dokumen PDF, dan materi gambar.
 Fitur: Pengunjung dapat melihat informasi kurikulum serta mengunduh dokumen PDF dan materi gambar yang disediakan sekolah.
 Sistem: File disimpan melalui Laravel Storage. Gambar dapat memiliki versi WebP teroptimasi untuk preview website, sedangkan file asli yang disediakan untuk unduhan tetap dipertahankan.

### 5.6 Berita
 Fitur: List berita (arsip), detail berita, pencarian (search), dan filter kategori (Berita Sekolah, Pengumuman, Kegiatan, Akademik).
 Meta Data: Judul, slug, gambar utama, tanggal rilis, penulis (admin), meta title, dan meta description.

### 5.7 SPMB
 Konten: Halaman informasi Sistem Penerimaan Murid Baru (SPMB) yang berisi keterangan atau informasi pendaftaran sekolah.
 Fitur: Pengunjung dapat melihat informasi SPMB serta mengunduh file informasi dan brosur yang disediakan sekolah.
 Sistem: File PDF atau gambar disimpan melalui Laravel Storage. Gambar yang digunakan sebagai preview dapat menggunakan versi WebP teroptimasi, sedangkan file asli untuk unduhan tetap dipertahankan.

### 5.8 Jejak & Karya
 Prestasi: List & detail prestasi akademik/non-akademik (Nama prestasi, tingkat, tahun, deskripsi, foto).
 Ekstrakurikuler: List & detail program ekstrakurikuler sekolah (Nama, deskripsi, nama pembina, jadwal, foto kegiatan).
 Alumni: Menampilkan maksimal 4 Alumni Pilihan dan menyediakan akses menuju Google Forms untuk pendataan alumni.

 Pendataan Alumni melalui Google Forms dapat meminta:
 - Nama lengkap
 - Nomor HP/WhatsApp
 - Email
 - Tahun kelulusan
 - Pekerjaan atau aktivitas saat ini
 - Nama instansi/perusahaan
 - Domisili
 - Foto alumni (opsional)
 - Pesan atau cerita (opsional)

 Data hasil pendataan dikelola melalui Google Forms dan Google Sheets milik sekolah serta tidak otomatis ditampilkan pada website.

### 5.9 Fasilitas
Konten: List sarana prasarana (Nama, deskripsi, foto, kategori seperti Ruang Kelas, Laboratorium, Perpustakaan, dll).

### 5.10 Kontak
 Informasi: Alamat, email, telepon, jam layanan, dan embed Google Maps.
 Form Pesan: Input Nama, Email, No HP (opsional), Subjek, Pesan.
 Sistem: Pesan wajib tersimpan ke database dan mengirim notifikasi ke email sekolah apabila konfigurasi email tersedia.

### 5.11 Chatbot FAQ
 Sistem: Menjawab otomatis pertanyaan berdasarkan kecocokan kata kunci data FAQ sekolah.
 Scope: Profil, Sejarah, Guru, Karyawan, Alamat, Kontak, Kurikulum, Fasilitas, Berita, Prestasi, Ekstrakurikuler, Alumni, dan SPMB.
 Fallback: Jika kata kunci tidak dikenali, menampilkan teks: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."

---

## 6. Spesifikasi Fitur Admin Panel (Filament)

Setiap modul CRUD (Create, Read, Update, Delete) yang membutuhkan metadata SEO menyertakan input manajemen SEO spesifik sesuai kebutuhan modul.

### 6.1 Autentikasi & Multi-Role
 Super Admin: Akses penuh ke seluruh sistem, manajemen user admin, dan pengaturan global.
 Admin: Hanya dapat mengelola konten website sesuai hak akses yang diberikan.

### 6.2 Modul CRUD Admin
 Dashboard: Ringkasan statistik jumlah berita, prestasi, ekskul, fasilitas, dan pesan masuk baru.
 Kelola Profil Sekolah: Mengubah identitas sekolah, visi, misi, tujuan, Sambutan Kepala Sekolah, dan informasi profil lainnya.
 Kelola SPMB: Mengubah keterangan SPMB serta mengelola file informasi dan brosur yang dapat diunduh.
 Kelola Kurikulum: CRUD informasi kurikulum, tahun ajaran, dokumen PDF, dan materi gambar.
 Kelola Guru & Karyawan: CRUD data staf menggunakan satu modul backend dengan kategori Guru atau Karyawan.
 Kelola Konten Dinamis: CRUD Berita, Prestasi, Ekstrakurikuler, dan Fasilitas.
 Kelola Alumni Pilihan: CRUD maksimal 4 profil alumni yang ditampilkan pada halaman publik.
 Kelola Banner & Galeri: Mengelola Hero Banner dan Galeri.
 Kelola Chatbot FAQ: CRUD data pertanyaan dan jawaban acuan untuk respon chatbot.
 Kelola Pesan Kontak: Membaca pesan masuk, menandai status (belum/sudah dibaca), dan menghapus pesan.
 Kelola Konfigurasi SEO Global: Mengatur default meta title, default meta description, keyword dasar, open graph image, sitemap.xml, dan robots.txt.

Pendataan alumni tidak dikelola melalui database Laravel. Data pendataan dikumpulkan melalui Google Forms dan dikelola oleh pihak sekolah melalui Google Sheets.

---

## 7. Kebutuhan Non-Fungsional

### 7.1 Performance & Mobile-First
 Kecepatan load halaman di bawah 3 detik.
 Kompresi otomatis untuk gambar yang digunakan sebagai media tampilan website.
 File asli yang memang disediakan sebagai file unduhan tetap dipertahankan.
 Layout responsif dengan prioritas kenyamanan tampilan mobile (HP/Tablet).

### 7.2 SEO & Aksesibilitas
 Struktur heading rapi (H1, H2, H3) dan otomatis menghasilkan sitemap.xml.
 Kontras warna teks minimal 4.5:1 menggunakan font ramah baca (diutamakan Inter atau Lexend) dengan alt text pada gambar.

### 7.3 Keamanan (Security)
 Proteksi bawaan Laravel: CSRF protection, validasi form keras, sanitasi input, password hashing (Bcrypt).
 Pembatasan ekstensi dan ukuran file upload, pembatasan hak akses berbasis role, serta sistem backup database berkala.
 Data pribadi alumni dari Google Forms tidak boleh otomatis dipublikasikan pada website.

---

## 8. Batasan Proyek (Out of Scope)
Versi awal tidak mencakup: Sistem e-learning, login siswa/guru, absensi, sistem nilai akademik, sistem seleksi SPMB online terintegrasi, portal alumni dengan akun pribadi, penyimpanan data pendataan alumni di database website, dan sinkronisasi otomatis Google Forms/Google Sheets dengan Laravel.

## 9. Prinsip Pengembangan
1. Dokumentasi selesai sebelum proses coding.
2. Semua konten informasi sekolah yang dikelola melalui website wajib dinamis dan tidak di-hardcode.
3. Kode harus bersih, aman, efisien, dan siap pakai di hosting nyata.
4. Data pribadi alumni tidak boleh otomatis dipublikasikan.
5. Backend lama yang sudah stabil tidak diubah tanpa kebutuhan fungsional nyata.

## 10. Roadmap Pengembangan
 Phase 1: Finalisasi Dokumentasi & Struktur Database.
 Phase 2: Setup Laravel, Auth, dan Filament Admin.
 Phase 3: Pembuatan dan penyempurnaan CRUD Backend Admin Panel, termasuk Kurikulum, SPMB, Guru & Karyawan, serta Alumni Pilihan.
 Phase 4: Pembuatan Frontend Public Website & Optimasi Mobile.
 Phase 5: Implementasi Engine Chatbot FAQ Lokal & Testing.
 Phase 6: SEO Final, Security Check, dan Deployment ke Hosting.

## 11. Status Dokumen
 Version: 1.2 (Revised Approved Baseline)
 Status: Siap Produksi
 Catatan: Dokumen ini telah diperbarui untuk mencakup Kurikulum, SPMB, Data Guru & Karyawan, Alumni Pilihan, serta pendataan Alumni melalui Google Forms.