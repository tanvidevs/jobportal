<?php
session_start();
include('/includes/db.php');
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query to fetch user data based on username
    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['status'] = $user['status'];
            
            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header('Location: ../admin/dashboard.php');
            } elseif ($user['role'] == 'hr') {
                header('Location: ../hr/dashboard.php');
            } elseif ($user['role'] == 'candidate') {
                header('Location: ../candidate/dashboard.php');
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Login</h1>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-600 p-4 mb-4 rounded">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST" class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="border w-full p-2" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="border w-full p-2" required>
            </div>
            <button type="submit" name="login" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
        </form>
    </div>
</body>
</html>
