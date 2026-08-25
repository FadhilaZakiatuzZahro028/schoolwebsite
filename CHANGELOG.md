## [Unreleased]

### Added

* Modul Kurikulum dengan dukungan dokumen PDF, gambar asli untuk unduhan, dan preview WebP.
* Modul Guru dan Karyawan menggunakan satu fondasi data dengan halaman pengelolaan Filament.
* Modul SPMB untuk informasi penerimaan, file informasi PDF, dan brosur.
* Modul Alumni Pilihan dengan batas maksimal 4 profil aktif.
* Modul pengetahuan chatbot dengan kategori FAQ yang selaras dengan cakupan informasi sekolah.
* Dashboard admin dengan statistik berita aktif, prestasi, ekstrakurikuler, fasilitas, dan pesan kontak belum dibaca.
* Pengujian integrasi untuk modul Kurikulum, Guru dan Karyawan, SPMB, Alumni Pilihan, Pengetahuan Chatbot, Pesan Kontak, Kategori Berita, Manajemen Admin, dan Dashboard.
* Pengujian pembersihan media untuk Hero Banner, Galeri, Berita, Prestasi, Ekstrakurikuler, dan Fasilitas.
* Modul Program Unggulan dengan pengaturan pengantar halaman dan informasi umum kolaborasi LPK/BLK, pengelolaan bidang keterampilan berdasarkan status aktif dan urutan tampil, foto utama WebP, serta maksimal 2 foto dokumentasi tambahan per program.

### Changed

* Terminologi penerimaan siswa diperbarui dari PPDB menjadi SPMB.
* Rancangan navigasi publik diperbarui menjadi Beranda, Profil, Akademik, Informasi, Jejak & Karya, dan Kontak.
* Rancangan halaman Profil dipisahkan menjadi Profil Sekolah, Sejarah, Data Guru, dan Data Karyawan.
* Rancangan pendataan alumni menggunakan Google Forms dan Google Sheets, tanpa menyimpan data pendaftaran alumni dalam database Laravel.
* Ukuran gambar palsu pada pengujian diperkecil untuk meningkatkan stabilitas dan efisiensi test suite.
* Perintah test Composer menggunakan process isolation untuk meningkatkan stabilitas pengujian konversi gambar.
* Seeder default tidak lagi membuat akun pengujian otomatis.
* Dokumentasi proyek diperbarui menyesuaikan kebutuhan fitur dan implementasi backend terbaru.
* Rancangan footer publik diperbarui dengan identitas sekolah, informasi kontak menggunakan Lucide Icons, tautan publik tanpa Login Admin, tombol media sosial, dan mini Google Maps opsional.
* Navigasi Akademik diperluas dengan menu Program Unggulan di antara Kurikulum dan Fasilitas.


### Fixed

* File gambar dan PDF Kurikulum lama tetap dipertahankan ketika data diedit tanpa mengunggah file baru.
* File media yang tidak lagi digunakan dibersihkan sesuai jenis penghapusan record.
* Batas maksimal empat Alumni Pilihan aktif diterapkan pada level aplikasi.
* Proteksi manajemen admin mencegah penghapusan akun sendiri dan penghapusan super admin terakhir.
* Kategori berita yang masih digunakan oleh berita tidak dapat dihapus.
* Pesan kontak mendukung status dibaca, soft delete, restore, dan force delete khusus super admin.

### Planned

* Implementasi frontend publik berbasis Blade dan Bootstrap 5.
* Implementasi halaman publik sesuai Information Architecture dan Page Blueprints.
* Integrasi formulir kontak publik dengan modul Pesan Kontak.
* Integrasi tautan pendataan alumni melalui Google Forms dan Google Sheets.
* Implementasi layanan dan widget chatbot pada frontend publik.
* Penyempurnaan SEO, aksesibilitas, responsivitas, dan performa frontend.
