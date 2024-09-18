<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Jobs</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Search Jobs</h1>
        
        <!-- Search Form -->
        <form id="searchForm" method="GET" action="">
            <div class="grid grid-cols-3 gap-4 mb-6">
                <input type="text" name="title" placeholder="Job Title" class="border p-2">
                <input type="text" name="location" placeholder="Location" class="border p-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2">Search</button>
            </div>
        </form>

        <!-- Search Results -->
        <div id="jobResults">
            <?php
            // Include database connection
            include('../includes/db.php');

            // Default query
            $query = "SELECT * FROM jobs WHERE 1";

            // Check for search criteria
            if (isset($_GET['title']) && !empty($_GET['title'])) {
                $title = mysqli_real_escape_string($conn, $_GET['title']);
                $query .= " AND title LIKE '%$title%'";
            }
            if (isset($_GET['location']) && !empty($_GET['location'])) {
                $location = mysqli_real_escape_string($conn, $_GET['location']);
                $query .= " AND location LIKE '%$location%'";
            }

            // Execute query
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='bg-white p-4 mb-4 rounded shadow'>";
                    echo "<h2 class='text-xl font-bold'>" . $row['title'] . "</h2>";
                    echo "<p class='text-gray-700'>" . $row['description'] . "</p>";
                    echo "<a href='view_job.php?id=" . $row['job_id'] . "' class='text-blue-500 mt-2 inline-block'>View Details</a>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-gray-700'>No jobs found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
