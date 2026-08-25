# Information Architecture (IA) - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.6 | Status: Revised Approved Baseline (Production-Ready)

## 1. Peta Situs Global (Sitemap)
Struktur kedalaman informasi dibatasi maksimal 3 klik dari Beranda demi kemudahan navigasi pengguna.

 Beranda (Home): Landing page dengan kompilasi ringkasan informasi dan konten visual utama website.

 Profil (Dropdown):
 - Profil Sekolah: Identitas sekolah, visi & misi, tujuan sekolah, dan Sambutan Kepala Sekolah.
 - Sejarah: Informasi sejarah dan perkembangan SMA PGRI 1 Tulungagung.
 - Data Guru: Daftar tenaga pendidik melalui centered horizontal carousel profil yang dapat memuat foto, nama, riwayat pendidikan, jabatan, dan mata pelajaran.
- Data Karyawan: Daftar tenaga kependidikan/karyawan melalui centered horizontal carousel profil yang dapat memuat foto, nama, riwayat pendidikan, jabatan, dan bagian/unit.

  Akademik (Dropdown):
 - Kurikulum: Informasi kurikulum berdasarkan tahun ajaran dengan dokumen PDF dan materi gambar yang dapat diunduh.
 - Program Unggulan: Landing page pengembangan keterampilan praktis siswa yang menampilkan bidang program aktif, manfaat, dokumentasi kegiatan, serta informasi umum kolaborasi dengan LPK/BLK.
 - Fasilitas: Dokumentasi sarana dan prasarana sekolah melalui halaman indeks dan halaman detail fasilitas.

 Informasi (Dropdown):
 - Berita: Arsip artikel, pengumuman, kegiatan, pencarian, kategori, dan halaman detail berita.
 - SPMB: Informasi Sistem Penerimaan Murid Baru, file informasi, brosur, preview media, dan file yang dapat diunduh.

 Jejak & Karya (Dropdown):
- Prestasi: Daftar pencapaian akademik dan non-akademik sekolah.
- Ekstrakurikuler: Daftar kegiatan ekstrakurikuler sekolah.
- Alumni: Menampilkan maksimal 4 Alumni Pilihan serta akses menuju Google Forms resmi sekolah untuk pendataan alumni.
- Galeri: Menampilkan dokumentasi foto kegiatan, pembelajaran, prestasi, dan momen sekolah.

 Kontak: Detail alamat, telepon, email, form hubungi kami, dan embed Google Maps.

 Chatbot Widget: Floating overlay widget yang selalu aktif di seluruh halaman sebagai akses informasi cepat.

---

## 2. Navigasi Komponen (Header & Footer)

### 2.1 Navigasi Utama (Navbar Header)
Menerapkan maksimal 6 menu utama di desktop. Pada mode mobile, navigasi otomatis berubah menjadi Hamburger Menu dengan sistem accordion untuk submenu, tanpa mega-menu.

`[Logo Sekolah] Beranda | Profil ▾ | Akademik ▾ | Informasi ▾ | Jejak & Karya ▾ | Kontak`

Struktur submenu:

 Profil:
 - Profil Sekolah
 - Sejarah
 - Data Guru
 - Data Karyawan

  Akademik:
 - Kurikulum
 - Program Unggulan
 - Fasilitas

 Informasi:
 - Berita
 - SPMB

 Jejak & Karya:
- Prestasi
- Ekstrakurikuler
- Alumni
- Galeri

Halaman Profil Sekolah menggabungkan informasi profil utama, Visi & Misi, Tujuan Sekolah, dan Sambutan Kepala Sekolah sehingga tidak perlu menjadi submenu terpisah.

