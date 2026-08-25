# Features Documentation - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.5 | Status: Revised Approved Baseline (Production-Ready)

---

## MODUL 1: PUBLIC WEBSITE (FRONTEND)

### 1. Beranda (Home Page)
 Tujuan: Menyajikan impresi pertama yang profesional dan ringkasan informasi sekolah dalam waktu < 3 detik.
Komponen Fitur: Hero Banner Dinamis (Slider/Single), Menu Navigasi Cepat, Sambutan Kepala Sekolah dalam format ringkas, carousel Data Guru, Widget 3 Berita Terbaru, Widget 3 Prestasi Terkini, Ekstrakurikuler Unggulan, Fasilitas Unggulan, Komponen Galeri Foto, Google Maps Lokasi, dan Widget Chatbot FAQ (Floating).
Carousel Guru Beranda: Ditampilkan setelah Sambutan Kepala Sekolah menggunakan komponen centered horizontal carousel yang sama dengan halaman Data Guru. Kepala Sekolah menjadi slide aktif pertama, Guru lainnya mengikuti `sort_order`, dan tersedia akses menuju halaman Data Guru untuk melihat informasi lebih lengkap.
 Acceptance Criteria: Responsif di semua ukuran layar, gambar terkompresi otomatis, teks dinamis dari database, tombol CTA berfungsi penuh, carousel Guru menggunakan fondasi komponen yang sama dengan halaman Data Guru, dan Beranda tidak menampilkan statistik sekolah sebagai section tersendiri.
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

Tujuan: Menampilkan informasi tenaga pendidik dan tenaga kependidikan sekolah secara jelas, menarik, dan mudah diakses.

Data Guru: Menampilkan Guru melalui centered horizontal carousel. Pada desktop, tiga kartu dapat terlihat secara bersamaan dengan kartu aktif berada di tengah dan tampil lebih besar serta lebih terang. Kepala Sekolah menjadi slide aktif pertama saat halaman Guru pertama kali dibuka, kemudian Guru lainnya mengikuti urutan tampil.

Data Karyawan: Menampilkan Karyawan melalui centered horizontal carousel dengan pola visual dan interaksi yang sama. Slide pertama mengikuti urutan tampil Karyawan aktif.

Informasi Staf: Kartu dapat berisi foto, nama, satu atau lebih riwayat pendidikan, jabatan, serta mata pelajaran untuk Guru atau bagian/unit untuk Karyawan.

Riwayat Pendidikan: Setiap staf dapat memiliki lebih dari satu riwayat pendidikan yang mencakup jenjang pendidikan, program studi jika tersedia, dan perguruan tinggi atau institusi pendidikan.

Interaksi Carousel: Mendukung autoplay, pause sementara saat pointer berada pada area carousel, drag menggunakan mouse, swipe pada perangkat sentuh, serta kontrol navigasi manual yang aksesibel.

Acceptance Criteria: Data Guru dan Karyawan menggunakan satu fondasi backend dengan kategori jenis staf yang berbeda. Riwayat pendidikan dikelola secara terstruktur. Halaman publik tetap dipisahkan menjadi Data Guru dan Data Karyawan. Foto bersifat opsional dan menggunakan placeholder jika belum tersedia.

### 5. Kurikulum
 Tujuan: Menyediakan informasi kurikulum sekolah berdasarkan tahun ajaran.
 Komponen Fitur: Judul, Tahun Ajaran, Deskripsi, Dokumen PDF, Materi Gambar, Status Publikasi, Preview Gambar, dan Tombol Unduh.
 Acceptance Criteria: Data dikelola melalui backend, PDF dapat diunduh, gambar asli yang disediakan untuk unduhan tetap tersedia, dan preview website dapat menggunakan versi WebP teroptimasi.

 ### 6. Program Unggulan

Tujuan: Menampilkan pengembangan keterampilan praktis siswa sebagai salah satu program unggulan sekolah dan memperkuat informasi bagi calon siswa serta orang tua bahwa pembelajaran sekolah tidak terbatas pada aspek akademik.

Bidang Program: Program dapat mencakup Bahasa Korea, Desain Grafis, Tata Boga, Tata Kecantikan, Otomotif, serta bidang keterampilan lain yang kemudian ditambahkan sekolah.

Komponen Fitur:
- Satu landing page `/program-unggulan`.
- Pengantar mengenai Program Unggulan dan kolaborasi pengembangan keterampilan dengan LPK/BLK.
- Penjelasan manfaat dan keunggulan program secara profesional dan kredibel.
- Showcase program berdasarkan data aktif dan `sort_order`.
- Foto utama untuk setiap program.
- Maksimal 2 foto dokumentasi tambahan per program.
- Closing CTA menuju informasi SPMB dan/atau Kontak.

