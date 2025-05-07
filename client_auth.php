<?php
session_start();
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");

$loginError = '';
$signupSuccess = '';
$signupError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];

        $check = $conn->query("SELECT * FROM client WHERE email='$email'");
        if ($check->num_rows === 1) {
            $user = $check->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['client'] = $user['email'];
                header("Location: shop.php"); // Redirect directly to shop
                exit();
            } else {
                $loginError = "Invalid email or password.";
            }
        } else {
            $loginError = "Invalid email or password.";
        }
    }

    if (isset($_POST['signup'])) {
        $name = $_POST['signup_name'];
        $email = $_POST['signup_email'];
        $password = password_hash($_POST['signup_password'], PASSWORD_DEFAULT);
        $address = $_POST['signup_address'];

        $exists = $conn->query("SELECT * FROM client WHERE email='$email'");
        if ($exists->num_rows > 0) {
            $signupError = "This email is already registered.";
        } else {
            $insert = $conn->query("INSERT INTO client (nom, email, password, adresse) VALUES ('$name', '$email', '$password', '$address')");
            if ($insert) {
                $_SESSION['client'] = $email;

                // Optional: retrieve client ID if you need it
                $clientResult = $conn->query("SELECT id_client FROM client WHERE email='$email'");
                if ($clientRow = $clientResult->fetch_assoc()) {
                    $_SESSION['client_id'] = $clientRow['id_client'];
                }

                header("Location: shop.php");
                exit();
            } else {
                $signupError = "Something went wrong. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Client Login/Signup</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #fffaf4, #ffe6e0);
      font-family: 'Poppins', sans-serif;
    }

    .container {
      width: 100%;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .flip-card {
      background-color: transparent;
      width: 360px;
      height: 500px;
      perspective: 1000px;
    }

    .flip-card-inner {
      width: 100%;
      height: 100%;
      transition: transform 0.8s;
      transform-style: preserve-3d;
      position: relative;
    }

    .flipped {
      transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
      width: 100%;
      height: 100%;
      background: white;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      padding: 40px;
      box-sizing: border-box;
      position: absolute;
      backface-visibility: hidden;
    }

    .flip-card-back {
      transform: rotateY(180deg);
    }

    h2 {
      margin-bottom: 25px;
      color: #a0522d;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: none;
      border-bottom: 2px solid #a0522d;
      background: transparent;
      font-size: 15px;
      outline: none;
      color: #3e2c28;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #a0522d;
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      font-size: 15px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #7b3f1d;
    }

    .toggle-link {
      margin-top: 10px;
      font-size: 14px;
      color: #5a3e36;
      cursor: pointer;
      text-align: center;
    }

    .error, .success {
      color: #a0522d;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
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

.admin-link {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #a0522d;
  color: white;
  padding: 12px 20px;
  border-radius: 30px;
  text-decoration: none;
  font-family: 'Poppins', sans-serif;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  transition: background-color 0.3s;
}

.admin-link:hover {
  background-color: #7b3f1d;
}


  </style>
</head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<body>

 <!-- NAVE SECTION -->
<nav class="navbar">
  <a href="admin_login.php" class="admin-link">🔐 Admin Access</a>
  <a href="index.php" class="logo-button">Velvet Bloom</a>
  <ul class="nav-links">
    <li><a href="client_auth.php">Sign up</a></li>
    <li><a href="shop.php">Shop</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
</nav>


<div class="container">
  <div class="flip-card">
    <div class="flip-card-inner" id="flipCard">

      <!-- LOGIN -->
      <div class="flip-card-front">
        <form method="POST">
          <h2>Login</h2>
          <input type="email" name="login_email" placeholder="Email" required>
          <div style="position: relative;">
  <input type="password" id="login_password" name="login_password" placeholder="Password" required>
  <span onclick="togglePassword('login_password', this)" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
  <i class="fa-solid fa-eye" id="eye_login"></i>
</span>

</div>

          <?php if ($loginError): ?><div class="error"><?= $loginError ?></div><?php endif; ?>
          <?php if ($signupSuccess): ?><div class="success"><?= $signupSuccess ?></div><?php endif; ?>
          <button type="submit" name="login">Login</button>
          <div class="toggle-link" onclick="flipToSignup()">Don’t have an account? Sign up</div>
        </form>
      </div>

      <!-- SIGNUP -->
      <div class="flip-card-back">
        <form method="POST">
          <h2>Sign Up</h2>
          <input type="text" name="signup_name" placeholder="Your Name" required>
          <input type="email" name="signup_email" placeholder="Email" required>
          <div style="position: relative;">
  <input type="password" id="signup_password" name="signup_password" placeholder="Password" required>
  <span onclick="togglePassword('signup_password', this)" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
  <i class="fa-solid fa-eye" id="eye_signup"></i>
</span>


</div>

          <input type="text" name="signup_address" placeholder="Address" required>
          <?php if ($signupError): ?><div class="error"><?= $signupError ?></div><?php endif; ?>
          <button type="submit" name="signup">Sign Up</button>
          <div class="toggle-link" onclick="flipToLogin()">Already have an account? Login</div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
  function flipToSignup() {
    document.getElementById('flipCard').classList.add('flipped');
  }

  function flipToLogin() {
    document.getElementById('flipCard').classList.remove('flipped');
  }

  
  function togglePassword(inputId, iconSpan) {
  const input = document.getElementById(inputId);
  const eyeIcon = iconSpan.querySelector('i');
  
  if (input.type === "password") {
    input.type = "text";
    eyeIcon.classList.remove('fa-eye');
    eyeIcon.classList.add('fa-eye-slash');
  } else {
    input.type = "password";
    eyeIcon.classList.remove('fa-eye-slash');
    eyeIcon.classList.add('fa-eye');
  }
}

</script>

</body>
</html>
