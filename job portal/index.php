<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header Section -->
    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Job Portal</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li><a href="jobs.php" class="hover:underline">Jobs</a></li>
                    <li><a href="login.php" class="hover:underline">Login</a></li>
                    <li><a href="register.php" class="hover:underline">Register</a></li>
                    <?php if (isset($_SESSION['role'])): ?>
                        <li><a href="logout.php" class="hover:underline">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="container mx-auto p-8">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-3xl font-bold mb-4">Welcome to the Job Portal</h2>
            <p class="mb-4">Find your next job or post new job openings with ease. Our platform connects job seekers with employers in a streamlined process.</p>
            <p class="mb-4">Explore the job listings, create your profile, or log in to manage your applications.</p>
            
            <!-- Example call to action buttons -->
            <div class="flex space-x-4">
                <a href="jobs.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View Jobs</a>
                <a href="register.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Register</a>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Job Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
