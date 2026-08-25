docs/06-design-system.md

# Design System - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.2 | Status: Approved Baseline (Production-Ready)

## 1. Filosofi Desain: Modern Academic Glass
Konsep visual menggabungkan identitas Formal institusi pendidikan dengan estetika Modern melalui sentuhan Glassmorphism ringan, White Space yang luas, gradasi biru yang elegan, serta Micro-interactions yang presisi tanpa mengganggu keterbacaan teks.

---

## 2. Sistem Warna (Color System)
| Kategori | Nama Variabel | Kode Warna / Properti | Penempatan Penggunaan |
| :--- | :--- | :--- | :--- |
| Brand Primary | `Primary-900` (Deep Blue) <br> `Primary-700` (Royal Blue) <br> `Primary-500` (True Blue) <br> `Primary-100` (Alice Blue) | `#123C9B` <br> `#2563EB` <br> `#3B82F6` <br> `#EFF6FF` | Footer, Heading Utama, Text Link <br> Tombol Utama, Hover State <br> Ikon, Aksen Komponen <br> Background Section |
| Brand Accent | `Gold` | `#F59E0B` | Highlight CTA, Bintang, Badge Prestasi |
| Surfaces | `Background` <br> `Solid White` <br> `Glass White` | `#F8FAFC` <br> `#FFFFFF` <br> `rgba(255,255,255,0.72)` | Dasar Halaman Publik <br> Konten Cards, Konten Form <br> Navbar (Scroll), Chatbot, Hero Cards |
| Typography | `Heading` <br> `Body` <br> `Muted` | `#0F172A` <br> `#334155` <br> `#64748B` | Tag H1, H2, H3 <br> Paragraf, Teks Form, Teks Kartu <br> Tanggal Berita, Penulis, Breadcrumb |

### Aturan Gradasi & Glassmorphism (CSS Rules)
 Default Gradient: `linear-gradient(135deg, #123C9B, #2563EB, #60A5FA)`. Hanya untuk Hero background, CTA banner, section divider, dan ikon highlight. Dilarang untuk background global halaman.
 Glassmorphism Standard: 
  ```css
  background: rgba(255, 255, 255, 0.72);
  backdrop-filter: blur(18px);
  border: 1px solid rgba(255, 255, 255, 0.2);

```

---

## 3. Tipografi & Aturan Kontras (Typography)

 Aturan Kontras Luar: Rasio kontras teks wajib minimal 4.5 : 1 terhadap warna latar belakang demi aksesibilitas (a11y).
 Font Family: `font-family: "Lexend", "Inter", system-ui, sans-serif;`

| Komponen Teks | Ukuran Desktop | Ukuran Mobile | Font Weight | Keterangan |
| --- | --- | --- | --- | --- |
| Heading 1 (H1) | `44px - 56px` | `32px - 40px` | 700 (Bold) | Judul Utama Halaman / Hero |
| Heading 2 (H2) | `32px - 40px` | `26px - 32px` | 700 (Bold) | Judul Section Konten |
| Heading 3 (H3) | `24px - 28px` | `22px - 24px` | 600 (Semi-Bold) | Judul Kartu / Sub-Section |
| Body Text | `16px - 18px` | `16px` | 400 (Regular) | Teks Paragraf (Line Height: 1.6) |
| Small Text | `14px` | `14px` | 400 / 500 | Metadata, Teks Muted, Badge |

---

## 4. Spacing, Elevasi, & Struktur Geometri

 Sistem Spacing Lintasan: `4px`, `8px`, `12px`, `16px`, `24px`, `32px`, `48px`, `64px`, `96px`.
 Section Jarak Jeda: Desktop = `80px - 96px`, Mobile = `48px - 64px`.
 Border Radius: `Small = 8px` (Badge/Input), `Medium = 12px` (Buttons/Form), `Large = 20px` (Cards Utama/Hero Elements).
 Sistem Bayangan (Box Shadows):
 `Shadow-SM:` `0 4px 12px rgba(15, 23, 42, 0.05)` (Form, Badge)
 `Shadow-MD:` `0 8px 24px rgba(15, 23, 42, 0.08)` (Cards Standar, Dropdown)
 `Shadow-LG:` `0 24px 48px rgba(15, 23, 42, 0.12)` (Floating Chatbot, Hero Base Card)



---

## 5. Komponen UI Standar (UI Components)