Aturan Konten:
- Informasi program dikelola melalui backend dan tidak di-hardcode pada Blade.
- Tidak menampilkan klaim mengenai sertifikasi, penyaluran kerja, jaminan pekerjaan, nama mitra tertentu, atau klaim lainnya apabila belum tersedia data resmi dari sekolah.
- Tidak terdapat halaman detail terpisah untuk setiap bidang pada versi saat ini.
- Program tidak membutuhkan slug selama tidak memiliki route detail.
- Pengantar halaman dan keterangan umum kolaborasi LPK/BLK berasal dari pengaturan dinamis backend dan tidak di-hardcode pada Blade.

Aturan Media:
- Foto utama menjadi visual utama setiap bidang keterampilan.
- Foto dokumentasi tambahan bersifat opsional dan maksimal 2 foto.
- Dokumentasi tambahan memiliki teks alternatif dan urutan tampil.
- Seluruh gambar menggunakan fondasi optimasi WebP yang sudah tersedia.
- Tidak menggunakan carousel atau galeri berat secara default.

Acceptance Criteria:
- Hanya program berstatus aktif yang tampil pada halaman publik.
- Program ditampilkan berdasarkan `sort_order`.
- Landing page responsif dan mobile-first.
- Halaman tetap utuh apabila suatu program hanya memiliki foto utama.
- Dokumentasi tambahan tidak menampilkan placeholder apabila datanya kosong.
- Jika tidak terdapat program aktif, tampilkan empty state yang sesuai.

### 7. Berita & Artikel
 Tujuan: Media publikasi resmi mengenai kegiatan, pengumuman, dan informasi sekolah.
 Komponen Fitur: Halaman list berita dengan pagination, pencarian berita berdasarkan judul, filter kategori, halaman detail berita (SEO friendly URL via Slug), artikel terkait (Related News), tombol share media sosial, estimasi waktu baca otomatis, dan indikator progres membaca pada halaman detail.
 Halaman Detail: Menggunakan layout editorial dengan header artikel ringkas, gambar utama, rich text body, sticky sidebar pada desktop untuk aksi berbagi dan artikel terkait, serta fallback responsif yang memindahkan sidebar ke bawah konten pada tablet/mobile.
 Acceptance Criteria: Mendukung status Draft/Published, optimasi metadata per berita, gambar utama wajib dikonversi otomatis ke `.webp`, artikel terkait hanya berasal dari berita yang telah dipublikasikan, dan fitur interaktif tetap dapat digunakan dengan keyboard serta menghormati preferensi reduced motion.
 
### 8. SPMB
 Tujuan: Menyediakan pusat informasi Sistem Penerimaan Murid Baru (SPMB) sekolah tanpa membangun sistem seleksi atau pendaftaran online penuh.
 Komponen Fitur: Keterangan atau informasi SPMB, File Informasi, Brosur SPMB, preview gambar jika tersedia, dan tombol unduh.
 Acceptance Criteria: Keterangan dan file dapat dikelola admin melalui backend. File PDF dan gambar asli dapat diunduh. Gambar yang digunakan untuk preview website dapat menggunakan versi WebP teroptimasi.

### 9. Jejak & Karya

 Modul Prestasi: Menampilkan daftar pencapaian akademik dan non-akademik dilengkapi informasi nama prestasi, tingkat, tahun, deskripsi singkat, dan foto dokumentasi.

 Modul Ekstrakurikuler: Menampilkan daftar dan profil detail kegiatan ekstrakurikuler yang dilengkapi nama, deskripsi kegiatan, nama pembina, jadwal, foto utama kegiatan, serta maksimal 2 foto dokumentasi tambahan opsional. Halaman detail menggunakan pola Activity Profile yang menempatkan identitas kegiatan, informasi pembina dan jadwal, narasi kegiatan, serta dokumentasi visual dalam hierarki yang terkontrol.

 Aturan Dokumentasi Ekstrakurikuler:
- Foto utama tetap menjadi media utama dan wajib tersedia sesuai implementasi backend yang berlaku.
- Admin dapat menambahkan maksimal 2 foto dokumentasi tambahan.
- Foto tambahan bersifat opsional.
- Setiap foto tambahan dapat memiliki teks alternatif untuk aksesibilitas dan urutan tampil.
- Jika tidak terdapat foto tambahan, section dokumentasi tambahan tidak dirender pada halaman publik.
- Jika tersedia 1 foto tambahan, dokumentasi ditampilkan sebagai satu visual yang terkontrol.
- Jika tersedia 2 foto tambahan, dokumentasi ditampilkan dalam komposisi dua gambar responsif.
- Dokumentasi tambahan tidak menggunakan carousel atau galeri besar secara default.

 Modul Alumni: Menampilkan maksimal 4 Alumni Pilihan yang dikelola oleh admin serta menyediakan akses menuju Google Forms resmi sekolah untuk pendataan alumni.

 Pendataan Alumni: Google Forms dapat meminta informasi berupa nama lengkap, nomor HP/WhatsApp, email, tahun kelulusan, pekerjaan atau aktivitas saat ini, instansi/perusahaan, domisili, foto opsional, serta informasi tambahan sesuai kebutuhan sekolah.

 Acceptance Criteria: Data Prestasi tetap menggunakan backend yang tersedia. Modul Ekstrakurikuler mempertahankan data utama yang tersedia dan dapat memiliki maksimal 2 foto dokumentasi tambahan yang dikelola melalui backend. Alumni Pilihan dikelola melalui backend dengan maksimal 4 profil aktif. Data pendataan alumni dikumpulkan melalui Google Forms dan dikelola melalui Google Sheets milik sekolah serta tidak otomatis ditampilkan kepada publik.

### 10. Fasilitas Sekolah

Tujuan: Menampilkan sarana dan prasarana penunjang kegiatan belajar mengajar melalui katalog fasilitas yang informatif serta halaman detail yang lebih visual.

Komponen Fitur:
- Halaman indeks fasilitas dengan grid foto responsif.
- Foto utama, nama, dan deskripsi singkat pada kartu fasilitas.
- Akses dari kartu fasilitas menuju halaman detail.
- Halaman detail dengan foto utama, uraian fasilitas, dan maksimal 2 foto dokumentasi tambahan jika tersedia.
- Section dokumentasi tambahan hanya ditampilkan jika data foto tersedia.
- CTA kembali atau menuju daftar fasilitas sekolah.

Media:
- Foto utama fasilitas tetap menggunakan field `facilities.image`.
- Foto dokumentasi tambahan dikelola secara terpisah.
- Seluruh gambar tampilan menggunakan optimasi WebP melalui fondasi media reusable yang tersedia.

Acceptance Criteria:
- Index dan detail responsif serta mobile-first.
- Foto tambahan tidak wajib tersedia.
- Tidak menampilkan placeholder palsu jika foto tambahan kosong.
- Homepage tetap menggunakan foto utama fasilitas dan tidak bergantung pada foto dokumentasi tambahan.
- Data fasilitas dan media berasal dari backend serta tidak di-hardcode pada Blade.

Future Enhancement: Integrasi 360° Virtual Tour.

### 11. Kontak & Hubungi Kami
 Tujuan: Menyediakan saluran komunikasi resmi bagi masyarakat umum dan orang tua siswa.
 Komponen Fitur: Detail Kontak (Alamat lengkap, Email resmi, Telepon, WhatsApp Link), Jam Layanan, Embed Google Maps, dan Form Hubungi Kami (Input: Nama, Email, No. HP, Subjek, Pesan).
 Acceptance Criteria: Form memiliki proteksi rate limiting anti-spam, input wajib divalidasi, pesan tersimpan ke database, dan dapat memicu notifikasi email apabila konfigurasi email tersedia.

### 12. Chatbot FAQ Lokal
 Tujuan: Otomatisasi layanan informasi 24/7 untuk menjawab pertanyaan seputar sekolah secara gratis dan cepat.
 Komponen Fitur: Antarmuka obrolan (chat widget) di pojok kanan bawah. Memproses input teks user menggunakan metode pencarian kata kunci (rule-based keyword matching) terhadap basis data FAQ lokal.
 Scope Jawaban: Hanya merespon seputar Profil Sekolah, Sejarah, Guru, Karyawan, Alamat, Kontak, Kurikulum, Fasilitas, Berita, Ekstrakurikuler, Prestasi, Alumni, dan SPMB.
 Fallback Response: Jika tidak ada kata kunci yang cocok, memunculkan teks seragam: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."

---