### 2.2 Navigasi Kaki (Footer Global)

 Kolom 1 (Identitas Sekolah): Logo sekolah, nama sekolah, deskripsi singkat, alamat resmi, nomor telepon, dan email instansi yang ditarik dinamis dari database. Jam operasional hanya ditampilkan apabila tersedia pada sumber data.

 Kolom 2 (Tautan Cepat): Tautan publik menuju Profil Sekolah, Kurikulum, Berita, SPMB, Alumni, dan Kontak. Tautan menuju panel admin tidak ditampilkan pada footer publik.

 Kolom 3 (Lokasi & Media Sosial): Tautan Instagram, Facebook, dan YouTube dalam bentuk tombol ikon, serta mini Google Maps apabila data embed tersedia.

 Baris Bawah: Hak cipta dinamis berdasarkan konfigurasi website.

---

## 3. Struktur Pengalamatan URL (Routing SEO-Friendly)

URL publik menggunakan struktur yang singkat, konsisten, dan mudah dipahami pengguna.

| Halaman Publik | Pola URL (Route Path) | Jenis Konten / Parameter |
| :--- | :--- | :--- |
| Beranda | `/` | Kompilasi Konten |
| Profil Sekolah | `/profil` | Data Profil Sekolah |
| Sejarah | `/sejarah` | Data Sejarah Sekolah |
| Data Guru | `/guru` | Dinamis / Centered Carousel Profil Guru |
| Data Karyawan | `/karyawan` | Dinamis / Centered Carousel Profil Karyawan |
| Kurikulum | `/kurikulum` | Dinamis / Informasi dan File Download |
| Program Unggulan | `/program-unggulan` | Dinamis / Landing Page Program Keterampilan |
| Indeks Fasilitas | `/fasilitas` | Dinamis / Grid Fasilitas |
| Detail Fasilitas | `/fasilitas/{slug}` | Dinamis / Detail Fasilitas & Dokumentasi Pendukung |
| Arsip Berita | `/berita` | Dinamis / Pagination & Search |
| Detail Berita | `/berita/{slug}` | Dinamis / Unique Slug |
| SPMB | `/spmb` | Informasi dan File Download |
| Arsip Prestasi | `/prestasi` | Dinamis / Grid & Filter |
| Detail Prestasi | `/prestasi/{slug}` | Dinamis / Achievement Showcase |
| Arsip Ekstrakurikuler | `/ekstrakurikuler` | Dinamis / Grid Cards |
| Alumni | `/alumni` | Dinamis / Alumni Pilihan & Akses Google Forms |
| Galeri | `/galeri` | Dinamis / Grid Foto & Pagination |
| Kontak Kami | `/kontak` | Informasi Kontak & Form POST |

Pendataan Alumni tidak memiliki route POST pada website Laravel karena pengisian data dilakukan melalui Google Forms resmi milik sekolah.

---

## 4. Alur Informasi Halaman Depan (Homepage Wireframe IA)

Urutan penyajian informasi vertikal dari atas ke bawah pada Beranda diatur berdasarkan tingkat prioritas informasi pengunjung:

1. Hero Banner: Slider atau banner utama dengan gambar, judul, subjudul, dan tombol CTA.
2. Quick Menu: Tombol pintas menuju halaman penting seperti Profil, SPMB, Berita, dan Kontak.
3. Sambutan Kepala Sekolah: Sambutan ringkas sebagai pengantar identitas dan arah pendidikan sekolah, dilengkapi akses menuju halaman Profil Sekolah.
4. Data Guru: Centered horizontal carousel Guru menggunakan komponen yang sama dengan halaman Data Guru. Kepala Sekolah menjadi slide aktif pertama dan Guru lainnya mengikuti `sort_order`.
5. Highlights Dinamis: Berita terbaru, prestasi terbaru, dan ekstrakurikuler pilihan.
6. Fasilitas & Galeri: Ringkasan fasilitas dan dokumentasi kegiatan sekolah.
7. Lokasi & Kontak: Informasi kontak singkat dan Google Maps.

Beranda tidak menampilkan section statistik sekolah tersendiri. Informasi mengenai tenaga pendidik diprioritaskan melalui carousel Guru agar alur halaman lebih kuat secara visual dan memberikan pengenalan langsung terhadap tenaga pendidik sekolah.

