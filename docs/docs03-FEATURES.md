# Features Documentation - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.3 | Status: Revised Approved Baseline (Production-Ready)

---

## MODUL 1: PUBLIC WEBSITE (FRONTEND)

### 1. Beranda (Home Page)
 Tujuan: Menyajikan impresi pertama yang profesional dan ringkasan informasi sekolah dalam waktu < 3 detik.
 Komponen Fitur: Hero Banner Dinamis (Slider/Single), Menu Navigasi Cepat, Sambutan Kepala Sekolah, Profil Singkat & Statistik (jika data tersedia), Widget 3 Berita Terbaru, Widget 3 Prestasi Terkini, Ekstrakurikuler Unggulan, Komponen Galeri Foto, Google Maps Lokasi, dan Widget Chatbot FAQ (Floating).
 Acceptance Criteria: Responsif di semua ukuran layar, gambar terkompresi otomatis, teks dinamis dari database, tombol CTA berfungsi penuh.
 Future Enhancement: Video Profile Sekolah (Embed YouTube).

### 2. Profil Sekolah
 Tujuan: Menyediakan informasi identitas dan profil resmi sekolah kepada publik.
 Komponen Fitur: Informasi Profil Sekolah, Visi & Misi, Nilai/Tujuan Sekolah, Sambutan Kepala Sekolah, serta informasi sekolah yang tersedia pada database.
 Acceptance Criteria: Seluruh data yang tersedia ditarik secara dinamis dari database.

### 3. Sejarah Sekolah
 Tujuan: Menyediakan informasi khusus mengenai sejarah dan perkembangan SMA PGRI 1 Tulungagung.
 Komponen Fitur: Konten sejarah sekolah yang disajikan dalam halaman terpisah agar informasi profil utama tetap ringkas dan mudah dibaca.
 Acceptance Criteria: Konten sejarah ditarik secara dinamis dari database dan ditampilkan secara responsif.

### 4. Data Guru & Karyawan
 Tujuan: Menampilkan informasi tenaga pendidik dan tenaga kependidikan sekolah secara jelas dan mudah diakses.

 Data Guru: Menampilkan daftar guru dalam bentuk kartu profil yang dapat berisi foto, nama, jabatan, dan mata pelajaran jika tersedia.

 Data Karyawan: Menampilkan daftar karyawan dalam bentuk kartu profil yang dapat berisi foto, nama, jabatan, dan bagian/unit jika tersedia.

 Acceptance Criteria: Data Guru dan Karyawan menggunakan satu fondasi backend dengan kategori jenis staf yang berbeda. Halaman publik tetap dipisahkan menjadi Data Guru dan Data Karyawan. Foto bersifat opsional dan menggunakan placeholder jika belum tersedia.

### 5. Kurikulum
 Tujuan: Menyediakan informasi kurikulum sekolah berdasarkan tahun ajaran.
 Komponen Fitur: Judul, Tahun Ajaran, Deskripsi, Dokumen PDF, Materi Gambar, Status Publikasi, Preview Gambar, dan Tombol Unduh.
 Acceptance Criteria: Data dikelola melalui backend, PDF dapat diunduh, gambar asli yang disediakan untuk unduhan tetap tersedia, dan preview website dapat menggunakan versi WebP teroptimasi.

### 6. Berita & Artikel
 Tujuan: Media publikasi resmi mengenai kegiatan, pengumuman, dan informasi sekolah.
 Komponen Fitur: Halaman list berita dengan pagination, pencarian berita berdasarkan judul, filter kategori, halaman detail berita (SEO friendly URL via Slug), artikel terkait (Related News), dan tombol share media sosial.
 Acceptance Criteria: Mendukung status Draft/Published, optimasi metadata per berita, gambar utama wajib dikonversi otomatis ke `.webp`.
 Future Enhancement: Kolom komentar (moderated) dan sistem kuesioner/survei singkat.

