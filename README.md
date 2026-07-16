# UtiFarm

UtiFarm adalah aplikasi manajemen budidaya perikanan berbasis web dengan arsitektur modular, REST API, dan frontend React. Status saat ini: **MVP v1.0 Release Candidate preparation**.

## Feature Freeze

Tahap Release Engineering sudah aktif. Perubahan yang diperbolehkan hanya bug fix, regression fix, security fix, optimasi kecil yang aman, cleanup terisolasi, dan dokumentasi release.

AI Recommendation belum termasuk MVP v1.0 dan belum diimplementasikan.

## Stack

- Backend: Laravel 12, PHP 8.4, PostgreSQL, Redis, Laravel Sanctum
- Frontend: React, TypeScript strict mode, Vite, Tailwind CSS, React Query
- Runtime: Docker, Nginx, database queue, log mailer

## MVP Modules

- Foundation, Authentication, RBAC
- Master Data, Culture Cycle, Activities
- Warehouse, Harvest, Finance
- Dashboard, Report Analytics, Notification
- System Administration

Frontend workspace tersedia untuk Master Data MVP, Dashboard, Report Analytics, Notification Center, dan System Administration. Master Data frontend MVP mencakup Companies, Farms, Pond Areas, Ponds, Fish Species, Fish Strains, Feed Brands, Feed Categories, Feed Types, Units, Suppliers, Provinces, Cities, Districts, dan Villages melalui route `#/master-data`; resource post-MVP seperti Customers, Employees, Medicines, Probiotics, Vitamins, dan General References tetap ditunda.

## Local Setup

```bash
cp .env.example .env
docker compose up --build -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
npm install
npm run dev
```

## Verification

Checklist release candidate:

```bash
docker compose up -d
docker compose exec app composer install
docker compose exec app composer dump-autoload
docker compose exec app php artisan route:list
docker compose exec app php artisan test
docker compose exec app php artisan about
docker compose exec app php artisan migrate:status
npm run build
npm run lint
```

Tidak ada script `type-check` terpisah; TypeScript diverifikasi melalui `npm run build`.
