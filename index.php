<?php
session_start();
require_once 'db.php';

if (isset($_POST['logout'])) {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['reset'])) {
  unset($_SESSION['number']);
  unset($_SESSION['attempts']);
  header("Location: index.php");
  exit();
}

if (!isset($_SESSION['number'])) {
  $_SESSION['number'] = rand(1, 100);
  $_SESSION['attempts'] = 0;
}

$message = "";

//  Check guess
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guess'])) {
  $guess = (int)$_POST['guess'];
  $_SESSION['attempts']++;

  if ($guess < $_SESSION['number']) {
    $message = "📉 Try a higher number!";
  } elseif ($guess > $_SESSION['number']) {
    $message = "📈 Try a lower number!";
  } else {
    $message = "🎉 Correct! The number was {$guess}. You guessed it in {$_SESSION['attempts']} attempts.";

    $stmt = $pdo->prepare("INSERT INTO scores (attempts, user_id) VALUES (:attempts, :user_id)");
    $stmt->execute([
      'attempts' => $_SESSION['attempts'],
      'user_id' => $_SESSION['user_id']
    ]);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Guess The Number</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .small-btn {
      display: inline-block;
      padding: 8px 16px;
      font-size: 14px;
      border-radius: 20px;
      border: none;
      background: #6f73ff;
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      margin: 5px;
      transition: 0.3s;
      cursor: pointer;
    }

    .small-btn:hover {
      background: #a78bfa;
      transform: scale(1.05);
    }
    
  </style>
</head>

<body>

  <div class="game-container">
    <h1>🎯 Guess The Number</h1>
    <p>Enter a number between <strong>1 and 100</strong></p>

    <form method="post">
      <div class="input-box">
        <input type="number" name="guess" min="1" max="100" placeholder="Your guess" required>
      </div>
      <button type="submit" class="btn">Guess</button>
    </form>

    <form method="post">
      <input type="hidden" name="reset" value="1">
      <button type="submit" class="btn">🔄 Restart Game</button>
    </form>

    <div class="message">
      <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    </div>
    <div style="text-align: center; margin-top: 20px;">
      <a href="profile.php" class="small-btn">👤 View Profile</a>

      <form method="post" style="display: inline;">
        <input type="hidden" name="logout" value="1">
        <button  class="small-btn">🚪 Logout</button>
      </form>
    </div>
  </div>

</body>

</html>