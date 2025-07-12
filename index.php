<?php
session_start();

// Reset game
if (isset($_POST['reset'])) {
    session_unset();
    header("Location: index.php");
    exit();
}

// Generate random number once
if (!isset($_SESSION['number'])) {
    $_SESSION['number'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
}

$message = "";

// Check guess
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guess'])) {
    $guess = (int)$_POST['guess'];
    $_SESSION['attempts']++;

    if ($guess < $_SESSION['number']) {
        $message = "📉 Try a higher number!";
    } elseif ($guess > $_SESSION['number']) {
        $message = "📈 Try a lower number!";
    } else {
        $message = "🎉 Correct! The number was {$guess}. You guessed it in {$_SESSION['attempts']} attempts.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Guess The Number</title>
  <link rel="stylesheet" href="style.css">
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
  </div>

</body>

</html>
