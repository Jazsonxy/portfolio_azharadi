<?php
session_start();
include 'includes/config.php'; // Koneksi database

// Cek apakah pengguna sudah login
if (!isset ($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Ambil data portofolio dari database
$sql = "SELECT * FROM portfolios";
$result = $conn->query($sql);
$portfolios = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $portfolios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .button-group {
            text-align: right;
            margin-bottom: 20px;
        }
        .button-group a {
            background-color: #6a11cb;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
            margin-left: 10px;
        }
        .button-group a:hover {
            background-color: #2575fc;
        }
        .portfolio-item {
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fafafa;
        }
        .portfolio-item h4 {
            margin: 0;
            color: #333;
        }
        .portfolio-item p {
            color: #666;
        }
        .portfolio-item a {
            color: #6a11cb;
            text-decoration: none;
            margin-right: 10px;
        }
        .portfolio-item a:hover {
            text-decoration: underline;
        }
        .no-portfolios {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <div class="button-group">
            <a href="add_portfolio.php">Add Portfolio</a>
            <a href="logout.php">Logout</a>
        </div>
        <h3>Portfolio List</h3>
        <?php if (!empty($portfolios)): ?>
            <?php foreach ($portfolios as $portfolio): ?>
                <div class="portfolio-item">
                    <h4><?php echo htmlspecialchars($portfolio['title']); ?></h4>
                    <p><?php echo htmlspecialchars($portfolio['description']); ?></p>
                    <a href="edit_portfolio.php?id=<?php echo $portfolio['id']; ?>">Edit</a>
                    <a href="delete_portfolio.php?id=<?php echo $portfolio['id']; ?>">Delete</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-portfolios">No portfolios found.</p>
        <?php endif; ?>
    </div>
</body>
</html>