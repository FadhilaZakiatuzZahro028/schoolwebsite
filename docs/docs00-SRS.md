# Software Requirements Specification (SRS)
# Website Resmi SMA PGRI 1 Tulungagung

Version: 1.4 | Status: Revised Approved Baseline

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
 - Program Unggulan
 - Fasilitas

 Struktur Menu Informasi:
 - Berita
 - SPMB

 Struktur Menu Jejak & Karya:
- Prestasi
- Ekstrakurikuler
- Alumni
- Galeri

### 4.2 Admin Panel (Filament)
Manajemen Konten: Autentikasi, Kelola Profil, SPMB, Kurikulum, Program Unggulan, Guru & Karyawan, Berita, Prestasi, Ekstrakurikuler, Fasilitas, Alumni Pilihan, Banner/Hero, Galeri, Pesan Masuk, Data Chatbot FAQ, dan Konfigurasi SEO Global.

---

## 5. Spesifikasi Fitur Public Website

### 5.1 Beranda
Komponen Halaman:
 Hero Section (Banner, nama sekolah, tagline, tombol cepat ke Profil/Kontak).
 Quick Access Menu.
 Sambutan Kepala Sekolah dalam format ringkas sebagai pengantar menuju halaman Profil Sekolah.
 Ringkasan Data Guru menggunakan centered horizontal carousel setelah Sambutan Kepala Sekolah. Carousel menggunakan komponen dan behavior yang sama dengan halaman Data Guru, dengan Kepala Sekolah sebagai slide aktif pertama dan Guru lainnya mengikuti urutan tampil.
 Ringkasan konten dinamis: berita terbaru, prestasi terbaru, ekstrakurikuler pilihan, fasilitas unggulan, dan galeri foto.
 Footer: Kontak singkat, Google Maps, dan Chatbot Widget.

### 5.2 Profil Sekolah
Konten: Identitas resmi sekolah, visi, misi, tujuan, Sambutan Kepala Sekolah, alamat, email, nomor telepon, logo, dan informasi pendukung sekolah.

### 5.3 Sejarah
Konten: Halaman khusus yang menampilkan sejarah dan perkembangan SMA PGRI 1 Tulungagung.

### 5.4 Data Guru & Karyawan

Data Guru: Menampilkan data Guru melalui carousel horizontal responsif. Pada desktop, tiga kartu dapat terlihat secara bersamaan dengan kartu aktif berada di tengah dan tampil lebih menonjol. Saat halaman pertama kali dibuka, Kepala Sekolah menjadi slide aktif pertama, kemudian Guru lainnya mengikuti urutan tampil.

Data Karyawan: Menampilkan data Karyawan melalui carousel horizontal responsif dengan pola visual dan interaksi yang sama. Slide awal pada halaman Karyawan mengikuti urutan tampil data aktif.

Informasi Profil: Kartu staf dapat menampilkan foto, nama, satu atau lebih riwayat pendidikan, jabatan, serta mata pelajaran untuk Guru atau bagian/unit untuk Karyawan.

Interaksi Carousel: Carousel mendukung autoplay, pause sementara ketika pointer berada pada area carousel, drag menggunakan mouse, swipe pada perangkat sentuh, serta navigasi manual yang aksesibel.

Sistem: Data Guru dan Karyawan dikelola menggunakan satu fondasi backend dengan kategori jenis staf yang berbeda. Riwayat pendidikan dikelola secara terstruktur dan satu staf dapat memiliki lebih dari satu riwayat pendidikan. Foto dapat bersifat opsional dan menggunakan placeholder apabila belum tersedia.

### 5.5 Kurikulum
 Konten: Informasi kurikulum sekolah berdasarkan tahun ajaran, dilengkapi judul, deskripsi, dokumen PDF, dan materi gambar.
 Fitur: Pengunjung dapat melihat informasi kurikulum serta mengunduh dokumen PDF dan materi gambar yang disediakan sekolah.
 Sistem: File disimpan melalui Laravel Storage. Gambar dapat memiliki versi WebP teroptimasi untuk preview website, sedangkan file asli yang disediakan untuk unduhan tetap dipertahankan.

 ### 5.6 Program Unggulan

Tujuan: Menampilkan program pengembangan keterampilan praktis siswa sebagai bagian dari penawaran pendidikan sekolah dan salah satu informasi utama bagi calon siswa serta orang tua.

Konten: Program Unggulan mencakup bidang keterampilan yang dikelola sekolah, seperti Bahasa Korea, Desain Grafis, Tata Boga, Tata Kecantikan, Otomotif, dan bidang lain yang dapat ditambahkan kemudian melalui backend.

Kolaborasi: Halaman dapat menjelaskan secara umum bahwa kegiatan keterampilan dilaksanakan melalui kerja sama dengan LPK dan/atau BLK. Website tidak boleh menampilkan klaim mengenai sertifikasi resmi, jaminan kerja, penyaluran kerja, nama mitra tertentu, atau klaim lain yang belum dikonfirmasi oleh sekolah.

Pengaturan Halaman: Narasi pengantar Program Unggulan dan keterangan umum mengenai kolaborasi dengan LPK/BLK dikelola secara dinamis melalui pengaturan Program Unggulan pada backend. Informasi sekolah tersebut tidak ditulis secara hardcode pada Blade.

Halaman Publik: Program Unggulan menggunakan satu landing page `/program-unggulan` dan tidak memiliki halaman detail terpisah untuk masing-masing bidang pada versi saat ini.

