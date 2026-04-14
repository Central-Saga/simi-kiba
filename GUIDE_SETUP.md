# 🚀 Panduan Instalasi & Penggunaan (WSL, Podman, & PHP)

Dokumentasi ini akan membantu Anda menyiapkan lingkungan pengembangan profesional menggunakan **Windows Subsystem for Linux (WSL)**, **Podman** sebagai pengganti Docker, dan **PHP** untuk menjalankan aplikasi Laravel Anda.

---

## 🏗️ 1. Instalasi WSL2 (Windows Subsystem for Linux)

WSL memungkinkan Anda menjalankan linux di dalam Windows secara native.

1.  **Buka PowerShell** sebagai Administrator.
2.  Jalankan perintah berikut:
    ```powershell
    wsl --install
    ```
3.  **Restart Komputer** Anda.
4.  Setelah restart, buka Ubuntu (atau distro yang diinstal) dan buat **Username** serta **Password** Anda.

> [!TIP]
> Gunakan perintah `wsl --update` untuk memastikan WSL Anda selalu diperbarui.

---

## 🦭 2. Instalasi Podman di WSL

Podman adalah mesin kontainer yang bersifat *daemonless* dan *rootless*, menjadikannya alternatif yang lebih ringan dan aman dibandingkan Docker.

1.  **Masuk ke terminal WSL/Ubuntu**.
2.  Update repository:
    ```bash
    sudo apt update && sudo apt upgrade -y
    ```
3.  Instal Podman:
    ```bash
    sudo apt install podman -y
    ```
4.  Verifikasi instalasi:
    ```bash
    podman version
    ```

---

## 🐘 3. Instalasi PHP di WSL (Local CLI)

Meskipun kita akan menjalankan PHP di dalam kontainer, memiliki PHP di WSL sangat berguna untuk menjalankan perintah cepat.

1.  **Instal PHP & Extension Dasar**:
    ```bash
    sudo apt install php-cli php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath -y
    ```
2.  **Instal Composer**:
    ```bash
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    ```

---

## 📦 4. Menjalankan Project dengan Podman

Kami telah menyertakan script `manage.sh` untuk memudahkan Anda.

### Persiapan File `compose.yaml`
Pastikan Anda memiliki file `compose.yaml` di root project. Jika belum, gunakan konfigurasi standar Laravel Sail.

### Menjalankan Container
Gunakan script `manage.sh`:
```bash
./manage.sh up
```

---

## 🛠️ 5. Penggunaan `manage.sh`

Script ini adalah *wrapper* untuk perintah Podman yang panjang.

| Perintah | Deskripsi |
| :--- | :--- |
| `./manage.sh up` | Menjalankan semua container (Background) |
| `./manage.sh down` | Menghentikan & menghapus container |
| `./manage.sh shell` | Masuk ke terminal di dalam container PHP |
| `./manage.sh artisan ...` | Menjalankan perintah artisan (Contoh: `./manage.sh artisan migrate`) |
| `./manage.sh composer ...`| Menjalankan perintah composer |
| `./manage.sh logs` | Melihat log aplikasi |

---

> Panduan ini dibuat untuk membantu mempercepat workflow pengembangan **Simi Kiba**.
