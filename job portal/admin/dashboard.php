<?php
    // Start the session and check if the user is logged in
    session_start();
    
    // Check if the user is admin, otherwise redirect to login
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }

    // Include the database connection
    include '../includes/db.php';

    // Fetch required data for the dashboard overview (job posts, HRs, candidates, applications)
    $jobCountQuery = "SELECT COUNT(*) AS total_jobs FROM jobs";
    $hrCountQuery = "SELECT COUNT(*) AS total_hrs FROM users WHERE role = 'hr'";
    $candidateCountQuery = "SELECT COUNT(*) AS total_candidates FROM users WHERE role = 'candidate'";
    $applicationCountQuery = "SELECT COUNT(*) AS total_applications FROM applications";

    $jobCountResult = $conn->query($jobCountQuery);
    $hrCountResult = $conn->query($hrCountQuery);
    $candidateCountResult = $conn->query($candidateCountQuery);
    $applicationCountResult = $conn->query($applicationCountQuery);

    $jobCount = $jobCountResult->fetch_assoc()['total_jobs'];
    $hrCount = $hrCountResult->fetch_assoc()['total_hrs'];
    $candidateCount = $candidateCountResult->fetch_assoc()['total_candidates'];
    $applicationCount = $applicationCountResult->fetch_assoc()['total_applications'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="../assets/css/tailwind.css" rel="stylesheet">
</head>
<body>

    <!-- Include Header -->
    <?php include '../includes/header.php'; ?>

    <div class="container mx-auto p-5">
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

        <!-- Overview Section -->
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-blue-500 text-white p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-bold">Total Jobs</h2>
                <p class="text-3xl"><?php echo $jobCount; ?></p>
            </div>

            <div class="bg-green-500 text-white p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-bold">Total HRs</h2>
                <p class="text-3xl"><?php echo $hrCount; ?></p>
            </div>

            <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-bold">Total Candidates</h2>
                <p class="text-3xl"><?php echo $candidateCount; ?></p>
            </div>

            <div class="bg-red-500 text-white p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-bold">Total Applications</h2>
                <p class="text-3xl"><?php echo $applicationCount; ?></p>
            </div>
        </div>

        <!-- Navigation Section -->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Manage Portal</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="manage_hr.php" class="bg-blue-400 text-white p-4 rounded-lg text-center shadow-md hover:bg-blue-600">
                    Manage HRs
                </a>
                <a href="../jobs/view_job.php" class="bg-green-400 text-white p-4 rounded-lg text-center shadow-md hover:bg-green-600">
                    View Job Postings
                </a>
                <a href="../applications/status.php" class="bg-yellow-400 text-white p-4 rounded-lg text-center shadow-md hover:bg-yellow-600">
                    View Applications
                </a>
                <a href="reports.php" class="bg-purple-400 text-white p-4 rounded-lg text-center shadow-md hover:bg-purple-600">
                    View Reports
                </a>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include '../includes/footer.php'; ?>

</body>
</html>
