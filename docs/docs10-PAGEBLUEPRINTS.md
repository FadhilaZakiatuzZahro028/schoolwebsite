# Page Blueprints - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.3 | Status: Revised Approved Baseline (Production-Ready)

---

## 1. Aturan Global Core UX & Metrik Performa (Lighthouse Target)

Seluruh halaman wajib menggunakan tata letak dasar responsif Bootstrap 5, memuat `<x-navbar>` di bagian atas, dan `<x-footer>` di bagian bawah. Halaman non-beranda wajib menyertakan komponen `<x-breadcrumb>`.

 Metrik Kecepatan Core Web Vitals: `LCP < 2.5s` | `CLS < 0.1` | `INP < 200ms`.

 Target Skor Audit Lighthouse: `Performance >= 95` | `Accessibility >= 95` | `SEO >= 95`.

Seluruh halaman dirancang menggunakan pendekatan mobile-first dan mengikuti Design System Modern Academic Glass yang telah ditetapkan. 

---

## 2. Matriks Komponen Susunan Halaman (Wireframe Layout Blueprint)

| ID | Nama Halaman | Pola Alur Struktur Komponen Visual (Atas ke Bawah) | Elemen Aksi Utama (CTA) & Aturan Fallback |
| :--- | :--- | :--- | :--- |
| P-01 | Beranda (Home) | `<x-navbar>` → `<x-hero-banner>` → Quick Access Grid → Sambutan Kepala Sekolah & Statistik Sekolah jika tersedia (`<x-stat-card>`) → Grid 3 `<x-news-card>` → Grid 3 `<x-achievement-card>` → Kompilasi Ekstrakurikuler & Fasilitas → `<x-gallery-grid>` → Kontak Ringkas → Maps → `<x-footer>` | Primary: "Hubungi Kami"<br>Secondary: "Lihat Profil"<br>Fallback: Section tanpa data dapat disembunyikan atau menggunakan `<x-empty-state>` sesuai kebutuhan. |
| P-02 | Profil Sekolah | Mini Hero → Identitas / Profil Singkat Sekolah → Visi & Misi → Tujuan Sekolah jika tersedia → Sambutan Kepala Sekolah → CTA | CTA: "Lihat Sejarah Sekolah" / "Hubungi Sekolah"<br>Behavior: Seluruh section responsif dan stack vertikal pada mobile. |
| P-03 | Sejarah Sekolah | Mini Hero → Konten Sejarah dan Perkembangan Sekolah → Dokumentasi Pendukung jika tersedia → CTA | CTA: "Kembali ke Profil Sekolah"<br>Fallback: Jika dokumentasi visual tidak tersedia, halaman tetap menampilkan konten teks tanpa placeholder palsu. |
| P-04 | Data Guru | Mini Hero → Pengantar Singkat → Grid `<x-staff-card>` khusus `teacher` → CTA | CTA: "Lihat Data Karyawan" / "Hubungi Sekolah"<br>Fallback: Jika belum ada data aktif, tampilkan `<x-empty-state>`. |
| P-05 | Data Karyawan | Mini Hero → Pengantar Singkat → Grid `<x-staff-card>` khusus `employee` → CTA | CTA: "Lihat Data Guru" / "Hubungi Sekolah"<br>Fallback: Jika belum ada data aktif, tampilkan `<x-empty-state>`. |
| P-06 | Kurikulum | Mini Hero → Pengantar Kurikulum → Daftar berdasarkan Tahun Ajaran → List `<x-curriculum-card>` → Preview Materi jika tersedia → Tombol Unduh PDF/Gambar | CTA: "Unduh Dokumen" / "Unduh Gambar"<br>Fallback: Jika data belum tersedia, tampilkan `<x-empty-state>`. |
| P-07 | Indeks Fasilitas | Mini Hero → Grid `<x-facility-card>` dengan rasio gambar konsisten → Preview/Lightbox jika diperlukan | CTA: Klik gambar untuk preview jika fitur lightbox digunakan.<br>Fallback: Jika kosong, tampilkan `<x-empty-state>`. |
| P-08 | Indeks Berita | Mini Hero → Search Bar + Filter Kategori → Grid/List `<x-news-card>` → `<x-pagination>` | CTA: Pencarian dan filter berita.<br>Fallback: Jika hasil kosong, tampilkan `<x-empty-state>`. |
| P-09 | Detail Berita | `<x-breadcrumb>` → Gambar Utama WebP → Judul Artikel (H1) → Metadata → Rich Text Body → Tombol Share → Related News | CTA: "Kembali ke Berita" / Share Link.<br>SEO: Menggunakan metadata spesifik berita jika tersedia. |
| P-10 | SPMB | Mini Hero → Keterangan Utama SPMB → Blok File Informasi (`<x-download-card>`) → Blok Brosur (`<x-download-card>`) → CTA Kontak | CTA: "Unduh File Informasi" / "Unduh Brosur"<br>Fallback: File yang belum tersedia tidak menampilkan tombol download. Keterangan utama tetap dapat ditampilkan. |
| P-11 | Indeks Prestasi | Mini Hero → Filter Tingkatan jika diperlukan → Grid `<x-achievement-card>` → Pagination jika diperlukan | CTA: Filter berdasarkan tingkatan prestasi.<br>Fallback: Jika kosong, tampilkan `<x-empty-state>`. |
| P-12 | Indeks Ekstrakurikuler | Mini Hero → Pengantar → Grid `<x-extracurricular-card>` | CTA: "Lihat Informasi SPMB" / "Hubungi Sekolah"<br>Fallback: Jika kosong, tampilkan `<x-empty-state>`. |
| P-13 | Alumni | Mini Hero → Pengantar Alumni → Grid maksimal 4 `<x-alumni-card>` → Section "Mari Terhubung Kembali dengan Almamater" → Deskripsi Pendataan → Tombol menuju Google Forms | CTA: "Isi Data Alumni"<br>Behavior: Tautan Google Forms berasal dari konfigurasi dinamis dan dapat dibuka pada tab baru.<br>Fallback: Jika URL form belum tersedia, tombol tidak ditampilkan dan diganti informasi yang sesuai. |
| P-14 | Hubungi Kontak | Mini Hero → Grid 2 Kolom (Informasi Kontak & Google Maps / `<x-contact-form>`) → Informasi Tambahan jika tersedia | CTA: "Kirim Pesan"<br>Security: Endpoint form dilindungi validasi dan rate limiting. |
| P-15 | Hasil Pencarian | Search Bar Master → Informasi keyword pencarian → Grid/List Konten Relevan → `<x-pagination>` | Fallback: Jika pencarian tidak menemukan hasil, tampilkan `<x-empty-state>` dan tautan kembali ke Beranda. |

