# Penjelasan Alur Sistem Pakar C4.5 (Karir Siswa)

Dokumen ini menjelaskan rancangan, alur kerja, dan cara komunikasi antar komponen dalam proyek Sistem Pakar Penentuan Karir Siswa menggunakan algoritma C4.5. Dokumen ini disusun dengan bahasa yang sederhana agar mudah dipahami oleh klien.

## 1. Arsitektur Sistem (Bagaimana Sistem Dibangun)

Sistem ini dibangun menggunakan arsitektur yang memisahkan antara tampilan aplikasi (User Interface) dengan mesin pemroses kecerdasan buatannya (AI). Sistem ini dibagi menjadi dua bagian/folder utama:

1.  **Frontend & Backend Web (Folder `karir-siswa`)**:
    *   **Teknologi:** PHP dengan Framework Laravel (Versi 12).
    *   **Peran:** Bertindak sebagai wajah aplikasi. Bagian ini mengelola halaman web, proses login pengguna, menyediakan formulir untuk input data siswa, dan menampilkan hasil akhir dengan rapi.
2.  **Mesin Algoritma AI (Folder `c45-service`)**:
    *   **Teknologi:** Python dengan Framework FastAPI.
    *   **Peran:** Bertindak sebagai "otak" dari sistem ini. Python dipilih karena sangat unggul untuk melakukan perhitungan matematis kompleks (Algoritma C4.5). Tugasnya murni hanya menerima data, menghitung pohon keputusan, dan memberikan prediksi.

## 2. Alur Kerja Sistem (Dari Awal Hingga Akhir)

Berikut adalah urutan langkah bagaimana sistem ini bekerja, mulai dari pengguna memasukkan data hingga hasil rekomendasi keluar:

### Tahap 1: Pengumpulan dan Input Data (Di Laravel)
*   Pengguna (misalnya Guru BK atau Admin) login ke dalam aplikasi web (Laravel).
*   Guru memasukkan data historis siswa atau kriteria penilaian (seperti nilai akademik, hasil tes minat, dsb) melalui halaman formulir yang disediakan.
*   Aplikasi Laravel menyimpan data-data ini dengan aman ke dalam **Database (MySQL)**.

### Tahap 2: Permintaan Perhitungan (Laravel Memanggil Python)
*   Ketika Guru menekan tombol "Hitung/Proses Algoritma" di layar komputer, aplikasi Laravel tidak akan menghitungnya sendiri.
*   Laravel merapikan data yang dibutuhkan ke dalam format teks khusus bernama **JSON** (format pertukaran data standar), lalu mengirimkannya ke layanan Python.
*   *Analogi:* Kasir (Laravel) mengirimkan daftar pesanan pelanggan ke Koki di Dapur (Python).

### Tahap 3: Pemrosesan Algoritma C4.5 (Di Python)
*   Layanan Python menerima data dari Laravel.
*   Skrip Python menjalankan perhitungan matematis algoritma C4.5:
    *   Menghitung *Entropy* (tingkat ketidakpastian data).
    *   Menghitung *Information Gain* (penentu kriteria mana yang paling berpengaruh).
    *   Membentuk **Pohon Keputusan (Decision Tree)**.
*   Setelah dihitung, Python menemukan kesimpulan/prediksi karir yang tepat untuk siswa tersebut.

### Tahap 4: Pengiriman Hasil (Python Membalas Laravel)
*   Setelah perhitungan selesai, Python membungkus hasil keputusannya kembali ke dalam format **JSON**.
*   Python mengirimkan balasan berisi hasil tersebut kepada Laravel.
*   *Analogi:* Koki di Dapur (Python) memberikan makanan yang sudah matang kepada Kasir (Laravel).

### Tahap 5: Menampilkan Hasil (Di Laravel)
*   Laravel menerima hasil perhitungan matang dari Python.
*   Laravel mungkin akan menyimpan hasil ini ke dalam database untuk keperluan riwayat (history).
*   Laravel kemudian menampilkan hasil tersebut ke layar komputer (halaman web) dengan tampilan yang menarik dan mudah dibaca.
*   Pengguna (Guru BK) dapat mencetak hasil tersebut dalam format laporan **PDF** atau mengunduhnya sebagai file **Excel**.

## 3. Bagaimana Keduanya Terhubung?

Kunci dari terhubungnya aplikasi web (Laravel) dan mesin AI (Python) adalah teknologi bernama **REST API**. 

*   **API (Application Programming Interface)** ibarat kurir atau jembatan penghubung antara dua sistem yang berbeda.
*   Meskipun PHP (Laravel) dan Python adalah bahasa yang berbeda, mereka bisa saling mengobrol dan bertukar data menggunakan format standar universal yaitu **JSON**.
*   Laravel (sebagai pihak yang butuh bantuan) akan "menge-chat" sistem Python melalui jalur API. Python yang selalu *standby*, akan membaca pesan (data) tersebut, memprosesnya, dan membalas pesannya dengan hasil yang sudah dihitung.
*   Selain API, keduanya terhubung secara tidak langsung karena berbagi penyimpanan arsip yang sama, yaitu **satu Database MySQL**. 

**Keuntungan Cara Ini:** 
Dengan memisahkan sistem menjadi dua bagian (Web dan Mesin AI), aplikasi menjadi jauh lebih cepat, stabil, dan aman. Jika kelak ada pembaruan pada rumus perhitungannya, programmer hanya perlu mengubah bagian Python tanpa mengganggu tampilan web yang digunakan oleh klien.
