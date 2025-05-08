<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM administrateur WHERE nom = '$nom' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $nom;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $message = "❌ Accès non autorisé";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #fff5f0, #ffe4e1);
      font-family: 'Poppins', sans-serif;
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

    .login-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding-top: 60px;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      width: 320px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 30px;
      color: #5a3e36;
    }

    .input-group {
      position: relative;
      margin-bottom: 25px;
    }

    .input-group input {
      width: 100%;
      padding: 14px 10px;
      border: none;
      border-bottom: 2px solid #a0522d;
      background: transparent;
      outline: none;
      font-size: 16px;
      color: #3e2c28;
    }

    .input-group label {
      position: absolute;
      top: 14px;
      left: 10px;
      color: #a0522d;
      transition: 0.3s ease;
      pointer-events: none;
    }

    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
      top: -10px;
      font-size: 12px;
      color: #a0522d;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #a0522d;
      border: none;
      color: white;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      font-family: 'Poppins', sans-serif;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #7b3f1d;
    }

    .error {
      color: red;
      margin-top: 15px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Updated Navbar -->
<nav class="navbar">
  <a href="index.php" class="logo-button">Velvet Bloom</a>
  <ul class="nav-links">
    <li><a href="client_auth.php">Sign up</a></li>
    <!-- Updated Shop link -->
    <li><a href="<?php echo isset($_SESSION['client']) ? 'shop.php' : 'client_auth.php'; ?>">Shop</a></li>
  </ul>
</nav>

<!-- Login Form -->
<div class="login-wrapper">
  <div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST" autocomplete="on">
      <div class="input-group">
        <input type="text" name="nom" required placeholder=" " autocomplete="username">
        <label>Nom d'utilisateur</label>
      </div>
      <div class="input-group">
        <input type="password" name="password" required placeholder=" " autocomplete="current-password">
        <label>Mot de passe</label>
      </div>
      <button type="submit">Login</button>
      <?php if ($message): ?>
        <div class="error"><?= $message ?></div>
      <?php endif; ?>
    </form>
  </div>
</div>

</body>
</html>
