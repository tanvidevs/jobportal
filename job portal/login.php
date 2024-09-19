<?php
session_start();
include('./includes/db.php');

if (isset($_SESSION['role'])) {
    // Redirect logged-in users to their respective dashboard
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    // Fetch user from database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            
            // Redirect based on role
            if ($user['role'] == 'admin') {
                header('Location: .../../admin/dashboard.php');
            } elseif ($user['role'] == 'hr') {
                header('Location: .../../hr/dashboard.php');
            } else {
                header('Location: .../../candidate/dasshboard.php');
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm bg-white p-8 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Login</h2>

        <?php if (isset($error)): ?>
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="border p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="border p-2 w-full rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</button>
        </form>

        <p class="mt-4 text-center">
            Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register</a>
        </p>
    </div>
</body>
</html>
