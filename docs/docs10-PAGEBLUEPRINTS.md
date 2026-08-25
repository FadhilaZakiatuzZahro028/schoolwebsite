# Page Blueprints - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.4 | Status: Revised Approved Baseline (Production-Ready)

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
| P-01 | Beranda (Home) | `<x-navbar>` → `<x-hero-banner>` → Quick Access Grid → Sambutan Kepala Sekolah Ringkas → Centered Carousel Guru `<x-staff-carousel>` → Grid 3 `<x-news-card>` → Grid 3 `<x-achievement-card>` → Kompilasi Ekstrakurikuler & Fasilitas → `<x-gallery-grid>` → Kontak Ringkas → Maps → `<x-footer>` | Primary: "Hubungi Kami"<br>Secondary: "Lihat Profil"<br>Carousel Guru: menggunakan komponen dan behavior yang sama dengan halaman Data Guru, dengan Kepala Sekolah sebagai slide aktif pertama serta CTA menuju halaman Data Guru.<br>Fallback: Section tanpa data dapat disembunyikan atau menggunakan `<x-empty-state>` sesuai kebutuhan. |
| P-02 | Profil Sekolah | Mini Hero → Identitas / Profil Singkat Sekolah → Visi & Misi → Tujuan Sekolah jika tersedia → Sambutan Kepala Sekolah → CTA | CTA: "Lihat Sejarah Sekolah" / "Hubungi Sekolah"<br>Behavior: Seluruh section responsif dan stack vertikal pada mobile. |
| P-03 | Sejarah Sekolah | Mini Hero Sejarah → Pengantar Singkat → Timeline Sejarah Zig-Zag → Dokumentasi/Foto Arsip per Milestone jika tersedia → Section Penutup → CTA
| P-04 | Data Guru | Mini Hero → Pengantar Singkat → Centered Carousel `<x-staff-carousel>` berisi `<x-staff-card>` khusus `teacher` → CTA | CTA: "Lihat Data Karyawan" / "Hubungi Sekolah"<br>Behavior: Kepala Sekolah menjadi slide aktif pertama, kemudian Guru lain mengikuti `sort_order`. Carousel mendukung autoplay, pause on hover, drag, swipe, dan navigasi manual.<br>Fallback: Jika belum ada data aktif, tampilkan `<x-empty-state>`. |
| P-05 | Data Karyawan | Mini Hero → Pengantar Singkat → Centered Carousel `<x-staff-carousel>` berisi `<x-staff-card>` khusus `employee` → CTA | CTA: "Lihat Data Guru" / "Hubungi Sekolah"<br>Behavior: Slide awal mengikuti `sort_order` Karyawan aktif. Carousel mendukung autoplay, pause on hover, drag, swipe, dan navigasi manual.<br>Fallback: Jika belum ada data aktif, tampilkan `<x-empty-state>`. |
| P-06 | Kurikulum | Mini Hero → Pengantar Kurikulum → Daftar berdasarkan Tahun Ajaran → List `<x-curriculum-card>` → Preview Materi jika tersedia → Tombol Unduh PDF/Gambar | CTA: "Unduh 
Dokumen" / "Unduh Gambar"<br>Fallback: Jika data belum tersedia, tampilkan `<x-empty-state>`. |
| P-06A | Program Unggulan | Compact Skill-Development Hero → Pengantar Program → Konteks Kolaborasi LPK/BLK jika tersedia → Keunggulan / Manfaat → Image-led Skill Showcase program aktif → Dokumentasi Kegiatan opsional → Closing CTA SPMB & Kontak | Visual: Halaman harus terasa sebagai flagship skill-development program sekolah, bukan katalog CRUD atau kumpulan white-card identik. Program dapat menggunakan komposisi editorial bergantian antara teks dan foto utama. Data ditampilkan berdasarkan `is_active` dan `sort_order`.<br>Media: Setiap program memiliki foto utama dan maksimal 2 dokumentasi tambahan. Dokumentasi hanya ditampilkan apabila tersedia dan tidak menggunakan placeholder palsu atau carousel secara default.<br>CTA: "Lihat Informasi SPMB" dan "Hubungi Sekolah".<br>Fallback: Jika tidak terdapat program aktif, tampilkan `<x-empty-state>`. |
| P-07A | Indeks Fasilitas | Mini Hero Fasilitas → Pengantar / Heading Katalog → Grid `<x-facility-card>` dengan rasio gambar konsisten → Pagination jika diperlukan → Closing Ringan | CTA: Kartu fasilitas menuju halaman detail.<br>Fallback: Jika kosong, tampilkan `<x-empty-state>`. |
| P-07B | Detail Fasilitas | Mini Hero Detail → Main Facility Showcase (Foto Utama + Intro) → Tentang Fasilitas → Dokumentasi Tambahan jika tersedia → Closing CTA | CTA: "Lihat Semua Fasilitas".<br>Dokumentasi: Maksimal 2 foto tambahan. Jika tidak tersedia, section tidak ditampilkan.<br>Fallback: Foto utama dan deskripsi tetap membentuk halaman detail yang utuh. |
| P-08 | Indeks Berita | Mini Hero → Search Bar + Filter Kategori → Grid/List `<x-news-card>` → `<x-pagination>` | CTA: Pencarian dan filter berita.<br>Fallback: Jika hasil kosong, tampilkan `<x-empty-state>`. |
| P-09 | Detail Berita | Breadcrumb → Compact Editorial Header (Kategori, H1, Tanggal, Estimasi Waktu Baca) → Gambar Utama WebP → Layout Editorial (Rich Text Body + Sticky Sidebar Desktop) → Share / Copy Link → Related News → Closing / Kembali ke Berita | CTA: "Kembali ke Berita" / Share Link.<br>Related News: Maksimal 3 berita published, memprioritaskan kategori yang sama dan mengecualikan berita yang sedang dibuka.<br>Behavior: Reading progress ditampilkan secara ringan selama artikel dibaca. Sidebar turun ke bawah artikel pada tablet/mobile.<br>SEO: Menggunakan metadata spesifik berita jika tersedia. |
| P-10 | SPMB | Admissions Gateway Hero (identitas SPMB + CTA menuju informasi + CTA Kontak) → Informasi Pendaftaran Editorial → Dokumen Resmi (`<x-download-card>`) → Closing CTA Kontak | Visual: Halaman SPMB berfungsi sebagai admissions gateway yang membantu calon siswa dan orang tua memahami informasi pendaftaran, memperoleh dokumen resmi, dan menghubungi sekolah tanpa menggunakan pola tumpukan white-card yang berat.<br>CTA Hero: "Lihat Informasi" melakukan anchor scroll menuju informasi pendaftaran. "Hubungi Sekolah" menuju halaman Kontak.<br>Dokumen: File Informasi dan Brosur hanya ditampilkan jika tersedia dari backend. Preview menggunakan media yang tersedia tanpa placeholder palsu apabila preview tidak tersedia.<br>Fallback: Jika pengaturan SPMB belum tersedia, tampilkan empty state yang sesuai. Jika salah satu dokumen tidak tersedia, dokumen lainnya tetap dapat ditampilkan. |
| P-11A | Indeks Prestasi | Mini Hero → Filter Tingkatan jika diperlukan → Grid `<x-achievement-card>` → Pagination jika diperlukan | CTA: Filter berdasarkan tingkatan prestasi.<br>Fallback: Jika kosong, tampilkan `<x-empty-state>`. |
| P-11B | Detail Prestasi | Breadcrumb → Achievement Showcase Split Hero (identitas prestasi + metadata tingkat/tahun + dokumentasi utama) → Focused Achievement Story → Compact Closing | CTA: "Lihat Semua Prestasi".<br>Visual: Detail Prestasi harus memiliki identitas showcase pencapaian dan tidak menyalin layout editorial Detail Berita. Pada desktop, informasi utama dan dokumentasi disusun dalam komposisi split yang terkontrol. Pada mobile, konten ditumpuk secara vertikal dengan metadata tetap berada dekat judul.<br>Media: Dokumentasi utama menggunakan rasio dan `object-fit` yang tidak memotong konteks penting gambar secara agresif.<br>Accent: Gold digunakan secara terbatas sebagai aksen pencapaian, sedangkan biru tetap menjadi warna utama.<br>Fallback: Data yang digunakan tetap berasal dari field Prestasi yang tersedia: judul, tingkat, tahun, deskripsi, dan gambar. |
| P-12A | Indeks Ekstrakurikuler | Activity Explorer Hero (copy utama + komposisi dokumentasi dari data Ekstrakurikuler yang tersedia) → Activity Explorer Heading + jumlah kegiatan → Image-led Grid `<x-extracurricular-card>` → Pagination jika diperlukan | Visual: Halaman menonjolkan energi kegiatan siswa melalui dokumentasi nyata dan tidak menggunakan pola katalog white-card yang berat. Foto menjadi fokus utama kartu, sedangkan nama, deskripsi singkat, pembina, jadwal, dan aksi detail disusun secara ringkas.<br>Behavior: Hero hanya menggunakan data Ekstrakurikuler yang tersedia dan tidak menambahkan media hardcode. Pada mobile, komposisi hero dan grid ditumpuk secara vertikal.<br>CTA: Kartu menuju halaman detail kegiatan.<br>Fallback: Jika data kosong, tampilkan empty state yang sesuai. |
| P-12B | Detail Ekstrakurikuler | Breadcrumb → Activity Profile Hero (identitas kegiatan + informasi pembina/jadwal + foto utama) → Tentang Kegiatan → Dokumentasi Kegiatan opsional → Compact Closing | Visual: Detail Ekstrakurikuler harus terasa sebagai profil kegiatan siswa yang aktif dan visual, bukan dashboard administratif. Foto utama menjadi focal point, sedangkan pembina dan jadwal ditampilkan sebagai fact strip yang ringan.<br>Dokumentasi: Maksimal 2 foto tambahan. Jika 0 foto, section tidak dirender; 1 foto menggunakan single visual; 2 foto menggunakan responsive duo composition.<br>Media: Foto tidak dipotong secara agresif sehingga konteks kegiatan tetap terlihat.<br>CTA: "Lihat Semua Ekstrakurikuler".<br>Fallback: Halaman tetap utuh menggunakan foto utama dan deskripsi apabila dokumentasi tambahan belum tersedia. |
| P-13 | Galeri | Mini Hero → Grid `<x-gallery-grid>` → Pagination jika diperlukan | CTA: Melihat dokumentasi sekolah.<br>Fallback: Jika kosong, tampilkan `<x-empty-state>`. |
| P-14 | Alumni | Compact Alumni Story Hero (identitas halaman + CTA Alumni + jumlah Alumni Pilihan jika tersedia) → Alumni Stories Showcase maksimal 4 profil → Pendataan Alumni → CTA Google Forms | Visual: Alumni Pilihan ditampilkan sebagai story cards yang memberi ruang cukup untuk foto, identitas, aktivitas, instansi, dan kutipan. Pada desktop digunakan komposisi 2 kolom dengan kartu horizontal; tablet menggunakan 1 kolom horizontal; mobile menumpuk foto dan konten secara vertikal. Tidak menggunakan carousel karena jumlah Alumni Pilihan dibatasi maksimal 4 dan seluruh profil sebaiknya dapat dipindai tanpa interaksi tambahan.<br>CTA: "Isi Data Alumni" menuju Google Forms resmi dari konfigurasi dinamis.<br>Fallback: Jika URL form belum tersedia, CTA tidak ditampilkan dan diganti informasi yang sesuai. Jika Alumni Pilihan kosong, tampilkan empty state. |
| P-15 | Hubungi Kontak | Compact Contact Hero → Contact Hub 2 Kolom (Informasi Resmi + Embedded Map / Form Pesan Compact) → Light Closing | Visual: Halaman Kontak berfungsi sebagai contact hub yang memprioritaskan akses cepat ke saluran resmi sekolah, lokasi, dan form pesan tanpa menggunakan tumpukan white-card yang berat. Informasi alamat, telepon, dan email disatukan dalam satu panel dengan separator ringan. Map menjadi visual anchor pada panel informasi, sedangkan form disusun compact pada panel terpisah dengan bobot visual yang seimbang.<br>CTA Hero: "Kirim Pesan" menuju form dan "Lihat Lokasi" menuju peta jika tersedia.<br>Behavior: Pada tablet/mobile kedua panel ditumpuk secara vertikal. Data kontak dan map tetap berasal dari konfigurasi dinamis sekolah.<br>Security: Endpoint form tetap menggunakan validasi, CSRF protection, dan rate limiting. |
| P-16 | Hasil Pencarian | Search Bar Master → Informasi keyword pencarian → Grid/List Konten Relevan → `<x-pagination>` | Fallback: Jika pencarian tidak menemukan hasil, tampilkan `<x-empty-state>` dan tautan kembali ke Beranda. |

