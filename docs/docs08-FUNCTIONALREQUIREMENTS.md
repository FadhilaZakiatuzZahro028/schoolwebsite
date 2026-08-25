# Functional Requirements Specification (FRS) - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.4 | Status: Revised Approved Baseline (Production-Ready)

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
- Satu atau lebih Riwayat Pendidikan

Riwayat Pendidikan:
- Riwayat pendidikan dikelola melalui data `staff_educations`.
- Satu staf dapat memiliki lebih dari satu riwayat pendidikan.
- Setiap riwayat pendidikan dapat mencakup Jenjang Pendidikan, Program Studi opsional, Perguruan Tinggi atau Institusi Pendidikan, dan Urutan Tampil.
- Riwayat pendidikan memiliki relasi dengan `staff_members` dan mengikuti urutan tampil yang telah ditentukan.

Aturan Jenis Staf:
- Data dengan `staff_type = teacher` ditampilkan pada halaman Data Guru.
- Data dengan `staff_type = employee` ditampilkan pada halaman Data Karyawan.

Tampilan Publik:
- Data Guru dan Data Karyawan ditampilkan pada halaman yang berbeda.
- Kedua halaman menggunakan centered horizontal carousel.
- Pada desktop, tiga kartu dapat terlihat secara bersamaan.
- Kartu aktif berada di tengah serta tampil lebih besar, lebih terang, dan memiliki shadow yang lebih kuat.
- Kartu sisi kiri dan kanan tampil sedikit lebih kecil dengan opacity dan shadow yang lebih rendah.
- Halaman Guru menampilkan Kepala Sekolah sebagai slide aktif pertama. Pengaturan tersebut dilakukan dengan menempatkan Kepala Sekolah pada `sort_order` paling awal di antara data Guru aktif.
- Guru berikutnya mengikuti `sort_order`.
- Halaman Karyawan menggunakan Karyawan aktif dengan `sort_order` paling awal sebagai slide pertama.
- Carousel berjalan otomatis secara berulang.
- Autoplay berhenti sementara ketika pointer berada pada area carousel dan dilanjutkan kembali ketika pointer meninggalkan area.
- Desktop mendukung drag menggunakan mouse.
- Perangkat sentuh mendukung swipe.
- Navigasi manual Previous dan Next tersedia dan dapat dioperasikan menggunakan keyboard.
- Data Guru dapat menampilkan Foto, Nama, Riwayat Pendidikan, Jabatan, dan Mata Pelajaran.
- Data Karyawan dapat menampilkan Foto, Nama, Riwayat Pendidikan, Jabatan, dan Bagian/Unit.
- Hanya data berstatus aktif yang ditampilkan kepada publik.

Aturan Kondisi Data:
- Jika hanya terdapat satu data staf aktif, satu kartu ditampilkan di tengah dan fungsi autoplay serta drag/swipe yang tidak diperlukan dinonaktifkan.
- Jika tidak terdapat data staf aktif, frontend menampilkan empty state yang sesuai.

Aturan Gerakan & Aksesibilitas:
- Animasi carousel tidak boleh menyebabkan layout shift yang mengganggu.
- Sistem harus menghormati preferensi `prefers-reduced-motion`; autoplay atau animasi non-esensial dikurangi atau dinonaktifkan bagi pengguna yang mengaktifkan preferensi tersebut.
- Kontrol carousel harus memiliki label aksesibel yang jelas.

Aturan Foto:
- Foto bersifat opsional.
- Jika foto tidak tersedia, frontend wajib menampilkan placeholder yang konsisten.
- Foto yang diunggah untuk tampilan website menggunakan sistem optimasi dan konversi WebP yang sudah tersedia.

---

### Modul 4: CRUD Konten Dinamis (Berita, Kategori, Prestasi, Program Unggulan, Ekstrakurikuler, Fasilitas, Galeri)

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

#### Aturan Khusus Modul Program Unggulan

Pengaturan Tingkat Halaman:
- Admin dapat mengelola narasi pengantar Program Unggulan.
- Admin dapat mengelola keterangan umum mengenai kolaborasi pengembangan keterampilan dengan LPK/BLK.
- Pengantar dan informasi kolaborasi berasal dari backend dan tidak ditulis secara hardcode pada Blade.
- Sistem tidak menampilkan klaim mengenai sertifikasi, penyaluran kerja, jaminan pekerjaan, nama mitra tertentu, atau klaim lain apabila data tersebut belum dikonfirmasi sekolah.

Data utama Program Unggulan:
- Nama program.
- Ringkasan singkat.
- Deskripsi atau manfaat program.
- Foto utama.
- Status aktif.
- Urutan tampil.

Aturan Data:
- Program tidak menggunakan slug pada versi saat ini.
- Hanya data `is_active = true` yang ditampilkan kepada publik.
- Data publik diurutkan berdasarkan `sort_order`.
- Admin dapat menambah program baru tanpa perubahan struktur database.
- Sistem tidak membatasi data hanya pada lima bidang keterampilan awal.

