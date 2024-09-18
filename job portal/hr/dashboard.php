<?php
// Start session to access session variables
session_start();

// Include database connection
include('../includes/db.php');

// Check if HR ID exists in the session
if (!isset($_SESSION['user_id'])) {
    die("HR not logged in."); // Ensure that only logged-in HRs can access this page
}

// Fetch HR ID from session
$hr_id = $_SESSION['user_id']; // Assuming HR's ID is stored in session

// Ensure the HR ID is an integer to prevent SQL injection
$hr_id = intval($hr_id);

// Fetch jobs posted by HR
$query_jobs = "SELECT * FROM jobs WHERE posted_by_hr = ?";
$stmt_jobs = mysqli_prepare($conn, $query_jobs);
mysqli_stmt_bind_param($stmt_jobs, 'i', $hr_id);
mysqli_stmt_execute($stmt_jobs);
$result_jobs = mysqli_stmt_get_result($stmt_jobs);

if (!$result_jobs) {
    die("Error fetching jobs: " . mysqli_error($conn));
}

// Fetch applications related to the jobs posted by this HR
$query_applications = "
    SELECT * 
    FROM applications 
    WHERE job_id IN (
        SELECT job_id 
        FROM jobs 
        WHERE posted_by_hr = ?
    )
";
$stmt_applications = mysqli_prepare($conn, $query_applications);
mysqli_stmt_bind_param($stmt_applications, 'i', $hr_id);
mysqli_stmt_execute($stmt_applications);
$result_applications = mysqli_stmt_get_result($stmt_applications);

if (!$result_applications) {
    die("Error fetching applications: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">HR Dashboard</h1>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Job Postings</h2>
            <?php if (mysqli_num_rows($result_jobs) > 0): ?>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Job ID</th>
                            <th class="py-2 px-4 border-b">Job Title</th>
                            <th class="py-2 px-4 border-b">Job Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_jobs)): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_title']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_description']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No job postings available.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2 class="text-2xl font-semibold mb-4">Applications</h2>
            <?php if (mysqli_num_rows($result_applications) > 0): ?>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Application ID</th>
                            <th class="py-2 px-4 border-b">Job ID</th>
                            <th class="py-2 px-4 border-b">Candidate ID</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Applied At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_applications)): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['application_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['candidate_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['status']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['applied_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No applications available.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">HR Dashboard</h1>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Job Postings</h2>
            <?php if (mysqli_num_rows($result_jobs) > 0): ?>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Job ID</th>
                            <th class="py-2 px-4 border-b">Job Title</th>
                            <th class="py-2 px-4 border-b">Job Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_jobs)): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_title']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_description']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No job postings available.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2 class="text-2xl font-semibold mb-4">Applications</h2>
            <?php if (mysqli_num_rows($result_applications) > 0): ?>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Application ID</th>
                            <th class="py-2 px-4 border-b">Candidate ID</th>
                            <th class="py-2 px-4 border-b">Job ID</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Applied At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_applications)): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['application_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['candidate_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['job_id']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['status']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['applied_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No applications available.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