---

## 3. Blueprint Detail Halaman Profil & Staf

### 3.1 Profil Sekolah

Urutan halaman:

`Mini Hero`
→ `Identitas / Profil Singkat Sekolah`
→ `Visi & Misi`
→ `Tujuan Sekolah jika tersedia`
→ `Sambutan Kepala Sekolah`
→ `CTA`

Halaman Profil Sekolah tidak lagi memisahkan Visi & Misi dan Sambutan Kepala Sekolah menjadi submenu tersendiri.

---

### 3.2 Sejarah Sekolah

Urutan halaman:

`Mini Hero`
→ `Judul Sejarah`
→ `Konten Naratif Sejarah`
→ `Dokumentasi Pendukung jika tersedia`
→ `CTA`

Sejarah memiliki halaman tersendiri agar konten Profil Sekolah tidak terlalu panjang.

---

### 3.3 Data Guru

Urutan halaman:

`Mini Hero`
→ `Judul dan Pengantar`
→ `Grid Kartu Profil Guru`
→ `CTA`

Setiap `<x-staff-card>` Guru dapat menampilkan:

- Foto
- Nama
- Jabatan
- Mata Pelajaran

Foto bersifat opsional. Jika tidak tersedia, gunakan placeholder yang konsisten.

---

### 3.4 Data Karyawan

Urutan halaman:

`Mini Hero`
→ `Judul dan Pengantar`
→ `Grid Kartu Profil Karyawan`
→ `CTA`

Setiap `<x-staff-card>` Karyawan dapat menampilkan:

- Foto
- Nama
- Jabatan
- Bagian atau Unit

Guru dan Karyawan menggunakan desain kartu yang sama, tetapi ditampilkan pada halaman publik yang berbeda.

---

## 4. Blueprint Halaman SPMB

Urutan halaman:

