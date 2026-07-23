# User Stories - Website Resmi SMA PGRI 1 Tulungagung
Version: 1.3 | Status: Revised Approved Baseline (Production-Ready)

## 1. Matriks Aktor Sistem
 Guest (Masyarakat Umum): Calon siswa, orang tua, alumni, dan publik yang mengakses halaman depan tanpa login.
 Admin Konten: Staf sekolah yang memiliki hak akses login untuk memperbarui informasi harian website.
 Super Admin: Kepala tata usaha atau IT administrator yang memiliki kontrol penuh atas user admin dan konfigurasi SEO global.

---

## 2. Daftar User Stories & Acceptance Criteria

### 2.1 Guest (Public User Experience)

| ID | Cerita Pengguna (User Story) | Kriteria Penerimaan (Acceptance Criteria) |
| :--- | :--- | :--- |
| G-01 | Ingin melihat Profil Sekolah, visi-misi, Sambutan Kepala Sekolah, dan informasi identitas sekolah. | ✔ Dapat diakses tanpa login, data ditampilkan secara dinamis, layout responsif, dan font mudah dibaca. |
| G-02 | Ingin membaca informasi khusus mengenai sejarah sekolah. | ✔ Tersedia halaman Sejarah yang terpisah dari halaman Profil Sekolah dan dapat diakses tanpa login. |
| G-03 | Ingin melihat daftar Guru dan Data Karyawan sekolah. | ✔ Guru dan Karyawan tersedia pada halaman terpisah dalam bentuk kartu profil berisi nama, foto jika tersedia, jabatan, serta mata pelajaran atau bagian/unit jika tersedia. |
| G-04 | Ingin membaca berita terbaru, detail artikel, dan melakukan pencarian. | ✔ Berita terbaru tampil di beranda, pencarian berdasarkan keyword tersedia, dan URL detail menggunakan slug yang rapi. |
| G-05 | Ingin melihat informasi SPMB dan mengunduh file informasi atau brosur yang tersedia. | ✔ Informasi dapat diakses tanpa login, file dan brosur dapat diunduh, serta preview gambar ditampilkan jika tersedia. |
| G-06 | Ingin melihat daftar prestasi dan program ekstrakurikuler sekolah. | ✔ Foto dokumentasi tampil dengan baik, informasi mudah dibaca, dan fitur filter tersedia jika dibutuhkan. |
| G-07 | Ingin melihat daftar fasilitas sarana dan prasarana sekolah. | ✔ Grid foto rapi, responsif, dan dilengkapi deskripsi fasilitas yang tersedia. |
| G-08 | Ingin mengirim pesan pertanyaan melalui form halaman kontak. | ✔ Validasi input berjalan, proteksi anti-spam rate-limit diterapkan, notifikasi sukses muncul, dan pesan tersimpan ke database. |
| G-09 | Ingin bertanya ke Chatbot FAQ untuk mendapatkan informasi sekolah dengan cepat. | ✔ Respon diberikan berdasarkan database FAQ, tidak mengarang jawaban di luar data, dan menolak pertanyaan luar topik dengan sopan. |
| G-10 | Ingin melihat informasi kurikulum sekolah dan mengunduh dokumen yang tersedia. | ✔ Informasi dapat diakses tanpa login, file PDF dan materi gambar yang disediakan dapat diunduh. |
| G-11 | Sebagai alumni, ingin melihat Alumni Pilihan dan mengisi pendataan alumni sekolah. | ✔ Maksimal 4 Alumni Pilihan dapat ditampilkan dan tersedia akses menuju Google Forms resmi sekolah untuk pendataan alumni. |
| G-12 | Sebagai alumni, ingin dapat mengirim data diri tanpa diwajibkan mengunggah foto. | ✔ Google Forms dapat meminta data nama, nomor HP/WhatsApp, email, tahun kelulusan, pekerjaan atau aktivitas, dan informasi lain sesuai kebutuhan sekolah, sedangkan upload foto bersifat opsional. |

### 2.2 Admin Konten (Content Management Experience)

