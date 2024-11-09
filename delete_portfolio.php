<?php
session_start();
include 'includes/config.php'; // Koneksi database

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hapus portofolio dari database
    $sql = "DELETE FROM portfolios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Error deleting portfolio: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Portfolio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container p {
            text-align: center;
            margin: 20px 0;
        }
        .button-group {
            text-align: center;
        }
        .button-group a, .button-group button {
            background-color: #6a11cb;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
            margin: 0 5px;
        }
        .button-group a:hover, .button-group button:hover {
            background-color: #2575fc;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Portfolio</h2>
        <p>Are you sure you want to delete this portfolio?</p>
        <form action="" method="POST">
            <div class="button-group">
                <button type="submit">Delete</button>
                <a href="admin_dashboard.php">Cancel</a>
            </div>
        </form>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>