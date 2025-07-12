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
    <p>Guess a number between <strong>1 and 100</strong></p>

    <form method="post">
      <div class="input-box">
        <input type="number" name="guess" min="1" max="100" placeholder="Your guess" required>
      </div>
      <button type="submit">Guess</button>
    </form>

    <div class="message">
      <!-- هنا هتظهر الرسالة بعدين -->
    </div>
  </div>

</body>

</html>