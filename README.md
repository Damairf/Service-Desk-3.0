Proyek Service Desk Versi 3.0 dari Tim Magang UNDIP

[KEBUTUHAN]
- Vue 3 + Vite
- Laravel 12
- MySQL
- Akun google developer Recaptcha

[LANGKAH INSTALASI]
1. Set Up Frontend:
- 'npm install' pada terminal folder frontend (terminal frontend)
- 'npm run dev' untuk menjalankan via developer (terminal frontend)
- 'npm run preview' untuk menjalankan via preview (terminal frontend)
2. Set Up Backend:
- 'composer install' untuk menginstall semua library keperluan laravel (terminal backend)
- duplikat file .env.example dan ganti nama file menjadi .env
- 'php artisan key:generate' untuk membuat app key baru (terminal backend)
- 'php artisan migrate:fresh' untuk melakukan migrasi awal database (terminal backend)
- 'php artisan migrate --seed' untuk melakukan simulasi isi database (opsional)
- 'php artisan serve' untuk menjalankan backend (terminal backend)
3. Mendapatkan token Recaptcha:
- Pergi ke web https://www.google.com/recaptcha/admin/create?hl=id
- masukkan label untuk tahu nama dari web yang akan diberi recaptcha
- pilih score based v3
- masukkan domain yaitu localhost atau ip (yang sesuai) jika sudah pake dockerized
- beri nama google cloud platformnya
- submit
- masukkan RECAPTCHA_SECRET_KEY ke file .env (backend laravel)
- isi RECAPTCHA_SITE_KEY di main.js (frontend vue)
