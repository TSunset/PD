# Корпоративный университет ИНФИНИТУМ

Laravel MVP для автоматизации оформления заявок на онлайн-обучение корпоративного университета. Система покрывает регистрацию пользователя, выбор курса, создание заявки, автоматическую генерацию PDF-договора и CSV-файла по студенту, а также административную обработку заявок.

## Что умеет MVP

- Публичный корпоративный лендинг и каталог курсов.
- Регистрация и вход с ролями `user` и `admin`.
- Личный кабинет пользователя со списком заявок и скачиванием PDF-договора.
- Форма заявки с валидацией, CSRF-защитой и honeypot-полем от ботов.
- Автоматическая генерация PDF через `barryvdh/laravel-dompdf`.
- Автоматическая генерация отдельного CSV по каждой заявке.
- Админ-панель с фильтрами, поиском, изменением статуса и скачиванием PDF/CSV.
- Выгрузка общего CSV по всем заявкам.
- Защищённая отдача файлов без публичных прямых ссылок.

## Стек

- Backend: Laravel 13
- База данных: MySQL
- Frontend: Blade + Tailwind CSS
- PDF: `barryvdh/laravel-dompdf`
- Веб-сервер: Nginx + PHP-FPM
- SSL: Let's Encrypt / Certbot

## Роли и доступы

### Пользователь

- регистрируется и входит в систему;
- смотрит список курсов;
- создаёт заявку;
- видит свои заявки и статусы;
- скачивает свой PDF-договор.

### Администратор

- входит в админ-панель;
- видит все заявки;
- фильтрует по статусу и курсу;
- ищет по ФИО, email и организации;
- открывает карточку заявки;
- скачивает PDF и CSV;
- меняет статус заявки;
- скачивает общий CSV по всем заявкам.

## Структура базы данных

### `users`

- `id`
- `name`
- `email`
- `phone`
- `password`
- `role`
- `remember_token`
- `timestamps`

### `courses`

- `id`
- `title`
- `description`
- `price`
- `duration`
- `is_active`
- `timestamps`

### `orders`

- `id`
- `user_id`
- `course_id`
- `full_name`
- `email`
- `phone`
- `organization`
- `inn`
- `position`
- `comment`
- `status`
- `contract_pdf_path`
- `student_csv_path`
- `agreement_accepted`
- `timestamps`

## Логика проекта

1. Пользователь регистрируется и авторизуется.
2. Выбирает курс и заполняет форму заявки.
3. `OrderController` создаёт запись в `orders`.
4. `ContractService` формирует PDF-договор в `storage/app/contracts`.
5. `CsvExportService` формирует CSV по заявке в `storage/app/csv`.
6. Пути к файлам сохраняются в базе.
7. Пользователь видит заявку в личном кабинете.
8. Администратор скачивает документы и меняет статус обработки.

## Основные контроллеры и сервисы

- `CourseController`
- `OrderController`
- `AdminOrderController`
- `ContractController`
- `CsvExportController`
- `ContractService`
- `CsvExportService`

## Тестовые доступы

- `admin@example.com` / `password`
- `user@example.com` / `password`

## Локальный запуск

Минимальная последовательность:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Для фронтенда на Tailwind/Vite также нужно собрать ассеты:

```bash
npm install
npm run build
```

После этого приложение будет доступно по адресу `http://127.0.0.1:8000`.

## Маршруты

### Публичные

- `GET /`
- `GET /courses`
- `GET /courses/{id}`
- `GET /login`
- `GET /register`

### Пользователь

- `GET /dashboard`
- `GET /orders`
- `GET /orders/create`
- `POST /orders`
- `GET /orders/{id}`
- `GET /orders/{id}/download-contract`

### Администратор

- `GET /admin`
- `GET /admin/orders`
- `GET /admin/orders/{id}`
- `POST /admin/orders/{id}/status`
- `GET /admin/orders/{id}/download-contract`
- `GET /admin/orders/{id}/download-csv`
- `GET /admin/export/orders.csv`

