<h1 align="center">🛒 SIM Penjualan - TokoArya</h1>
<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.x-blue?style=flat&logo=php" />
  <img src="https://img.shields.io/badge/MySQL-5.x-orange?style=flat&logo=mysql" />
  <img src="https://img.shields.io/badge/Bootstrap-5.x-purple?style=flat&logo=bootstrap" />
  <img src="https://img.shields.io/badge/Status-Active-success?style=flat" />
</p>

<p align="center"><em>Simple Sales Management System using PHP + MySQL + Bootstrap</em></p>

---

## 📸 Preview Screenshot

<p align="center">
  <img src="https://user-images.githubusercontent.com/your-image-id/dashboard-example.png" width="700">
</p>

> _Dashboard, Login, Transactions, and Sales Report View_

---

## 🚀 Features

- 🔐 Multi-role login (Admin, Cashier, Owner)
- 🧾 Real-time transactions + stock deduction
- 📊 Monthly sales reports with charts
- 📦 Product management (CRUD)
- 👥 User management with profile photo upload
- 🖨️ Printable reports & export-ready
- 💡 Clean Bootstrap 5 UI

---

## 🧱 Project Structure

tokoarya/
├── config/ # DB connection
├── modules/ # Modules: barang, penjualan, laporan, user
├── uploads/user/ # Profile photo storage
├── views/ # Header, footer, sidebar
├── index.php # Dashboard
├── login.php # Login page
└── README.md


---

## 📥 Installation

1. **Clone this repo**
   ```bash
   git clone https://github.com/yourusername/tokoarya.git

Import SQL

Open phpMyAdmin

Create database tokoarya

Import tokoarya.sql

Configure DB connection

Edit config/database.php
$conn = mysqli_connect("localhost", "root", "", "tokoarya");

Run on browser : http://localhost/tokoarya/

🔑 Default Login
Role	Username	Password
Admin	admin	admin123
Cashier	kasir	kasir123
Owner	owner	owner123

Passwords are hashed using password_hash().

🔧 Built With
PHP Native (no framework)
MySQL
Bootstrap 5
Chart.js
XAMPP / Laragon (Localhost dev)

🤝 Author
👨‍💻 Muh. Arya Rafandi
📍 Universitas Muhammadiyah Papua
📧 aryamhmmd505@gmail.com

📜 License
This project is open-source, created for learning & academic purposes. Feel free to modify and adapt it for small business or personal usage!

⭐ Screenshot Gallery (Optional)
Add more screenshots here:



🔗 Extra Ideas
Want to take this further?

✨ Add pagination or search

🌐 Host it on real web hosting

📱 Make it responsive for mobile

🔐 Add role-based access control per module

🙌 Thanks for checking out this project!
Don't forget to ⭐ Star this repo if it's helpful!

