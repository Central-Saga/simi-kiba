#!/bin/bash
# Mac-only: jalanin app tanpa ganggu Podman Windows
# Container mysql+redis harus jalan dulu: bash vendor/bin/sail up -d mysql redis

export DB_HOST=127.0.0.1
export DB_PORT=3307
export REDIS_HOST=127.0.0.1
export REDIS_PORT=6380
export APP_PORT=8080

echo "🚀 Starting Laravel (port $APP_PORT) + Vite (port 5174)"
php artisan serve --host=0.0.0.0 --port=$APP_PORT &
echo $! > /tmp/laravel.pid

npm run dev &
echo $! > /tmp/vite.pid

echo ""
echo "✅ App  : http://localhost:$APP_PORT"
echo "✅ Vite : http://localhost:5174"
echo "💡 kill \$(cat /tmp/laravel.pid) \$(cat /tmp/vite.pid) to stop"
