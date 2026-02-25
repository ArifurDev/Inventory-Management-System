# 📦 Inventory Management System

With Accounting Journal & Date-wise Financial Report

This is a Laravel-based Inventory Management System integrated with
proper double-entry accounting and financial reporting.

The system manages products, stock, sales transactions, VAT calculation,
discount handling, partial payments, and automatic journal entries.

------------------------------------------------------------------------

## 🚀 Features

-   Product Management
-   Opening Stock Management
-   Sales Module
-   Discount Support
-   VAT Calculation (5%)
-   Partial Payment Handling
-   Due Amount Calculation
-   Automatic Stock Reduction
-   Automatic Double-Entry Journal Entries
-   Date-wise Financial Reporting
-   Demo Data Seeder (10 Records)

------------------------------------------------------------------------

## 🧰 Tech Stack

-   Laravel 11
-   PHP 8+
-   MySQL
-   Bootstrap 5 (Blade UI)

------------------------------------------------------------------------

# 📦 Installation Guide

## 1️⃣ Clone the Repository

    git clone https://github.com/ArifurDev/inventory-management.git
    cd inventory-management

------------------------------------------------------------------------

## 2️⃣ Install Backend Dependencies

    composer install

------------------------------------------------------------------------

## 3️⃣ Install Frontend Dependencies

    npm install
    npm run build

------------------------------------------------------------------------

## 4️⃣ Create Environment File

    cp .env.example .env

------------------------------------------------------------------------

## 5️⃣ Configure Environment Variables

Update `.env`:

APP_NAME=InventorySystem\
APP_ENV=local\
APP_DEBUG=true\
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql\
DB_HOST=127.0.0.1\
DB_PORT=3306\
DB_DATABASE=your_database_name\
DB_USERNAME=your_database_username\
DB_PASSWORD=your_database_password

------------------------------------------------------------------------

## 6️⃣ Generate Application Key

    php artisan key:generate

------------------------------------------------------------------------

## 7️⃣ Run Migrations & Seed Demo Data

    php artisan migrate:fresh --seed

This will generate:

-   10 Products
-   10 Sales
-   Journal Entries
-   Stock Adjustments
-   Random Discount & Payment Data

------------------------------------------------------------------------

## 8️⃣ Start Development Server

    php artisan serve

Visit:

http://127.0.0.1:8000

------------------------------------------------------------------------

# 💰 Accounting Logic

For every sale, the system generates:

1.  Accounts Receivable (Debit)
2.  Sales Revenue (Credit)
3.  VAT Payable (Credit)
4.  Cash (Debit if paid)
5.  Cost of Goods Sold (Debit)
6.  Inventory (Credit)

This ensures proper double-entry accounting principles.

------------------------------------------------------------------------

# 📊 Date-wise Financial Report

The system provides filtering by:

-   From Date
-   To Date

It calculates:

-   Total Sales (sum of total_amount)
-   Total Expense (Cost of Goods Sold)

------------------------------------------------------------------------

# 🛡 Security Features

-   CSRF Protection
-   Request Validation
-   Database Transactions
-   Stock Validation
-   Mass Assignment Protection
-   Clean Naming Convention
-   No Raw SQL Injection

------------------------------------------------------------------------

# 🚀 Production Setup

Update `.env`:

APP_ENV=production\
APP_DEBUG=false

Then run:

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

Ensure:

-   Correct database credentials
-   Domain points to /public
-   HTTPS enabled

------------------------------------------------------------------------

# 👨‍💻 Author

Arifur Rahman Rifat\
GitHub: https://github.com/ArifurDev

------------------------------------------------------------------------

# 📜 License

This project is built for educational and demonstration purposes.
