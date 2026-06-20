# SwiftCart - E-Commerce Management System

A full-stack E-Commerce Management System built with **Laravel 12**, **PHP 8.2**, **SQLite**, **Vite**, and **Tailwind CSS**. The platform provides separate dashboards for **Admins** and **Buyers**, enabling efficient product management, order processing, payment tracking, and customer feedback management.

## 🚀 Features

### 👨‍💼 Admin Panel

* Secure admin authentication
* Product management (Add, Edit, Delete products)
* Order management and status updates
* Payment monitoring
* Sales tracking and reporting
* Customer feedback management
* Dashboard with business statistics

### 🛍️ Buyer Panel

* User registration and login
* Browse products
* Shopping cart functionality
* Checkout and order placement
* Order tracking
* Profile management
* Password update
* Feedback submission

### 📦 Product Management

* Product categories
* Product images support
* Inventory organization
* Category-product relationships

### 💳 Order & Payment System

* Cart management
* Order processing
* Payment records
* Order status tracking

### 👤 User Management

* Role-based access control (Admin & Buyer)
* User authentication and authorization
* Profile customization

## 🛠️ Technologies Used

* **Backend:** Laravel 12, PHP 8.2
* **Frontend:** Blade Templates, Tailwind CSS
* **Build Tool:** Vite
* **Database:** SQLite
* **Authentication:** Laravel Authentication
* **Version Control:** Git & GitHub

## 📂 Database Structure

The system includes:

* Users
* Products
* Categories
* Cart
* Orders
* Order Items
* Payments
* Sales
* Feedbacks

## 🎯 Project Objective

The goal of this project is to provide a complete e-commerce solution where administrators can manage products, orders, and customers while buyers can easily browse products, place orders, track deliveries, and share feedback.

## ⚙️ Installation

```bash
git clone https://github.com/Arsal908029/SwiftCart-E-Commerce-Management-System.git
cd SwiftCart-E-Commerce-Management-System

composer install
npm install

cp .env.example .env

php artisan key:generate
php artisan migrate --seed

npm run dev
php artisan serve
```

## 📸 Future Improvements

* Online payment gateway integration
* Wishlist functionality
* Product reviews and ratings
* Email notifications
* Advanced analytics dashboard
* Multi-vendor support

---

**Developed using Laravel 12 to demonstrate modern web application development, database management, authentication, and e-commerce workflows.**
