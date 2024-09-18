<?php
// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Get logged-in user info from session
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header / Navigation Bar -->
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="dashboard.php" class="text-white text-lg font-bold">Job Portal</a>

            <!-- User Information -->
            <div class="flex items-center space-x-4">
                <span class="text-gray-300">Welcome, <?php echo ucfirst($user_name); ?> (<?php echo ucfirst($user_role); ?>)</span>
                
                <!-- If Admin, show Admin Menu -->
                <?php if ($user_role == 'admin') { ?>
                <a href="../admin/manage_user.php" class="text-white hover:text-blue-400">Manage Users</a>
                <a href="../admin/manage_jobs.php" class="text-white hover:text-blue-400">Manage Jobs</a>
                <a href="../admin/reports.php" class="text-white hover:text-blue-400">Reports</a>
                <?php } ?>

                <!-- If HR, show HR Menu -->
                <?php if ($user_role == 'hr') { ?>
                <a href="../hr/manage_jobs.php" class="text-white hover:text-blue-400">Manage Jobs</a>
                <a href="../hr/candidate_management.php" class="text-white hover:text-blue-400">Manage Candidates</a>
                <a href="../hr/reports.php" class="text-white hover:text-blue-400">Reports</a>
                <?php } ?>

                <!-- If Candidate, show Candidate Menu -->
                <?php if ($user_role == 'candidate') { ?>
                <a href="../candidate/job_listings.php" class="text-white hover:text-blue-400">Job Listings</a>
                <a href="../candidate/my_applications.php" class="text-white hover:text-blue-400">My Applications</a>
                <?php } ?>

                <!-- Logout -->
                <a href="../auth/logout.php" class="text-red-400 hover:text-red-500">Logout</a>
            </div>
        </div>
    </nav>
                
</body>