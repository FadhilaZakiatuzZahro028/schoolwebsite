# Project Rules - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.1 | Status: Approved Baseline (Production-Ready)

## 1. Visi & Dokumen Acuan
 Tujuan: Mengatur standardisasi teknis agar website siap produksi, mudah dirawat (maintainable), dan bebas dari hutang teknis (technical debt).
 Single Source of Truth: Folder `docs/` adalah kebenaran tunggal. Jika kode berbeda dengan dokumentasi, dokumen dianggap benar hingga ada revisi resmi.
 Documentation First: Dilarang coding tanpa dokumentasi. Alur kerja wajib:  
  `Requirement` → `Documentation` → `Database Design` → `UI Design` → `Implementation` → `Testing`.
 Versioning: Setiap perubahan arsitektur atau fitur besar wajib dicatat terlebih dahulu di `CHANGELOG.md`.

## 2. Arsitektur Kode & Konvensi (Backend Laravel 13 & Database)
 Clean Architecture: Mengikuti kaidah Separation of Concerns. Controller hanya mengatur alur data (thin controller); logic kompleks wajib dipindahkan ke lapisan Service Class. Hindari spaghetti code, duplicate code, dan hardcode.
 Naming Convention: Seluruh komponen teknis (database tables, models, controllers, routes, migrations, classes) wajib menggunakan Bahasa Inggris. Bahasa Indonesia hanya digunakan untuk isi konten/konten statis di database.
 RESTful Design: Semua rute CRUD wajib memanfaatkan Laravel Resource Controller dan mematuhi verb HTTP standar (`GET`, `POST`, `PUT`, `DELETE`).
 Database First: Struktur tabel pada `database-design.md` harus selesai dan valid sebelum membuat Model atau CRUD. Perubahan tabel wajib melalui file migration baru, bukan mengubah migration lama yang sudah deployed.
 Coding Style: Mengikuti PER Coding Style standar bawaan Laravel 13. Wajib menggunakan type hint dan return types, serta mematuhi prinsip Single Responsibility (satu fungsi hanya melakukan satu tugas).
 Security Standards: Wajib mengimplementasikan proteksi bawaan Laravel secara ketat: CSRF, Form Validation (Form Request), Authorization (Policy/Gate), Password Hashing (Bcrypt), Mass Assignment Protection, dan Rate Limiting pada endpoint krusial.

## 3. Aturan Frontend & Pengalaman Pengguna (UI/UX)
 No Hardcode: Semua informasi sekolah (alamat, email, nomor telepon, jam operasional, logo, media sosial, nama kepala sekolah) tidak boleh ditulis manual di Blade, melainkan wajib ditarik dinamis dari database.
 Tech Stack Frontend: Wajib menggunakan Bootstrap 5, Blade Template, dan Vanilla JavaScript. Dilarang menggunakan Tailwind CSS atau framework JS (React/Vue) pada fase ini.
 Responsive & Mobile-First: Tampilan website wajib dioptimasi penuh dan diprioritaskan untuk layar Mobile (HP), kemudian disesuaikan untuk Tablet, Laptop, dan Desktop.
 Accessibility (a11y): Wajib memenuhi standar aksesibilitas dasar: kontras warna minimal 4.5:1, wajib menyertakan `alt text` pada gambar, urutan tag heading (`H1` hingga `H6`) yang logis, keyboard navigability, dan label form yang jelas.
 Admin Experience: UI Filament Admin harus dirancang sederhana, intuitif, bebas istilah teknis yang membingungkan, memiliki tombol aksi yang jelas, dan menampilkan pesan eror yang manusiawi.

## 4. Optimasi, SEO, & Batasan Sistem
 Target Kinerja (Lighthouse): Performance ≥ 90, Accessibility ≥ 95, Best Practice ≥ 95, SEO ≥ 95. Waktu muat (loading time) halaman publik wajib di bawah 3 detik.
 Manajemen Gambar: Semua aset gambar wajib disimpan melalui Laravel Storage (bukan folder `public/`). Sistem backend wajib mengompresi dan mengonversi otomatis format `.jpg` dan `.png` menjadi `.webp` saat admin mengunggah gambar.
 SEO & Metadata: Setiap halaman wajib memiliki keunikan Meta Title, Meta Description, SEO-friendly Slug, Open Graph Tags, Canonical URL, dan otomatis memperbarui Sitemap.xml & Robots.txt.
 AI Chatbot Sandbox: Chatbot bersifat rule-based (pencarian FAQ lokal dari database). Chatbot dilarang keras menjawab di luar topik sekolah dan wajib memberikan penolakan sopan (fallback) jika mendeteksi pertanyaan luar.
 Future Ready: Struktur database dan folder aplikasi harus modular agar siap menerima pengembangan fitur masa depan (PPDB penuh, E-Learning, Portal Guru/Siswa/Alumni) tanpa merombak arsitektur inti.
 Production Ready Definition: Fitur dianggap selesai jika: Lolos pengujian fungsi, 100% responsif, SEO & Aksesibilitas siap, bebas bug mayor, dokumentasi diperbarui, dan selesai dilakukan code review.