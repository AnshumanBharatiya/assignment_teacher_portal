# assignment_teacher_portal# Teacher Portal

This project is a Teacher Portal built using **PHP**, **HTML**, **CSS**, and **vanilla JavaScript**. It allows teachers to log in, view, add, edit, and delete student information. The system handles database integration using **MySQL**.

## Requirements

### Software

- **XAMPP**: Required to run the Apache server and MySQL database.

  
- **PHP**: Included with XAMPP to run the back-end logic of the portal.

### Steps to Install

1. **Install XAMPP**: Download and install XAMPP from the official website.

2. **Set Up Project Directory**:
   - Navigate to the `xampp/htdocs` folder.
   - Create a new folder called `teacher_portal`.
   - Copy all the project files into this folder.

3. **Import the Database**:
   - Start **Apache** and **MySQL** from the XAMPP Control Panel.
   - Open `http://localhost/phpmyadmin` in your browser.
   - Create a new database called `teacher_portal`.
   - Import the provided SQL file `SQL DB/teacher_portal.sql`:
     - Go to the **Import** tab in phpMyAdmin.
     - Select the `teacher_portal.sql` file and click **Go**.

4. **Configure Database Connection**:
   - Open `db.php` and ensure the database connection matches your local setup. For XAMPP, this is typically:
     ```php
     <?php
     $con = mysqli_connect("localhost", "root", "", "teacher_portal");
     if (!$con) {
         die("Connection failed: " . mysqli_connect_error());
     }
     ?>
     ```

5. **Run the Project**:
   - Open your browser and navigate to `http://localhost/teacher_portal/index.php`.
   - Log in using the credentials stored in the database (or register a new teacher).

## Project Structure

```bash
teacher_portal/
├── SQL DB/
│   └── teacher_portal.sql     # Database export file
├── db.php                     # Database connection
├── home.php                   # Teacher portal home and student listing
├── index.php                  # Login page
├── register.php               # Teacher registration
├── add_student.php            # Logic to add new student
├── edit_student.php           # Logic to edit student details
└── delete_student.php         # Logic to delete a student
