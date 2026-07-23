# Information Architecture (IA) - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.3 | Status: Revised Approved Baseline (Production-Ready)

## 1. Peta Situs Global (Sitemap)
Struktur kedalaman informasi dibatasi maksimal 3 klik dari Beranda demi kemudahan navigasi pengguna.

 Beranda (Home): Landing page dengan kompilasi ringkasan informasi dan konten visual utama website.

 Profil (Dropdown):
 - Profil Sekolah: Identitas sekolah, visi & misi, tujuan sekolah, dan Sambutan Kepala Sekolah.
 - Sejarah: Informasi sejarah dan perkembangan SMA PGRI 1 Tulungagung.
 - Data Guru: Daftar tenaga pendidik dalam bentuk kartu profil.
 - Data Karyawan: Daftar tenaga kependidikan/karyawan dalam bentuk kartu profil.

 Akademik (Dropdown):
 - Kurikulum: Informasi kurikulum berdasarkan tahun ajaran dengan dokumen PDF dan materi gambar yang dapat diunduh.
 - Fasilitas: Dokumentasi sarana dan prasarana sekolah.

 Informasi (Dropdown):
 - Berita: Arsip artikel, pengumuman, kegiatan, pencarian, kategori, dan halaman detail berita.
 - SPMB: Informasi Sistem Penerimaan Murid Baru, file informasi, brosur, preview media, dan file yang dapat diunduh.

 Jejak & Karya (Dropdown):
 - Prestasi: Daftar pencapaian akademik dan non-akademik sekolah.
 - Ekstrakurikuler: Daftar kegiatan ekstrakurikuler sekolah.
 - Alumni: Menampilkan maksimal 4 Alumni Pilihan serta akses menuju Google Forms resmi sekolah untuk pendataan alumni.

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
 - Fasilitas

 Informasi:
 - Berita
 - SPMB

 Jejak & Karya:
 - Prestasi
 - Ekstrakurikuler
 - Alumni

Halaman Profil Sekolah menggabungkan informasi profil utama, Visi & Misi, Tujuan Sekolah, dan Sambutan Kepala Sekolah sehingga tidak perlu menjadi submenu terpisah.

### 2.2 Navigasi Kaki (Footer Global)
 Kolom 1: Logo Sekolah, Alamat Resmi, Nomor Telepon, Email Instansi, dan Jam Operasional Layanan.

 Kolom 2 (Quick Links): Tautan cepat ke Profil Sekolah, Kurikulum, Berita, SPMB, Alumni, Kontak, dan Login Admin.

 Kolom 3 (Media Sosial): Tautan ke Instagram, Facebook, YouTube, dan widget mini Google Maps jika tersedia.

 Baris Bawah: Hak Cipta dinamis berdasarkan konfigurasi website.

---

## 3. Struktur Pengalamatan URL (Routing SEO-Friendly)

URL publik menggunakan struktur yang singkat, konsisten, dan mudah dipahami pengguna.

| Halaman Publik | Pola URL (Route Path) | Jenis Konten / Parameter |
| :--- | :--- | :--- |
| Beranda | `/` | Kompilasi Konten |
| Profil Sekolah | `/profil` | Data Profil Sekolah |
| Sejarah | `/sejarah` | Data Sejarah Sekolah |
| Data Guru | `/guru` | Dinamis / Grid Kartu Profil Guru |
| Data Karyawan | `/karyawan` | Dinamis / Grid Kartu Profil Karyawan |
| Kurikulum | `/kurikulum` | Dinamis / Informasi dan File Download |
| Fasilitas | `/fasilitas` | Dinamis / Grid Fasilitas |
| Arsip Berita | `/berita` | Dinamis / Pagination & Search |
| Detail Berita | `/berita/{slug}` | Dinamis / Unique Slug |
| SPMB | `/spmb` | Informasi dan File Download |
| Arsip Prestasi | `/prestasi` | Dinamis / Grid & Filter |
| Arsip Ekstrakurikuler | `/ekstrakurikuler` | Dinamis / Grid Cards |
| Alumni | `/alumni` | Dinamis / Alumni Pilihan & Akses Google Forms |
| Kontak Kami | `/kontak` | Informasi Kontak & Form POST |

