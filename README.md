```markdown
# My Laravel RESTful API

RESTful API built with Laravel 12, using Sanctum for authentication.  
Supports **users** and **articles** resources with authorization, policies, pagination, and structured error handling.

---

## 🛠️ Features

- **Authentication**: Token-based using **Laravel Sanctum**
- **Users**: 
  - List users (only public info + their published articles)
  - View user details
- **Articles**:
  - CRUD operations (Create, Read, Update, Delete)
  - Users can only view/edit/delete their own articles
  - Users can see all their articles, whether published or not
- **Authorization**:
  - Policies enforce resource ownership
  - Only authorized users can perform actions
- **Pagination**:
  - API endpoints support pagination (`?page=2`)
- **Error Handling**:
  - Structured JSON responses for validation errors, authorization, and general exceptions
- **API Versioning**: `/api/v1/`

---

## 🔑 Authentication

Use **Sanctum** to authenticate and obtain a token.

**Login:**
```

POST /api/v1/auth/login
Content-Type: application/json



````

**Response:**
```json
{
  "token": "YOUR_ACCESS_TOKEN"
}
````

Include the token in the `Authorization` header for protected routes:

```
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

## 📦 Endpoints

### Users

| Method | Endpoint           | Description                         |
| ------ | ------------------ | ----------------------------------- |
| GET    | /api/v1/users      | List all users + published articles |
| GET    | /api/v1/users/{id} | View a single user                  |

### Articles

| Method | Endpoint              | Description                                   |
| ------ | --------------------- | --------------------------------------------- |
| GET    | /api/v1/articles      | List all published articles                   |
| GET    | /api/v1/articles/{id} | View a single article (authorization applied) |
| POST   | /api/v1/articles      | Create a new article (authenticated)          |
| PUT    | /api/v1/articles/{id} | Update an article (only own articles)         |
| DELETE | /api/v1/articles/{id} | Delete an article (only own articles)         |

---

## ⚡ Pagination

All listing endpoints support pagination:

```
GET /api/v1/articles?page=2
```

Response includes pagination metadata:

```json
{
  "data": [...],
  "links": {...},
  "meta": {...}
}
```

---

## 🚨 Error Handling

All errors return JSON with proper HTTP status codes:

* **403 Forbidden**: Unauthorized access
* **404 Not Found**: Resource not found
* **422 Unprocessable Entity**: Validation errors
* **500 Internal Server Error**: Unexpected errors

Example response:

```json
{
  "success": false,
  "message": "You are not authorized to delete this article"
}
```

---

## 📸 Screenshots

<!-- Add your screenshots here -->

