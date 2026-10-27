# Детская школа искусств г. Волжска — vdmsh

Новый сайт ДШИ г. Волжска на Laravel 11 / PHP 8.2 / MySQL / Vite / Three.js.

## Требования

- PHP 8.2+ с расширениями: mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, fileinfo
- MySQL 8+ или MariaDB 10.6+
- Composer 2
- Node.js 20+ и npm
- nginx или Apache
- корень сайта **обязательно** должен указывать на каталог `public`

## Установка на Ubuntu / FASTPANEL

```bash
cd /var/www/ИМЯ_ПОЛЬЗОВАТЕЛЯ/data/www/ДОМЕН
git clone https://github.com/asbcorp24/vdmsh.git .
git checkout develop

composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Заполните в `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ВАШ-ДОМЕН
DB_DATABASE=vdmsh
DB_USERNAME=vdmsh
DB_PASSWORD=СЛОЖНЫЙ_ПАРОЛЬ

ADMIN_NAME="Администратор"
ADMIN_EMAIL=admin@example.ru
ADMIN_PASSWORD=СЛОЖНЫЙ_ПАРОЛЬ
```

После этого:

```bash
php artisan migrate --seed --force
php artisan storage:link

npm ci
npm run build

php artisan optimize
```

После первого создания администратора рекомендуется удалить `ADMIN_PASSWORD` из рабочего `.env`. Сидер не создаёт администратора без `ADMIN_EMAIL` и `ADMIN_PASSWORD`.

## FASTPANEL

В настройках сайта укажите document root:

```text
/var/www/ИМЯ_ПОЛЬЗОВАТЕЛЯ/data/www/ДОМЕН/public
```

PHP: 8.2 или новее.

Каталоги `storage` и `bootstrap/cache` должны быть доступны на запись пользователю PHP-FPM:

```bash
chmod -R ug+rwX storage bootstrap/cache
```

Не выставляйте права 777.

## Очередь

Если фоновые задачи используются, создайте процесс:

```bash
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

Для production лучше запускать его через Supervisor/systemd или менеджер процессов FASTPANEL.

## Планировщик

Cron один раз в минуту:

```cron
* * * * * cd /var/www/ИМЯ_ПОЛЬЗОВАТЕЛЯ/data/www/ДОМЕН && php artisan schedule:run >> /dev/null 2>&1
```

## Проверка после установки

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan config:show app
php artisan storage:link
```

Откройте:
- `/up` — Laravel health endpoint;
- `/admin/login` — вход администратора;
- `/documents` — официальные документы;
- `/download/...` — локальные документы отдаются как скачиваемые файлы.

## Файлы сайта

Загруженные документы хранятся на диске `public`, но пользовательские ссылки на документы формируются через контролируемый маршрут скачивания. Он отдаёт `Content-Disposition: attachment`, поэтому PDF/DOC/XLS и другие материалы скачиваются, а не используются как прямые storage-ссылки.

Изображения (фото преподавателей, галереи, обложки) являются визуальным контентом сайта и отображаются в браузере, а не принудительно скачиваются.

## Обновление

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm ci
npm run build
php artisan optimize
```

Перед production-обновлением рекомендуется резервная копия БД и `storage/app/public`.

## Ветки

Разработка ведётся в `develop`. В `main` изменения переносятся только после отдельного подтверждения.
