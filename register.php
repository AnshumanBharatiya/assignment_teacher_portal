<!-- register.php -->
<?php
session_start();
include('db.php'); // Include the database connection

if (isset($_SESSION['teacher'])) {
    header('Location: home.php');
    exit();
}

$errors = [];
$success = "";

// Handle Registration Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username=mysqli_real_escape_string($con,$_REQUEST['username']);
    $password=mysqli_real_escape_string($con,$_REQUEST['password']);
    $confirm_password=mysqli_real_escape_string($con,$_REQUEST['confirm_password']);


    // Validate Inputs
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    } else {

        // Check if the username already exists
        $query_search="SELECT * FROM teachers WHERE username='$username'";
        $sresult=mysqli_query($con,$query_search);
        $result_count = mysqli_num_rows($sresult);

        if ($result_count > 0) {
            $errors[] = "Username already exists. Please choose another one.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security
            $insert_query="INSERT INTO teachers (username, password) values ('$username','$hashed_password')";
            $iresult=mysqli_query($con,$insert_query);

            if ($iresult) {
                $success = "Registration successful! You can now log in.";
            } else {
                $errors[] = "Failed to register. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="container">
        
        <div class="flex flex-col justify-center font-[sans-serif] sm:h-screen p-4">
            <div class="flex justify-center mt-10 mb-8">
                <h1 class="text-xl">Teacher Portal Registration</h1>
            </div>
            <div class="max-w-md w-full mx-auto border border-gray-300 rounded-2xl p-8">
                
                <form method="POST" action="register.php">

                    <div class="space-y-6">
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">User Name</label>
                            <input type="text" class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500" placeholder="User Name" id="username" name="username" required>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <input type="password" class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500" placeholder="Enter password" id="password" name="password" />
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Confirm Password</label>
                            <input type="password" class="text-gray-800 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500" placeholder="Enter confirm password" id="confirm_password" name="confirm_password" />
                        </div>


                    </div>

                    <div class="!mt-12">
                        <button class="w-full py-3 px-4 text-sm tracking-wider font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none" type="submit">
                            Create an account
                        </button>

                        <div>

                            <!-- Display errors if any -->
                            <?php if (!empty($errors)): ?>
                                <div class="error">
                                    <?php foreach ($errors as $error): ?>
                                        <p style="color:red; margin:15px 0px;"><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Display success message -->
                            <?php if ($success): ?>
                                <div class="success">
                                    <p style="color:green; margin:15px 0px;"><?php echo $success; ?></p>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        
                    </div>

                    <p class="text-gray-800 text-sm mt-6 text-center">Already have an account? <a href="index.php" class="text-blue-600 font-semibold hover:underline ml-1">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>