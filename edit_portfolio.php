<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio</title>
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
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Portfolio</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" value="<?php echo htmlspecialchars($portfolio['title']); ?>" required>
            <textarea name="description" required><?php echo htmlspecialchars($portfolio['description']); ?></textarea>
            <input type="url" name="project_link" value="<?php echo htmlspecialchars($portfolio['project_link']); ?>" required>
            <input type="file" name="image" accept="image/*">
            <input type="submit" value="Update Portfolio">
        </form>
        <a class="back-link" href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>