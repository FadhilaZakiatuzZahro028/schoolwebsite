# UI Component Specification - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.4 | Status: Revised Approved Baseline (Production-Ready)

---

## 1. Standar Implementasi Blade Components
Semua komponen antarmuka publik wajib dibangun sebagai reusable component berbasis Laravel Blade Components menggunakan sintaks `<x-nama-komponen>` apabila komponen memang digunakan berulang atau memiliki fungsi UI yang jelas.

Setiap komponen harus mematuhi batas responsivitas (`Desktop >=1200px`, `Laptop 992px-1199px`, `Tablet 768px-991px`, `Mobile <=767px`) serta standar aksesibilitas dasar seperti WAI-ARIA jika diperlukan, `alt` gambar wajib, keyboard accessibility, dan rasio kontras minimal 4.5:1.

Elemen sederhana yang hanya digunakan satu kali tidak wajib dipisahkan menjadi Blade Component tersendiri untuk menghindari over-engineering.

---

## 2. Matriks Komponen Utama (Public Frontend)

| Sintaks Komponen | Properti Masukan (Props) | Varian / State Visual | Lokasi Penempatan |
| :--- | :--- | :--- | :--- |
| `<x-button>` | `variant`, `size`, `href`, `icon` | Primary, Secondary, Accent, Ghost, Danger \| Hover, Focus, Disabled, Loading | Global Component UI |
| `<x-navbar>` | `brandLogo`, `menuItems` | Transparent, Glassmorphism Scrolled State, Mobile Hamburger, Dropdown/Accordion | Global Layout Header |
| `<x-hero-banner>` | `title`, `subtitle`, `description`, `image`, `ctaText`, `ctaUrl` | Full Width Background Gradient, Glassmorphism Floating Base Card | Beranda |
| `<x-news-card>` | `thumbnail`, `category`, `title`, `excerpt`, `slug`, `date` | Standard Grid Tile \| Hover Translate-Y, Skeleton Loading | Beranda, Indeks Berita |
| `<x-achievement-card>` | `image`, `title`, `level`, `year`, `description` | Standard Grid Tile \| Badge Category Level | Beranda, Indeks Prestasi |
| `<x-extracurricular-card>` | `image`, `name`, `coach`, `schedule` | Card Grid View \| Hover State | Indeks Ekstrakurikuler |
| `<x-facility-card>` | `image`, `name`, `description` | Card Layout Gallery \| Lightbox Trigger State | Indeks Fasilitas |
| `<x-staff-card>` | `photo`, `name`, `position`, `subject`, `department`, `type` | Profile Card \| Teacher / Employee \| Placeholder Photo | Data Guru, Data Karyawan |
| `<x-curriculum-card>` | `title`, `academicYear`, `description`, `previewImage`, `pdfUrl`, `imageDownloadUrl` | Standard Card \| Preview Image, Download Actions | Halaman Kurikulum |
| `<x-alumni-card>` | `photo`, `name`, `graduationYear`, `currentActivity`, `institution`, `quote` | Standard Profile Card \| Responsive Grid | Halaman Alumni |
| `<x-download-card>` | `title`, `description`, `fileSize`, `fileUrl`, `previewImage` | Glass Layout Box \| Preview Optional, Download Action | Halaman SPMB, Kurikulum jika relevan |
| `<x-stat-card>` | `icon`, `number`, `label` | Counter Display, Glassmorphism Border | Beranda |
| `<x-gallery-grid>` | `images` (array) | Responsive Columns (Desktop: 4, Tablet: 3, Mobile: 2) | Beranda, Galeri |
| `<x-contact-form>` | None | Default State, Validation Error, Submit Processing, Success State | Halaman Kontak |
| `<x-google-map>` | `mapsEmbedUrl` | Responsive Iframe Container | Halaman Kontak, Footer |
| `<x-chatbot-widget>` | None | Floating Trigger \| Opened Chat Window, Typing Indicator, Fallback Error | Global Overlay |
| `<x-footer>` | `schoolProfile`, `siteSetting` | Deep Blue Surface, Brand Identity, Contact Information with Lucide Icons, Public Quick Links, Social Icon Buttons, Optional Mini Google Maps, Copyright Bar | Global Layout Footer |

---

## 3. Struktur Navigasi Navbar

Komponen `<x-navbar>` menggunakan maksimal 6 menu utama pada desktop dengan susunan:

`Beranda | Profil ▾ | Akademik ▾ | Informasi ▾ | Jejak & Karya ▾ | Kontak`

Struktur dropdown:

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

Halaman Profil Sekolah mencakup informasi Profil Utama, Visi & Misi, Tujuan Sekolah jika tersedia, serta Sambutan Kepala Sekolah sehingga tidak perlu dibuat menjadi submenu terpisah.

Pada perangkat mobile, navbar berubah menjadi Hamburger Menu. Submenu ditampilkan menggunakan pola accordion yang mudah digunakan tanpa mega-menu.

---

## 4. Komponen Pendukung Utility UI

 `<x-breadcrumb>`
   Props: `items` (array asosiatif judul dan tautan URL).
   Render: Jejak navigasi dipisahkan menggunakan karakter atau ikon separator. Item terakhir berstatus aktif dan tidak memiliki tautan.

 `<x-badge>`
   Props: `variant` (Primary, Success, Warning, Danger, Gold).
   Render: Label informasi singkat dengan tampilan compact dan radius penuh.

 `<x-pagination>`
   Props: `paginator` (Instance dari LengthAwarePaginator Laravel).
   Render: Kontrol halaman responsif. Pada perangkat mobile dapat menyederhanakan jumlah nomor halaman yang ditampilkan.

 `<x-empty-state>`
   Props: `title`, `description`, `icon`.
   Render: Tampilan ramah ketika data yang diminta belum tersedia atau hasil pencarian kosong.

 `<x-skeleton>`
   Props: `type` (Card, Text, Circle), `lines` (integer).
   Render: Placeholder loading untuk mencegah pergeseran layout ketika diperlukan.

 `<x-modal>`
   Props: `id`, `title`, `size`.
   Render: Dialog responsif yang dapat digunakan untuk preview gambar Galeri, Fasilitas, Kurikulum, atau SPMB jika diperlukan.

