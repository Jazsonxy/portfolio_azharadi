<?php
session_start();
include 'includes/config.php'; // Koneksi database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $project_link = $_POST['project_link'];

    // Upload image
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Simpan data ke database
    $sql = "INSERT INTO portfolios (title, description, image_url, project_link) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Periksa apakah persiapan pernyataan berhasil
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param("ssss", $title, $description, $image, $project_link);

    // Eksekusi dan upload file
    if ($stmt->execute() && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Error adding portfolio: " . $stmt->error; // Menangkap kesalahan eksekusi
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Portfolio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }
        .container {
            max-width: 600px;
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
        .container input, .container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Menjaga ukuran box tetap konsisten */
        }
        .container input[type="submit"] {
            background-color: #6a11cb;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .container input[type="submit"]:hover {
            background-color: #2575fc;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #6a11cb; /* Warna tautan */
            text-decoration: none; /* Menghilangkan garis bawah */
        }
        .back-link:hover {
            text-decoration: underline; /* Garis bawah saat hover */
        }
        .error-message {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Portfolio</h2>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="url" name="project_link" placeholder="Project Link" required>
            <input type="file" name="image" accept="image/*" required >
            <input type="submit" value="Add Portfolio">
        </form>
        <a class="back-link" href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>