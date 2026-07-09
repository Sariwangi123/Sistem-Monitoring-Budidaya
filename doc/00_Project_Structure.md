# UtiFarm
# 00_Project_Structure

Version : 1.0

Status : Active

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Business_Rules.md
- 00_Database_Convention.md
- 00_API_Convention.md
- 00_UI_Convention.md
- 00_Coding_Convention.md

---

# 1. Purpose

Dokumen ini mendefinisikan struktur project UtiFarm.

Seluruh Backend, Frontend, dan AI Coding Assistant wajib mengikuti struktur ini.

Struktur project tidak boleh diubah tanpa persetujuan.

---

# 2. Project Architecture

Project menggunakan arsitektur:

- Modular Architecture
- Service Layer
- Repository Pattern
- REST API
- Component Based Frontend

Bukan Microservice.

Bukan Domain Driven Design (DDD) penuh.

Seluruh sistem berjalan sebagai Monolithic Modular Application.

---

# 3. Project Root Structure

```
utifarm/

├── backend/
├── frontend/
├── docs/
├── docker/
├── scripts/
├── storage/
├── README.md
├── README_AI.md
├── PROJECT_STATUS.md
└── CHANGELOG.md
```

---

# 4. Backend Structure

```
backend/

app/

Modules/

Shared/

Providers/

bootstrap/

config/

database/

routes/

storage/

tests/

public/
```

---

# 5. Module Structure

Setiap module memiliki struktur berikut.

```
ModuleName/

Controllers/

Models/

Repositories/

Services/

Requests/

Resources/

Policies/

Routes/
```

Contoh

```
MasterData/

Company/

Farm/

Pond/

Supplier/

Customer/
```

---

# 6. Frontend Structure

```
frontend/

src/

assets/

components/

hooks/

layouts/

pages/

services/

stores/

types/

utils/

router/
```

---

# 7. Components Structure

```
components/

common/

datatable/

forms/

layout/

modal/

navigation/

table/

toast/

upload/
```

Seluruh komponen harus reusable.

---

# 8. Pages Structure

```
pages/

dashboard/

master-data/

culture-cycle/

activities/

warehouse/

harvest/

finance/

reports/

settings/
```

---

# 9. Services Structure

```
services/

api/

company.service.ts

farm.service.ts

pond.service.ts
```

Satu file service untuk satu resource.

---

# 10. Hooks Structure

```
hooks/

useCompany.ts

useFarm.ts

usePond.ts
```

Custom Hook digunakan untuk komunikasi API.

---

# 11. Types Structure

```
types/

company.ts

farm.ts

pond.ts

api.ts
```

---

# 12. Utils Structure

```
utils/

date.ts

number.ts

currency.ts

validation.ts
```

---

# 13. Router Structure

```
router/

index.ts

protected.ts

guest.ts
```

Seluruh route dikelola secara terpusat.

---

# 14. Backend Routes

Gunakan:

routes/api.php

Semua endpoint menggunakan prefix

```
/api/v1
```

---

# 15. Database Structure

```
database/

migrations/

seeders/

factories/
```

Migration mengikuti urutan dependency.

---

# 16. Storage Structure

```
storage/

app/

logs/

framework/
```

File upload disimpan menggunakan Laravel Storage.

---

# 17. Testing Structure

Backend

```
tests/

Feature/

Unit/
```

Frontend

```
tests/

components/

pages/
```

---

# 18. Docker Structure

```
docker/

nginx/

php/

postgres/

redis/
```

---

# 19. Scripts Structure

```
scripts/

backup.sh

deploy.sh

restore.sh

seed.sh
```

---

# 20. Documentation Structure

```
docs/

00_Project_Master.md

00_Development_Convention.md

00_Business_Rules.md

00_Database_Convention.md

00_API_Convention.md

00_UI_Convention.md

00_Coding_Convention.md

00_Project_Structure.md

01_Milestone_Foundation.md

02_Master_Data/

03_Culture_Cycle/

04_Activities/

05_Warehouse/

06_Harvest/

07_Finance/

08_Dashboard/

09_Report_Analytics/
```

---

# 21. Root Documentation

README.md

Panduan untuk developer.

README_AI.md

Panduan untuk AI Coding Assistant.

PROJECT_STATUS.md

Status implementasi project.

CHANGELOG.md

Riwayat perubahan project.

---

# 22. Dependency Flow

```
Master Data

↓

Culture Cycle

↓

Activities

↓

Warehouse

↓

Harvest

↓

Finance

↓

Dashboard

↓

Report Analytics
```

Dashboard hanya membaca data.

Dashboard tidak boleh menjadi sumber data.

---

# 23. Backend Flow

```
Client

↓

API Route

↓

Controller

↓

Service

↓

Repository

↓

Model

↓

Database
```

---

# 24. Frontend Flow

```
Page

↓

Hook

↓

Service

↓

Axios

↓

REST API
```

Component tidak boleh mengakses API secara langsung.

---

# 25. Naming Convention

Backend

CompanyController

CompanyService

CompanyRepository

Frontend

CompanyPage

CompanyTable

CompanyForm

CompanyModal

---

# 26. File Naming

Gunakan:

PascalCase

untuk Component.

camelCase

untuk Hook.

snake_case

untuk database.

---

# 27. Module Dependency Rules

Master Data

↓

Culture Cycle

↓

Activities

↓

Warehouse

↓

Harvest

↓

Finance

↓

Dashboard

↓

Report

Modul tidak boleh melompati dependency.

---

# 28. AI Coding Rules

AI Coding Assistant wajib:

- Mengikuti struktur folder yang telah ditentukan.
- Tidak membuat folder baru tanpa persetujuan.
- Tidak memindahkan file tanpa alasan yang jelas.
- Mengimplementasikan modul sesuai urutan dependency.
- Menjaga konsistensi struktur project.

---

# 29. Definition of Done

Struktur project dianggap selesai apabila:

- Backend mengikuti struktur yang ditentukan.
- Frontend mengikuti struktur yang ditentukan.
- Dokumentasi berada pada folder docs.
- Tidak ada folder yang tidak digunakan.
- Seluruh modul menggunakan struktur yang konsisten.

---

# End of Document