# 🎡 Green City Entertainment Park - نظام إدارة المدينة الترفيهية

A complete web-based theme park management system built with **Laravel 11 + MySQL**, designed for XAMPP.

---

## ✅ Requirements

| Tool | Version |
|------|---------|
| XAMPP | 8.x (PHP 8.2 included) |
| MySQL | 5.7+ (included in XAMPP) |
| PHP | 8.2+ |

---

## 🚀 Quick Start (Step by Step)

### Step 1 — Start XAMPP

Open **XAMPP Control Panel** and click **Start** on both:
- ✅ Apache
- ✅ MySQL

### Step 2 — Create the Database

Go to: `http://localhost/phpmyadmin`

1. Click **"New"** on the left panel
2. Enter name: `green_city_park`
3. Click **"Create"**

### Step 3 — Open a Terminal in the Project Folder

Press `Win + R`, type `cmd`, press Enter. Then:

```
cd %USERPROFILE%\Desktop\green-city-park
```

### Step 4 — Install Dependencies

```
C:\xampp\php\php.exe C:\xampp\php\composer.phar install
```

Wait 1-2 minutes for packages to download.

### Step 5 — Run Migrations

```
C:\xampp\php\php.exe artisan migrate
```

This creates all database tables.

### Step 6 — Seed Sample Data

```
C:\xampp\php\php.exe artisan db:seed
```

This adds default users, 8 rides, 4 events, 3 promotions.

### Step 7 — Start the Server

```
C:\xampp\php\php.exe artisan serve
```

Open your browser: **http://localhost:8000** 🎉

---

## 👤 Login Accounts

| Role | Email | Password |
|------|-------|----------|
| **Admin (AR)** | admin@greencitypark.ye | Admin@1234 |
| **Staff** | staff@greencitypark.ye | Staff@1234 |
| **Visitor** | visitor@greencitypark.ye | Visitor@1234 |
| **Admin (EN)** | admin@example.com | Admin@1234 |

---

## 💰 Ticket Prices

| Type | Price |
|------|-------|
| Adult (13+) | 1,500 YER |
| Child (3-12) | 800 YER |
| Group (10+) | 1,200 YER/person |

---

## 🗂️ System Features

| Module | Features |
|--------|----------|
| 🔐 Auth | Login, Register, RBAC (admin/staff/visitor) |
| 🎡 Rides | Arabic+English names, status (active/maintenance/closed) |
| 📅 Events | Upcoming events with dates and locations |
| 🎫 Bookings | Book tickets with date, type, quantity, promo code |
| 💳 Payments | Exchange transfer (Mohsen Al-Khader) or cash at gate |
| 🎟️ Tickets | QR code generated per ticket after confirmation |
| 🔔 Notifications | System notifications for booking/payment status |
| 📊 Reports | Monthly revenue chart, ticket sales breakdown |
| 🌐 Bilingual | Full Arabic RTL + English LTR interface |

---

## 🌐 Key URLs

| URL | Who |
|-----|-----|
| http://localhost:8000 | Public homepage |
| http://localhost:8000/login | All users |
| http://localhost:8000/visitor/dashboard | Visitors |
| http://localhost:8000/staff/dashboard | Staff |
| http://localhost:8000/admin/dashboard | Admin |

---

## 🔄 Reset Everything

```
C:\xampp\php\php.exe artisan migrate:fresh --seed
```

---

## 📁 Key Files

```
green-city-park/
├── .env                    ← Database config (edit DB_PASSWORD if needed)
├── app/Http/Controllers/   ← All controllers
├── app/Models/             ← Eloquent models
├── database/migrations/    ← 11 migration files
├── database/seeders/       ← Sample data
├── lang/ar/ & lang/en/     ← Arabic + English translations
└── resources/views/        ← All Blade templates
```

---

Built for PSM1 Final Year Project — Green City Entertainment, Yemen.
