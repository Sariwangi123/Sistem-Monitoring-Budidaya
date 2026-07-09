# UtiFarm
# 12_AI_Recommendation
## Part 2 - AI Architecture & Aquaculture Intelligence Platform

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Business_Rules.md
- 00_Database_Convention.md
- 00_API_Convention.md
- 00_UI_Convention.md
- 00_Coding_Convention.md
- 00_Project_Structure.md
- 12_AI_Recommendation_Part_1.md

---

# 1. Purpose

Dokumen ini mendefinisikan arsitektur Aquaculture Intelligence Platform (AIP), AI Gateway, AI Pipeline, AI Registry, dan seluruh komponen utama yang membentuk lapisan kecerdasan pada UtiFarm.

AIP merupakan platform yang bersifat modular, scalable, provider-independent, dan Read Only terhadap seluruh Business Module.

---

# 2. AI Architecture

Arsitektur AI menggunakan pola berikut:

Business Modules

↓

AI Gateway

↓

AI Service

↓

Aquaculture Intelligence Platform (AIP)

↓

Knowledge Engine

↓

Recommendation Engine

↓

Prediction Engine

↓

Forecast Engine

↓

Insight Engine

↓

Explainability Engine

↓

Confidence Engine

↓

Response

Business Module tidak pernah berkomunikasi langsung dengan AI Provider.

---

# 3. AI Principles

Aquaculture Intelligence Platform menggunakan prinsip:

- Read Only Intelligence
- Human in the Loop
- Explainable AI
- Provider Independent
- Modular
- Scalable
- Event Aware
- Context Aware

---

# 4. AI Gateway

AI Gateway bertugas:

- Menerima Request
- Validasi Permission
- Routing Request
- Context Injection
- Logging
- Rate Limiting
- Response Normalization

AI Gateway menjadi satu-satunya pintu masuk menuju AI.

---

# 5. AI Service

AI Service bertugas:

- Menyiapkan Request
- Mengelola AI Pipeline
- Memanggil Engine yang sesuai
- Mengembalikan Response

Service tidak memiliki Business Logic.

---

# 6. AI Pipeline

Pipeline AI:

Request

↓

Permission Validation

↓

Context Builder

↓

Knowledge Collector

↓

Reasoning Engine

↓

Recommendation Engine

↓

Explainability Engine

↓

Confidence Engine

↓

Response Formatter

↓

Response

---

# 7. Knowledge Engine

Knowledge Engine bertugas:

- Mengumpulkan konteks
- Mengakses Data Lineage
- Menggabungkan informasi lintas modul
- Menyediakan Knowledge Context

Knowledge Engine tidak menghasilkan keputusan.

---

# 8. Recommendation Engine

Recommendation Engine:

- Menganalisis kondisi saat ini
- Memberikan rekomendasi
- Menentukan prioritas tindakan
- Menampilkan alternatif solusi

---

# 9. Prediction Engine

Prediction Engine menghasilkan:

- Prediksi Biomassa
- Prediksi Survival Rate
- Prediksi Panen
- Prediksi Kebutuhan Pakan
- Prediksi Pertumbuhan

Prediction menggunakan data historis dan parameter yang tersedia.

---

# 10. Forecast Engine

Forecast Engine menghasilkan:

- Forecast Feed
- Forecast Inventory
- Forecast Cash Flow
- Forecast Revenue
- Forecast Harvest

Forecast digunakan untuk perencanaan.

---

# 11. Insight Engine

Insight Engine menghasilkan:

- Trend
- Anomali
- KPI Insight
- Executive Summary
- Opportunity
- Risk

Insight bersifat informatif.

---

# 12. Explainability Engine

Explainability Engine menjelaskan:

- Mengapa rekomendasi muncul
- Faktor utama
- Data yang digunakan
- Hubungan antar data

Setiap Recommendation wajib memiliki Explainability.

---

# 13. Confidence Engine

Confidence Engine menghasilkan:

- Confidence Score
- Confidence Level
- Confidence Explanation

Confidence bukan jaminan kebenaran.

---

# 14. Context Builder

Context Builder menggabungkan data dari:

- Master Data
- Culture Cycle
- Activities
- Warehouse
- Harvest
- Finance
- Dashboard
- Report
- Notification
- Administration

Context dibangun sesuai hak akses pengguna.

---

# 15. AI Registry

AI Registry menyimpan metadata:

- Engine Name
- Capability
- Version
- Provider
- Status
- Configuration

Registry mendukung penambahan Engine baru tanpa perubahan arsitektur.

---

# 16. AI Provider Abstraction

Provider AI berada di belakang Adapter Layer.

Contoh provider:

- OpenAI
- Google Gemini
- Anthropic Claude
- Ollama
- LM Studio
- Future Provider

Pergantian provider tidak mengubah Business Module.

---

# 17. AI Response Standard

Seluruh Response AI harus memiliki:

- Recommendation
- Explanation
- Confidence Score
- Data Source
- Timestamp

Format Response mengikuti standar API UtiFarm.

---

# 18. Logging & Audit

Seluruh interaksi AI mencatat:

- User
- Prompt
- Context Source
- AI Provider
- Execution Time
- Response ID

Prompt yang mengandung data sensitif mengikuti kebijakan keamanan sistem.

---

# 19. Performance Rules

Gunakan:

- Cache Context
- Background Processing
- Provider Timeout
- Retry Policy
- Response Streaming (Future)

AI tidak boleh menghambat transaksi operasional.

---

# 20. Business Rules

- AI hanya membaca data.
- AI tidak membuat transaksi.
- AI tidak melakukan approval.
- AI mengikuti RBAC.
- AI wajib memberikan Explainability.
- AI wajib memberikan Confidence Score.
- AI menggunakan Data Lineage.

---

# 21. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan AI Gateway.
- Menggunakan Aquaculture Intelligence Platform.
- Menggunakan AI Pipeline.
- Menggunakan Provider Adapter Pattern.
- Menggunakan Explainability Engine.
- Menggunakan Confidence Engine.
- Menghasilkan implementasi production-ready.

---

# 22. Deliverables

Implementasi harus menghasilkan:

Backend

- AI Gateway
- AI Service
- Knowledge Engine
- Recommendation Engine
- Prediction Engine
- Forecast Engine
- Insight Engine
- Explainability Engine
- Confidence Engine
- AI Registry
- Provider Adapter
- Feature Test

---

# End of Document