## 2.1 Blueprint Detail Beranda

Urutan utama Beranda:

`Hero Banner`
→ `Quick Access`
→ `Sambutan Kepala Sekolah Ringkas`
→ `Centered Carousel Guru`
→ `Berita Terbaru`
→ `Prestasi Terkini`
→ `Ekstrakurikuler Pilihan`
→ `Fasilitas Sekolah`
→ `Galeri Terbaru`
→ `Kontak / Lokasi`
→ `Footer`

### Sambutan Kepala Sekolah

Sambutan pada Beranda berfungsi sebagai preview ringkas dan tidak menggantikan konten Sambutan Kepala Sekolah lengkap pada halaman Profil Sekolah.

Section menggunakan foto Kepala Sekolah, nama, tagline jika tersedia, cuplikan sambutan, serta CTA menuju halaman Profil Sekolah.

### Carousel Guru Beranda

Carousel Guru ditampilkan tepat setelah Sambutan Kepala Sekolah.

Aturan:
- Menggunakan `<x-staff-carousel>` dan `<x-staff-card>` yang sama dengan halaman Data Guru.
- Tidak membuat varian visual atau behavior carousel baru khusus Beranda.
- Hanya Guru aktif yang ditampilkan.
- Kepala Sekolah menjadi slide aktif pertama.
- Guru berikutnya mengikuti `sort_order`.
- Mendukung autoplay, pause on hover, mouse drag, touch swipe, navigasi manual, keyboard accessibility, dan `prefers-reduced-motion` sesuai spesifikasi komponen yang telah ditetapkan.
- Tersedia CTA menuju halaman Data Guru.
- Jika tidak terdapat Guru aktif, section tidak menampilkan informasi palsu atau hardcode.

