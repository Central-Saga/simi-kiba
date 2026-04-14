#!/bin/bash
# Script Kemudahan Penggunaan Podman - Simi Kiba System
# Copyright (c) 2026

COMMAND=$1
APP_SERVICE="app"

# DETEKSI PODMAN COMPOSE
if command -v podman-compose &> /dev/null; then
    COMPOSE_CMD="podman-compose"
else
    COMPOSE_CMD="podman compose"
fi

# Fungsi untuk cek apakah container sedang jalan
check_running() {
    if ! podman ps | grep -q "$APP_SERVICE"; then
        echo "❌ Error: Container '$APP_SERVICE' tidak sedang berjalan."
        echo "💡 Jalankan './manage.sh up' terlebih dahulu."
        exit 1
    fi
}

case "$COMMAND" in
    "init")
        echo "🚀 Menginisialisasi proyek Laravel (Install vendor & buat env)..."
        composer install
        if [ ! -f .env ]; then
            cp .env.example .env
        fi
        php artisan key:generate
        echo "✅ Inisialisasi selesai. Silakan jalankan './manage.sh up'"
        ;;
    "up")
        echo "🚀 Menyalakan Podman Container..."
        $COMPOSE_CMD up -d
        echo "✅ Container sedang dinyalakan. Silakan cek http://localhost:8000"
        ;;
    "down")
        echo "🛑 Mematikan Podman Container..."
        $COMPOSE_CMD down
        ;;
    "restart")
        echo "🔄 Me-restart Podman Container..."
        $COMPOSE_CMD down
        $COMPOSE_CMD up -d
        echo "✅ Restart selesai."
        ;;
    "build")
        echo "🛠️ Membangun ulang (build) kontainer Podman tanpa cache..."
        $COMPOSE_CMD build --no-cache
        ;;
    "artisan")
        check_running
        echo "⚙️ Menjalankan artisan: ${@:2}"
        $COMPOSE_CMD exec $APP_SERVICE php artisan "${@:2}"
        ;;
    "composer")
        check_running
        echo "⚙️ Menjalankan composer: ${@:2}"
        $COMPOSE_CMD exec $APP_SERVICE composer "${@:2}"
        ;;
    "npm")
        check_running
        echo "📦 Menjalankan npm: ${@:2}"
        $COMPOSE_CMD exec $APP_SERVICE npm "${@:2}"
        ;;
    "shell")
        check_running
        echo "💻 Masuk ke dalam terminal container (bash)..."
        podman exec -it simi-kiba-app bash
        ;;
    "clean")
        echo "🧹 Membersihkan folder node_modules dan vendor..."
        rm -rf node_modules vendor package-lock.json composer.lock
        echo "✅ Pembersihan selesai. Silakan jalankan './manage.sh init' kembali."
        ;;
    "logs")
        echo "📜 Melihat log realtime..."
        $COMPOSE_CMD logs -f
        ;;
    "status")
        echo "📊 Status Container saat ini:"
        podman ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}" | grep "simi-kiba"
        ;;
    *)
        echo "================================================================"
        echo "🥝 SIMI KIBA - MANAGEMEN TOOL (PODMAN)"
        echo "================================================================"
        echo "Penggunaan: ./manage.sh [command]"
        echo ""
        echo "Basic Commands:"
        echo "  up        : Menyalakan server & database (Detached)"
        echo "  down      : Mematikan & menghapus container yang jalan"
        echo "  restart   : Mematikan lalu menyalakan kembali"
        echo "  status    : Cek apakah container sedang UP atau DOWN"
        echo "  logs      : Lihat log error/aktifitas server"
        echo ""
        echo "Development Commands:"
        echo "  artisan   : Jalankan perintah Laravel (contoh: ./manage.sh artisan migrate)"
        echo "  composer  : Jalankan perintah Composer inside container"
        echo "  npm       : Jalankan perintah Node (contoh: ./manage.sh npm run dev)"
        echo "  build     : Build ulang Docker Image (gunakan jika ada perubahan Dockerfile)"
        echo "  shell     : Masuk ke dalam terminal container secara langsung"
        echo ""
        echo "Setup Commands:"
        echo "  init      : Install vendor pertama kali & set up .env"
        echo "  clean     : Hapus node_modules & vendor (Gunakan jika error install)"
        echo "================================================================"
        ;;
esac
