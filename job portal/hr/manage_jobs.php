<?php
session_start();
include('../includes/db.php');

// Ensure the user is logged in and has the HR role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'hr') {
    header('Location:  ../../dashboard.php');
    exit();
}

$hr_id = $_SESSION['id']; // Assuming HR ID is stored in session

// Fetch job postings managed by the logged-in HR
$query = "SELECT * FROM jobs WHERE posted_by_hr = $hr_id";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/js/main.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Manage Job Postings</h1>
        
        <!-- Add Job Form -->
        <form action="add_job.php" method="POST" class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="title" placeholder="Job Title" class="border p-2" required>
                <input type="text" name="salary" placeholder="Salary" class="border p-2" required>
                <textarea name="description" placeholder="Job Description" class="border p-2" rows="4" required></textarea>
                <textarea name="requirements" placeholder="Requirements" class="border p-2" rows="4" required></textarea>
                <button type="submit" name="add_job" class="bg-blue-500 text-white px-4 py-2">Add Job</button>
            </div>
        </form>

        <!-- Job Table -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Title</th>
                    <th class="py-2">Salary</th>
                    <th class="py-2">Posted At</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $row['job_id']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['title']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['salary']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['created_at']; ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit_job.php?id=<?php echo $row['job_id']; ?>" class="text-blue-500">Edit</a> |
                        <a href="delete_job.php?id=<?php echo $row['job_id']; ?>" class="text-red-500" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
