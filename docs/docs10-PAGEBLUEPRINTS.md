# Page Blueprints - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

---

## 1. Aturan Global Core UX & Metrik Performa (Lighthouse Target)
Seluruh halaman wajib menggunakan tata letak dasar responsif Bootstrap 5, memuat `<x-navbar>` di atas, dan `<x-footer>` di bawah. Halaman non-beranda wajib menyertakan komponen `<x-breadcrumb>`.
 Metrik Kecepatan Core Web Vitals: `LCP < 2.5s` | `CLS < 0.1` | `INP < 200ms`.
 Target Skor Audit Lighthouse: `Performance >= 95` | `Accessibility >= 95` | `SEO >= 95`.

---

## 2. Matriks Komponen Susunan Halaman (Wireframe Layout Blueprint)

| ID | Nama Halaman | Pola Alur Struktur Komponen Visual (Atas ke Bawah) | Elemen Aksi Utama (CTA) & Aturan Fallback |
| :--- | :--- | :--- | :--- |
| P-01 | Beranda (Home) | `<x-navbar>` → `<x-hero-banner>` → Quick Access Grid → Sambutan Kepala Sekolah & Statistik Sekolah (`<x-stat-card>`) → Grid 3 `<x-news-card>` → Grid 3 `<x-achievement-card>` → Kompilasi Ekskul & Fasilitas Grid → `<x-gallery-grid>` → Form Kontak Ringkas → Maps → `<x-footer>` | Primary: Button "Hubungi Kami"<br>Secondary: Button "Lihat Profil"<br>Fallback: Gunakan `<x-skeleton>` saat memuat. |
| P-02 | Profil Sekolah| Mini Hero → Sejarah Sekolah (Teks Paragraf) → Visi & Misi Section → Susunan Guru & Tenaga Kependidikan (Grid Foto Kartu) → Bagan Struktur Organisasi. | CTA: Button "Hubungi Sekolah"<br>Behavior: Responsif stack 1 kolom di layar mobile. |
| P-03 | Informasi PPDB| Mini Hero → Teks Alur & Syarat Pendaftaran → Timeline Jadwal Penting PPDB → Biaya Pendidikan → Blok Unduhan Berkas (`<x-download-card>`). | CTA: Button "Unduh Brosur Pendaftaran (PDF)"<br>Behavior: Target unduhan membuka tab baru (`_blank`). |
| P-04 | Indeks Berita | Mini Hero → Search Bar + Dropdown Filter Kategori → Grid List `<x-news-card>` (Flex Layout) → `<x-pagination>`. | CTA: Pencarian Instan via Text Input.<br>Fallback: Jika kosong, panggil `<x-empty-state>`. |
| P-05 | Detail Berita | `<x-breadcrumb>` → Gambar Utama (`16:9` Webp) → Judul Artikel (H1) → Metadata (Tanggal, Kategori, Penulis) → Teks Konten Artikel (Rich Text Body) → Tombol Share Sosmed → Seksi 3 Related News. | CTA: Button "Kembali ke Berita" / Share Link.<br>SEO: Auto-inject meta-tags spesifik per slug berita. |
| P-06 | Indeks Pojok Siswa| Mini Hero → Tab Selector (Pilihan: "Prestasi Sekolah" atau "Kegiatan Ekstrakurikuler") → Grid Tampilan `<x-achievement-card>` atau `<x-extracurricular-card>`. | CTA: Filter Berdasarkan Tingkatan Prestasi.<br>Behavior: Transisi hover kartu bergeser ke atas (`-6px`). |
| P-07 | Indeks Fasilitas| Mini Hero → Grid Tampilan Galeri Foto Sarana Prasarana Sekolah (`<x-facility-card>`) dengan rasio aspek gambar `4:3`. | CTA: Klik foto memicu komponen `<x-modal>` pop-up lightbox gambar resolusi tinggi. |
| P-08 | Hubungi Kontak| Mini Hero → Grid 2 Kolom (Kiri: Teks Alamat, Telepon, Email, Jam Layanan, Embed Google Maps; Kanan: `<x-contact-form>`) → Seksi FAQ Akordion Singkat. | CTA: Tombol keras "Kirim Pesan" pada form.<br>Security: Dilindungi oleh rate-limit middleware keras. |
| P-09 | Hasil Pencarian| Search Bar Master → Teks Info Judul "Menampilkan hasil untuk: {keyword}" → Grid List Konten Relevan → `<x-pagination>`. | Fallback: Jika pencarian nihil, tampilkan tombol `<x-empty-state>` berarah kembali ke Beranda. |

---

## 3. Cetak Biru Halaman Pengecualian & Sistem Melayang (System Views)

### 3.1 Halaman Kesalahan Sistem (Error Pages Layout)
 Page Error 404 (Not Found): Ilustrasi vektor ikon pecah/hilang → Teks pesan ringkas: "Halaman yang Anda cari tidak ditemukan atau telah dipindahkan." → Tombol CTA Utama: `<x-button>` mengarah balik ke Beranda (`/`).
 Page Error 500 (Internal Server Error): Ilustrasi penanda sistem down → Teks pesan aman: "Terjadi kesalahan internal pada sistem server kami. Silakan coba memuat ulang halaman beberapa saat lagi." → Tombol CTA: Kombinasi tombol "Reload Halaman" dan tautan cepat ke Kontak Admin Teknis.

### 3.2 Antarmuka Obrolan Floating Chatbot FAQ Widget (`<x-chatbot-widget>`)
Komponen berbentuk lingkaran melayang di pojok kanan bawah layar. Ketika diklik, membuka panel chat kecil berukuran responsif dengan blueprint komponen internal sebagai berikut:
1. Header Panel: Gradasi biru royal, memuat judul "Asisten Informasi SMA PGRI 1 Tulungagung" dan tombol Close/Minimize.
2. Body Conversation: Area scroll teks otomatis ke bawah. Memuat teks gelembung sapaan awal bot, daftar Quick Suggestion Questions (Pintasan pertanyaan klik cepat), dan gelembung riwayat tanya-jawab.
3. Input Bar: Kotak teks pengetikan pertanyaan manual pengguna dan tombol kirim ikon panah (Lucide Icon).
4. Daftar Pertanyaan Cepat Standar (Quick Links Trigger):
    "Dimana alamat lengkap sekolah?"
    "Bagaimana syarat pendaftaran siswa baru (PPDB)?"
    "Apa saja program kegiatan ekstrakurikuler?"
    "Berapa nomor kontak WhatsApp sekolah?"