### 5.1 Tombol (Buttons)

 Primary Button: Background `Primary-900` atau `Gradient`, teks putih, radius 12px, efek hover brightness 105%.
 Secondary Button: Background putih, border `Primary-700`, teks `Primary-700`, radius 12px.
 Accent Button: Background `Gold` (#F59E0B), teks `Primary-900`, digunakan khusus untuk CTA krusial (e.g., SPMB / Hubungi Kami).

### 5.2 Kartu Konten (Cards) & Rasio Gambar (Image Ratios)

 Spesifikasi Kartu: Background putih bersih, radius 16px, `Shadow-MD`, judul maksimal 2 baris, deskripsi maksimal 3 baris. Efek hover: `transform: translateY(-6px); transition: 250ms ease-in-out;`.
 Rasio Aspek Gambar: Hero (`16:9` / `21:9`), Berita (`16:9`), Prestasi/Fasilitas/Ekskul (`4:3`), Galeri/Logo (`1:1`).

 #### 5.2.1 Staff Carousel & Active Card State

Halaman Data Guru dan Data Karyawan menggunakan centered horizontal carousel dengan hierarki visual yang menempatkan kartu aktif sebagai fokus utama.

Desktop:
- Tiga kartu dapat terlihat secara bersamaan.
- Kartu aktif berada di tengah.
- Kartu aktif memiliki ukuran sedikit lebih besar, opacity penuh, dan shadow lebih kuat.
- Kartu kiri dan kanan memiliki ukuran sedikit lebih kecil, opacity lebih rendah, dan shadow lebih lembut.
- Blur kuat tidak digunakan pada kartu samping agar identitas dan informasi staf tetap terbaca.
- Transisi antarstate harus halus dan tidak menyebabkan layout shift.

Rekomendasi visual:
- Active card scale: sekitar `1.05` sampai `1.10`.
- Side card scale: sekitar `0.90` sampai `0.94`.
- Active card opacity: `1`.
- Side card opacity: sekitar `0.65` sampai `0.80`.
- Active card dapat menggunakan `Shadow-LG`.
- Side card menggunakan `Shadow-SM` atau `Shadow-MD`.

Mobile:
- Kartu aktif menjadi fokus utama.
- Sebagian kartu sebelumnya atau berikutnya dapat tetap terlihat sebagai petunjuk bahwa konten dapat digeser.
- Interaksi swipe harus tetap nyaman tanpa horizontal overflow pada halaman.

Motion & Interaction:
- Carousel dapat berjalan otomatis.
- Autoplay berhenti sementara saat pointer berada pada area carousel.
- Autoplay dilanjutkan ketika pointer meninggalkan area carousel.
- Desktop mendukung drag menggunakan mouse.
- Perangkat sentuh mendukung swipe.
- Kontrol Previous dan Next harus dapat digunakan melalui keyboard.
- Jika hanya tersedia satu kartu, autoplay dan interaksi perpindahan yang tidak diperlukan dinonaktifkan.
- Implementasi harus menghormati `prefers-reduced-motion` dengan mengurangi atau menonaktifkan autoplay serta animasi non-esensial.

### 5.3 Antarmuka Chatbot & Form Input

 Chatbot Widget: Floating circle di kanan bawah, header bernuansa gradasi biru, gelembung chat user berlatar `Primary-700` (teks putih), gelembung bot berlatar abu-abu sangat muda (teks `Heading`).
 Form & Input: Label teks tegas, placeholder informatif, tinggi input nyaman untuk mobile, focus state menggunakan ring border `Primary-500`.

---

## 6. Library Aset & Arsitektur Atomik (Atomic Design)

 Icon Library: Menggunakan Lucide Icons (Ukuran standard: 20px/24px untuk UI, 32px/48px untuk highlight ikon). Dilarang memakai Bootstrap Icons.
 Struktur Komponen (Atomic Mapping):
 Atoms: Button, Input Field, Badge Status, Heading, Lucide Icon, Text Link.
 Molecules: News Card, Achievement Card, Staff Card, SPMB Download Box, Search Bar, Chat Bubble.
Organisms: Navbar (Sticky glass state), Hero Section, Staff Carousel, Footer, Contact Form Section, Chatbot Widget overlay.
 Templates: Public Master Layout, Detail Grid Layout, Filament Dashboard View.
 Pages: Home, Profile (Tab-based), SMPB Info, News Index & Detail, Achievement, Extracurricular, Facility, Contact.