## MODUL 2: ADMIN PANEL (FILAMENT BACKEND)

 Dashboard Statis: Menampilkan ringkasan data berupa total berita aktif, pesan kontak belum dibaca, total prestasi, total ekskul, dan statistik sederhana penggunaan kata kunci chatbot.

 Manajemen Profil Sekolah: Mengelola data identitas sekolah, visi, misi, tujuan, Sambutan Kepala Sekolah, sejarah, serta informasi profil lainnya yang tersedia pada backend.

 Manajemen SPMB: Mengelola keterangan SPMB, file informasi, brosur, dan media pendukung yang dapat ditampilkan atau diunduh pada halaman publik.

 Manajemen Guru & Karyawan: CRUD data tenaga sekolah melalui satu fondasi backend dengan kategori Guru atau Karyawan. Data dapat mencakup nama, foto opsional, jabatan, mata pelajaran atau bagian/unit, status aktif, urutan tampil, serta satu atau lebih riwayat pendidikan yang terdiri atas jenjang pendidikan, program studi jika tersedia, dan perguruan tinggi atau institusi pendidikan.

 CRUD Konten Dinamis: Pengelolaan penuh (Create, Read, Update, Delete) untuk modul Berita, Kategori, Prestasi, Program Unggulan, Ekstrakurikuler, Fasilitas, Album Galeri, dan Banner Slider Utama sesuai requirement masing-masing modul.

 Manajemen Kurikulum: CRUD informasi kurikulum, tahun ajaran, dokumen PDF, materi gambar, status publikasi, dan urutan tampil.

 Manajemen Program Unggulan: Mengelola pengantar halaman dan keterangan umum kolaborasi LPK/BLK, serta CRUD bidang Program Unggulan yang mencakup nama, ringkasan, deskripsi/manfaat, foto utama, status aktif, urutan tampil, dan maksimal 2 foto dokumentasi tambahan. Pengelolaan media menggunakan fondasi WebP reusable yang sudah tersedia.

 Manajemen Alumni Pilihan: CRUD profil alumni yang akan ditampilkan pada halaman publik dengan maksimal 4 alumni aktif.

 Pendataan Alumni: Tidak dikelola melalui database atau Admin Panel Laravel. Pendataan dilakukan menggunakan Google Forms dan hasilnya dikelola pihak sekolah melalui Google Sheets.

 Manajemen Pesan Kontak: Fitur membaca pesan masuk dari publik, mengubah status pesan (Belum Dibaca / Sudah Dibaca), dan opsi menghapus pesan.

 Manajemen Chatbot FAQ: CRUD pangkalan data pasangan Pertanyaan (Keywords) dan Jawaban yang menjadi acuan respon mesin chatbot lokal.

 Manajemen Pengguna & Sistem: Pengaturan akun admin dengan pembagian role (Super Admin untuk kontrol sistem penuh; Admin Konten untuk kelola konten publik) serta halaman konfigurasi SEO global.

---

## MODUL 3: SYSTEM INTEGRAL FEATURES (NON-FUNCTIONAL)

 Security: Proteksi CSRF, Form Validation, Authentication, Mass Assignment Protection, pembatasan hak akses, dan enkripsi password.

 Performance: Eager loading relasi model database jika diperlukan, pagination otomatis pada data dalam jumlah besar, caching berkala pengaturan situs, lazy loading media, dan konversi otomatis gambar tampilan website ke `.webp`. File asli yang memang disediakan untuk kebutuhan unduhan tetap dipertahankan.

  Media Management: Seluruh gambar dan dokumen yang dikelola website menggunakan Laravel Storage. Foto Guru dan Karyawan, Alumni Pilihan, Program Unggulan, serta media tampilan modul lainnya menggunakan optimasi WebP sesuai fondasi reusable yang tersedia.

 External Integration: Google Forms digunakan sebagai layanan eksternal untuk pendataan alumni. Website hanya menyediakan akses menuju form resmi sekolah dan tidak melakukan sinkronisasi otomatis data Google Forms atau Google Sheets pada versi awal.

 Error Handling: Menonaktifkan mode debug pada production environment dan menampilkan halaman kustom 404/500 yang aman bagi user awam.

---

## MODUL 4: FUTURE ROADMAP (VERSI LANJUTAN)

 Pengembangan sistem fungsional terintegrasi: Portal Guru & Staf, Portal Nilai Siswa, Sistem Absensi Digital, SPMB Online Penuh (Seleksi Sistem), Platform E-Learning (CBT), Perpustakaan Digital, Portal Alumni dengan akun pribadi, Sistem Tracer Study Alumni terintegrasi, sinkronisasi otomatis Google Forms/Google Sheets, dan Aplikasi Mobile Native (Android & iOS).