Beranda tidak menggunakan section statistik sekolah tersendiri.

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

`Mini Hero Sejarah`
→ `Pengantar Perjalanan Sekolah`
→ `Timeline Zig-Zag Sejarah`
→ `Milestone Tahun + Judul + Narasi + Foto Arsip jika tersedia`
→ `Penutup Perjalanan / Masa Kini`
→ `CTA`

Timeline Sejarah menggunakan pola zig-zag pada desktop dan berubah menjadi satu kolom pada perangkat mobile. Setiap milestone dapat memuat tahun/periode, judul, narasi singkat, dan dokumentasi pendukung. Konten sejarah wajib berasal dari data resmi sekolah pada implementasi produksi; data dummy hanya diperbolehkan selama tahap pengembangan visual.

---

### 3.3 Data Guru

Urutan halaman:

`Mini Hero`
→ `Judul dan Pengantar`
→ `Centered Carousel Profil Guru`
→ `CTA`

Carousel menggunakan `<x-staff-carousel>` dengan `<x-staff-card>` sebagai item.

Saat halaman pertama kali dibuka, Kepala Sekolah tampil sebagai slide aktif di tengah. Guru lainnya mengikuti `sort_order`.

Pada desktop, tiga kartu terlihat secara bersamaan dengan kartu aktif di tengah tampil lebih menonjol.

