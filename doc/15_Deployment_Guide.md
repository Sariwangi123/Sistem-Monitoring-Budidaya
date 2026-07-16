# 15_Deployment_Guide.md

# UtiFarm MVP v1.0

# Deployment Guide

Version:
1.0

Status:
Production Ready

Current Phase:
Deployment Engineering

---

# OBJECTIVE

Dokumen ini menjadi panduan resmi
untuk melakukan deployment
UtiFarm MVP v1.0 ke lingkungan Production.

Deployment harus:

- Aman
- Konsisten
- Repeatable
- Mudah dipelihara
- Mudah di-upgrade
- Mudah di-rollback

Deployment tidak boleh
mengubah Business Logic aplikasi.

---

# DEPLOYMENT ARCHITECTURE

Target Production:

Internet

↓

Reverse Proxy (Nginx)

↓

Laravel Application

↓

PHP-FPM

↓

PostgreSQL

↓

Redis

↓

Queue Worker

↓

Scheduler

↓

Storage

↓

Backup

↓

Monitoring

---

# MINIMUM SERVER REQUIREMENT

Operating System

Ubuntu Server 24.04 LTS

CPU

4 Core

RAM

8 GB

Storage

100 GB SSD

Recommended

8 Core

16 GB RAM

200 GB SSD

---

# REQUIRED SOFTWARE

Pastikan server memiliki:

- Docker
- Docker Compose
- Git
- Nginx
- PHP 8.4+
- Composer
- PostgreSQL
- Redis

---

# ENVIRONMENT CONFIGURATION

Pastikan file:

.env

berisi:

APP_ENV=production

APP_DEBUG=false

APP_URL=https://your-domain.com

LOG_CHANNEL=stack

QUEUE_CONNECTION=database

CACHE_STORE=redis

SESSION_DRIVER=database

Buat APP_KEY baru
apabila deployment pertama.

---

# DATABASE

Lakukan:

Migration

Seeder (jika diperlukan)

Verifikasi:

- Foreign Key
- Index
- Constraint

Pastikan:

Migration sukses.

---

# STORAGE

Jalankan:

php artisan storage:link

Pastikan folder:

storage/

memiliki permission yang benar.

---

# CACHE

Jalankan:

php artisan optimize

php artisan config:cache

php artisan route:cache

php artisan view:cache

Pastikan cache berhasil dibuat.

---

# QUEUE

Pastikan Queue Worker berjalan.

Gunakan Supervisor
atau Systemd.

Queue harus:

Auto Restart

Auto Recovery

Logging Enabled

---

# SCHEDULER

Tambahkan Cron Job:

* * * * * php artisan schedule:run

Pastikan:

Scheduler aktif.

---

# LOGGING

Pastikan:

storage/logs

dapat ditulis.

Gunakan:

Daily Log Rotation

Pastikan:

Log tidak tumbuh tanpa batas.

---

# BACKUP

Backup meliputi:

- Database
- Storage
- Configuration

Pastikan:

Backup memiliki:

- Retention
- Verification
- Encryption (jika digunakan)

Jangan menyimpan backup
di lokasi yang sama dengan aplikasi.

---

# SECURITY

Pastikan:

HTTPS aktif

SSL Certificate valid

APP_DEBUG=false

Permission file benar

RBAC aktif

Sanctum aktif

Policy aktif

Secret tidak tersimpan
di repository.

---

# PERFORMANCE

Aktifkan:

Redis Cache

Route Cache

Config Cache

View Cache

Gunakan:

Queue Worker

Scheduler

Optimalkan:

N+1 Query

Pagination

Eager Loading

---

# MONITORING

Pantau:

Application

Database

Redis

Queue

Worker

Scheduler

Storage

Backup

Gunakan monitoring
yang sesuai kebutuhan.

---

# HEALTH CHECK

Verifikasi:

Application

Database

Redis

Queue

Scheduler

Storage

Backup

Semua harus:

Healthy

sebelum aplikasi digunakan.

---

# DEPLOYMENT CHECKLIST

Pastikan:

✅ Docker Running

✅ PostgreSQL Running

✅ Redis Running

✅ Queue Running

✅ Scheduler Running

✅ Migration Success

✅ Storage Linked

✅ Cache Generated

✅ HTTPS Active

✅ APP_DEBUG=false

✅ Build Success

✅ Tests Passed

---

# POST DEPLOYMENT VALIDATION

Verifikasi:

Login

Master Data

Culture Cycle

Activities

Warehouse

Harvest

Finance

Dashboard

Report

Notification

Administration

Pastikan:

Tidak ada Regression.

---

# ROLLBACK PLAN

Jika deployment gagal:

1.

Rollback source code.

2.

Rollback migration
(jika memungkinkan).

3.

Restore database
dari backup.

4.

Restore storage
jika diperlukan.

5.

Restart service.

Pastikan:

Rollback terdokumentasi.

---

# RELEASE TAG

Gunakan Git Tag:

v1.0.0

atau

v1.0.0-rc1

atau

v1.0.0-production

---

# DOCUMENTATION

Update:

CHANGELOG.md

PROJECT_STATUS.md

Tambahkan:

Deployment Date

Deployment Version

Deployment Environment

Release Tag

Deployment Result

---

# STOP CONDITION

Deployment dinyatakan selesai
apabila:

- Seluruh service berjalan
- Seluruh modul dapat digunakan
- Tidak ada Critical Error
- Monitoring Healthy
- Backup tersedia
- Release Tag dibuat

Output akhir:

UtiFarm MVP v1.0

Production Ready