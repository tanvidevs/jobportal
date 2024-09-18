<?php
// Include database connection
include('../includes/db.php');
session_start();

// Check if HR is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'hr') {
    header('Location: ../auth/login.php');
    exit();
}

// Get HR user ID from session
$hr_id = $_SESSION['user_id'];

// Fetch all job postings created by this HR
$query_jobs = "SELECT job_id, title FROM jobs WHERE posted_by_hr = $hr_id";
$result_jobs = mysqli_query($conn, $query_jobs);

// Fetch all applications for jobs created by this HR
$query_applications = "
    SELECT applications.application_id, applications.status, applications.applied_at, 
           candidates.resume, candidates.skills, users.name, jobs.title 
    FROM applications
    JOIN candidates ON applications.candidate_id = candidates.candidate_id
    JOIN users ON candidates.user_id = users.id
    JOIN jobs ON applications.job_id = jobs.job_id
    WHERE jobs.posted_by_hr = $hr_id
";
$result_applications = mysqli_query($conn, $query_applications);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Applications</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Manage Applications</h1>

        <!-- Filter by Job Posting -->
        <form action="application.php" method="GET" class="mb-6">
            <label for="job" class="block mb-2">Filter by Job:</label>
            <select name="job_id" id="job" class="border p-2">
                <option value="">All Jobs</option>
                <?php while ($job = mysqli_fetch_assoc($result_jobs)) { ?>
                    <option value="<?php echo $job['job_id']; ?>">
                        <?php echo $job['title']; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Filter</button>
        </form>

        <!-- Applications Table -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">Candidate Name</th>
                    <th class="py-2">Job Title</th>
                    <th class="py-2">Resume</th>
                    <th class="py-2">Skills</th>
                    <th class="py-2">Application Date</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_applications)) { ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $row['name']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['title']; ?></td>
                    <td class="border px-4 py-2"><a href="../uploads/resumes/<?php echo $row['resume']; ?>" class="text-blue-500" target="_blank">View Resume</a></td>
                    <td class="border px-4 py-2"><?php echo $row['skills']; ?></td>
                    <td class="border px-4 py-2"><?php echo date('Y-m-d', strtotime($row['applied_at'])); ?></td>
                    <td class="border px-4 py-2"><?php echo ucfirst($row['status']); ?></td>
                    <td class="border px-4 py-2">
                        <form action="update_application_status.php" method="POST">
                            <input type="hidden" name="application_id" value="<?php echo $row['application_id']; ?>">
                            <select name="status" class="border p-2">
                                <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="approved" <?php echo $row['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                <option value="rejected" <?php echo $row['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2">Update</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
