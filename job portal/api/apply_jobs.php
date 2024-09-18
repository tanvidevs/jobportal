<?php
// Include database connection
include('/includes/db.php');

// Start session
session_start();

// Check if the user is logged in and is a candidate
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'candidate') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Check if job ID is provided
if (isset($_POST['job_id'])) {
    // Sanitize input
    $job_id = mysqli_real_escape_string($conn, $_POST['job_id']);
    $candidate_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Check if the candidate has already applied for this job
    $checkQuery = "SELECT * FROM applications WHERE candidate_id='$candidate_id' AND job_id='$job_id'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'You have already applied for this job.']);
        exit();
    }

    // Insert application data into the database
    $query = "INSERT INTO applications (candidate_id, job_id, status, applied_at) VALUES ('$candidate_id', '$job_id', 'pending', NOW())";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting application: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Job ID is required.']);
}
?>
