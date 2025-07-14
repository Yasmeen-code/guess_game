<?php
require_once 'db.php';
session_start();

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

$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData = $stmt->fetch();
$name = $userData['name'];

$stmt = $pdo->prepare("SELECT * FROM scores WHERE user_id = ? ORDER BY play_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$scores = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .scores-table {
            margin-top: 20px;
            width: 100%;
            color: #fff;
            border-collapse: collapse;
        }

        .scores-table th,
        .scores-table td {
            padding: 10px;
            border: 1px solid #6f73ff;
            text-align: center;
        }

        .scores-table th {
            background-color: #6f73ff33;
            color: #a78bfa;
        }

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

        form {
            display: inline;
        }
    </style>
</head>

<body>

    <div class="game-container">
        <h2>Welcome, <?= htmlspecialchars($name) ?></h2>
        <p>Your game history:</p>

        <?php if (count($scores) > 0): ?>
            <table class="scores-table">
                <tr>
                    <th>#</th>
                    <th>Attempts</th>
                    <th>Date Played</th>
                </tr>
                <?php foreach ($scores as $index => $score): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $score['attempts'] ?></td>
                        <td><?= $score['play_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No games played yet.</p>
        <?php endif; ?>

        <div style="margin-top: 20px; text-align: center;">
            <a href="index.php" class="small-btn">🎮 Play Again</a>

            <form method="post">
                <input type="hidden" name="logout" value="1">
                <button type="submit" class="small-btn">Logout</button>
            </form>
        </div>
    </div>

</body>

</html>