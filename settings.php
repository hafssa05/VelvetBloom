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
    $address = $_POST['address'];
    $currentPassword = $_POST['password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if the current password matches the stored password
    if (!empty($currentPassword)) {
        if (!password_verify($currentPassword, $clientData['password'])) {
            $updateError = "Current password is incorrect.";
        } else {
            // Validate new password and confirm password
            if ($newPassword != $confirmPassword) {
                $updateError = "New password and confirm password do not match.";
            } else {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updatePassword = ", password='$hashedPassword'";
            }
        }
    }

    // Update client address and password (if provided)
    $sql = "UPDATE client SET adresse='$address' $updatePassword WHERE id_client='$client_id'";
    if ($conn->query($sql)) {
        // Refresh client data from the database
        $query = $conn->query("SELECT * FROM client WHERE id_client = '$client_id'");
        $clientData = $query->fetch_assoc();

        // Set success message
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
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
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

        #update-address-form {
            display: none;
            margin-top: 20px;
        }

        #update-address-form form {
            display: grid;
            gap: 15px;
        }

        #update-address-form input {
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        #update-address-form button {
            padding: 12px;
            background-color: #a0522d;
            color: white;
            font-size: 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        #update-address-form button:hover {
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
            <div class="profile-box">
                <span>Email:</span>
                <span><?= $clientData['email'] ?></span>
            </div>
            <div class="profile-box">
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
    <div id="update-address-form">
        <h3>Update Your Address</h3>
        <form method="POST">
            <div id="address-form" class="hidden">
                <input type="text" name="address" value="<?= $clientData['adresse'] ?>" class="editable-field" required placeholder="New Address">
            </div>
            <input type="password" name="password" class="editable-field" placeholder="Current Password (for security)" required>
            <input type="password" name="new_password" class="editable-field" placeholder="New Password" required>
            <input type="password" name="confirm_password" class="editable-field" placeholder="Confirm New Password" required>
            <button type="submit" name="update">Update Information</button>
        </form>
    </div>
</div>

<script>
    function toggleForm(formId) {
        // Only toggle visibility for address form
        const addressForm = document.getElementById(formId);
        addressForm.classList.remove('hidden');

        // Show update form
        document.getElementById('update-address-form').style.display = 'block';
    }
</script>

</body>
</html>