Setiap `<x-staff-card>` Guru dapat menampilkan:
- Foto
- Nama
- Riwayat Pendidikan
- Jabatan
- Mata Pelajaran

Foto bersifat opsional. Jika tidak tersedia, gunakan placeholder yang konsisten.

---

### 3.4 Data Karyawan

Urutan halaman:

`Mini Hero`
→ `Judul dan Pengantar`
→ `Centered Carousel Profil Karyawan`
→ `CTA`

Carousel menggunakan `<x-staff-carousel>` dengan `<x-staff-card>` sebagai item.

Slide aktif pertama mengikuti `sort_order` Karyawan aktif.

Pada desktop, tiga kartu terlihat secara bersamaan dengan kartu aktif di tengah tampil lebih menonjol.

Setiap `<x-staff-card>` Karyawan dapat menampilkan:
- Foto
- Nama
- Riwayat Pendidikan
- Jabatan
- Bagian atau Unit

Foto bersifat opsional. Jika tidak tersedia, gunakan placeholder yang konsisten.

---

## Blueprint Halaman Program Unggulan

Urutan halaman:

`Compact Skill-Development Hero`
→ `Pengantar Program Unggulan`
→ `Konteks Kolaborasi LPK/BLK jika tersedia`
→ `Keunggulan / Manfaat Pengembangan Keterampilan`
→ `Showcase Program Aktif`
→ `Dokumentasi Kegiatan jika tersedia`
→ `Closing CTA`
→ `Footer`

### Hero & Pengantar

Hero menggunakan hierarchy yang compact dan tidak mengambil tinggi viewport secara berlebihan.

Judul halaman dapat menggunakan label antarmuka "Program Unggulan", sedangkan narasi pengantar dan informasi umum kolaborasi LPK/BLK berasal dari pengaturan dinamis backend.

Hero tidak menggunakan klaim mengenai sertifikasi, kesiapan kerja, jaminan pekerjaan, penyaluran kerja, atau mitra tertentu apabila data resmi belum tersedia.

### Skill Showcase

Program aktif ditampilkan berdasarkan `sort_order`.

