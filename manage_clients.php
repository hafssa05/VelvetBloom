<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");

// Handle deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM client WHERE id_client = $id");
    header("Location: manage_clients.php");
    exit();
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_client'])) {
    $id = $_POST['id_client'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $conn->query("UPDATE client SET nom='$nom', email='$email', adresse='$adresse' WHERE id_client = $id");
}

// Fetch clients
$clients = $conn->query("SELECT * FROM client");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Clients</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff8f4;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #ffffff;
      padding: 15px 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar .logo {
      color: #a0522d;
      font-size: 24px;
      font-weight: bold;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
    }

    h2 {
      color: #a0522d;
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 16px;
      border-bottom: 1px solid #f3eae6;
      text-align: left;
    }

    th {
      background-color: #fce9e0;
      color: #5a3e36;
    }

    tr:last-child td {
      border-bottom: none;
    }

    input[type="text"], input[type="email"] {
      width: 90%;
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-family: 'Poppins', sans-serif;
    }

    .actions {
      display: flex;
      gap: 10px;
    }

    .actions button, .actions a {
      background-color: #a0522d;
      color: white;
      padding: 6px 14px;
      border: none;
      border-radius: 20px;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .actions button:hover, .actions a:hover {
      background-color: #7b3f1d;
    }

    form {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      font-weight: bold;
      color: #a0522d;
    }

    .back-link:hover {
      color: #7b3f1d;
    }

  </style>
</head>
<body>

<div class="navbar">
  <div class="logo">Velvet Bloom Admin</div>
  <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

<div class="container">
  <h2>Manage Clients</h2>
  <table>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Address</th>
      <th>Actions</th>
    </tr>
    <?php while($client = $clients->fetch_assoc()): ?>
      <tr>
        <form method="POST">
          <td><input type="text" name="nom" value="<?= htmlspecialchars($client['nom']) ?>"></td>
          <td><input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>"></td>
          <td><input type="text" name="adresse" value="<?= htmlspecialchars($client['adresse']) ?>"></td>
          <td class="actions">
            <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
            <button type="submit" name="update_client">Update</button>
            <a href="manage_clients.php?delete=<?= $client['id_client'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </form>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>
