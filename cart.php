<?php
session_start();
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");

if (!isset($_SESSION['client_id'])) {
    header("Location: client_auth.php");
    exit();
}

$id_client = $_SESSION['client_id'];

$confirmationMessage = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['validate_order'])) {
    // You can insert logic here to move cart to 'orders' table if needed

    // Clear the cart
    $conn->query("DELETE FROM commande_client WHERE id_client = $id_client");

    // Confirmation message
    $confirmationMessage = "✅ Votre commande a été validée avec succès !";
}


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

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #ffffff;
      padding: 15px 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .logo-button {
      color: #a0522d;
      font-size: 24px;
      font-weight: bold;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .logo-button:hover {
      color: #7b3f1d;
      background-color: #fff1ec;
      border-radius: 50px;
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
      color: #5a3e36;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .back-to-shop-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 25px;
      background-color: #a0522d;
      color: white;
      text-decoration: none;
      border-radius: 30px;
      font-size: 16px;
      text-align: center;
    }

    .back-to-shop-btn:hover {
      background-color: #7b3f1d;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <!-- Clickable Velvet Bloom Logo -->
  <a href="index.php" class="logo-button">Velvet Bloom</a> <!-- Link to home or wherever you want -->

  <ul class="nav-links">
    <li><a href="orders.php">Order History</a></li> <!-- Replace with actual link to order history -->
    <li><a href="logout.php">Logout</a></li> <!-- Replace with actual logout script -->
  </ul>
</nav>

<div class="container">
<h2>Your Shopping Cart</h2>
<?php if (!empty($confirmationMessage)): ?>
  <p style="color: green; font-weight: bold;"><?= $confirmationMessage ?></p>
<?php endif; ?>


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
    <form method="POST">
  <input type="hidden" name="validate_order" value="1">
  <button type="submit" class="validate-btn">Valider la commande</button>
</form>


  <?php else: ?>
    <p>Your cart is empty.</p>
  <?php endif; ?>

  <!-- Back to Shop button -->
  <a href="shop.php" class="back-to-shop-btn">Back to Shop</a>

</div>

</body>
</html>
