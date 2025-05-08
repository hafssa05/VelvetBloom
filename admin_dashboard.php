<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit();
}

$adminName = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fff8f4;
      color: #3e2c28;
    }

    .navbar {
      background-color: #ffffff;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .logo {
      color: #a0522d;
      font-size: 24px;
      font-weight: bold;
    }

    .welcome {
      font-size: 18px;
      color: #5a3e36;
    }

    .dashboard-container {
      padding: 60px 20px;
      max-width: 1000px;
      margin: auto;
    }

    .dashboard-title {
      font-size: 28px;
      margin-bottom: 30px;
      color: #5a3e36;
    }

    .dashboard-links {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .dashboard-links a {
      background-color: #ffffff;
      border: 2px solid #f0d8ce;
      padding: 30px 40px;
      border-radius: 15px;
      text-decoration: none;
      color: #a0522d;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      transition: 0.3s ease;
      width: 220px;
      text-align: center;
    }

    .dashboard-links a:hover {
      background-color: #fce9e0;
      color: #5a3e36;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .logout {
      position: absolute;
      top: 20px;
      right: 20px;
      color: #a0522d;
      font-size: 14px;
    }

    .logout:hover {
      color: #7b3f1d;
    }

  </style>
</head>
<body>

  <div class="navbar">
    <div class="logo">Velvet Bloom Admin</div>
    <div class="welcome">Welcome, <?= htmlspecialchars($adminName) ?>!</div>
  </div>

  <div class="dashboard-container">
    <h2 class="dashboard-title">Dashboard</h2>

    <div class="dashboard-links">
      <a href="manage_products.php">📦 Manage Products</a>
      <a href="manage_clients.php">👥 Manage Clients</a>
      <a href="total_orders.php">📝 View Orders</a>
      <a href="logout.php">🚪 Logout</a>
    </div>
  </div>

</body>
</html>
