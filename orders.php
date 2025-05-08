<?php
session_start();
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");

if (!isset($_SESSION['client_id'])) {
    header("Location: client_auth.php");
    exit();
}

$id_client = $_SESSION['client_id'];

$sql = "SELECT cc.date_commande, m.produit, m.prix, cc.quantite
        FROM commande_client cc
        JOIN materiel m ON cc.id_materiel = m.id_materiel
        WHERE cc.id_client = $id_client AND cc.date_commande IS NOT NULL AND statut = 'Confirmed'
        ORDER BY cc.date_commande DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Orders</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff8f4;
      margin: 0;
      padding: 0;
    }

    .container {
      padding: 60px 20px;
      max-width: 800px;
      margin: auto;
    }

    h2 {
      color: #a0522d;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 16px;
      text-align: left;
      border-bottom: 1px solid #f2e7e1;
    }

    th {
      background-color: #fce9e0;
      color: #5a3e36;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #ffffff;
      padding: 15px 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .logo-button {
      color: #a0522d;
      font-size: 24px;
      font-weight: bold;
      text-decoration: none;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .nav-links a {
      text-decoration: none;
      color: #3e2c28;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 30px;
      transition: all 0.3s ease;
    }

    .nav-links a:hover {
      background-color: #fce9e0;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 30px;
      font-weight: bold;
      color: #a0522d;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="logo-button">Velvet Bloom</a>
  <ul class="nav-links">
    <li><a href="cart.php">Cart</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</nav>

<div class="container">
  <h2>Order History</h2>

  <?php if ($result->num_rows > 0): ?>
  <table>
    <tr>
      <th>Date</th>
      <th>Product</th>
      <th>Qty</th>
      <th>Price</th>
      <th>Total</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['date_commande'] ?></td>
      <td><?= $row['produit'] ?></td>
      <td><?= $row['quantite'] ?></td>
      <td><?= $row['prix'] ?> DH</td>
      <td><?= $row['prix'] * $row['quantite'] ?> DH</td>
    </tr>
    <?php endwhile; ?>
  </table>
  <?php else: ?>
    <p>You have no past orders.</p>
  <?php endif; ?>
</div>

<!-- Back to Shop Button -->
<a href="shop.php" class="back-link">← Back to Shop</a>

</body>
</html>