Konten yang belum memiliki data tidak boleh menampilkan informasi palsu atau hardcode. Section dapat disembunyikan atau menggunakan empty state yang sesuai.

---

## 5. Struktur Informasi Halaman Profil

### 5.1 Profil Sekolah
Urutan konten:

`Mini Hero` → `Identitas / Profil Singkat Sekolah` → `Visi & Misi` → `Tujuan Sekolah` → `Sambutan Kepala Sekolah` → `CTA`

### 5.2 Sejarah
Halaman khusus yang menampilkan perjalanan dan perkembangan sekolah secara terpisah agar halaman Profil Sekolah tidak terlalu panjang.

### 5.3 Data Guru

Menampilkan tenaga pendidik menggunakan centered horizontal carousel profil.

Saat halaman pertama kali dibuka, Kepala Sekolah menjadi slide aktif pertama. Guru lainnya mengikuti `sort_order`.

Pada desktop, tiga kartu dapat terlihat secara bersamaan dengan kartu aktif berada di tengah dan tampil lebih menonjol.

Informasi kartu dapat mencakup:
- Foto
- Nama
- Satu atau lebih Riwayat Pendidikan
- Jabatan
- Mata Pelajaran

Riwayat pendidikan dapat mencakup jenjang pendidikan, program studi jika tersedia, serta perguruan tinggi atau institusi pendidikan.

Carousel mendukung autoplay, pause sementara ketika pointer berada pada area carousel, drag menggunakan mouse, swipe pada perangkat sentuh, dan navigasi manual.

Foto bersifat opsional dan menggunakan placeholder apabila belum tersedia.

### 5.4 Data Karyawan

Menampilkan tenaga kependidikan/karyawan menggunakan centered horizontal carousel profil.

Slide aktif pertama mengikuti `sort_order` Karyawan aktif.

Pada desktop, tiga kartu dapat terlihat secara bersamaan dengan kartu aktif berada di tengah dan tampil lebih menonjol.

Informasi kartu dapat mencakup:
- Foto
- Nama
- Satu atau lebih Riwayat Pendidikan
- Jabatan
- Bagian atau Unit

Riwayat pendidikan dapat mencakup jenjang pendidikan, program studi jika tersedia, serta perguruan tinggi atau institusi pendidikan.

Carousel mendukung autoplay, pause sementara ketika pointer berada pada area carousel, drag menggunakan mouse, swipe pada perangkat sentuh, dan navigasi manual.

Foto bersifat opsional dan menggunakan placeholder apabila belum tersedia.

Data Guru dan Karyawan berasal dari satu fondasi backend, tetapi ditampilkan pada dua halaman publik yang berbeda.

---

## 6. Struktur Informasi Halaman Program Unggulan

Program Unggulan merupakan bagian dari domain Akademik karena berfungsi sebagai penawaran dan pengembangan pendidikan sekolah, bukan sebagai hasil karya siswa.

Urutan konten:

`Compact Visual Hero`
→ `Pengantar Program Unggulan`
→ `Konteks Kolaborasi LPK/BLK jika tersedia`
→ `Keunggulan / Manfaat Pengembangan Keterampilan`
→ `Showcase Program Aktif berdasarkan sort_order`
→ `Dokumentasi Kegiatan jika tersedia`
→ `Closing CTA menuju SPMB dan Kontak`

Pengantar halaman dan informasi umum kolaborasi berasal dari pengaturan dinamis backend.

Setiap bidang Program Unggulan dapat menampilkan:
- Nama program.
- Ringkasan singkat.
- Deskripsi atau manfaat.
- Foto utama.
- Maksimal 2 foto dokumentasi tambahan.

Showcase menggunakan pendekatan image-led/editorial dan tidak menggunakan pola katalog white-card yang berat.

Program yang ditampilkan hanya data dengan `is_active = true` dan diurutkan berdasarkan `sort_order`.

