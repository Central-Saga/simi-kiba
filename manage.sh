#!/bin/bash
# SIMI-KIBA MANAGEMEN TOOL (PODMAN)
# Menggunakan 'podman compose' (BUKAN podman-compose) agar melalui Podman Machine

COMMAND=$1
APP_CONTAINER="simi-kiba-app"

# Fungsi untuk cek apakah container sedang jalan
check_running() {
    if ! podman ps | grep -q "$APP_CONTAINER"; then
        echo "❌ Error: Container '$APP_CONTAINER' tidak sedang berjalan."
        echo "💡 Jalankan './manage.sh up' terlebih dahulu."
        exit 1
    fi
}

case "$COMMAND" in
    "up")
        echo "🚀 Menyalakan Podman Container (Simi-Kiba)..."
        podman compose up -d
        echo "✅ Container sedang dinyalakan. Silakan cek http://localhost:8000"
        ;;

    "down")
        echo "🛑 Mematikan Podman Container..."
        podman compose down
        ;;

    "restart")
        echo "🔄 Me-restart Podman Container..."
        podman compose down
        podman compose up -d
        echo "✅ Restart selesai."
        ;;

    "build")
        echo "🛠️ Membangun ulang (build) kontainer Podman tanpa cache..."
        podman compose build --no-cache
        ;;

    "artisan")
        check_running
        echo "⚙️ Menjalankan artisan: ${@:2}"
        podman compose exec laravel.test php artisan "${@:2}"
        ;;

    "npm")
        check_running
        echo "📦 Menjalankan npm: ${@:2}"
        podman compose exec laravel.test npm "${@:2}"
        ;;

    "migrate")
        check_running
        echo "🗄️ Menjalankan migrasi database..."
        podman compose exec laravel.test php artisan migrate
        ;;

    "seed")
        check_running
        echo "🌱 Menjalankan seeder..."
        podman compose exec laravel.test php artisan db:seed
        ;;

    "fresh")
        check_running
        echo "🔄 Fresh migrate + seed..."
        podman compose exec laravel.test php artisan migrate:fresh --seed
        ;;

    "shell")
        check_running
        echo "💻 Masuk ke dalam terminal container (bash)..."
        podman compose exec laravel.test bash
        ;;

    "logs")
        echo "📜 Melihat log realtime..."
        podman compose logs -f
        ;;

    "prune")
        echo "🧹 Membersihkan kontainer, image, dan network yang tidak terpakai..."
        podman system prune -af
        echo "✅ Prune selesai."
        ;;

    "clean")
        echo "🧹 Membersihkan folder node_modules dan vendor..."
        rm -rf node_modules vendor package-lock.json composer.lock public/build
        echo "✅ Pembersihan selesai."
        ;;

    "status")
        echo "📊 Status Container saat ini:"
        podman ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}" | grep -E "simi-kiba|NAMES"
        ;;

    *)
        echo "================================================================"
        echo "🏗️  SIMI-KIBA - MANAGEMEN TOOL (PODMAN)"
        echo "================================================================"
        echo "Penggunaan: ./manage.sh [command]"
        echo ""
        echo "Basic Commands:"
        echo "  up        : Menyalakan semua container"
        echo "  down      : Mematikan semua container"
        echo "  restart   : Restart container"
        echo "  status    : Cek apakah container sedang jalan"
        echo "  logs      : Lihat log realtime"
        echo ""
        echo "Development Commands:"
        echo "  artisan   : Jalankan php artisan (contoh: ./manage.sh artisan migrate)"
        echo "  npm       : Jalankan npm (contoh: ./manage.sh npm run dev)"
        echo "  migrate   : Jalankan migrasi database"
        echo "  seed      : Jalankan seeder"
        echo "  fresh     : Fresh migrate + seed"
        echo "  build     : Build ulang Docker Image"
        echo "  shell     : Masuk ke dalam terminal container"
        echo ""
        echo "Maintenance Commands:"
        echo "  prune     : Hapus kontainer & image sampah"
        echo "  clean     : Hapus folder vendor & node_modules"
        echo "================================================================"
        ;;
esac
