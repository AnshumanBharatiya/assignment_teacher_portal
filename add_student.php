<?php
session_start(); // Start the session
include('db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $student_name = mysqli_real_escape_string($con, trim($_POST['student_name']));
    $subject = mysqli_real_escape_string($con, trim($_POST['subject']));
    $marks = intval($_POST['marks']); // Sanitize the marks input

    // Check if student with same name and subject already exists
    $check_query = "SELECT * FROM students WHERE student_name = '$student_name' AND subject = '$subject'";
    $result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Student exists, update marks
        $row = mysqli_fetch_assoc($result);
        $existing_marks = $row['marks'];
        $new_marks = $existing_marks + $marks; // Add the new marks to the existing marks

        if($new_marks <= 100){
            $update_query = "UPDATE students SET marks = $new_marks WHERE student_name = '$student_name' AND subject = '$subject'";
            $update_result = mysqli_query($con, $update_query);

            if ($update_result) {
                $_SESSION['message'] = "Student's marks updated successfully!";
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = "Failed to update student's marks. Please try again.";
                $_SESSION['message_type'] = 'error';
            }
        }else{
          
            $_SESSION['message'] = "Marks cannot be exceed 100.";
            $_SESSION['message_type'] = 'error';
        }
       
    } else {
        // Student doesn't exist, insert new record
        $insert_query = "INSERT INTO students (student_name, subject, marks) VALUES ('$student_name', '$subject', $marks)";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            $_SESSION['message'] = "New student record successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to add new student. Please try again.";
            $_SESSION['message_type'] = 'error';
        }
    }
    // Redirect back to the home page
    header('Location: home.php');
    exit();
}
?>
