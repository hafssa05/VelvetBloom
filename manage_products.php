<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit();
}

$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle Deletion
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM materiel WHERE id_materiel = $id");
}

// Handle New Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
  $produit = $_POST['produit'];
  $prix = $_POST['prix'];
  $caracteristique = $_POST['caracteristique'];
  $conn->query("INSERT INTO materiel (produit, prix, caracteristique) VALUES ('$produit', '$prix', '$caracteristique')");
}

// Get Products
$result = $conn->query("SELECT * FROM materiel ORDER BY id_materiel DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff8f4;
      margin: 0;
      padding: 0;
    }

    .container {
      padding: 50px;
      max-width: 1000px;
      margin: auto;
    }

    h2 {
      color: #a0522d;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
    }

    table th, table td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #fce9e0;
      color: #5a3e36;
    }

    form input, form textarea {
      padding: 10px;
      margin: 8px 0;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-family: 'Poppins', sans-serif;
    }

    form button {
      background-color: #a0522d;
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 14px;
      margin-top: 10px;
    }

    form button:hover {
      background-color: #7b3f1d;
    }

    .delete-btn {
      background-color: #ff9999;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 8px;
      cursor: pointer;
    }

    .delete-btn:hover {
      background-color: #cc0000;
    }

    .back-link {
      display: inline-block;
      margin-bottom: 20px;
      color: #a0522d;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
  <h2>Manage Products</h2>

  <!-- Product List -->
  <table>
    <tr>
      <th>ID</th>
      <th>Product</th>
      <th>Price (DH)</th>
      <th>Description</th>
      <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id_materiel'] ?></td>
        <td><?= htmlspecialchars($row['produit']) ?></td>
        <td><?= htmlspecialchars($row['prix']) ?></td>
        <td><?= htmlspecialchars($row['caracteristique']) ?></td>
        <td>
          <a href="?delete=<?= $row['id_materiel'] ?>" class="delete-btn" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

  <!-- Add Product Form -->
  <h3>Add New Product</h3>
  <form method="POST">
    <input type="text" name="produit" placeholder="Product Name" required>
    <input type="text" name="prix" placeholder="Price in DH" required>
    <textarea name="caracteristique" placeholder="Product Description" required></textarea>
    <button type="submit" name="add_product">Add Product</button>
  </form>
</div>

</body>
</html>
