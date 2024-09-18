<?php
// Include database connection
include('../includes/db.php');

// Fetch job posts data
$jobPostsQuery = "SELECT COUNT(*) AS total_jobs, SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) AS open_jobs, SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) AS closed_jobs FROM jobs";
$jobPostsResult = mysqli_query($conn, $jobPostsQuery);
$jobData = mysqli_fetch_assoc($jobPostsResult);

// Fetch applications data
$applicationsQuery = "SELECT COUNT(*) AS total_applications, SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved, SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending FROM applications";
$applicationsResult = mysqli_query($conn, $applicationsQuery);
$appData = mysqli_fetch_assoc($applicationsResult);

// Fetch HR activity data
$hrActivityQuery = "SELECT hr.username, COUNT(jobs.job_id) AS jobs_posted, COUNT(applications.application_id) AS applications_handled 
                    FROM users AS hr 
                    LEFT JOIN jobs ON hr.id = jobs.posted_by_hr
                    LEFT JOIN applications ON jobs.job_id = applications.job_id
                    WHERE hr.role = 'hr'
                    GROUP BY hr.username";
$hrActivityResult = mysqli_query($conn, $hrActivityQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Reports</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Admin Reports</h2>

        <!-- Job Post Summary -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Job Post Summary</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-100 p-4 rounded">
                    <h4 class="text-lg">Total Job Posts</h4>
                    <p><?php echo $jobData['total_jobs']; ?></p>
                </div>
                <div class="bg-green-100 p-4 rounded">
                    <h4 class="text-lg">Open Jobs</h4>
                    <p><?php echo $jobData['open_jobs']; ?></p>
                </div>
                <div class="bg-red-100 p-4 rounded">
                    <h4 class="text-lg">Closed Jobs</h4>
                    <p><?php echo $jobData['closed_jobs']; ?></p>
                </div>
            </div>
        </div>

        <!-- Application Summary -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Application Summary</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-100 p-4 rounded">
                    <h4 class="text-lg">Total Applications</h4>
                    <p><?php echo $appData['total_applications']; ?></p>
                </div>
                <div class="bg-green-100 p-4 rounded">
                    <h4 class="text-lg">Approved Applications</h4>
                    <p><?php echo $appData['approved']; ?></p>
                </div>
                <div class="bg-red-100 p-4 rounded">
                    <h4 class="text-lg">Rejected Applications</h4>
                    <p><?php echo $appData['rejected']; ?></p>
                </div>
                <div class="bg-yellow-100 p-4 rounded">
                    <h4 class="text-lg">Pending Applications</h4>
                    <p><?php echo $appData['pending']; ?></p>
                </div>
            </div>
        </div>

        <!-- HR Activity Summary -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">HR Activity Summary</h3>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">HR Name</th>
                        <th class="px-4 py-2">Jobs Posted</th>
                        <th class="px-4 py-2">Applications Handled</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($hr = mysqli_fetch_assoc($hrActivityResult)) { ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $hr['username']; ?></td>
                            <td class="border px-4 py-2"><?php echo $hr['jobs_posted']; ?></td>
                            <td class="border px-4 py-2"><?php echo $hr['applications_handled']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