---

## 5. Aturan Komponen Guru & Karyawan

### `<x-staff-card>`

Komponen digunakan kembali pada halaman Data Guru dan Data Karyawan.

Untuk Data Guru, informasi yang dapat ditampilkan:
- Foto
- Nama
- Jabatan
- Mata Pelajaran

Untuk Data Karyawan, informasi yang dapat ditampilkan:
- Foto
- Nama
- Jabatan
- Bagian atau Unit

Aturan tampilan:
- Foto bersifat opsional.
- Jika foto tidak tersedia, komponen menggunakan placeholder visual yang konsisten.
- Foto yang tersedia menggunakan versi WebP teroptimasi.
- Informasi yang kosong tidak perlu menampilkan label atau ruang kosong yang tidak diperlukan.
- Nomor telepon pribadi, alamat rumah, dan informasi sensitif lainnya tidak ditampilkan.

Layout kartu bersifat mobile-first:
- Mobile: 1 sampai 2 kartu per baris menyesuaikan lebar layar.
- Tablet: 2 sampai 3 kartu per baris.
- Desktop: 3 sampai 4 kartu per baris.

Data Guru dan Karyawan menggunakan komponen visual yang sama agar desain konsisten, meskipun ditampilkan pada halaman publik yang berbeda.

---

## 6. Aturan Komponen Kurikulum

### `<x-curriculum-card>`

Komponen menampilkan informasi Kurikulum berdasarkan data backend yang tersedia.

Konten dapat mencakup:
- Judul
- Tahun Ajaran
- Deskripsi
- Preview Gambar
- Tombol Unduh PDF
- Tombol Unduh Materi Gambar

Aturan:
- Preview gambar menggunakan versi WebP teroptimasi apabila tersedia.
- Tombol unduh PDF hanya ditampilkan apabila dokumen tersedia.
- Tombol unduh gambar hanya ditampilkan apabila file asli tersedia.
- File asli untuk unduhan tidak digantikan oleh versi WebP preview.
- Jika tidak ada file tertentu, tombol terkait tidak ditampilkan.

---

## 7. Aturan Komponen SPMB

Halaman SPMB dapat menggunakan `<x-download-card>` untuk menampilkan File Informasi dan Brosur.

Komponen dapat menampilkan:
- Judul file
- Keterangan singkat
- Preview gambar jika tersedia
- Informasi ukuran file jika tersedia
- Tombol unduh

Aturan:
- File Informasi dan Brosur dapat berupa PDF atau gambar.
- Jika file berupa gambar, preview website menggunakan versi WebP teroptimasi apabila tersedia.
- Tombol download tetap mengarah ke file asli.
- Jika suatu file belum tersedia, komponen terkait tidak ditampilkan.
- Halaman tetap dapat menampilkan keterangan utama SPMB meskipun file belum tersedia.

---

## 8. Aturan Komponen Alumni

### `<x-alumni-card>`

Komponen hanya menampilkan data Alumni Pilihan yang telah diaktifkan oleh admin.

Aturan:
- Maksimal 4 Alumni Pilihan ditampilkan pada halaman publik.
- Informasi dapat mencakup Foto, Nama, Tahun Kelulusan, Aktivitas/Pekerjaan, Instansi, dan Kutipan.
- Informasi pribadi seperti nomor HP dan email pribadi tidak ditampilkan.
- Foto menggunakan versi WebP teroptimasi.

Pendataan alumni tidak menggunakan `<x-alumni-form>` karena pengisian data dilakukan melalui Google Forms resmi sekolah.

Bagian pendataan Alumni pada halaman publik cukup menggunakan:
- Judul ajakan, misalnya "Mari Terhubung Kembali dengan Almamater".
- Deskripsi singkat.
- Tombol CTA menuju Google Forms resmi sekolah.

URL Google Forms berasal dari konfigurasi dinamis sistem dan tidak boleh ditulis secara hardcode pada Blade.

Jika URL Google Forms belum tersedia, tombol CTA tidak ditampilkan dan dapat diganti dengan informasi bahwa pendataan alumni belum tersedia.

---

## 9. Aturan Komponen Media & Download

Seluruh komponen yang menampilkan gambar wajib menggunakan atribut `alt` yang sesuai.

Gambar tampilan website menggunakan versi WebP teroptimasi apabila tersedia.

File asli tetap digunakan untuk tombol unduh apabila file tersebut memang disediakan untuk kebutuhan download, khususnya:
- Dokumen dan gambar Kurikulum.
- File Informasi SPMB.
- Brosur SPMB.

Komponen tidak boleh membuat URL file menggunakan hardcode. URL media berasal dari data backend dan Laravel Storage.

---

## 10. Daftar Komponen Masa Depan (Future Roadmap)

Komponen berikut tidak termasuk kebutuhan wajib versi awal dan hanya dibuat jika benar-benar diperlukan pada pengembangan berikutnya:

- `<x-accordion>` untuk FAQ dinamis.
- `<x-announcement-banner>` untuk pengumuman penting.
- `<x-video-player>` untuk video profil sekolah.
- `<x-toast-notification>` untuk sistem notifikasi global.
- `<x-search-overlay>` untuk pencarian global layar penuh.