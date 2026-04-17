# 🏗️ SIMI-KIBA — Panduan Podman untuk Developer (Updated)

> Dokumentasi strategi "Ultimate Mount" untuk bypass masalah jaringan korup saat build di Windows/WSL2.

---

## 🚀 Strategi "Ultimate Mount" (Anti-Gagal Jaringan)

Jika build image Laravel Sail selalu gagal karena `Hash Sum mismatch`, kita menggunakan strategi **Bypass Build**:
1. Menggunakan image yang sudah jadi (dari SIP Madu atau image backup ~2.5GB).
2. Mem-mount script konfigurasi langsung dari folder project ke dalam container.

---

## 🛠️ Langkah Darurat Jika Rebuild Gagal

Jika Anda harus pindah laptop atau image terhapus:

### 1. Tag Image yang Ada
Cari image berukuran besar (~2.5 GB) dan beri tag agar dikenali oleh Simi-Kiba:
```bash
# Cek ID image (misal: f3a07428f381)
podman images

# Tag sebagai sail-8.5
podman tag <IMAGE_ID_ANDA> sail-8.5/app:latest
```

### 2. Pastikan start-container Executable
Di terminal WSL, jalankan:
```bash
chmod +x vendor/laravel/sail/runtimes/8.5/start-container
```

### 3. Konfigurasi compose.yaml (Mount Mode)
Pastikan `compose.yaml` menggunakan volume mount untuk script startup (sudah dikonfigurasi di repo ini):
```yaml
volumes:
  - '.:/var/www/html:z'
  - './vendor/laravel/sail/runtimes/8.5/start-container:/usr/local/bin/start-container:z'
  - './vendor/laravel/sail/runtimes/8.5/supervisord.conf:/etc/supervisor/conf.d/supervisord.conf:z'
```

---

## 📋 Troubleshooting Error Terkini

### 🔴 Error: `usermod: user 'sail' does not exist`
**Penyebab:** Image lama yang Anda gunakan tidak memiliki user `sail` di dalamnya.
**Solusi:** (Sudah diterapkan) Script `start-container` kita sekarang otomatis membuatkan user `sail` saat startup jika belum ada.

### 🔴 Error: `executable file not found`
**Penyebab:** File `start-container` tidak ada di dalam image karena build gagal.
**Solusi:** Pastikan baris `- ./vendor/laravel/sail/.../start-container` ada di bagian `volumes` pada `compose.yaml`.

---

## 📋 Perintah Dasar (manage.sh)

Sekarang Anda bisa menggunakan perintah standar:

```bash
./manage.sh up        # Nyalakan (Tanpa Build!)
./manage.sh down      # Matikan
./manage.sh status    # Cek status
./manage.sh artisan   # Jalankan perintah Laravel (contoh: ./manage.sh artisan migrate)
./manage.sh npm       # Jalankan perintah Node (contoh: ./manage.sh npm run dev)
```

---

## 🔑 Tips Workflow

1. **JANGAN Menjalankan `./manage.sh build`**: Kecuali Anda berada di jaringan yang sangat stabil (Fiber/Lan). Selama di jaringan yang tidak stabil, gunakan strategi `podman tag` + `up`.
2. **Pembersihan Network**: Jika muncul error label network, jalankan:
   ```bash
   podman network rm simi-kiba_sail
   ```

---

*Terakhir diperbarui: 16 April 2026 - Solusi "Ultimate Mount" Stabil.*
