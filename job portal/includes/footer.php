<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <!-- Footer Section -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6">
        <!-- Footer Content -->
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Navigation Links -->
            <div class="mb-4 md:mb-0">
                <ul class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-6">
                    <li><a href="index.php" class="hover:text-gray-300">Home</a></li>
                    <li><a href="about.php" class="hover:text-gray-300">About</a></li>
                    <li><a href="contact.php" class="hover:text-gray-300">Contact</a></li>
                    <li><a href="privacy.php" class="hover:text-gray-300">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Social Media Links -->
            <div class="mb-4 md:mb-0">
                <a href="#" class="text-gray-400 hover:text-white mx-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-gray-400 hover:text-white mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-gray-400 hover:text-white mx-2"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-gray-400 hover:text-white mx-2"><i class="fab fa-instagram"></i></a>
            </div>

            <!-- Contact Information -->
            <div>
                <p>Contact Us: <a href="mailto:support@jobportal.com" class="hover:text-gray-300">support@jobportal.com</a></p>
                <p>Call Us: <a href="tel:+1234567890" class="hover:text-gray-300">+123 456 7890</a></p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 text-center">
            <p>&copy; <?php echo date("Y"); ?> Job Portal. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Include FontAwesome for Social Media Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
