# سیستم یادداشت تحت وب (Note System)

سیستم یادداشت تحت وب با Laravel 9 که امکان ثبت نام، ورود، ایجاد و مدیریت یادداشت‌ها را فراهم می‌کند.

## ویژگی‌ها

### ویژگی‌های اصلی:
1. ✅ صفحه ثبت نام
2. ✅ صفحه ورود با Google reCAPTCHA
3. ✅ ورود با اکانت گوگل (OAuth)
4. ✅ مدیریت یادداشت‌ها (ایجاد، ویرایش، حذف)
5. ✅ جستجوی پیشرفته یادداشت‌ها (پشتیبانی از فارسی و انگلیسی)
6. ✅ پنل مدیریت با گزارش آماری و نمودارهای گرافیکی

### ویژگی‌های تکمیلی:
7. ✅ طراحی واکنش‌گرا (Responsive)
8. ✅ کنترل زمان جلسه (10 دقیقه)
9. ✅ بازیابی رمز عبور از طریق ایمیل

## نصب و راه‌اندازی

### پیش‌نیازها:
- PHP >= 8.0.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (برای assets)

### مراحل نصب:

1. **کلون کردن پروژه:**
```bash
cd /mnt/f/AryiaTech/Projects/NoteSystem
```

2. **نصب وابستگی‌ها:**
```bash
composer install
npm install
```

3. **تنظیم فایل .env:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **تنظیمات پایگاه داده در .env:**
```env
DB_CONNECTION=sqlite

```

5. **تنظیمات ایمیل در .env:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

6. **تنظیمات Google OAuth در .env:**
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

7. **تنظیمات Google reCAPTCHA در .env:**
```env
RECAPTCHA_SITE_KEY=your_recaptcha_site_key
RECAPTCHA_SECRET_KEY=your_recaptcha_secret_key
```

8. **اجرای Migration ها:**
```bash
php artisan migrate
```

9. **ایجاد کاربران پیش‌فرض:**
```bash
php artisan db:seed --class=UserSeeder
```

این دستور دو کاربر پیش‌فرض ایجاد می‌کند:
- **ادمین:** `admin@example.com` / `password`
- **کاربر عادی:** `user@example.com` / `password`

10. **اجرای سرور:**
```bash
php artisan serve
```

## تنظیمات Google OAuth

1. به [Google Cloud Console](https://console.cloud.google.com/) بروید
2. یک پروژه جدید ایجاد کنید
3. API Credentials ایجاد کنید
4. Authorized redirect URIs را تنظیم کنید: `http://localhost:8000/auth/google/callback`
5. Client ID و Client Secret را در فایل .env قرار دهید

## استفاده

- **ثبت نام:** `/register`
- **ورود:** `/login`
- **یادداشت‌ها:** `/notes`
- **جستجو:** `/notes/search`
- **پنل مدیریت:** `/admin` (فقط برای ادمین‌ها)

## ساختار پروژه

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── GoogleController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   └── ResetPasswordController.php
│   │   ├── NoteController.php
│   │   └── AdminController.php
│   └── Middleware/
│       ├── SessionTimeout.php
│       └── AdminMiddleware.php
├── Models/
│   ├── User.php
│   └── Note.php
└── Policies/
    └── NotePolicy.php

resources/views/
├── layouts/
│   └── app.blade.php
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   └── reset-password.blade.php
├── notes/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   └── search.blade.php
└── admin/
    └── dashboard.blade.php
```

## امنیت

- استفاده از CSRF Protection
- Hash کردن رمزهای عبور
- Session Timeout (10 دقیقه)
- Authorization Policy برای یادداشت‌ها
- CAPTCHA در صفحه ورود

## پشتیبانی

برای سوالات و مشکلات، لطفا issue ایجاد کنید.