```
![Screenshot 1](https://drive.google.com/u/0/drive-viewer/AKGpihaEuaizLBTZBPw7D0W_bhOVl7E9Nd1VhJRroJHtqt4IfkIBjxnrcx1PFFILiIf5fORGRhWs7F1qhF1HDBkDcWtzmErMc3otpQ=s1600-rw-v1?auditContext=forDisplay)
![Screenshot 2](https://lh3.googleusercontent.com/rd-d/ALs6j_GIX8gadmnMDSPm3TQxoiaX_R7cXlEAAXdU5DEcU-nqWxaLxf0GnYgM-pPljKrG07OY97UmR-enYym7VxCk51UE3xC5kK6dNuTLywHyiAsUAnMLYSdFI-2BeDBHv1B2QC9lUUUnjTA_Igj8UiFBecUWcpdR_ay4F8cSVHrO9EPSj5Q8OJGK_jMQlBuF0WKHsBdiq0SDIzwY_SAQSaurhhsxTwUldeKzefWCCcEnphaOGDUSNp4qKiECXSz2L5Sf9nz9k9y4-gqUAhLUFKc_GCrzzCb-puwpykVHD_jrU159LBmNPQyXvDvbJeXtViaKiuOc03DGP4vJkjI5CHmrW1pWE9S2I2C4Jxv3wzBZuOfSZNG8Ez9vFwih6doWgtoux3yaSK4aTKrAPAO2jMrd1knmPL1wDobYVFCQNOLkC8OrzlNtI9LWkJJSeXCvuGaCL5kDKTZHyiWQPTl72HB20K1nzbFTbMjMCPG1lyq-8Qhw4neIuqZ4cUBKInBVuQZGEFkmi7dIX5uNSR8BV5nzwhbVE0y-tK1d8Y0VisWjpF5AIc5O0PLfNLJ6oZb-Ja7eaP4ju70oHXLU3b7U5c0nBtvPBwwKxXs8o8vvwc3cvDcLPbeyrX9u_st8UFwovSOCRHrKF53FF78L6Mm1F51JAY2MfLlTapJyCFrwT5eR_Yw7SU8D4XJWcPzsATqXvNjXLby4pa1Bql_CM9Kuk25585bOARf4v9hOnjBSKuQ1KQvvoaF8zRHYdX-U9RVxhr47ORV6vfRQjLEyswff6eWd6rZf9Qv_lfHlPmor6Kx2ZDz7rrQ--nfdndZM7WrijAC4GFGggQpK5srnEXu6jyTvM3p1yVi2v7Ac0vwtACka_40ldrrwmtMblLwx_Altr-Ai83u_uTEcXsKPYqAyY_XMNWPfa-i9QHrbeuVuSptWp1hadS59VDC2rOa6tp6StBLjkSetUGpH2hquIjifNioJSCVl7eLg2gwZFQgAn6iwJ2DhzkD5DE9Ox3uhz3tuW3PkyumHSG-GVgWakTOERqFYHRvvOaaqyIRGSX_CRzGYVNcpSzw9cWk5OpzWlyqcIHEmUSy2nOT6jn4gqw=w2880-h1624?auditContext=prefetch)
![Screenshot 3](https://lh3.googleusercontent.com/rd-d/ALs6j_G5NCDmys16KWsjX9mYdQnc_whT83yoSpSr5fDEj-BV7hNM8_TeoI1QWOLy3P9Xw68z1fUdHkBy8wFqKHjRgdjDnSCTGe_bccSreIjb-TbrdhoNkb4AY4fWmKblsgShGXtyFieHZLC1jnEmYUwuo_NGoMz9lxRMr1GW2b-OMC4q-R8iitzdKkQvGT0EJk-Z1k46wE9A0EH76_DDX9NmM_EnSjk6sxZLWhP5E20iiPB4ar7W19KAHlWIJ7_UccPUKfXV55K1JRJ146xDp4RwXMWC6fe-Ag0anJSgN3QgWuKDXP90omKU2qus2GxTbSmOSAnhK7a6CrPHsEFdywt3d7BVJDx2xkE570Onvn6ynXDZhhPhbCuplgRnKwhJZfepYuhNQ8cpCGvzNOlv3hQP75UYRVtN7kU-E8iPNunz_SgiJElu-dACYB8_IYRgHEsrV9hOmvJe72Z_yv5Hy0edMWW1oiMhb2krimw0kLtti23I_JNo3Xa4ManYCTXl47TLWeBpzxhJzvomzDI7u3N164gfeF-Mu0Mq8XvR5leTxOZXmtvY3pJ1yr4UXk6ojHrKX1P7ffFGppm54X63kaYfq5snrpht-1gNupYUL4fnv7hKkn7ErAd-D2_XncmA-Wy2Vri1kqRblJ0Bh4JHk22fA56yDX9FQT3MvY56j3r_b5AaRCcYYBzKbKakjHpoxAzL1J0VmqRuEgD774vaIXGqtqEcmIkXtLTAxBeoiuvZDudhBImUsU2mgiNTng-6cFexRL92acnYRGTt3fmWPfdb_Ugf0o2-ttRR6FdDvc5b_nc9uiA6nWfpoHs3NQVeILKm-1UBP8MkVwv5m3Qmj1zGtrpxLo1Rd-8Qtz6jPCDyugC-NKxFlcAoGbw5KgljnV430E4K4AMLAVcjH4HbbxpctzW_m-dDi4kSifIPAKRzFI3_oyk--WgdaQAj_SAocz5pOhCQ9znZ137v7uIFveBR6AdKJkFAtMQ4Q184xCtqkxwOhz5TY_xCK2WDTautUrRP6kJrsyU-UlrjIsDVF_3zl99x25cbBWidN6U_hYSebx0Oo_SjiqP-oMptV5JSFgAqbh5DU667DyGX9w=w2880-h1624?auditContext=prefetch)
```

---

## ✅ Notes

* Ensure users **cannot modify resources they do not own**
* Policies are implemented to enforce business rules
* API responses are formatted consistently using **Laravel API Resources**
* Supports future **versioning** and **role-based access control** if needed

---

## ⚙️ Installation

1. Clone the repository:

```bash
git clone https://github.com/your-repo.git
```

2. Install dependencies:

```bash
composer install
```

3. Set up `.env` file and database

4. Run migrations:

```bash
php artisan migrate
```

5. Serve the application:

```bash
php artisan serve
```

