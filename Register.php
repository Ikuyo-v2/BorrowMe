<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    $errors = [];
    
    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        $errors[] = "All fields are required";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        $conn = db();
        // Check if email exists
        $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = "Email already registered";
        } else {
            // Insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful!";
                header("Location: Login.php");
                exit();
            } else {
                $errors[] = "Registration failed";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - BorrowMe</title>
    <link rel="stylesheet" href="login.css" />
    <style>
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="right-panel">
            <div class="overlay-text">
                <h2><strong>Hello<br />Let's be friends</strong></h2>
                <p>If you already have an account, login here and have fun</p>
                <a href="Login.php" class="register-button"><strong>Login</strong></a>
            </div>
        </div>
        <div class="left-panel">
            <h1><strong>Let's start your journey</strong></h1>
            <p>Start your journey now! Register to borrow and enjoy thousands of books online.</p>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo ($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="login-form" method="POST">
                <input type="text" name="name" placeholder="Name" 
                       value="<?php echo ($name ?? ''); ?>" required />
                <input type="email" name="email" placeholder="Email" 
                       value="<?php echo ($email ?? ''); ?>" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="confirm_password" placeholder="Confirm your password" required />
                <button type="submit" class="login-button"><strong>Register</strong></button>
            </form>
        </div>
    </div>
</body>
</html>