<?php
// Include database connection
include('../includes/db.php');
session_start();

// Check if user is logged in and is a candidate
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'candidate') {
    header('Location: ../auth/login.php');
    exit();
}

$candidate_id = $_SESSION['user_id']; // Assuming user ID is stored in session

// Fetch candidate profile information
$query_profile = "SELECT * FROM candidates WHERE user_id = ?";
$stmt_profile = mysqli_prepare($conn, $query_profile);
mysqli_stmt_bind_param($stmt_profile, 'i', $candidate_id);
mysqli_stmt_execute($stmt_profile);
$result_profile = mysqli_stmt_get_result($stmt_profile);

if (!$result_profile) {
    die("Error fetching candidate profile: " . mysqli_error($conn));
}

$candidate = mysqli_fetch_assoc($result_profile);

// Fetch job listings
$query_jobs = "SELECT * FROM jobs";
$result_jobs = mysqli_query($conn, $query_jobs);

if (!$result_jobs) {
    die("Error fetching job listings: " . mysqli_error($conn));
}

// Fetch application status
$query_applications = "SELECT * FROM applications WHERE candidate_id = ?";
$stmt_applications = mysqli_prepare($conn, $query_applications);
mysqli_stmt_bind_param($stmt_applications, 'i', $candidate_id);
mysqli_stmt_execute($stmt_applications);
$result_applications = mysqli_stmt_get_result($stmt_applications);

if (!$result_applications) {
    die("Error fetching application status: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Dashboard</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="../assets/js/main.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <!-- Profile Section -->
        <div class="bg-white p-6 rounded shadow-md mb-8">
            <h2 class="text-2xl font-bold mb-4">Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($candidate['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($candidate['email']); ?></p>
            <p><strong>Resume:</strong> <a href="../uploads/<?php echo htmlspecialchars($candidate['resume']); ?>" class="text-blue-500" target="_blank">View Resume</a></p>
            <a href="edit_profile.php" class="text-blue-500 underline">Edit Profile</a>
        </div>

        <!-- Job Listings Section -->
        <div class="bg-white p-6 rounded shadow-md mb-8">
            <h2 class="text-2xl font-bold mb-4">Job Listings</h2>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Job Title</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Requirements</th>
                        <th class="py-2 px-4 border-b">Salary</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($job = mysqli_fetch_assoc($result_jobs)) { ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($job['job_title']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($job['job_description']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($job['requirements']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($job['salary']); ?></td>
                        <td class="border px-4 py-2">
                            <a href="apply_job.php?job_id=<?php echo htmlspecialchars($job['job_id']); ?>" class="text-blue-500">Apply</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Application Status Section -->
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Application Status</h2>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Job Title</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Applied On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($application = mysqli_fetch_assoc($result_applications)) { 
                        $job_query = "SELECT job_title FROM jobs WHERE job_id = ?";
                        $stmt_job = mysqli_prepare($conn, $job_query);
                        mysqli_stmt_bind_param($stmt_job, 'i', $application['job_id']);
                        mysqli_stmt_execute($stmt_job);
                        $job_result = mysqli_stmt_get_result($stmt_job);
                        $job = mysqli_fetch_assoc($job_result);
                    ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($job['job_title']); ?></td>
                        <td class="border px-4 py-2"><?php echo ucfirst(htmlspecialchars($application['status'])); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($application['applied_at']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