Data Program:
- Nama program.
- Ringkasan singkat.
- Deskripsi atau manfaat program.
- Foto utama kegiatan.
- Status aktif.
- Urutan tampil.
- Maksimal 2 foto dokumentasi tambahan opsional.

Media:
- Foto utama menjadi visual utama setiap program.
- Foto dokumentasi tambahan dikelola melalui relasi tersendiri dan dapat memiliki teks alternatif serta urutan tampil.
- Seluruh gambar tampilan Program Unggulan menggunakan optimasi WebP melalui fondasi pemrosesan gambar yang sudah tersedia.

Tampilan: Hanya program berstatus aktif yang ditampilkan dan urutannya mengikuti `sort_order`. Halaman dirancang sebagai skill-development showcase yang menonjolkan dokumentasi kegiatan nyata, bukan sebagai katalog kartu administratif.

Fallback: Program tetap dapat ditampilkan hanya dengan foto utama apabila dokumentasi tambahan belum tersedia. Jika tidak terdapat program aktif, halaman menampilkan empty state yang sesuai dan tidak menggunakan data atau dokumentasi palsu.

### 5.7 Berita
 Fitur: List berita (arsip), detail berita, pencarian (search), dan filter kategori (Berita Sekolah, Pengumuman, Kegiatan, Akademik).
 Meta Data: Judul, slug, gambar utama, tanggal rilis, penulis (admin), meta title, dan meta description.

### 5.8 SPMB
 Konten: Halaman informasi Sistem Penerimaan Murid Baru (SPMB) yang berisi keterangan atau informasi pendaftaran sekolah.
 Fitur: Pengunjung dapat melihat informasi SPMB serta mengunduh file informasi dan brosur yang disediakan sekolah.
 Sistem: File PDF atau gambar disimpan melalui Laravel Storage. Gambar yang digunakan sebagai preview dapat menggunakan versi WebP teroptimasi, sedangkan file asli untuk unduhan tetap dipertahankan.

### 5.9 Jejak & Karya
 Prestasi: List & detail prestasi akademik/non-akademik (Nama prestasi, tingkat, tahun, deskripsi, foto).
 Ekstrakurikuler: List & detail program ekstrakurikuler sekolah (Nama, deskripsi, nama pembina, jadwal, foto utama kegiatan, dan maksimal 2 foto dokumentasi tambahan opsional). Foto dokumentasi tambahan digunakan untuk memperkuat informasi visual kegiatan pada halaman detail dan tidak wajib tersedia pada setiap ekstrakurikuler.
 Alumni: Menampilkan maksimal 4 Alumni Pilihan dan menyediakan akses menuju Google Forms untuk pendataan alumni.
 Galeri: Menampilkan dokumentasi foto kegiatan, pembelajaran, prestasi, dan berbagai momen sekolah melalui halaman galeri publik.

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

### 5.10 Fasilitas

Konten: Menampilkan daftar sarana dan prasarana sekolah yang mencakup nama, deskripsi, dan foto utama.

Halaman Indeks: Menampilkan fasilitas dalam grid responsif menggunakan foto utama sebagai cover dan menyediakan akses menuju halaman detail setiap fasilitas.

Halaman Detail: Menampilkan informasi fasilitas secara lebih lengkap melalui foto utama, deskripsi, serta maksimal 2 foto dokumentasi tambahan apabila tersedia.

Media:
- `facilities.image` digunakan sebagai foto utama atau cover fasilitas.
- Setiap fasilitas dapat memiliki maksimal 2 foto dokumentasi tambahan.
- Foto tambahan bersifat opsional dan tidak menampilkan placeholder apabila belum tersedia.
- Seluruh gambar tampilan fasilitas menggunakan optimasi WebP melalui fondasi pemrosesan gambar yang tersedia.

Fallback: Halaman detail tetap dapat ditampilkan secara lengkap menggunakan foto utama dan deskripsi apabila fasilitas belum memiliki foto dokumentasi tambahan.

### 5.11 Kontak
 Informasi: Alamat, email, telepon, jam layanan, dan embed Google Maps.
 Form Pesan: Input Nama, Email, No HP (opsional), Subjek, Pesan.
 Sistem: Pesan wajib tersimpan ke database dan mengirim notifikasi ke email sekolah apabila konfigurasi email tersedia.

### 5.12 Chatbot FAQ
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
 Kelola Guru & Karyawan: CRUD data staf menggunakan satu modul backend dengan kategori Guru atau Karyawan, termasuk pengelolaan satu atau lebih riwayat pendidikan pada setiap staf.
 Kelola Program Unggulan: Mengelola pengantar halaman dan informasi kolaborasi Program Unggulan serta CRUD bidang keterampilan yang ditampilkan kepada publik.
 Kelola Konten Dinamis: CRUD Berita, Prestasi, Program Unggulan, Ekstrakurikuler, dan Fasilitas. Program Unggulan dapat dikelola melalui Filament dengan data nama, ringkasan, deskripsi/manfaat, foto utama, status aktif, urutan tampil, serta maksimal 2 foto dokumentasi tambahan. Modul Ekstrakurikuler dan Fasilitas tetap mendukung satu foto utama serta maksimal 2 foto dokumentasi tambahan sesuai requirement masing-masing.
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
Version: 1.4 (Revised Approved Baseline)
 Status: Siap Produksi
Catatan: Dokumen telah diperbarui untuk mencakup carousel Data Guru pada Beranda setelah Sambutan Kepala Sekolah serta penyederhanaan Beranda tanpa statistik sekolah.