<?php

/**
 * Password Fix Script
 * This script fixes the corrupted password hashes in the database
 */

include "config/db.php";

// Passwords to set
$users = [
    ['email' => 'admin@clinic.com', 'password' => 'admin123'],
    ['email' => 'doctor@clinic.com', 'password' => 'doctor123'],
    ['email' => 'patient@clinic.com', 'password' => 'patient123']
];

echo "<h2>🔐 Password Fix Script</h2>";
echo "<p>Fixing password hashes...</p>";

foreach ($users as $user) {
    $email = $user['email'];
    $password = $user['password'];
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password='$hashed' WHERE email='$email'";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Password fixed for: <strong>$email</strong><br>";
    } else {
        echo "❌ Error fixing password for: <strong>$email</strong><br>";
    }
}

echo "<hr>";
echo "<h3>✅ All passwords fixed!</h3>";
echo "<p>You can now login with:</p>";
echo "<ul>";
echo "<li><strong>Admin:</strong> admin@clinic.com / admin123</li>";
echo "<li><strong>Doctor:</strong> doctor@clinic.com / doctor123</li>";
echo "<li><strong>Patient:</strong> patient@clinic.com / patient123</li>";
echo "</ul>";
echo "<p><a href='auth/login.php' class='btn btn-primary' style='padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>Go to Login</a></p>";

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        h2 {
            color: #667eea;
        }

        h3 {
            color: #48bb78;
        }

        hr {
            margin: 20px 0;
        }

        ul {
            line-height: 2;
        }

        a {
            color: white;
        }
    </style>
</head>

<body>
</body>

</html>