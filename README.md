# 🎡 Green City Park

A theme park management system built with Laravel 11. Handles booking tickets, managing rides and events, processing payments, and generating QR code tickets.

## Quick Setup

**Requirements:** PHP 8.2+, MySQL 5.7+

```bash
composer install
php artisan migrate
php artisan db:seed
php artisan serve
```

Then go to `http://localhost:8000`

## Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@greencitypark.ye | Admin@1234 |
| Staff | staff@greencitypark.ye | Staff@1234 |
| Visitor | visitor@greencitypark.ye | Visitor@1234 |

## Features

- **Rides Management** - Add, edit, track ride status
- **Event Management** - Manage upcoming park events
- **Ticket Booking** - Customers can book tickets with date and quantity
- **Payment Processing** - Track bank transfers and cash payments
- **QR Code Tickets** - Auto-generated per ticket after confirmation
- **Notifications** - System alerts for bookings and payments
- **Reports** - Monthly revenue and ticket sales breakdown
- **Bilingual** - Full Arabic and English support

## Tech Stack

- Laravel 11
- MySQL
- Blade Templates
- Bootstrap 5
- Vite

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

## 🧪 Testing

Run automated tests:

```bash
php artisan test
```

---

## 📝 API Endpoints (Internal)

### Promotions
- `GET /api/promo-check?code=CODE&amount=AMOUNT` - Validate promo code

### Tickets
- `GET /api/tickets/{qrCode}` - Validate ticket QR code

---

## 🚀 Deployment Checklist

Before deploying to production:

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Generate new `APP_KEY`
- [ ] Configure real SMTP for emails
- [ ] Set strong database password
- [ ] Enable HTTPS/SSL
- [ ] Set up proper file permissions
- [ ] Configure backup strategy
- [ ] Set up monitoring and logging

---

## 📊 Code Quality & Improvements

This project has been analyzed for code quality. See the [Improvement Report](https://claude.ai/artifact/EvoXHmuE2asNYegmA5LSMh) for recommendations on:
- Code refactoring opportunities
- Performance optimization
- Security enhancements
- Accessibility improvements (WCAG compliance)
- Database optimization

**Quick Wins** identified for immediate implementation include:
- Add transaction management for multi-step operations
- Extract duplicate code into services
- Add database indexes for faster queries
- Improve accessibility with ARIA labels
- Extract repeated template components

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Commit changes: `git commit -m 'Add amazing feature'`
4. Push to branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

---

## 🐛 Known Issues & Improvements

See the [Improvement Report](https://claude.ai/artifact/EvoXHmuE2asNYegmA5LSMh) for detailed analysis of:
- Code duplication areas
- Performance optimization opportunities
- Security considerations
- Accessibility gaps
- Database optimization suggestions

---

## 📄 License

This project is licensed under the MIT License.

---

## 👨‍💻 Author

**Musab Fahmi**
- Email: alhosainimusab@gmail.com
- GitHub: [@alhosainimusab](https://github.com/alhosainimusab)

---

## 🎓 Project Context

**PSM1 Final Year Project** for **Green City Entertainment Park, Yemen**

**Supervised by:** Dr. Mohd Zanes Bin Sahid  
*Senior Lecturer, Department of Software Engineering*  
*Faculty of Computer Science and Information Technology, UTHM*  
📧 Email: zanes@uthm.edu.my

---

## 💡 Support

For issues, questions, or suggestions:
1. Check existing [GitHub Issues](https://github.com/alhosainimusab/green-city-park/issues)
2. Create a new issue with detailed description
3. Include steps to reproduce bugs

---

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0/)
- [Blade Templating](https://laravel.com/docs/11.x/blade)

---

**Happy Coding! 🚀**

*Last Updated: October 8, 2026*
