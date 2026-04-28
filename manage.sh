#!/bin/bash

# SIMI-KIBA MANAGEMENT TOOL (PODMAN ROOTLESS)
# Naming convention: Underscore (_) for Podman Desktop clarity.

COMPOSE="podman-compose"
APP_CONTAINER="simi_kiba_app"
APP_SERVICE="laravel_app"

# Helper function to check if container is running
check_running() {
    if ! podman ps --format "{{.Names}}" | grep -q "$APP_CONTAINER"; then
        echo "❌ Error: Container '$APP_CONTAINER' tidak aktif."
        echo "💡 Jalankan './manage.sh up' terlebih dahulu."
        exit 1
    fi
}

case "$1" in
    "up")
        echo "🚀 Menyalakan project SIMI-KIBA (Podman Rootless)..."
        $COMPOSE up -d
        
        echo "📦 Menjalankan 'npm run dev' di background..."
        # Menjalankan npm run dev di dalam container secara background (detached)
        podman exec -d "$APP_CONTAINER" npm run dev -- --host
        
        echo "✅ Berhasil! Project dapat diakses di:"
        echo "   - App: http://localhost:8000"
        echo "   - Vite: http://localhost:5174"
        echo "   - Podman Desktop: Periksa kontainer '$APP_CONTAINER'"
        ;;

    "down")
        echo "🛑 Mematikan semua container..."
        $COMPOSE down
        ;;

    "restart")
        echo "🔄 Me-restart project..."
        $COMPOSE down
        $COMPOSE up -d
        podman exec -d "$APP_CONTAINER" npm run dev -- --host
        echo "✅ Restart selesai."
        ;;

    "logs")
        echo "📜 Menampilkan log (tekan Ctrl+C untuk keluar)..."
        $COMPOSE logs -f
        ;;

    "shell")
        check_running
        echo "💻 Masuk ke terminal container..."
        podman exec -it "$APP_CONTAINER" bash
        ;;

    "artisan")
        check_running
        echo "⚙️ PHP Artisan: ${@:2}"
        podman exec -it "$APP_CONTAINER" php artisan "${@:2}"
        ;;

    "npm")
        check_running
        echo "📦 NPM: ${@:2}"
        podman exec -it "$APP_CONTAINER" npm "${@:2}"
        ;;

    "composer")
        check_running
        echo "🎼 Composer: ${@:2}"
        podman exec -it "$APP_CONTAINER" composer "${@:2}"
        ;;

    "migrate")
        check_running
        echo "🗄️ Menjalankan Migrasi..."
        podman exec -it "$APP_CONTAINER" php artisan migrate
        ;;

    "seed")
        check_running
        echo "🌱 Menjalankan Seeder..."
        podman exec -it "$APP_CONTAINER" php artisan db:seed
        ;;

    "status")
        echo "📊 Status Kontainer:"
        podman ps -a --filter name=simi_kiba
        ;;

    *)
        echo "Usage: ./manage.sh [command]"
        echo "--------------------------"
        echo "up       : Start containers + npm run dev"
        echo "down     : Stop containers"
        echo "restart  : Restart project"
        echo "logs     : Show logs"
        echo "shell    : Enter container shell"
        echo "artisan  : Run artisan command"
        echo "npm      : Run npm command"
        echo "composer : Run composer command"
        echo "migrate  : Run migrations"
        echo "seed     : Run seeders"
        echo "status   : View container status"
        ;;
esac

