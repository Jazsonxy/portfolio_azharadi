<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: admin_login.php");
    exit();
}

include 'includes/config.php';

// Mengambil data portofolio
$sql = "SELECT * FROM portfolio";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menambahkan portofolio baru
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image_url = "";

        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $image_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . uniqid() . "_" . $image_name;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
            }
        }

        $stmt = $conn->prepare("INSERT INTO portfolio (title, description, image_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $image_url);
        $stmt->execute();
        $stmt->close();
    }

    // Menghapus portofolio
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Portfolio</title>
</head>
<body>
    <h1>Manage Portfolio</h1>
    <h2>Add New Portfolio Item</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <label for="image">Image:</label>
        <input type="file" name="image" accept="image/*">
        <br>
        <input type="submit" name="add" value="Add Portfolio">
    </form>

    <h2>Current Portfolio Items</h2>
    <ul>
        <?php while ($portfolio = $result->fetch_assoc()): ?>
            <li>
                <h3><?php echo htmlspecialchars($portfolio['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($portfolio['description'])); ?></p>
                <img src="<?php echo htmlspecialchars($portfolio['image_url']); ?>" alt="Portfolio Image" style="max-width: 200px;">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $portfolio['id']; ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>