`Mini Hero`
→ `Judul & Keterangan SPMB`
→ `File Informasi`
→ `Brosur SPMB`
→ `CTA Kontak`

### File Informasi
Dapat berupa PDF atau gambar.

Jika berupa gambar:
- Preview menggunakan versi WebP teroptimasi.
- Tombol download menggunakan file asli.

Jika berupa PDF:
- Tampilkan informasi file dan tombol download.

### Brosur
Dapat berupa PDF atau gambar dengan aturan preview dan download yang sama.

Jika File Informasi atau Brosur belum tersedia, blok terkait tidak perlu ditampilkan.

Halaman tetap dapat digunakan hanya dengan keterangan SPMB apabila dokumen belum diunggah.

---

## 5. Blueprint Halaman Alumni

Urutan halaman:

`Mini Hero`
→ `Pengantar Alumni`
→ `Grid Maksimal 4 Alumni Pilihan`
→ `Section Pendataan Alumni`
→ `CTA Google Forms`

### Alumni Pilihan
Menggunakan `<x-alumni-card>` dan hanya menampilkan data yang telah diaktifkan oleh admin.

Informasi yang dapat ditampilkan:
- Foto
- Nama
- Tahun Kelulusan
- Aktivitas atau Pekerjaan
- Instansi
- Kutipan

Data pribadi seperti nomor telepon dan email tidak ditampilkan.

### Pendataan Alumni

Bagian pendataan menggunakan teks yang sederhana dan ramah, misalnya:

**"Mari Terhubung Kembali dengan Almamater"**

Diikuti penjelasan singkat dan tombol:

**"Isi Data Alumni"**

Tombol mengarah menuju Google Forms resmi sekolah.

Tidak terdapat `<x-alumni-form>` dan tidak terdapat pengiriman data Alumni ke backend Laravel.

Upload foto pada Google Forms bersifat opsional.

---

## 6. Struktur Navigasi Halaman

Navbar utama menggunakan susunan:

`Beranda | Profil ▾ | Akademik ▾ | Informasi ▾ | Jejak & Karya ▾ | Kontak`

Submenu:

### Profil
- Profil Sekolah
- Sejarah
- Data Guru
- Data Karyawan

### Akademik
- Kurikulum
- Fasilitas

### Informasi
- Berita
- SPMB

### Jejak & Karya
- Prestasi
- Ekstrakurikuler
- Alumni

Pada perangkat mobile, submenu menggunakan pola accordion di dalam Hamburger Menu.

---

## 7. Cetak Biru Halaman Pengecualian & Sistem Melayang (System Views)

### 7.1 Halaman Kesalahan Sistem (Error Pages Layout)

 Page Error 404:
 Ilustrasi atau ikon sederhana → Pesan:
 "Halaman yang Anda cari tidak ditemukan atau telah dipindahkan."
 → Tombol kembali ke Beranda.

 Page Error 500:
 Ilustrasi atau ikon sistem → Pesan:
 "Terjadi kesalahan sistem. Silakan coba beberapa saat lagi."
 → Tombol reload atau kembali ke Beranda.

Halaman error tidak boleh menampilkan stack trace atau informasi teknis kepada pengunjung.

---

### 7.2 Antarmuka Floating Chatbot FAQ (`<x-chatbot-widget>`)

Komponen berbentuk tombol melayang di pojok kanan bawah layar.

Ketika dibuka, struktur panel:

1. Header Panel:
   Judul "Asisten Informasi SMA PGRI 1 Tulungagung" dan tombol Close/Minimize.

2. Body Conversation:
   Area percakapan, sapaan awal bot, Quick Suggestion Questions, dan riwayat percakapan.

3. Input Bar:
   Input pertanyaan dan tombol kirim dengan Lucide Icon.

4. Contoh Pertanyaan Cepat:
   - "Dimana alamat lengkap sekolah?"
   - "Bagaimana informasi SPMB sekolah?"
   - "Apa saja program ekstrakurikuler?"
   - "Dimana saya dapat melihat informasi kurikulum?"
   - "Bagaimana cara mengisi data alumni?"
   - "Dimana saya dapat melihat data guru?"
   - "Berapa nomor kontak sekolah?"

Chatbot hanya menjawab berdasarkan informasi yang tersedia pada database FAQ sekolah.