Setiap program dapat menampilkan:
- Nama.
- Ringkasan.
- Deskripsi/manfaat.
- Foto utama.

Pada desktop, showcase menggunakan komposisi image-led/editorial dengan variasi posisi foto dan teks secara terkontrol agar halaman tidak terasa seperti lima white-card identik.

Pada tablet dan mobile, seluruh komposisi berubah menjadi satu alur vertikal yang mudah dipindai.

Foto tetap menjadi elemen visual utama dan tidak dipotong secara agresif sehingga konteks aktivitas siswa tetap terlihat.

### Dokumentasi Kegiatan

Dokumentasi berasal dari relasi foto tambahan Program Unggulan.

Aturan:
- Maksimal 2 foto dokumentasi per program.
- 0 foto tambahan: tidak menghasilkan placeholder atau blok kosong.
- Foto ditampilkan berdasarkan urutan program dan `sort_order` dokumentasi.
- Layout dokumentasi responsif dan dapat menggunakan komposisi mosaic/grid ringan.
- Tidak menggunakan carousel atau library frontend baru secara default.
- Gambar menggunakan versi WebP teroptimasi dan lazy loading bila sesuai.

### Closing CTA

Halaman ditutup dengan ajakan menuju:
- Informasi SPMB.
- Halaman Kontak.

CTA menggunakan route internal website dan tidak membutuhkan field URL baru pada tabel Program Unggulan.

### Fallback

Jika pengaturan pengantar belum tersedia, halaman tetap dapat menampilkan program aktif tanpa mengarang informasi sekolah.

Jika tidak terdapat program aktif, tampilkan `<x-empty-state>` yang sesuai.

Tidak terdapat halaman detail per program pada versi saat ini.

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

## Blueprint Halaman Fasilitas

### Indeks Fasilitas

Urutan halaman:

`Mini Hero Fasilitas`
→ `Pengantar / Heading Katalog`
→ `Grid Fasilitas`
→ `Pagination jika diperlukan`
→ `Closing Ringan`

Grid tetap menggunakan `<x-facility-card>` reusable yang juga digunakan pada Beranda.

Perubahan layout khusus Indeks tidak boleh merusak tampilan Fasilitas pada Beranda.

### Detail Fasilitas

Urutan halaman:

`Mini Hero Detail`
→ `Main Facility Showcase`
→ `Tentang Fasilitas`
→ `Dokumentasi Tambahan jika tersedia`
→ `Closing CTA`
→ `Footer`

Main Facility Showcase menggunakan foto utama sebagai focal point dan menggabungkannya dengan teks pengantar/deskripsi secara editorial.

Dokumentasi Tambahan:
- 0 foto: section tidak dirender.
- 1 foto: satu foto ditampilkan dalam layout lebar.
- 2 foto: menggunakan komposisi dua gambar responsif.
- Tidak menggunakan placeholder gambar palsu.

Pada mobile, seluruh komposisi berubah menjadi alur vertikal dengan foto tetap memiliki rasio yang terkontrol dan teks tetap mudah dibaca.

---

## 5. Blueprint Halaman Alumni

Urutan halaman:

`Compact Alumni Story Hero`
→ `Alumni Stories Showcase maksimal 4 profil`
→ `Pendataan Alumni`
→ `CTA Google Forms`

### Alumni Stories Showcase

Menggunakan `<x-alumni-card>` dan hanya menampilkan Alumni Pilihan yang telah diaktifkan oleh admin.

Pada desktop:
- Maksimal 4 profil ditampilkan dalam grid 2 kolom.
- Kartu menggunakan komposisi horizontal dengan foto di satu sisi dan informasi alumni di sisi lainnya.
- Foto tetap menjadi elemen visual penting tanpa mendominasi seluruh tinggi kartu.

Pada tablet:
- Kartu ditampilkan satu kolom dengan komposisi horizontal.

Pada mobile:
- Foto dan konten ditumpuk secara vertikal.
- Seluruh informasi tetap dapat dibaca tanpa horizontal scrolling atau carousel.

Informasi yang dapat ditampilkan:
- Foto
- Nama
- Tahun Kelulusan
- Aktivitas atau Pekerjaan
- Instansi
- Kutipan

Carousel tidak digunakan karena Alumni Pilihan dibatasi maksimal 4 profil dan seluruh profil sebaiknya dapat dilihat tanpa interaksi tambahan.

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
- Program Unggulan
- Fasilitas

### Informasi
- Berita
- SPMB

### Jejak & Karya
- Prestasi
- Ekstrakurikuler
- Alumni
- Galeri

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