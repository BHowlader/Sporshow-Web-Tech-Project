# Sporshow E-Commerce Store — Delivery Manager Module

A multi-vendor online marketplace built with PHP, MySQL, HTML/CSS, and JavaScript (AJAX). This module covers the Delivery Manager role — managing delivery agents, zones, order dispatch, live tracking, and delivery history.

## Prerequisites

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP)

## Setup

1. **Start XAMPP** — Open XAMPP Control Panel and start both **Apache** and **MySQL**.

2. **Copy project** — Place this folder inside the XAMPP `htdocs` directory:
   - Windows: `C:\xampp\htdocs\`
   - Mac: `/Applications/XAMPP/htdocs/`

3. **Create database** — Open http://localhost/phpmyadmin, click the **SQL** tab, paste the contents of `sql/schema.sql`, and click **Go**.

4. **Import seed data** — In the same **SQL** tab, paste the contents of `sql/seed.sql` and click **Go**.

5. **Open the app** — Visit http://localhost/Sporshow%20Web%20Tech%20Project/

## Login

| Field    | Value              |
|----------|--------------------|
| Email    | dm@sporshow.com    |
| Password | password123        |

## Project Structure

```
├── index.php                  Router
├── config/
│   ├── database.php           DB connection
│   └── auth.php               Session & access control
├── models/                    Database queries (Model)
├── controllers/               Request handling (Controller)
├── views/delivery/            HTML pages (View)
├── api/
│   └── update_delivery_status.php   AJAX endpoint (JSON)
├── assets/
│   ├── css/style.css
│   └── js/app.js
└── sql/
    ├── schema.sql             Database tables
    └── seed.sql               Demo data
```

## Tech Stack

- PHP 8 (server-side logic)
- MySQL (database, mysqli prepared statements)
- HTML/CSS (frontend)
- JavaScript with XMLHttpRequest (AJAX status updates)
- MVC architecture
