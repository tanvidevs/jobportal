<?php
include('/includes/db.php');
header('Content-Type: application/json');
// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Determine the endpoint based on the method
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            getJobPost($_GET['id']);
        } else {
            getAllJobPosts();
        }
        break;
    case 'POST':
        addJobPost();
        break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $_PUT);
        updateJobPost($_PUT['id']);
        break;
    case 'DELETE':
        parse_str(file_get_contents('php://input'), $_DELETE);
        deleteJobPost($_DELETE['id']);
        break;
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

// Function to get a specific job post by ID
function getJobPost($id) {
    global $conn;
    $query = "SELECT * FROM jobs WHERE job_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $jobPost = $result->fetch_assoc();
    echo json_encode($jobPost);
}

// Function to get all job posts
function getAllJobPosts() {
    global $conn;
    $query = "SELECT * FROM jobs";
    $result = mysqli_query($conn, $query);
    $jobPosts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $jobPosts[] = $row;
    }
    echo json_encode($jobPosts);
}

// Function to add a new job post
function addJobPost() {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $title = $data['title'];
    $description = $data['description'];
    $requirements = $data['requirements'];
    $salary = $data['salary'];
    $posted_by_hr = $data['posted_by_hr'];
    
    $query = "INSERT INTO jobs (title, description, requirements, salary, posted_by_hr) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $title, $description, $requirements, $salary, $posted_by_hr);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Job post added successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }
}

// Function to update an existing job post
function updateJobPost($id) {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $title = $data['title'];
    $description = $data['description'];
    $requirements = $data['requirements'];
    $salary = $data['salary'];
    
    $query = "UPDATE jobs SET title = ?, description = ?, requirements = ?, salary = ? WHERE job_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $title, $description, $requirements, $salary, $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Job post updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }
}

// Function to delete a job post
function deleteJobPost($id) {
    global $conn;
    $query = "DELETE FROM jobs WHERE job_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Job post deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }
}
?>
