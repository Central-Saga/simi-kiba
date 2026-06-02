#!/bin/bash

# ==============================================================================
# SIMI-KIBA MANAGEMENT TOOL
# 
# Infrastruktur:
# - Backend (PHP 8.4 CLI) berjalan di dalam Podman (simi_kiba_app)
# - Database (MySQL 8.4) berjalan di dalam Podman (simi_kiba_mysql)
# - Cache (Redis Alpine) berjalan di dalam Podman (simi_kiba_redis)
# - Frontend (Vite/Node.js) berjalan di Background Native Windows
# ==============================================================================

COMPOSE="podman-compose"
APP_CONTAINER="simi_kiba_app"

case "$1" in
    "up")
        echo "========================================="
        echo "🚀 MENYALAKAN PROJECT SIMI-KIBA"
        echo "========================================="
        echo "Deskripsi: Perintah ini menyalakan seluruh arsitektur server Anda."
        
        export XDG_RUNTIME_DIR=/run/user/$(id -u)
        
        echo ""
        echo "🗄️  Tahap 1: Memulai Layanan Backend (Podman)"
        echo "[COMMAND] $COMPOSE up -d"
        $COMPOSE up -d
        
        echo "⏳ Menunggu container backend agar stabil (3 detik)..."
        sleep 3
        
        echo ""
        echo "📦 Tahap 2: Memulai Server Aset/Vite (Native Windows)"
        echo "Deskripsi: Vite akan memproses CSS/JS Anda secara real-time."
        echo "[COMMAND] npm.cmd run dev > storage/logs/vite.log 2>&1 &"
        npm.cmd run dev > storage/logs/vite.log 2>&1 &
        echo $! > storage/logs/npm.pid
        
        echo ""
        echo "========================================="
        echo "✅ BERHASIL! STATUS SISTEM SAAT INI:"
        echo "========================================="
        echo "   - App (PHP)   : MENYALA  di http://localhost:8000"
        echo "   - Database    : MENYALA  di Port 3306"
        echo "   - Redis       : MENYALA  di Port 6379"
        echo "   - Vite (Asset): MENYALA  di http://localhost:5174"
        echo "========================================="
        echo "💡 Ketik './manage.sh down' untuk mematikan seluruh sistem."
        ;;

    "down")
        echo "========================================="
        echo "🛑 MEMATIKAN SISTEM SIMI-KIBA"
        echo "========================================="
        
        echo "[COMMAND] $COMPOSE down"
        $COMPOSE down
        
        echo "[COMMAND] taskkill /F /IM node.exe"
        cmd.exe /c "taskkill /F /IM node.exe /T 2>NUL" > /dev/null 2>&1
        rm -f storage/logs/npm.pid
        
        echo ""
        echo "✅ Seluruh sistem telah dimatikan."
        ;;

    "restart")
        echo "========================================="
        echo "🔄 ME-RESTART SISTEM SIMI-KIBA"
        echo "========================================="
        
        echo "[COMMAND] ./manage.sh down"
        $0 down
        
        echo "⏳ Jeda 2 detik sebelum menyalakan kembali..."
        sleep 2
        
        echo "[COMMAND] ./manage.sh up"
        $0 up
        ;;

    "logs")
        echo "========================================="
        echo "📜 MENAMPILKAN LOG SERVER PODMAN"
        echo "========================================="
        
        echo "[COMMAND] $COMPOSE logs -f"
        $COMPOSE logs -f
        ;;

    "shell")
        echo "========================================="
        echo "💻 MASUK KE TERMINAL (APP CONTAINER)"
        echo "========================================="
        
        echo "[COMMAND] podman exec -it $APP_CONTAINER bash"
        podman exec -it "$APP_CONTAINER" bash
        ;;

    "status")
        echo "========================================="
        echo "📊 CEK STATUS KONTAINER"
        echo "========================================="

        echo "[COMMAND] podman ps -a"
        podman ps -a
        ;;

    "bootstrap")
        echo "========================================="
        echo "🧱 FULL BOOTSTRAP SIMI-KIBA (FIRST-TIME SETUP)"
        echo "========================================="
        echo "Deskripsi: Membangun seluruh project dari nol."
        echo ""

        echo "🔍 Tahap 1/8: Pemeriksaan tooling"
        for tool in podman podman-compose npm git; do
            if ! command -v "$tool" >/dev/null 2>&1; then
                echo "❌ FATAL: '$tool' tidak ditemukan di PATH."
                echo "   Silakan install $tool lalu jalankan ulang."
                exit 1
            fi
            echo "   ✓ $tool"
        done
        echo ""

        echo "📝 Tahap 2/8: Konfigurasi .env"
        if [ ! -f .env ]; then
            cp .env.example .env
            echo "   ✓ .env dibuat dari .env.example"
        else
            echo "   • .env sudah ada, lewati"
        fi
        echo ""

        echo "📁 Tahap 3/8: Folder runtime"
        mkdir -p storage/logs storage/framework/cache/data \
                 storage/framework/sessions storage/framework/views \
                 storage/framework/testing bootstrap/cache
        echo "   ✓ storage/ & bootstrap/cache siap"
        echo ""

        echo "📦 Tahap 4/8: composer install (container)"
        export XDG_RUNTIME_DIR=/run/user/$(id -u)
        $COMPOSE up -d
        sleep 3
        podman exec -i "$APP_CONTAINER" composer install --no-interaction --prefer-dist
        echo ""

        echo "🔐 Tahap 5/8: APP_KEY & storage:link"
        podman exec -i "$APP_CONTAINER" php artisan key:generate --force
        podman exec -i "$APP_CONTAINER" php artisan storage:link
        echo ""

        echo "🗄️  Tahap 6/8: Migrasi & seed database"
        podman exec -i "$APP_CONTAINER" php artisan migrate --force
        if podman exec -i "$APP_CONTAINER" php artisan db:seed --force 2>/dev/null; then
            echo "   ✓ seeder berjalan"
        else
            echo "   • seeder dilewati (tidak ada DatabaseSeeder atau gagal)"
        fi
        echo ""

        echo "🎨 Tahap 7/8: Frontend (npm install + build)"
        if command -v npm.cmd >/dev/null 2>&1; then
            NPM_CMD="npm.cmd"
        else
            NPM_CMD="npm"
        fi
        "$NPM_CMD" install
        "$NPM_CMD" run build
        echo ""

        echo "🚀 Tahap 8/8: Menyalakan Vite (background)"
        "$NPM_CMD" run dev > storage/logs/vite.log 2>&1 &
        echo $! > storage/logs/npm.pid
        echo "   ✓ Vite PID=$(cat storage/logs/npm.pid) (log: storage/logs/vite.log)"
        echo ""

        echo "========================================="
        echo "✅ BOOTSTRAP SELESAI"
        echo "========================================="
        echo "   - App   : http://localhost:8000"
        echo "   - Vite  : http://localhost:5174"
        echo "   - DB    : Port 3306"
        echo "   - Redis : Port 6379"
        echo "========================================="
        echo "💡 './manage.sh down' untuk mematikan, './manage.sh up' untuk start ulang."
        ;;

    *)
        echo "========================================================="
        echo "🛠️  PANDUAN PENGGUNAAN SIMI-KIBA MANAGEMENT TOOL"
        echo "========================================================="
        echo "Alat ini dibuat khusus untuk mempermudah Anda menjalankan"
        echo "sistem SIMI-KIBA menggunakan Podman. Berikut perintahnya:"
        echo ""
        echo "  ./manage.sh up        : Menyalakan Website & Database."
        echo "  ./manage.sh down      : Mematikan Website & Database."
        echo "  ./manage.sh restart   : Me-restart seluruh sistem."
        echo "  ./manage.sh shell     : Masuk ke dalam mesin PHP (untuk artisan/composer)."
        echo "  ./manage.sh logs      : Melihat catatan error/akses dari server."
        echo "  ./manage.sh status    : Mengecek status kontainer yang sedang hidup."
        echo "  ./manage.sh bootstrap : First-time setup (composer, migrate, npm, build)."
        echo "========================================================="
        exit 1
        ;;
esac
