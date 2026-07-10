# Information Architecture (IA) - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

## 1. Peta Situs Global (Sitemap)
Struktur kedalaman informasi dibatasi maksimal 3 klik dari Beranda demi kemudahan navigasi pengguna.

 Beranda (Home): Landing page dengan kompilasi ringkasan data visual seluruh website.
 Profil Sekolah (Dropdown): Sejarah, Visi & Misi, Sambutan Kepala Sekolah, Daftar Guru & Tendik, Struktur Organisasi.
 Informasi PPDB: Halaman statis berisi syarat, alur, jadwal pendaftaran, dan unduhan brosur PDF.
 Berita: Hub semua artikel, pengumuman, kategori, pencarian, dan halaman detail berita via slug.
 Pojok Siswa (Dropdown): Halaman indeks & detail Prestasi, Halaman indeks & detail Ekstrakurikuler.
 Fasilitas: Dokumentasi sarana dan prasarana sekolah.
 Kontak: Detail alamat, telepon, email, form hubungi kami, dan embed Google Maps.
 Chatbot Widget: Floating overlay widget yang selalu aktif di semua halaman (Akses universal).

---

## 2. Navigasi Komponen (Header & Footer)

### 2.1 Navigasi Utama (Navbar Header)
Menerapkan maksimal 6 menu utama di desktop. Pada mode mobile, otomatis berubah menjadi Hamburger Menu dengan sistem akordion (accordion closure), tanpa mega-menu.
`[Logo Sekolah] Beranda | Profil ▾ | Informasi PPDB | Berita | Pojok Siswa ▾ | Fasilitas | Kontak`

### 2.2 Navigasi Kaki (Footer Global)
 Kolom 1: Logo Sekolah, Alamat Resmi, Nomor Telepon, Email Instansi, Jam Operasional Layanan.
 Kolom 2 (Quick Links): Tautan cepat ke Profil, Berita, Informasi PPDB, Kontak, dan Link Login Admin.
 Kolom 3 (Media Sosial): Tautan ikonik ke Instagram, Facebook, YouTube, dan widget mini Google Maps.
 Baris Bawah: Hak Cipta (Copyright © 2026 SMA PGRI 1 Tulungagung. All Rights Reserved.)

---

## 3. Struktur Pengalamatan URL (Routing SEO-Friendly)
Seluruh parameter pengenal internal wajib menggunakan teks unik (unique slug) berupa huruf kecil dan tanda hubung, bukan nomor ID database.

| Halaman Publik | Pola URL (Route Path) | Jenis Konten / Parameter |
| :--- | :--- | :--- |
| Beranda | `/` | Statis / Kompilasi Query |
| Profil Induk / Sub | `/profil` atau `/profil/{section}` | Statis (`sejarah`, `visi-misi`, `guru`, `organisasi`) |
| PPDB Statis | `/ppdb` | Statis / File Download PDF |
| Arsip Berita | `/berita` | Dinamis (Pagination & Search Query) |
| Detail Berita | `/berita/{slug}` | Dinamis (Unique Slug) |
| Arsip Prestasi | `/prestasi` | Dinamis (Grid & Kategori Filter) |
| Arsip Ekskul | `/ekstrakurikuler` | Dinamis (Grid Cards) |
| Arsip Fasilitas | `/fasilitas` | Dinamis (Grid Images) |
| Kontak Kami | `/kontak` | Statis Form & POST Action |

---

## 4. Alur Informasi Halaman Depan (Homepage Wireframe IA)
Urutan penyajian informasi vertikal dari atas ke bawah pada Beranda diatur berdasarkan skala prioritas psikologi pengunjung:
1. Hero Banner: Slider gambar resolusi tinggi dengan teks judul utama dan tombol aksi (CTA Button).
2. Quick Menu: Grid 4 tombol pintas instan menuju Profil, PPDB, Berita, dan Kontak.
3. Sambutan & Profil Singkat: Foto Kepala Sekolah, teks sambutan hangat, dan counter statistik jumlah siswa/guru.
4. Highlights Dinamis: Kartu 3 berita terbaru, kartu 3 prestasi terbaru, dan kompilasi ekstrakurikuler unggulan.
5. Galeri & Lokasi: Tampilan foto aktivitas sekolah terkini, formulir kontak ringkas, dan peta Google Maps.

---

## 5. Komponen UX Core: Breadcrumb & Call To Action (CTA)
 Skema Jejak Halaman (Breadcrumb): Wajib diaktifkan pada seluruh halaman detail sebagai penanda navigasi SEO:
   `Beranda > Berita > [Judul-Berita-Slug]`
   `Beranda > Pojok Siswa > Prestasi > [Nama-Prestasi-Slug]`
 Distribusi Tombol Aksi (CTA): Menghindari halaman buntu. Setiap ujung bawah halaman wajib memiliki tombol pengarah:
   Halaman Berita/Prestasi → Tombol "Tertarik Gabung? Hubungi Kami" atau "Lihat Info PPDB".
   Halaman Profil/Fasilitas → Tombol "Lihat Fasilitas Sekolah" atau "Hubungi Kontak"`.
 Mekanisme Pencarian Global (Search): Tombol cari di header dibatasi secara efisien hanya memindai indeks teks pada tabel: `News`, `Achievements`, dan `Extracurriculars`.