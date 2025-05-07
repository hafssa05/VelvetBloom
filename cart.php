<?php
session_start();
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");

if (!isset($_SESSION['client_id'])) {
    header("Location: client_auth.php");
    exit();
}

$id_client = $_SESSION['client_id'];

// Update quantity
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_qty'])) {
    $id_commande = $_POST['id_commande'];
    $qty = max(1, intval($_POST['quantite'])); // prevent 0
    $conn->query("UPDATE commande_client SET quantite = $qty WHERE id_commande = $id_commande AND id_client = $id_client");
}

// Remove item
if (isset($_GET['remove'])) {
    $id_commande = intval($_GET['remove']);
    $conn->query("DELETE FROM commande_client WHERE id_commande = $id_commande AND id_client = $id_client");
}

// Get cart items
$sql = "SELECT cc.id_commande, m.produit, m.prix, cc.quantite
        FROM commande_client cc
        JOIN materiel m ON cc.id_materiel = m.id_materiel
        WHERE cc.id_client = $id_client";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
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

    input[type="number"] {
      width: 60px;
      padding: 5px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .actions button {
      padding: 6px 12px;
      border: none;
      border-radius: 20px;
      background-color: #a0522d;
      color: white;
      cursor: pointer;
      margin-right: 8px;
    }

    .actions button:hover {
      background-color: #7b3f1d;
    }

    .total {
      text-align: right;
      font-weight: bold;
      margin-top: 20px;
      font-size: 18px;
      color: #3e2c28;
    }

    .validate-btn {
      display: inline-block;
      margin-top: 30px;
      padding: 14px 30px;
      background-color: #a0522d;
      color: white;
      border: none;
      border-radius: 30px;
      text-decoration: none;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .validate-btn:hover {
      background-color: #7b3f1d;
    }

  </style>
</head>
<body>

<div class="container">
  <h2>Your Shopping Cart</h2>

  <?php if ($result->num_rows > 0): ?>
    <form method="POST">
    <table>
      <tr>
        <th>Product</th>
        <th>Price (DH)</th>
        <th>Qty</th>
        <th>Subtotal</th>
        <th>Action</th>
      </tr>
      <?php
      $total = 0;
      while ($row = $result->fetch_assoc()):
        $subtotal = $row['prix'] * $row['quantite'];
        $total += $subtotal;
      ?>
      <tr>
        <td><?= $row['produit'] ?></td>
        <td><?= $row['prix'] ?></td>
        <td>
          <form method="POST" style="display:inline;">
            <input type="number" name="quantite" value="<?= $row['quantite'] ?>" min="1">
            <input type="hidden" name="id_commande" value="<?= $row['id_commande'] ?>">
            <button name="update_qty">Update</button>
          </form>
        </td>
        <td><?= $subtotal ?> DH</td>
        <td class="actions">
          <a href="cart.php?remove=<?= $row['id_commande'] ?>"><button type="button">Remove</button></a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
    </form>

    <div class="total">Total: <?= $total ?> DH</div>
    <a class="validate-btn" href="#">Validate Order</a>

  <?php else: ?>
    <p>Your cart is empty.</p>
  <?php endif; ?>

</div>

</body>
</html>
