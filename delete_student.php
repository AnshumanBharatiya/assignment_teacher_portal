<?php
session_start();
include('db.php');

if (isset($_GET['id'])) {
    $student_id = intval($_GET['id']);

    $query = "DELETE FROM students WHERE id = $student_id";
    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = 'Student deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to delete student.';
        $_SESSION['message_type'] = 'error';
    }

    header('Location: home.php');
}
?>
