# UtiFarm
# 12_AI_Recommendation
## Part 6 - REST API & AI Workspace

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
- 12_AI_Recommendation_Part_2.md
- 12_AI_Recommendation_Part_3.md
- 12_AI_Recommendation_Part_4.md
- 12_AI_Recommendation_Part_5.md

---

# 1. Purpose

Dokumen ini mendefinisikan REST API, AI Workspace, AI Session, AI History, dan mekanisme interaksi pengguna dengan Aquaculture Intelligence Platform (AIP).

Seluruh komunikasi AI dilakukan melalui AI Gateway.

Frontend tidak berkomunikasi langsung dengan AI Provider.

---

# 2. Base URL

/api/v1/ai

---

# 3. Authentication

Seluruh endpoint menggunakan:

- Bearer Token
- Laravel Sanctum

---

# 4. Authorization

Menggunakan:

- RBAC
- Policy
- Permission

AI hanya dapat mengakses data sesuai hak akses pengguna.

---

# 5. AI Chat Endpoint

POST

/chat

Input:

- Session ID
- Prompt
- Context (Opsional)

Output:

- AI Response
- Recommendation
- Confidence
- Explanation
- Data Lineage

---

# 6. AI Recommendation Endpoint

GET

/recommendations

Support:

- category
- priority
- status
- page
- per_page

---

GET

/recommendations/{id}

Menampilkan detail Recommendation.

---

# 7. Prediction Endpoint

GET

/predictions

Support:

- prediction_type
- farm
- culture_cycle

---

GET

/predictions/{id}

Detail Prediction.

---

# 8. Forecast Endpoint

GET

/forecasts

---

GET

/forecasts/{id}

---

# 9. Scenario Endpoint

POST

/scenarios

Menjalankan simulasi.

Input:

- Scenario Type
- Parameter
- Farm
- Culture Cycle

Output:

- Prediction
- Forecast
- Recommendation

---

# 10. AI Session Endpoint

GET

/sessions

---

POST

/sessions

---

GET

/sessions/{session_id}

---

DELETE

/sessions/{session_id}

---

# 11. AI History Endpoint

GET

/history

Support:

- date_range
- user
- category

---

GET

/history/{id}

---

# 12. AI Feedback Endpoint

POST

/feedback

Input:

- Recommendation ID
- Rating
- Comment

Feedback digunakan untuk evaluasi AI.

---

# 13. AI Provider Endpoint

GET

/provider

Super Admin Only.

Menampilkan:

- Provider
- Model
- Version
- Status

---

# 14. AI Capability Endpoint

GET

/capabilities

Menampilkan kemampuan AI yang tersedia.

Contoh:

- Recommendation
- Prediction
- Forecast
- Scenario Analysis
- Executive Summary

---

# 15. AI Workspace

Workspace terdiri dari:

- AI Chat
- Recommendation
- Prediction
- Forecast
- Scenario Simulator
- AI History

Workspace mengikuti Role pengguna.

---

# 16. AI Chat Workspace

Menampilkan:

- Conversation
- Context
- Recommendation
- Explanation
- Confidence
- Source Data

Support:

- Streaming Response
- Copy Response
- Export Conversation (Future)

---

# 17. Recommendation Workspace

Menampilkan:

- Recommendation Card
- Priority
- Category
- Confidence
- Explanation

Support:

- Search
- Filter
- Sort

---

# 18. Prediction Workspace

Menampilkan:

- Prediction Chart
- Confidence
- Trend
- Risk Indicator

Support:

- Compare Prediction
- Historical Comparison

---

# 19. Scenario Simulator

Simulator mendukung:

- What-If Analysis
- Best Case
- Expected Case
- Worst Case
- Custom Scenario

Simulator menggunakan Digital Twin (Future).

---

# 20. AI History

History menyimpan:

- Session
- Prompt
- Response
- Recommendation
- Prediction
- Feedback

History mengikuti kebijakan retensi data.

---

# 21. Standard Response

Success

{
    "success": true,
    "message": "Success",
    "data": {},
    "meta": {}
}

Validation Error

{
    "success": false,
    "message": "Validation Error",
    "errors": {}
}

---

# 22. Logging

Seluruh interaksi AI mencatat:

- User
- Session ID
- Prompt
- Provider
- Execution Time
- Token Usage (Jika tersedia)
- Timestamp

---

# 23. Performance Rules

Gunakan:

- Streaming Response
- Cache Context
- Queue
- Lazy Loading

AI tidak boleh menghambat transaksi operasional.

---

# 24. Business Rules

- AI hanya membaca data.
- AI tidak mengubah transaksi.
- AI mengikuti RBAC.
- AI Session mengikuti hak akses pengguna.
- Feedback tidak mengubah Recommendation historis.

---

# 25. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan AI Gateway.
- Menggunakan REST API.
- Menggunakan Streaming Response apabila provider mendukung.
- Menggunakan AI Session.
- Menggunakan React Query.
- Menggunakan Service Layer.
- Menghasilkan implementasi production-ready.

---

# 26. Deliverables

Backend

- AI Gateway Controller
- AI Service
- AI Session Service
- AI History Service
- AI Feedback Service
- AI Provider Service
- Feature Test

Frontend

- AI Workspace
- AI Chat
- Recommendation Workspace
- Prediction Dashboard
- Forecast Dashboard
- Scenario Simulator
- AI History
- Responsive Layout

---

# End of Document