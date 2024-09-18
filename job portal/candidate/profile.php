<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and has a candidate role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'candidate') {
    header('Location: ../auth/login.php');
    exit();
}

$candidate_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Fetch candidate details
$query = "SELECT * FROM candidates WHERE user_id = $candidate_id";
$result = mysqli_query($conn, $query);
$candidate = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Your Profile</h1>
        
        <!-- Profile Form -->
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="name" class="block mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($candidate['name']); ?>" class="border p-2 w-full">
                </div>
                <div>
                    <label for="email" class="block mb-2">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($candidate['email']); ?>" class="border p-2 w-full">
                </div>
            </div>
            
            <div class="mb-6">
                <label for="resume" class="block mb-2">Resume</label>
                <input type="file" id="resume" name="resume" class="border p-2 w-full">
                <p class="text-gray-500 mt-2">Current Resume: <a href="../uploads/<?php echo htmlspecialchars($candidate['resume']); ?>" class="text-blue-500" download><?php echo htmlspecialchars($candidate['resume']); ?></a></p>
            </div>
            
            <div class="mb-6">
                <label for="skills" class="block mb-2">Skills</label>
                <textarea id="skills" name="skills" class="border p-2 w-full"><?php echo htmlspecialchars($candidate['skills']); ?></textarea>
            </div>

            <button type="submit" name="update_profile" class="bg-blue-500 text-white px-4 py-2">Save Changes</button>
        </form>
    </div>
</body>
</html>