Pendataan Alumni tidak memiliki route POST pada website Laravel karena pengisian data dilakukan melalui Google Forms resmi milik sekolah.

---

## 4. Alur Informasi Halaman Depan (Homepage Wireframe IA)

Urutan penyajian informasi vertikal dari atas ke bawah pada Beranda diatur berdasarkan tingkat prioritas informasi pengunjung:

1. Hero Banner: Slider atau banner utama dengan gambar, judul, subjudul, dan tombol CTA.
2. Quick Menu: Tombol pintas menuju halaman penting seperti Profil, SPMB, Berita, dan Kontak.
3. Sambutan & Profil Singkat: Sambutan Kepala Sekolah dan ringkasan informasi sekolah.
4. Highlights Dinamis: Berita terbaru, prestasi terbaru, dan ekstrakurikuler pilihan.
5. Fasilitas & Galeri: Ringkasan fasilitas dan dokumentasi kegiatan sekolah.
6. Lokasi & Kontak: Informasi kontak singkat dan Google Maps.

Konten yang belum memiliki data tidak boleh menampilkan informasi palsu atau hardcode. Section dapat disembunyikan atau menggunakan empty state yang sesuai.

---

## 5. Struktur Informasi Halaman Profil

### 5.1 Profil Sekolah
Urutan konten:

`Mini Hero` → `Identitas / Profil Singkat Sekolah` → `Visi & Misi` → `Tujuan Sekolah` → `Sambutan Kepala Sekolah` → `CTA`

### 5.2 Sejarah
Halaman khusus yang menampilkan perjalanan dan perkembangan sekolah secara terpisah agar halaman Profil Sekolah tidak terlalu panjang.

### 5.3 Data Guru
Menampilkan tenaga pendidik menggunakan grid kartu profil.

Informasi kartu dapat mencakup:
- Foto
- Nama
- Jabatan
- Mata Pelajaran

Foto bersifat opsional dan menggunakan placeholder apabila belum tersedia.

### 5.4 Data Karyawan
Menampilkan tenaga kependidikan/karyawan menggunakan grid kartu profil.

Informasi kartu dapat mencakup:
- Foto
- Nama
- Jabatan
- Bagian atau Unit

Data Guru dan Karyawan berasal dari satu fondasi backend, tetapi ditampilkan pada dua halaman publik yang berbeda.

---

## 6. Struktur Informasi Halaman Alumni

Halaman Alumni memiliki alur:

`Mini Hero` → `Pengantar Alumni` → `Maksimal 4 Alumni Pilihan` → `Ajakan Pendataan Alumni` → `Tombol/Akses Google Forms`

Alumni Pilihan dikelola melalui backend website.

Pendataan alumni umum dilakukan melalui Google Forms resmi sekolah. Data hasil pengisian dikelola melalui Google Sheets dan tidak otomatis ditampilkan pada website.

Upload foto pada Google Forms bersifat opsional.

---

## 7. Komponen UX Core: Breadcrumb & Call To Action (CTA)

 Skema Breadcrumb:
   `Beranda > Profil > Sejarah`
   `Beranda > Profil > Data Guru`
   `Beranda > Profil > Data Karyawan`
   `Beranda > Akademik > Kurikulum`
   `Beranda > Informasi > Berita > [Judul-Berita]`
   `Beranda > Informasi > SPMB`
   `Beranda > Jejak & Karya > Prestasi`
   `Beranda > Jejak & Karya > Ekstrakurikuler`
   `Beranda > Jejak & Karya > Alumni`

 Distribusi Tombol Aksi (CTA):
   Halaman Berita/Prestasi → "Lihat Informasi SPMB" atau "Hubungi Kami".
   Halaman Profil/Guru/Karyawan → "Lihat Fasilitas Sekolah" atau "Hubungi Sekolah".
   Halaman Alumni → "Isi Data Alumni" menuju Google Forms resmi sekolah.
   Halaman Kurikulum/SPMB → Tombol unduh hanya ditampilkan apabila file tersedia.

 Mekanisme Pencarian Global (Search): Pencarian global dibatasi pada konten yang memang membutuhkan pencarian teks, yaitu `News`, `Achievements`, dan `Extracurriculars`.

 Data Guru dan Karyawan tidak wajib masuk pencarian global karena masing-masing telah memiliki halaman daftar khusus.