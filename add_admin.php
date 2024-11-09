<?php
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "portfolio_db"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Username dan password yang ingin ditambahkan
$admin_username = "jazsonxy_123"; // Username yang diinginkan
$admin_password = "password"; // Password yang diinginkan

// Hash password
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

// Query untuk memasukkan admin ke database
$sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $admin_username, $hashed_password);

if ($stmt->execute()) {
    echo "Admin added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>