Dokumentasi Tambahan:
- Setiap program dapat memiliki maksimal 2 foto dokumentasi tambahan.
- Dokumentasi tambahan bersifat opsional.
- Setiap foto menyimpan file gambar, teks alternatif opsional, dan urutan tampil.
- Semua foto diproses melalui `ImageUploadService` dan fondasi WebP existing.
- Sistem tidak membuat uploader atau service pemrosesan gambar baru khusus Program Unggulan.

Tampilan Publik:
- Program Unggulan menggunakan satu landing page `/program-unggulan`.
- Tidak tersedia route detail per program pada versi saat ini.
- Halaman menggunakan pendekatan image-led/skill-development showcase dan tidak diwajibkan menggunakan pola white-card katalog.
- Jika sebuah program hanya mempunyai foto utama, program tetap dapat ditampilkan secara utuh.
- Dokumentasi tambahan hanya dirender jika tersedia.
- Jika tidak terdapat program aktif, halaman menampilkan empty state yang sesuai.
- Tidak menggunakan carousel dokumentasi secara default.

Lifecycle Media:
- Soft delete Program Unggulan tidak langsung menghapus foto utama maupun dokumentasi tambahan.
- Restore mempertahankan media yang sebelumnya dimiliki program.
- Force delete wajib membersihkan foto utama dan seluruh dokumentasi tambahan.
- Penggantian atau penghapusan foto dokumentasi wajib membersihkan file lama yang tidak lagi digunakan dari Laravel Storage.

---

#### Aturan Khusus Modul Ekstrakurikuler

Data utama Ekstrakurikuler:
- Nama
- Slug
- Deskripsi kegiatan
- Nama pembina
- Jadwal kegiatan
- Foto utama

Dokumentasi Tambahan:
- Setiap Ekstrakurikuler dapat memiliki maksimal 2 foto dokumentasi tambahan.
- Dokumentasi tambahan bersifat opsional.
- Setiap foto tambahan menyimpan file gambar, teks alternatif opsional, dan urutan tampil.
- Gambar diproses melalui sistem optimasi WebP yang sudah tersedia.
- Admin dapat menambah, mengubah, mengurutkan, dan menghapus foto dokumentasi tambahan melalui form Ekstrakurikuler.
- Sistem harus membersihkan file gambar lama apabila gambar diganti atau data dihapus secara permanen.
- Penghapusan permanen Ekstrakurikuler juga membersihkan file dokumentasi tambahannya.
- Soft delete Ekstrakurikuler tidak langsung menghapus file foto utama maupun dokumentasi tambahan sehingga data masih dapat dipulihkan.

Halaman Detail Publik:
- Foto utama menjadi focal visual kegiatan.
- Nama pembina dan jadwal ditampilkan sebagai informasi pendukung yang ringkas.
- Deskripsi menjadi bagian "Tentang Kegiatan".
- Jika tidak terdapat foto tambahan, section Dokumentasi Kegiatan tidak dirender.
- Jika tersedia 1 foto tambahan, tampilkan sebagai satu visual.
- Jika tersedia 2 foto tambahan, tampilkan dalam layout dua gambar yang responsif.
- Halaman tidak menggunakan carousel atau galeri besar secara default.

---

#### Aturan Khusus Modul Fasilitas

Data utama Fasilitas:
- Nama
- Slug
- Deskripsi
- Foto Utama

Foto Dokumentasi Tambahan:
- Setiap fasilitas dapat memiliki maksimal 2 foto dokumentasi tambahan.
- Foto tambahan bersifat opsional.
- Setiap foto tambahan dapat memiliki teks alternatif opsional dan urutan tampil.
- Foto tambahan diproses menggunakan fondasi optimasi WebP yang sudah tersedia.
- Sistem tidak membuat fondasi pemrosesan gambar baru apabila kebutuhan dapat menggunakan `ImageUploadService` yang tersedia.

Tampilan Publik:
- Halaman indeks menggunakan foto utama sebagai cover kartu fasilitas.
- Kartu fasilitas mengarah menuju halaman detail.
- Halaman detail menggunakan foto utama sebagai visual utama.
- Dokumentasi tambahan hanya ditampilkan apabila tersedia.
- Jika tidak tersedia foto tambahan, halaman tidak menampilkan placeholder atau area dokumentasi kosong.

Lifecycle Media:
- Penggantian atau penghapusan foto tambahan wajib membersihkan file yang tidak lagi digunakan dari Laravel Storage.
- Soft delete fasilitas tidak menghapus media secara permanen.
- Force delete fasilitas wajib membersihkan foto utama dan seluruh file dokumentasi tambahannya.

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

  Foto Guru, Karyawan, Alumni Pilihan, Hero Banner, Berita, Prestasi, Program Unggulan, Ekstrakurikuler, Fasilitas, dan Galeri menggunakan format teroptimasi untuk kebutuhan tampilan website.

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