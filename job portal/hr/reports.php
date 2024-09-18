<?php
// Include database connection and authentication check
include('../includes/db.php');
session_start();

// Check if the user is an HR
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'hr') {
    header('Location: ../auth/login.php');
    exit();
}

// Query for job postings by the HR
$hr_id = $_SESSION['user_id'];
$job_query = "SELECT * FROM jobs WHERE posted_by_hr = $hr_id";
$job_result = mysqli_query($conn, $job_query);

// Query for applications and their status
$application_query = "SELECT j.title, COUNT(a.application_id) AS total_applications, 
                      SUM(CASE WHEN a.status = 'approved' THEN 1 ELSE 0 END) AS approved,
                      SUM(CASE WHEN a.status = 'rejected' THEN 1 ELSE 0 END) AS rejected,
                      SUM(CASE WHEN a.status = 'pending' THEN 1 ELSE 0 END) AS pending
                      FROM jobs j
                      LEFT JOIN applications a ON j.job_id = a.job_id
                      WHERE j.posted_by_hr = $hr_id
                      GROUP BY j.job_id";
$application_result = mysqli_query($conn, $application_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>HR Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">HR Reports</h1>
        
        <!-- Report on Job Postings -->
        <h2 class="text-2xl font-semibold mb-4">Job Postings</h2>
        <table class="min-w-full bg-white mb-6">
            <thead>
                <tr>
                    <th class="py-2">Job ID</th>
                    <th class="py-2">Title</th>
                    <th class="py-2">Description</th>
                    <th class="py-2">Salary</th>
                    <th class="py-2">Posted At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = mysqli_fetch_assoc($job_result)) { ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $job['job_id']; ?></td>
                    <td class="border px-4 py-2"><?php echo $job['title']; ?></td>
                    <td class="border px-4 py-2"><?php echo $job['description']; ?></td>
                    <td class="border px-4 py-2"><?php echo $job['salary']; ?></td>
                    <td class="border px-4 py-2"><?php echo $job['created_at']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Report on Applications -->
        <h2 class="text-2xl font-semibold mb-4">Application Status</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">Job Title</th>
                    <th class="py-2">Total Applications</th>
                    <th class="py-2">Approved</th>
                    <th class="py-2">Rejected</th>
                    <th class="py-2">Pending</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($app = mysqli_fetch_assoc($application_result)) { ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $app['title']; ?></td>
                    <td class="border px-4 py-2"><?php echo $app['total_applications']; ?></td>
                    <td class="border px-4 py-2"><?php echo $app['approved']; ?></td>
                    <td class="border px-4 py-2"><?php echo $app['rejected']; ?></td>
                    <td class="border px-4 py-2"><?php echo $app['pending']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
