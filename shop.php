<?php
session_start();
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");

// Check if client is logged in
$clientLoggedIn = isset($_SESSION['client']);
$client_id = isset($_SESSION['client_id']) ? intval($_SESSION['client_id']) : 0;

// Handle "Add to Cart" if logged in
if (isset($_GET['add']) && $clientLoggedIn) {
    $id_materiel = intval($_GET['add']);
    $check = $conn->query("SELECT * FROM commande_client WHERE id_client = $client_id AND id_materiel = $id_materiel AND statut = 'Added to cart'" );

    if ($check->num_rows > 0) {
        // If already exists, just increase quantity
        $conn->query("UPDATE commande_client SET quantite = quantite + 1 WHERE id_client = $client_id AND id_materiel = $id_materiel");
    } else {
        // Else, insert new row with the current date and statut as "Added to cart"
        $stmt = $conn->prepare("INSERT INTO commande_client (id_client, id_materiel, quantite, date_commande, statut) VALUES (?, ?, 1, ?, ?)");
        $current_date = date("Y-m-d");  // Current date in the format YYYY-MM-DD
        $statut = "Added to cart";  // Statut value
        $stmt->bind_param("iiss", $client_id, $id_materiel, $current_date, $statut);
        $stmt->execute();
        $stmt->close();
    }
    
    // Set a session variable to trigger the toast notification
    $_SESSION['cart_notification'] = true;

    header("Location: shop.php");
    exit();
}


// Load products
$products = $conn->query("SELECT * FROM materiel");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop - Velvet Bloom</title>
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <div id="toast" class="toast">
  Item added to cart!
</div>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fff8f4;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #ffffff;
      padding: 15px 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .logo a {
      font-weight: bold;
      font-size: 24px;
      color: #a0522d;
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
      transition: 0.3s ease;
    }

    .nav-links a:hover {
      background-color: #fce9e0;
    }

    .shop-container {
      padding: 50px 20px;
      text-align: center;
    }

    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .product-card {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      width: 260px;
    }

    .product-card img {
      width: 100%;
      height: 240px;
      border-radius: 10px;
  object-fit: contain; /* show full image */
  border-radius: 10px; /* Match the card's border radius */
  margin-bottom: 15px;

    }

    .product-card h3 {
      color: #a0522d;
      margin: 10px 0 5px;
    }

    .product-card p {
      font-size: 14px;
      color: #3e2c28;
    }

    .product-card span {
      font-weight: bold;
      display: block;
      margin: 8px 0;
      color: #5a3e36;
    }

    .shop-button {
      display: inline-block;
      background-color: #a0522d;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 25px;
      text-decoration: none;
      font-size: 14px;
      transition: background-color 0.3s ease;
      margin-top: 10px;
    }

    .shop-button:hover {
      background-color: #7b3f1d;
    }

    
  .toast {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #00FF00;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    bottom: 30px;
    font-size: 17px;
    opacity: 0;
    transition: opacity 0.5s, bottom 0.5s;
  }

  .toast.show {
    visibility: visible;
    opacity: 1;
    bottom: 50px;
  }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="logo"><a href="index.php">Velvet Bloom</a></div>
  <ul class="nav-links">
    <li><a href="shop.php">Shop</a></li>
    <?php if ($clientLoggedIn): ?>
      <li><a href="settings.php">Settings</a></li>
      <li><a href="cart.php">Cart</a></li>
      <li><a href="orders.php">Order History</a></li>
      <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="client_auth.php">Signup</a></li>
    <?php endif; ?>
  </ul>
</nav>

<!-- Shop -->
<div class="shop-container">
  <h2>Explore Our Full Collection</h2>
  <div class="products">
    <?php while ($row = $products->fetch_assoc()): ?>
      <div class="product-card">
        <img src="img/<?= $row['image'] ?>" alt="<?= $row['produit'] ?>">
        <h3><?= $row['produit'] ?></h3>
        <p><?= $row['caracteristique'] ?></p>
        <span><?= $row['prix'] ?> DH</span>
        <?php if ($clientLoggedIn): ?>
          <a href="shop.php?add=<?= $row['id_materiel'] ?>" class="shop-button">Add to Cart</a>
        <?php else: ?>
          <a href="client_auth.php" class="shop-button"> Buy Now</a>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</div>
<script>
  // Function to show the toast notification
  function showToast() {
    var toast = document.getElementById("toast");
    toast.className = "toast show";
    setTimeout(function() {
      toast.className = toast.className.replace("show", "");
    }, 3000); // Toast disappears after 3 seconds
  }
  <?php if (isset($_SESSION['cart_notification']) && $_SESSION['cart_notification']): ?>
    showToast();
    <?php unset($_SESSION['cart_notification']); ?> // Clear the session flag after showing the toast
  <?php endif; ?>
</script>
</body>
</html>
