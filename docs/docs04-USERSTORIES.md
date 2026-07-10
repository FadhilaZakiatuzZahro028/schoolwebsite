# User Stories - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

## 1. Matriks Aktor Sistem
 Guest (Masyarakat Umum): Calon siswa, orang tua, alumni, dan publik yang mengakses halaman depan tanpa login.
 Admin Konten: Staf sekolah yang memiliki hak akses login untuk memperbarui informasi harian website.
 Super Admin: Kepala tata usaha atau IT administrator yang memiliki kontrol penuh atas user admin dan konfigurasi SEO global.

---

## 2. Daftar User Stories & Acceptance Criteria

### 2.1 Guest (Public User Experience)
| ID | Cerita Pengguna (User Story) | Kriteria Penerimaan (Acceptance Criteria) |
| :--- | :--- | :--- |
| G-01 | Ingin melihat profil sekolah, sejarah, visi-misi, dan daftar guru. | ✔ Dapat diakses tanpa login, layout responsif, font mudah dibaca. |
| G-02 | Ingin membaca berita terbaru, detail artikel, dan melakukan pencarian. | ✔ Berita terbaru tampil di beranda, pencarian via keyword instan, slug URL rapi. |
| G-03 | Ingin melihat detail informasi PPDB statis dan mengunduh brosur. | ✔ Tombol download PDF brosur berfungsi, skema alur pendaftaran jelas. |
| G-04 | Ingin melihat daftar prestasi dan program ekstrakurikuler sekolah. | ✔ Foto dokumentasi jelas (.webp), memiliki fitur filter kategori/tingkatan. |
| G-05 | Ingin melihat daftar fasilitas sarana dan prasarana sekolah. | ✔ Grid foto rapi, dilengkapi deskripsi fungsi fasilitas yang memadai. |
| G-06 | Ingin mengirim pesan pertanyaan lewat form halaman kontak. | ✔ Validasi input ketat, proteksi anti-spam rate-limit, notifikasi sukses muncul, pesan masuk DB. |
| G-07 | Ingin bertanya ke Chatbot FAQ di pojok halaman untuk respon kilat. | ✔ Respon < 2 detik, jawaban akurat sesuai database, menolak luar topik dengan sopan. |

### 2.2 Admin Konten (Content Management Experience)
| ID | Cerita Pengguna (User Story) | Kriteria Penerimaan (Acceptance Criteria) |
| :--- | :--- | :--- |
| A-01 | Ingin melakukan login ke dashboard Filament dengan aman. | ✔ Validasi akun sukses langsung mengarah ke halaman ringkasan dashboard. |
| A-02 | Ingin melakukan CRUD Berita dan mengatur status (Draft/Publish). | ✔ Upload gambar otomatis resize & webp, input khusus slug, meta title, dan description tersedia. |
| A-03 | Ingin memperbarui data Profil Sekolah dan data PPDB Statis. | ✔ Form input teks profil lengkap, upload file PDF brosur langsung mengganti file lama. |
| A-04 | Ingin melakukan CRUD Prestasi, Ekstrakurikuler, dan Fasilitas. | ✔ Form manajemen data lengkap dengan upload foto dokumentasi per entitas. |
| A-05 | Ingin mengelola konten visual Banner Hero depan dan Galeri foto. | ✔ Dapat mengubah gambar slider, teks headline, dan link tombol CTA di beranda. |
| A-06 | Ingin melihat pesan masuk dari form kontak publik. | ✔ Daftar pesan masuk rapi, terdapat penanda status (Belum Dibaca / Sudah Dibaca). |
| A-07 | Ingin mengelola basis data tanya-jawab (FAQ) mesin chatbot. | ✔ Input pasangan kata kunci (keywords) dan teks jawaban respon chatbot lokal. |

### 2.3 Super Admin (System & Configuration Experience)
| ID | Cerita Pengguna (User Story) | Kriteria Penerimaan (Acceptance Criteria) |
| :--- | :--- | :--- |
| SA-01| Ingin mengelola akun pengguna (CRUD User Admin). | ✔ Dapat menambah akun admin baru, mengedit hak akses, atau menghapus akun. |
| SA-02| Ingin mengatur konfigurasi SEO Default dan optimasi indeks situs. | ✔ Mengubah default meta keyword, default OG:Image, serta auto-generate sitemap.xml. |
| SA-03| Ingin memantau statistik performa data di halaman dashboard. | ✔ Menampilkan total hitungan berita, pesan masuk baru, dan tren kata kunci chatbot. |

---

## 3. Batasan Perilaku Sistem Chatbot (System Behavior Rules)
 Rule-01 (No Hallucination): Sistem chatbot dilarang keras mengarang jawaban di luar data tabel `chatbot_knowledges`.
 Rule-02 (Scope Guard): Jika mendeteksi kata kunci berbau politik, SARA, umum, atau pemrograman, wajib memicu respon penolakan standar: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."
 Rule-03 (Fresh Data Fetch): Pencarian teks wajib langsung melakukan query ke database terkini tanpa menahan data usang (stale data).

---

## 4. Kriteria Non-Fungsional Utama & Masa Depan
 Kualitas Produksi: Wajib memenuhi standar kecepatan muat halaman publik (< 3 detik), ramah aksesibilitas kontras teks (a11y), aman dari serangan injeksi form (CSRF/XSS), dan adaptif penuh di layar ponsel pintar (mobile-first).
 Skalabilitas Mendatang: Arsitektur kode siap dikembangkan untuk kebutuhan jangka panjang seperti integrasi penuh Portal Guru, Portal Alumni, Portal Nilai Siswa, Sistem E-Learning (CBT), dan Aplikasi Mobile.