<?php
session_start();
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");

if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['client_id'];
$client_email = $_SESSION['client']; // Email from session

// Fetch client details
$query = $conn->query("SELECT * FROM client WHERE id_client = '$client_id'");
$clientData = $query->fetch_assoc();

// Handle form submission for updating client info
$updateError = '';
$updateSuccess = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $updatePassword = ", password='$password'";
    } else {
        $updatePassword = '';
    }

    $sql = "UPDATE client SET nom='$name', email='$email', adresse='$address' $updatePassword WHERE id_client='$client_id'";
    if ($conn->query($sql)) {
        $_SESSION['client'] = $email;
        $updateSuccess = "Information updated successfully!";
    } else {
        $updateError = "Something went wrong. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffaf4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #a0522d;
            margin-bottom: 30px;
        }

        .success, .error {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .success { color: green; }
        .error { color: red; }

        .profile-container {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-image {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info {
            flex-grow: 1;
        }

        .info-text {
            margin: 6px 0;
            font-size: 17px;
            color: #333;
        }

        .email-link {
            color: #a0522d;
            font-weight: bold;
            cursor: pointer;
        }

        .profile-box {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background-color: #f0f0f0;
            border-radius: 8px;
            margin: 10px 0;
            font-size: 18px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-box:hover {
            background-color: #dcdcdc;
        }

        .editable-field {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 8px 12px;
            width: 100%;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .editable-field:focus {
            border-color: #a0522d;
            outline: none;
        }

        #update-email-form {
            display: none;
            margin-top: 20px;
        }

        #update-email-form form {
            display: grid;
            gap: 15px;
        }

        #update-email-form input {
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        #update-email-form button {
            padding: 12px;
            background-color: #a0522d;
            color: white;
            font-size: 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        #update-email-form button:hover {
            background-color: #7b3f1d;
        }

        .back-link {
            display: block;
            text-align: left;
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

<div class="container">
    <!-- Back to Shop link at the top -->
    <a href="shop.php" class="back-link">← Back to Shop</a>

    <h2>Your Profile</h2>

    <!-- Success or Error Messages -->
    <?php if ($updateSuccess): ?>
        <div class="success"><?= $updateSuccess ?></div>
    <?php endif; ?>
    <?php if ($updateError): ?>
        <div class="error"><?= $updateError ?></div>
    <?php endif; ?>

    <div class="profile-container">
        <div class="profile-image">
            <img src="img/default-profile-icon.png" alt="Default Icon" class="profile-img">
        </div>
        <div class="profile-info">
            <div class="profile-box" onclick="toggleForm('email-form')">
                <span>Email:</span>
                <span><?= $clientData['email'] ?></span>
            </div>
            <div class="profile-box" onclick="toggleForm('name-form')">
                <span>Name:</span>
                <span><?= $clientData['nom'] ?></span>
            </div>
            <div class="profile-box" onclick="toggleForm('address-form')">
                <span>Address:</span>
                <span><?= $clientData['adresse'] ?></span>
            </div>
        </div>
    </div>

    <!-- Update Form (Hidden Initially) -->
    <div id="update-email-form">
        <h3>Update Your Information</h3>
        <form method="POST">
            <div id="email-form" class="hidden">
                <input type="email" name="email" value="<?= $clientData['email'] ?>" class="editable-field" required placeholder="New Email">
            </div>
            <div id="name-form" class="hidden">
                <input type="text" name="name" value="<?= $clientData['nom'] ?>" class="editable-field" required placeholder="New Name">
            </div>
            <div id="address-form" class="hidden">
                <input type="text" name="address" value="<?= $clientData['adresse'] ?>" class="editable-field" required placeholder="New Address">
            </div>
            <input type="password" name="password" class="editable-field" placeholder="Current Password (for security)">
            <input type="password" name="new_password" class="editable-field" placeholder="New Password">
            <input type="password" name="confirm_password" class="editable-field" placeholder="Confirm New Password">
            <button type="submit" name="update">Update Information</button>
        </form>
    </div>
</div>

<script>
    function toggleForm(formId) {
        const forms = ['email-form', 'name-form', 'address-form'];
        forms.forEach(function(id) {
            const formElement = document.getElementById(id);
            formElement.classList.add('hidden');
        });

        const currentForm = document.getElementById(formId);
        currentForm.classList.remove('hidden');

        // Show update form
        document.getElementById('update-email-form').style.display = 'block';
    }
</script>

</body>
</html>