Dokumentasi tambahan:
- 0 foto: tidak menampilkan area dokumentasi kosong.
- Maksimal 2 foto per program.
- Section dokumentasi hanya menggunakan foto dari program aktif.
- Tidak menggunakan carousel secara default.

Halaman tidak memiliki route detail per bidang pada versi saat ini.

Jika tidak terdapat program aktif, halaman menampilkan empty state yang sesuai tanpa data atau dokumentasi palsu.

---

## 7. Struktur Informasi Halaman Fasilitas

### Indeks Fasilitas

Urutan konten:

`Mini Hero Fasilitas`
→ `Pengantar / Heading Katalog`
→ `Grid Fasilitas`
→ `Pagination jika diperlukan`
→ `Closing Ringan`

Setiap kartu menggunakan foto utama fasilitas dan mengarah menuju halaman detail berdasarkan `slug`.

### Detail Fasilitas

Urutan konten:

`Mini Hero Detail`
→ `Main Facility Showcase`
→ `Tentang Fasilitas`
→ `Dokumentasi Tambahan jika tersedia`
→ `CTA menuju Daftar Fasilitas`

Main Facility Showcase menggunakan foto utama sebagai visual utama dan menyajikan identitas serta pengantar fasilitas dengan hierarchy visual yang jelas.

Dokumentasi Tambahan bersifat opsional:
- 0 foto tambahan: section tidak ditampilkan.
- 1 foto tambahan: ditampilkan sebagai satu visual utama.
- 2 foto tambahan: ditampilkan dalam komposisi dua foto yang responsif.

Homepage tetap menggunakan foto utama fasilitas dan tidak bergantung pada data dokumentasi tambahan.

---

## 8. Struktur Informasi Halaman Alumni

Halaman Alumni memiliki alur:

`Mini Hero` → `Pengantar Alumni` → `Maksimal 4 Alumni Pilihan` → `Ajakan Pendataan Alumni` → `Tombol/Akses Google Forms`

Alumni Pilihan dikelola melalui backend website.

Pendataan alumni umum dilakukan melalui Google Forms resmi sekolah. Data hasil pengisian dikelola melalui Google Sheets dan tidak otomatis ditampilkan pada website.

Upload foto pada Google Forms bersifat opsional.

---

## 9. Komponen UX Core: Breadcrumb & Call To Action (CTA)

 Skema Breadcrumb:
   `Beranda > Profil > Sejarah`
   `Beranda > Profil > Data Guru`
   `Beranda > Profil > Data Karyawan`
   `Beranda > Akademik > Kurikulum`
   `Beranda > Akademik > Program Unggulan`
   `Beranda > Informasi > Berita > [Judul-Berita]`
   `Beranda > Informasi > SPMB`
   `Beranda > Jejak & Karya > Prestasi`
   `Beranda > Jejak & Karya > Ekstrakurikuler`
   `Beranda > Jejak & Karya > Alumni`
   `Beranda > Jejak & Karya > Galeri`

 Distribusi Tombol Aksi (CTA):
   Halaman Berita/Prestasi → "Lihat Informasi SPMB" atau "Hubungi Kami".
   Halaman Profil/Guru/Karyawan → "Lihat Fasilitas Sekolah" atau "Hubungi Sekolah".
   Halaman Alumni → "Isi Data Alumni" menuju Google Forms resmi sekolah.
   Halaman Kurikulum/SPMB → Tombol unduh hanya ditampilkan apabila file tersedia.
   Halaman Program Unggulan → "Lihat Informasi SPMB" dan/atau "Hubungi Sekolah".

 Mekanisme Pencarian Global (Search): Pencarian global dibatasi pada konten yang memang membutuhkan pencarian teks, yaitu `News`, `Achievements`, dan `Extracurriculars`.

 Data Guru dan Karyawan tidak wajib masuk pencarian global karena masing-masing telah memiliki halaman daftar khusus.