### 7. SPMB
 Tujuan: Menyediakan pusat informasi Sistem Penerimaan Murid Baru (SPMB) sekolah tanpa membangun sistem seleksi atau pendaftaran online penuh.
 Komponen Fitur: Keterangan atau informasi SPMB, File Informasi, Brosur SPMB, preview gambar jika tersedia, dan tombol unduh.
 Acceptance Criteria: Keterangan dan file dapat dikelola admin melalui backend. File PDF dan gambar asli dapat diunduh. Gambar yang digunakan untuk preview website dapat menggunakan versi WebP teroptimasi.

### 8. Jejak & Karya

 Modul Prestasi: Menampilkan daftar pencapaian akademik dan non-akademik dilengkapi informasi nama prestasi, tingkat, tahun, deskripsi singkat, dan foto dokumentasi.

 Modul Ekstrakurikuler: Menampilkan profil kegiatan ekstrakurikuler dilengkapi nama, deskripsi kegiatan, nama pembina, jadwal, dan foto kegiatan.

 Modul Alumni: Menampilkan maksimal 4 Alumni Pilihan yang dikelola oleh admin serta menyediakan akses menuju Google Forms resmi sekolah untuk pendataan alumni.

 Pendataan Alumni: Google Forms dapat meminta informasi berupa nama lengkap, nomor HP/WhatsApp, email, tahun kelulusan, pekerjaan atau aktivitas saat ini, instansi/perusahaan, domisili, foto opsional, serta informasi tambahan sesuai kebutuhan sekolah.

 Acceptance Criteria: Data Prestasi dan Ekstrakurikuler tetap menggunakan backend yang sudah tersedia. Alumni Pilihan dikelola melalui backend dengan maksimal 4 profil aktif. Data pendataan alumni dikumpulkan melalui Google Forms dan dikelola melalui Google Sheets milik sekolah serta tidak otomatis ditampilkan kepada publik.

### 9. Fasilitas Sekolah
 Tujuan: Menampilkan sarana dan prasarana penunjang kegiatan belajar mengajar.
 Komponen Fitur: Grid foto fasilitas (Ruang Kelas, Laboratorium, Perpustakaan, Mushola, Lapangan Olahraga, dll) disertai judul dan penjelasan fungsi fasilitas.
 Future Enhancement: Integrasi 360° Virtual Tour.

### 10. Kontak & Hubungi Kami
 Tujuan: Menyediakan saluran komunikasi resmi bagi masyarakat umum dan orang tua siswa.
 Komponen Fitur: Detail Kontak (Alamat lengkap, Email resmi, Telepon, WhatsApp Link), Jam Layanan, Embed Google Maps, dan Form Hubungi Kami (Input: Nama, Email, No. HP, Subjek, Pesan).
 Acceptance Criteria: Form memiliki proteksi rate limiting anti-spam, input wajib divalidasi, pesan tersimpan ke database, dan dapat memicu notifikasi email apabila konfigurasi email tersedia.

### 11. Chatbot FAQ Lokal
 Tujuan: Otomatisasi layanan informasi 24/7 untuk menjawab pertanyaan seputar sekolah secara gratis dan cepat.
 Komponen Fitur: Antarmuka obrolan (chat widget) di pojok kanan bawah. Memproses input teks user menggunakan metode pencarian kata kunci (rule-based keyword matching) terhadap basis data FAQ lokal.
 Scope Jawaban: Hanya merespon seputar Profil Sekolah, Sejarah, Guru, Karyawan, Alamat, Kontak, Kurikulum, Fasilitas, Berita, Ekstrakurikuler, Prestasi, Alumni, dan SPMB.
 Fallback Response: Jika tidak ada kata kunci yang cocok, memunculkan teks seragam: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."

---

