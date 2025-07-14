<?php
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username;
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .input-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            margin-left: -22px;
            border-radius: 25px;
            border: 2px solid #6f73ff;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            outline: none;
            font-size: 16px;
            transition: 0.3s;
        }

        .input-box input:focus {
            border-color: #a78bfa;
            transform: scale(1.02);

        }

        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-left: -10px;
            background: #6f73ff;
            border: none;
            border-radius: 25px;
            color: #120f2f;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #a78bfa;
        }

        .game-container {
            width: 320px;
            padding: 25px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            box-shadow: 0 0 20px rgba(111, 115, 255, 0.3);
            margin: 50px auto;
            color: #fff;
        }

        h2 {
            text-align: center;
            color: #a78bfa;
        }

        a {
            color: #a78bfa;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="game-container">
        <h2>Login</h2>
        <form method="post">
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn">Login</button>

            <?php if (!empty($error)) echo "<p style='color:#ff4d4d; text-align:center;'>$error</p>"; ?>
        </form>

        <p style="text-align:center; margin-top: 10px;">
            Don’t have an account? <a href="register.php">Register here</a>
        </p>
    </div>

</body>

</html>