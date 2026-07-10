# UI Component Specification - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

---

## 1. Standar Implementasi Blade Components
Semua komponen antarmuka publik wajib dibangun sebagai reusable component berbasis Laravel Blade Components menggunakan sintaks `<x-nama-komponen>`. Setiap komponen harus mematuhi batas responsivitas (`Desktop >=1200px`, `Laptop 992px-1199px`, `Tablet 768px-991px`, `Mobile <=767px`) serta standar aksesibilitas (WAI-ARIA, `alt` gambar wajib, rasio kontras >= 4.5:1).

---

## 2. Matriks Komponen Utama (Public Frontend)

| Sintaks Komponen | Properti Masukan (Props) | Varian / State Visual | Lokasi Penempatan |
| :--- | :--- | :--- | :--- |
| `<x-button>` | `variant`, `size`, `href`, `icon` | Primary, Secondary, Accent, Ghost, Danger \| Hover, Focus, Disabled, Loading | Global Component UI |
| `<x-navbar>` | `brandLogo`, `menuItems` | Transparent (Hero Top), Glassmorphism (Scrolled State), Mobile Hamburger | Global Layout Header |
| `<x-hero-banner>` | `title`, `subtitle`, `description`, `image`, `ctaText`, `ctaUrl` | Full Width Background Gradient, Glassmorphism Floating Base Card | Beranda (Homepage Only) |
| `<x-news-card>` | `thumbnail`, `category`, `title`, `excerpt`, `slug`, `date` | Standard Grid Tile \| Hover Translate-Y, Skeleton Loading | Beranda, Indeks Berita |
| `<x-achievement-card>`| `image`, `title`, `level`, `year`, `description` | Standard Grid Tile \| Badge Category Level (Gold Accent) | Beranda, Indeks Prestasi |
| `<x-extracurricular-card>`| `image`, `name`, `coach`, `schedule` | Card Grid View \| Hover Scale Optimization | Indeks Ekstrakurikuler |
| `<x-facility-card>` | `image`, `name`, `description` | Card Layout Gallery \| Lightbox Trigger State | Indeks Fasilitas |
| `<x-download-card>` | `title`, `fileSize`, `fileUrl` | Glass Layout Box \| Accent Button, Download Loading State | Halaman Informasi PPDB |
| `<x-stat-card>` | `icon`, `number`, `label` | Counter Up Display, Glassmorphism Border | Beranda (Profil Ringkas) |
| `<x-gallery-grid>` | `images` (array) | Responsive Columns (Desktop: 4, Tablet: 3, Mobile: 2) | Beranda, Halaman Galeri |
| `<x-contact-form>` | None | Default State, Input Validation Error, Submit Processing, Success Toast | Halaman Kontak |
| `<x-google-map>` | `mapsEmbedUrl` | Responsive Iframe Container | Halaman Kontak, Footer |
| `<x-chatbot-widget>` | None | Floating Trigger Icon \| Opened (Chat Window), Typing Indicator, Fallback Error | Global Overlay (Kanan Bawah) |
| `<x-footer>` | `schoolData`, `socialLinks` | Deep Blue Surface State, Quick Links Alignment, Copyright Bar | Global Layout Footer |

---

## 3. Komponen Pendukung Utility UI

 `<x-breadcrumb>`
   Props: `items` (array asosiatif judul dan tautan URL).
   Render: Jejak navigasi SEO-friendly dipisah karakter `>`. Suku terakhir otomatis berstatus active state (teks muted, non-link).
 `<x-badge>`
   Props: `variant` (Primary, Success, Warning, Danger, Gold).
   Render: Label teks info mini dengan background semi-transparan radius penuh (8px).
 `<x-pagination>`
   Props: `paginator` (Instance dari LengthAwarePaginator Laravel).
   Render: Kontrol halaman responsif. Menyembunyikan nomor halaman panjang pada resolusi mobile (hanya menampilkan tombol Prev/Next).
 `<x-empty-state>`
   Props: `title`, `description`, `icon`.
   Render: Tampilan penanda ramah jika kueri database menghasilkan data kosong (misal: pencarian berita tidak ditemukan).
 `<x-skeleton>`
   Props: `type` (Card, Text, Circle), `lines` (integer).
   Render: Efek animasi shimmer pulsing abu-abu sebagai penahan layout sebelum data asinkronus selesai dimuat sempurna.
 `<x-modal>`
   Props: `id`, `title`, `size`.
   Render: Overlay dialog box dengan tombol close trigger (ESC key binding), digunakan untuk preview detail foto galeri/fasilitas.

---

## 4. Daftar Komponen Masa Depan (Future Roadmap v1.2+)
`x-accordion` (FAQ dropdown dinamis), `x-announcement-banner` (Banner info penting di atas header), `x-video-player` (Embed wrapper YouTube sekolah), `x-toast-notification` (Pop-up notifikasi melayang), `x-search-overlay` (Modal pencarian berita global penuh layar).