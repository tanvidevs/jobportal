<?php
session_start();
include('./includes/db.php');

if (isset($_SESSION['role'])) {
    // Redirect logged-in users to their respective dashboard
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $error = "Email already registered.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert new user into the database
        $insert_query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            header('Location: login.php');
            exit();
        } else {
            $error = "Error registering user: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Job Portal</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Register</h2>

        <?php if (isset($error)): ?>
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="border p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="border p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="border p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Role</label>
                <select id="role" name="role" class="border p-2 w-full rounded" required>
                    <option value="candidate">Candidate</option>
                    <option value="hr">HR</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</button>
        </form>

        <p class="mt-4 text-center">
            Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>
</body>
</html>
