## [Unreleased]

### Added
- Modul Kurikulum dengan dukungan dokumen PDF, gambar asli untuk unduhan, dan preview WebP.
- Pengujian integrasi untuk pembuatan, penggantian, penghapusan, dan pemeliharaan file pada modul Kurikulum.
- Pembersihan file gambar otomatis ketika Hero Banner dan Galeri dihapus.
- Pembersihan file gambar ketika Berita, Prestasi, Ekstrakurikuler, dan Fasilitas dihapus secara permanen.

### Changed
- Ukuran gambar palsu pada pengujian diperkecil untuk meningkatkan stabilitas dan efisiensi test suite.
- Terminologi dalam dokumentasi penerimaan siswa diperbarui dari PPDB menjadi SPMB.
- Rancangan navigasi publik diperbarui menjadi Beranda, Profil, Akademik, Informasi, Jejak & Karya, dan Kontak.
- Rancangan halaman Profil dipisahkan menjadi Profil Sekolah, Sejarah, Data Guru, dan Data Karyawan.
- Rancangan pendataan alumni menggunakan Google Forms dan Google Sheets, tanpa menyimpan data pendaftaran alumni dalam database Laravel.
- Dokumentasi proyek diperbarui menyesuaikan kebutuhan fitur terbaru.

### Fixed
- File gambar dan PDF Kurikulum lama sekarang tetap dipertahankan ketika data diedit tanpa mengunggah file baru.
- Full test suite tidak lagi berhenti saat menjalankan pengujian konversi WebP.
- File media yang tidak lagi digunakan sekarang dibersihkan sesuai jenis penghapusan record.

### Planned
- Modul SPMB untuk informasi penerimaan, file informasi, dan brosur.
- Modul Guru & Karyawan menggunakan satu fondasi data dengan halaman publik terpisah.
- Modul Alumni Pilihan dengan maksimal 4 profil aktif.
- Integrasi tautan pendataan alumni melalui Google Forms dan Google Sheets.