## Деплой на VPS Ubuntu

Ниже пример для production-развёртывания Laravel на Ubuntu с MySQL, Nginx, PHP-FPM, GitHub и HTTPS.

### 1. Установить пакеты

```bash
sudo apt update
sudo apt install -y nginx mysql-server php php-fpm php-mysql php-xml php-mbstring php-zip php-curl unzip git composer certbot python3-certbot-nginx nodejs npm
```

Если на сервере нужен конкретный PHP 8.3, используйте соответствующий репозиторий и пакеты `php8.3-*`.

### 2. Клонировать проект из GitHub

```bash
cd /var/www
sudo git clone https://github.com/TSunset/PD.git infinitum-university
cd infinitum-university
```

### 3. Создать базу данных и пользователя MySQL

```bash
sudo mysql
```

```sql
CREATE DATABASE infinitum_mvp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'infinitum_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON infinitum_mvp.* TO 'infinitum_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Настроить `.env`

```bash
cp .env.example .env
```

Обязательные параметры:

```env
APP_NAME="Infinitum Corporate University"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=infinitum_mvp
DB_USERNAME=infinitum_user
DB_PASSWORD=strong_password_here
```

### 5. Установить PHP-зависимости

```bash
composer install --no-dev --optimize-autoloader
```

### 6. Сгенерировать ключ приложения

```bash
php artisan key:generate
```

### 7. Установить frontend-зависимости и собрать ассеты

```bash
npm install
npm run build
```

### 8. Выполнить миграции и сиды

```bash
php artisan migrate --seed
```

### 9. Создать симлинк для публичного storage

```bash
php artisan storage:link
```

Примечание: договоры и CSV в этом MVP отдаются не через публичные ссылки, а через контроллеры с проверкой прав. Команда `storage:link` всё равно полезна для стандартной структуры Laravel.

### 10. Выставить права

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 11. Настроить домен

- создать `A`-запись, если у VPS есть IPv4;
- создать `AAAA`-запись на IPv6-адрес VPS;
- дождаться обновления DNS.

### 12. Настроить Nginx под Laravel с учётом IPv6

Пример файла `/etc/nginx/sites-available/infinitum-university`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name example.com www.example.com;
    root /var/www/infinitum-university/public;
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Активировать конфиг:

```bash
sudo ln -s /etc/nginx/sites-available/infinitum-university /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 13. Подключить HTTPS через Let's Encrypt

```bash
sudo certbot --nginx -d example.com -d www.example.com
```

После выпуска сертификата итоговый конфиг должен содержать:

```nginx
listen 443 ssl;
listen [::]:443 ssl;
```

### 14. Проверить автообновление сертификата

```bash
sudo certbot renew --dry-run
```

### 15. Оптимизировать Laravel для production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 16. Smoke test после деплоя

1. Открыть главную страницу.
2. Перейти в каталог курсов.
3. Зарегистрировать пользователя.
4. Создать заявку.
5. Скачать PDF-договор.
6. Войти под `admin@example.com`.
7. Открыть заявку в админке.
8. Скачать PDF и CSV.
9. Изменить статус на `Передано менеджеру` или `Обработано`.

## Что хранится в файловой системе

- `storage/app/contracts` — PDF-договоры
- `storage/app/csv` — CSV-файлы по отдельным заявкам

## Безопасность, заложенная в MVP

- CSRF во всех формах
- серверная валидация данных
- роли через middleware
- проверка прав на скачивание файлов
- непубличное хранение PDF и CSV
- honeypot-поле для защиты от простых ботов
- кастомные страницы `403` и `404`
- отсутствие любых платёжных данных

## Ограничения MVP

- нет платёжного шлюза;
- нет интеграции с 1С, СПД, iSpring и другими внешними системами;
- общий процесс после формирования заявки рассчитан на дальнейшую ручную обработку менеджером.
