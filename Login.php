<?php

session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    $errors = [];
    
    if (empty($email) || empty($password)) {
        $errors[] = "All fields are required";
    } else {
        $conn = db();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
                       
            header("Location: Home.php");
            exit();
        } else {
            $errors[] = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - BorrowMe</title>
    <link rel="stylesheet" href="login.css" />
    <style>
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <h1><strong>Welcome back</strong></h1>
            <p>Welcome back to BorrowMe! Log in to borrow and explore your favorite books anytime, anywhere.</p>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo ($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="login-form" method="POST">
                <input type="email" name="email" placeholder="Email" 
                       value="<?php echo ($email ?? ''); ?>" required />
                <input type="password" name="password" placeholder="Password" required />
                <div class="options">
                    <label><input type="checkbox" name="remember" /> Remember Me</label>
                    <a href="#" class="forgot-password">Forgot Password ?</a>
                </div>
                <button type="submit" class="login-button"><strong>Login</strong></button>
            </form>
        </div>
        <div class="right-panel">
            <div class="overlay-text">
                <h2><strong>Start Your <br />journey now</strong></h2>
                <p>If you don't have an account yet, join us<br />And start your journey</p>
                <a href="Register.php" class="register-button"><strong>Register</strong></a>
            </div>
        </div>
    </div>
</body>
</html>