| ID | Cerita Pengguna (User Story) | Kriteria Penerimaan (Acceptance Criteria) |
| :--- | :--- | :--- |
| A-01 | Ingin melakukan login ke dashboard Filament dengan aman. | ✔ Validasi akun sukses langsung mengarah ke halaman dashboard. |
| A-02 | Ingin melakukan CRUD Berita dan mengatur status Draft/Published. | ✔ Upload gambar menggunakan optimasi WebP, slug dapat dikelola sesuai aturan sistem, serta metadata SEO tersedia sesuai kebutuhan. |
| A-03 | Ingin memperbarui data Profil Sekolah dan Sejarah. | ✔ Admin dapat memperbarui identitas sekolah, visi, misi, Sambutan Kepala Sekolah, sejarah, dan informasi profil lainnya. |
| A-04 | Ingin mengelola informasi SPMB sekolah. | ✔ Admin dapat memperbarui keterangan SPMB serta mengelola file informasi dan brosur yang dapat diunduh pengunjung. |
| A-05 | Ingin melakukan CRUD Prestasi, Ekstrakurikuler, dan Fasilitas. | ✔ Form manajemen data lengkap dengan upload foto dokumentasi per entitas sesuai kebutuhan. |
| A-06 | Ingin mengelola konten visual Hero Banner dan Galeri foto. | ✔ Dapat mengubah gambar, teks, link CTA, status, dan informasi visual sesuai modul yang tersedia. |
| A-07 | Ingin melihat pesan masuk dari form kontak publik. | ✔ Daftar pesan masuk rapi dan memiliki penanda status Belum Dibaca atau Sudah Dibaca. |
| A-08 | Ingin mengelola basis data FAQ Chatbot. | ✔ Admin dapat mengelola pasangan kata kunci dan teks jawaban yang menjadi sumber respon chatbot lokal. |
| A-09 | Ingin mengelola informasi Kurikulum berdasarkan tahun ajaran. | ✔ Dapat mengelola data kurikulum, dokumen PDF, materi gambar, status publikasi, dan urutan tampil. |
| A-10 | Ingin mengelola Data Guru dan Data Karyawan. | ✔ Admin dapat menambah, mengubah, dan menghapus data staf menggunakan satu modul backend dengan kategori Guru atau Karyawan, termasuk nama, foto opsional, jabatan, mata pelajaran atau bagian/unit, status aktif, dan urutan tampil. |
| A-11 | Ingin mengelola Alumni Pilihan yang ditampilkan pada website. | ✔ Admin dapat mengelola profil alumni dan maksimal 4 Alumni Pilihan aktif ditampilkan kepada publik. |

Pendataan alumni umum tidak dikelola melalui Admin Panel Laravel. Data pendataan dikumpulkan melalui Google Forms dan dikelola oleh pihak sekolah melalui Google Sheets.

### 2.3 Super Admin (System & Configuration Experience)

| ID | Cerita Pengguna (User Story) | Kriteria Penerimaan (Acceptance Criteria) |
| :--- | :--- | :--- |
| SA-01 | Ingin mengelola akun pengguna Admin. | ✔ Dapat menambah akun admin baru, mengedit hak akses, atau menghapus akun sesuai kewenangan. |
| SA-02 | Ingin mengatur konfigurasi SEO default dan optimasi indeks situs. | ✔ Dapat mengubah konfigurasi SEO global, default OG Image, dan pengaturan sistem yang tersedia. |
| SA-03 | Ingin memantau statistik performa data pada dashboard. | ✔ Menampilkan ringkasan data penting sesuai modul yang tersedia pada sistem. |

---

## 3. Batasan Perilaku Sistem Chatbot (System Behavior Rules)

 Rule-01 (No Hallucination): Sistem chatbot dilarang mengarang jawaban di luar data tabel `chatbot_knowledges`.

 Rule-02 (Scope Guard): Jika mendeteksi pertanyaan di luar ruang lingkup informasi SMA PGRI 1 Tulungagung, sistem wajib memicu respon penolakan standar: "Maaf, saya hanya dapat membantu menjawab pertanyaan seputar SMA PGRI 1 Tulungagung."

 Rule-03 (Fresh Data Fetch): Pencarian teks wajib menggunakan data FAQ aktif yang tersedia pada database.

 Ruang Lingkup Informasi: Profil Sekolah, Sejarah, Guru, Karyawan, Kurikulum, SPMB, Berita, Prestasi, Ekstrakurikuler, Fasilitas, Alumni, Kontak, dan informasi sekolah lainnya yang tersedia pada database FAQ.

---

## 4. Kriteria Non-Fungsional Utama & Masa Depan

 Kualitas Produksi: Wajib memenuhi standar kecepatan muat halaman publik di bawah 3 detik, ramah aksesibilitas, aman dari serangan injeksi form, dan adaptif penuh pada perangkat mobile.

 Optimasi Media: Gambar yang digunakan untuk tampilan website dioptimasi ke format WebP. File asli yang memang disediakan sebagai file unduhan pada Kurikulum dan SPMB tetap dipertahankan.

 Privasi Alumni: Data pendataan alumni dikelola melalui Google Forms dan Google Sheets milik sekolah dan tidak otomatis ditampilkan pada website.

 Skalabilitas Mendatang: Arsitektur kode siap dikembangkan untuk kebutuhan jangka panjang seperti Portal Guru, Portal Alumni dengan akun pribadi, Portal Nilai Siswa, Sistem E-Learning, SPMB Online terintegrasi, dan aplikasi mobile.