## MODUL 2: ADMIN PANEL (FILAMENT BACKEND)

 Dashboard Statis: Menampilkan ringkasan data berupa total berita aktif, pesan kontak belum dibaca, total prestasi, total ekskul, dan statistik sederhana penggunaan kata kunci chatbot.

 Manajemen Profil Sekolah: Mengelola data identitas sekolah, visi, misi, tujuan, Sambutan Kepala Sekolah, sejarah, serta informasi profil lainnya yang tersedia pada backend.

 Manajemen SPMB: Mengelola keterangan SPMB, file informasi, brosur, dan media pendukung yang dapat ditampilkan atau diunduh pada halaman publik.

 Manajemen Guru & Karyawan: CRUD data tenaga sekolah melalui satu fondasi backend dengan kategori Guru atau Karyawan. Data dapat mencakup nama, foto opsional, jabatan, mata pelajaran atau bagian/unit, status aktif, dan urutan tampil.

 CRUD Konten Dinamis: Pengelolaan penuh (Create, Read, Update, Delete) untuk modul Berita, Kategori, Prestasi, Ekstrakurikuler, Fasilitas, Album Galeri, dan Banner Slider Utama sesuai implementasi backend yang sudah tersedia.

 Manajemen Kurikulum: CRUD informasi kurikulum, tahun ajaran, dokumen PDF, materi gambar, status publikasi, dan urutan tampil.

 Manajemen Alumni Pilihan: CRUD profil alumni yang akan ditampilkan pada halaman publik dengan maksimal 4 alumni aktif.

 Pendataan Alumni: Tidak dikelola melalui database atau Admin Panel Laravel. Pendataan dilakukan menggunakan Google Forms dan hasilnya dikelola pihak sekolah melalui Google Sheets.

 Manajemen Pesan Kontak: Fitur membaca pesan masuk dari publik, mengubah status pesan (Belum Dibaca / Sudah Dibaca), dan opsi menghapus pesan.

 Manajemen Chatbot FAQ: CRUD pangkalan data pasangan Pertanyaan (Keywords) dan Jawaban yang menjadi acuan respon mesin chatbot lokal.

 Manajemen Pengguna & Sistem: Pengaturan akun admin dengan pembagian role (Super Admin untuk kontrol sistem penuh; Admin Konten untuk kelola konten publik) serta halaman konfigurasi SEO global.

---

## MODUL 3: SYSTEM INTEGRAL FEATURES (NON-FUNCTIONAL)

 Security: Proteksi CSRF, Form Validation, Authentication, Mass Assignment Protection, pembatasan hak akses, dan enkripsi password.

 Performance: Eager loading relasi model database jika diperlukan, pagination otomatis pada data dalam jumlah besar, caching berkala pengaturan situs, lazy loading media, dan konversi otomatis gambar tampilan website ke `.webp`. File asli yang memang disediakan untuk kebutuhan unduhan tetap dipertahankan.

 Media Management: Seluruh gambar dan dokumen yang dikelola website menggunakan Laravel Storage. Foto Guru dan Karyawan serta Alumni Pilihan menggunakan optimasi WebP untuk kebutuhan tampilan website.

 External Integration: Google Forms digunakan sebagai layanan eksternal untuk pendataan alumni. Website hanya menyediakan akses menuju form resmi sekolah dan tidak melakukan sinkronisasi otomatis data Google Forms atau Google Sheets pada versi awal.

 Error Handling: Menonaktifkan mode debug pada production environment dan menampilkan halaman kustom 404/500 yang aman bagi user awam.

---

## MODUL 4: FUTURE ROADMAP (VERSI LANJUTAN)

 Pengembangan sistem fungsional terintegrasi: Portal Guru & Staf, Portal Nilai Siswa, Sistem Absensi Digital, SPMB Online Penuh (Seleksi Sistem), Platform E-Learning (CBT), Perpustakaan Digital, Portal Alumni dengan akun pribadi, Sistem Tracer Study Alumni terintegrasi, sinkronisasi otomatis Google Forms/Google Sheets, dan Aplikasi Mobile Native (Android & iOS).