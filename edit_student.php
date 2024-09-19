<?php

session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = intval($_POST['student_id']);
    $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $marks = intval($_POST['marks']);

    if($marks <= 100){
        $query = "UPDATE students SET student_name = '$student_name', subject = '$subject', marks = $marks WHERE id = $student_id";
        if (mysqli_query($con, $query)) {
            $_SESSION['message'] = 'Student updated successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to update student.';
            $_SESSION['message_type'] = 'error';
        }
    }else{
        $_SESSION['message'] = "Marks cannot be exceed 100.";
        $_SESSION['message_type'] = 'error';
    }

    header('Location: home.php');
}


?>
