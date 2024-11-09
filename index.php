<?php
include 'includes/config.php'; // Menyertakan file konfigurasi

// Menyimpan komentar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO comments (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "Invalid email format.";
    }
}

// Mengambil komentar
$comments = [];
$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

// Mengambil data portfolio
$portfolios = [];
$sql = "SELECT * FROM portfolios ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $portfolios[] = $row;
    }
}

// Fetch About Me data
$sql = "SELECT * FROM about_me LIMIT 1";
$result = $conn->query($sql);
$aboutMeData = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>My Portfolio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .rounded-image {
            border-radius: 50%;
            overflow: hidden;
        }
        .custom-shape {
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }
        .comment-count {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: red;
            color: white;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            margin-left: 5px;
        }
    </style>
    <script>
        function toggleDescription(id) {
            const description = document.getElementById(id);
            const button = document.getElementById('toggle-button-' + id);
            if (description.classList.contains('line-clamp-3')) {
                description.classList.remove('line-clamp-3');
                button.textContent = 'Show Less';
            } else {
                description.classList.add('line-clamp-3');
                button.textContent = 'Show More';
            }
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="relative bg-gray-900 text-white py-20" style="background-image: url('URL_GAMBAR'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto text-center relative z-10">
            <h1 class="text-5xl font-bold tracking-wider">My Portfolio</h1>
            <p class="mt-4 text-lg">Welcome to my personal portfolio. Explore my work and connect with me!</p>
        </div>
    </header>
    <nav class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex space-x-6">
                <a class="hover:text-gray-400" href="#about">About</a>
                <a class="hover:text-gray-400" href="#education">Education</a>
                <a class="hover:text-gray-400" href="#portfolio">Portfolio</a>
                <a class="hover:text-gray-400" href="#contact">Contact</a>
            </div>
            <div>
                <a class="hover:text-gray-400" href="admin_login.php">Login Admin</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto py-10">
        <section class="bg-white p-8 rounded-lg shadow-lg mb-10" id="about">
            <div class="flex items-center">
                <img alt="Profile picture of the portfolio owner" class="rounded-full w-32 h-32 mr-6" height="150" src="http://localhost/portfolio/uploads/WhatsApp%20Image%202024-11-09%20at%2010.52.34_01a1cfd5.jpg"/>
                <div>
                    <h2 class="text-3xl font-bold mb-4">About Me</h2>
                    <p class="text-lg">
                        Mahasiswa semester akhir S1 Teknik Informatika di Institut Teknologi Adhi Tama Surabaya dengan minat dan antusiasme dalam bidang data, seperti Data Entry dan Data Analyst. Sedang menekuni dan menata karir di bidang data, serta terus mengembangkan keterampilan untuk mendukung kemampuan analisis yang akurat dan pengolahan informasi berbasis data.
                    </p>
                    <div class="mt-4">
                        <h3 class="text-xl font-bold mb-2">Connect with me:</h3>
                        <div class="flex space-x-4">
                            <a class="text-blue-600 hover:text-blue-800" href="https://www.linkedin.com/in/azhar-adi-dirgantara-setiawan-22488a28b/" target="_blank">
                                <i class="fab fa-linkedin fa-2x"></i>
                            </a>
                            <a class="text-pink-600 hover:text-pink-800" href="https://www.instagram.com/find.ay_?igsh=MTZrdGhrMHF0dnY1NA==" target="_blank">
                                <i class="fab fa-instagram fa-2x"></i>
                            </a>
                            <a class="text-gray-800 hover:text-gray-600" href="https://github.com/Jazsonxy" target="_blank">
                                <i class="fab fa-github fa-2x"></i>
                            </a>
                            <a class="text-red-600 hover:text-red-800" href="https://drive.google.com/file/d/1uX6I_A3ZqCQNZwbVtCmzUH5evFwJ09CF/view?usp=drivesdk" target="_blank">
                                <i class="fas fa-file-pdf fa-2x"></i> <!-- Ikon PDF -->
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white p-8 rounded-lg shadow-lg mb-10" id="education">
            <h2 class="text-3xl font-bold mb-6 text-center">Education</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start p-4 bg-gray-100 rounded-lg shadow-md">
                    <div class="w-16 h-16 mr-6 flex items-center justify-center bg-blue-500 text-white rounded-full shadow-lg">
                        <i class="fas fa-school fa-2x"></i> <!-- Ikon untuk SMK -->
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">SMK XYZ</h3>
                        <p class="text-lg mb-2">
                            I completed my vocational high school education at SMK XYZ, where I specialized in computer and network engineering. 
                            During my time there, I developed a strong foundation in IT and programming.
                        </p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-100 rounded-lg shadow-md">
                    <div class="w-16 h-16 mr-6 flex items-center justify-center bg-blue-500 text -white rounded-full shadow-lg">
                        <i class="fas fa-university fa-2x"></i> <!-- Ikon untuk Universitas -->
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">University ABC</h3>
                        <p class="text-lg mb-2">
                            I pursued my higher education at University ABC, majoring in Computer Science. 
                            My coursework included advanced topics in software development, data structures, algorithms, and web technologies.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white p-8 rounded-lg shadow-lg mb-10" id="portfolio">
            <h2 class="text-3xl font-bold mb-6 text-center">My Work</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($portfolios as $portfolio): ?>
                    <div class="portfolio-item bg-gray-100 rounded-lg shadow-md overflow-hidden">
                        <img alt="Screenshot of project" class="w-full h-48 object-cover" height="300" src="<?php echo htmlspecialchars($portfolio['image_url']); ?>" width="400"/>
                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($portfolio['title']); ?></h3>
                            <p class="text-gray-700 line-clamp-3" id="project-description-<?php echo $portfolio['id']; ?>">
                                <?php echo htmlspecialchars($portfolio['description']); ?>
                            </p>
                            <a class="text-blue-500 hover:underline" href="<?php echo htmlspecialchars($portfolio['project_link']); ?>" target="_blank">View Project</a>
                            <button class="text-blue-500 hover:underline mt-2" id="toggle-button-project-description-<?php echo $portfolio['id']; ?>" onclick="toggleDescription('project-description-<?php echo $portfolio['id']; ?>')">Show More</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="bg-white p-8 rounded-lg shadow-lg mt-10" id="contact">
            <h2 class="text-3xl font-bold mb-6 text-center">Contact Me</h2>
            <p class="text-lg mb-6 text-center">If you'd like to get in touch, please fill out the form below:</p>
            <form action="" method="POST" class="max-w-lg mx-auto">
                <div class="mb-4">
                    <input class="w-full p-3 border border-gray-300 rounded-lg" name="name" placeholder="Your Name" required type="text"/>
                </div>
                <div class="mb-4">
                    <input class="w-full p-3 border border-gray-300 rounded-lg" name="email" placeholder="Your Email" required type="email"/>
                </div>
                <div class="mb-4">
                    <textarea class="w-full p-3 border border-gray-300 rounded-lg" name="message" placeholder="Your Message" required rows="5"></textarea>
                </div>
                <div class="text-center">
                    <button class="bg-gray-900 text-white py-3 px-6 rounded-lg hover:bg-gray-700" name="comment_submit" type="submit">Send Message</button>
                </div>
            </form>
            <?php if (isset($success_message)): ?>
                <div class="mt-4 text-green-600 text-center"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="mt-4 text-red-600 text-center"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Comments <span class="comment-count"><?php echo count($comments); ?></span></h3>
                <?php if (!empty($comments)): ?>
                    <ul>
                        <?php foreach ($comments as $comment): ?>
                            <li class="border-b border-gray-300 py-2">
                                <strong><?php echo htmlspecialchars($comment['name']); ?></strong> (<?php echo htmlspecialchars($comment['email']); ?>)
                                <p><?php echo nl2br(htmlspecialchars($comment['message'])); ?></p>
                                <small class="text-gray-500"><?php echo $comment['created_at']; ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No comments yet.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <p>© 2025 My Portfolio. All rights reserved.</p>
            <div class="mt-4 flex justify-center space-x-4">
                <a class="text-white hover:text-gray-400" href="https://www.linkedin.com/in/azhar-adi-dirgantara-setiawan-22488a28b/" target="_blank">
                    <i class="fab fa-linkedin fa-2x"></i>
                </a>
                <a class="text-white hover:text-gray-400" href="https://www.instagram.com/find.ay_?igsh=MTZrdGhrMHF0dnY1NA==" target="_blank">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a class="text-white hover:text-gray-400" href="https://github.com/Jazsonxy" target="_blank">
                    <i class="fab fa-github fa-2x"></i>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>