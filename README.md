# Inventory & Financial Reporting System (Laravel 12 + Livewire 3 + Alpine.js, Tailwind.css)

### Live Link: https://inventory.ayshatech.com/

#### Video Overview: https://youtu.be/xpZd7zUMI3c?si=0EoLKJyJ677q5wgZ

This system is built using the TALL stack (Tailwind CSS, Alpine.js, Laravel, Livewire) along with Laravel Breeze for authentication. It includes:

-   Product Management
-   Stock In/Out Tracking
-   Sales with Discount, VAT, Payment & Due
-   Dynamic Journal Entries (no separate journal table)
-   Financial Report (Profit = Sales - Expenses)
-   Dashboard with Stats, Recent Sales, and Low Stock Alerts

---

## 🧪 Test Setup Instructions

### Prerequisites

-   PHP 8.2+
-   Composer
-   MySQL
-   Node.js & NPM
-   Laravel Installer or use `composer create-project`

---

## 🚀 Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/suraiyaaysha/inventory-financial-reporting-system
cd inventory-financial-reporting-system
```

### 2. Install Dependencies

```bash
composer install
npm install && npm run dev
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your DB credentials:

```
DB_DATABASE=inventory_financial_reporting_system
DB_USERNAME=root(your username)
DB_PASSWORD=(your password)
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Seed Default Admin (Optional)

```bash
php artisan db:seed
        -or-
php artisan migrate:fresh --seed
```

### 6. Start the Server

```bash
php artisan serve
```

Login at: http://localhost:8000  
Default login (if seeded):

-   Email: `admin@gmail.com`
-   Password: `12345678`

---

## 🔧 Features Breakdown

### ➤ Product Management

-   Add, edit, delete products
-   Track stock changes

### ➤ Sales Entry

-   Add new sale (quantity, unit price, discount, VAT)
-   Auto calculations: subtotal, VAT, discount, total, due
-   Saves as a `Sale` and dynamically generates journal rows

### ➤ Financial Report

-   Filter by date
-   Shows: total sales, expenses, profit
-   Summary and recent sales list

### ➤ Dashboard

-   Total stock value, today’s sale
-   Recent sales table
-   Low stock alert panel

---

## 🧩 Tech Stack

-   Laravel 12
-   Livewire 3
-   Alpine.js 3
-   Tailwind CSS 4
-   Breeze Auth (Livewire version)

---

## 🙋 Support

For contact:
**Name:** Suraiya Aysha  
**Email:** hello.suraiyaaysha@gmail.com
