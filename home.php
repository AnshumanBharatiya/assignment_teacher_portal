<!-- home.html -->


<?php
session_start();
include('db.php');

if (!isset($_SESSION['teacher'])) {
    header('Location: index.php');
    exit();
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];

    // Determine the color class based on message type
    $alert_class = $message_type === 'success' ? 'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400' : 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400';
    $alert_text = $message_type === 'success' ? 'Success!' : 'Error!';

    // Display the message in the specified alert box format
    echo "<div class='p-4 mb-4 text-sm $alert_class rounded-lg' role='alert'>";
    echo "<span class='font-medium'>$alert_text</span> $message";
    echo "</div>";

    // Unset the message after displaying it
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}


// get all the data
$query = "SELECT * FROM students";
$result = mysqli_query($con, $query);
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal - Student Listing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>

    <div>
        <header class='flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50'>
            <div class='flex flex-wrap items-center justify-between gap-5 w-full'>
                <a href="javascript:void(0)" class='w-36 text-red-500 font-extrabold' style="width:80%;">Teacher Portal
                </a>

                <div id="collapseMenu"
                    class='max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50'>
                    <button id="toggleClose" class='lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white p-3'>
                        <svg class="w-4 fill-black" viewBox="0 0 320.591 320.591">
                            <path
                                d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                                data-original="#000000"></path>
                            <path
                                d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                                data-original="#000000"></path>
                        </svg>
                    </button>

                    <ul
                        class='lg:flex gap-x-5 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50'>

                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='home.php'
                                class='hover:text-[#007bff] text-[#007bff] block font-semibold text-[15px]'>Home</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='logout.php'
                                class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Logout</a>
                        </li>
                    </ul>
                </div>

                <div class='flex max-lg:ml-auto space-x-3'>
                    <button id="toggleOpen" class='lg:hidden'>
                        <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </header>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5">

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Subject</th>
                        <th scope="col" class="px-6 py-3">Mark</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php $uniqueId = $row['id']; // Use unique ID for modal and dropdown 
                            ?>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 p-2 text-center me-5">
                                        <?php echo strtoupper(substr($row['student_name'], 0, 1)); ?>
                                    </div>
                                    <div class="text-base font-semibold"><?php echo $row['student_name']; ?></div>
                                </td>
                                <td class="px-6 py-4"><?php echo $row['subject']; ?></td>
                                <td class="px-6 py-4"><?php echo $row['marks']; ?></td>
                                <td class="px-6 py-4">
                                    <div>
                                        <button id="dropdownActionButton<?php echo $uniqueId; ?>" data-dropdown-toggle="dropdownAction<?php echo $uniqueId; ?>" class="h-10 w-10 rounded-full  p-2.5 text-center me-2" type="button" style="background:black;">
                                            <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="text-white h-5 w-5">
                                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownAction<?php echo $uniqueId; ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                            <ul class="py-1 text-sm text-gray-700">
                                                <li data-modal-target="editUserModal<?php echo $uniqueId; ?>" data-modal-show="editUserModal<?php echo $uniqueId; ?>">
                                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="delete_student.php?id=<?php echo $uniqueId; ?>" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Edit user modal -->
                                        <div id="editUserModal<?php echo $uniqueId; ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-2xl max-h-full">
                                                <!-- Modal content -->
                                                <form class="relative bg-white rounded-lg shadow" action="edit_student.php" method="POST">
                                                    <input type="hidden" name="student_id" value="<?php echo $uniqueId; ?>">
                                                    <!-- Modal header -->
                                                    <div class="flex items-start justify-between p-4 border-b rounded-t">
                                                        <h3 class="text-xl font-semibold text-gray-900">Edit Student</h3>
                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="editUserModal<?php echo $uniqueId; ?>">
                                                            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="p-6 space-y-6">
                                                        <div class="grid grid-cols-1 gap-6">
                                                            <div class="col-span-6 sm:col-span-3">
                                                                <label for="student_name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                                                                <input type="text" name="student_name" id="student_name" value="<?php echo $row['student_name']; ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                                                            </div>
                                                            <div class="col-span-6 sm:col-span-3">
                                                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900">Subject</label>
                                                                <input type="text" name="subject" id="subject" value="<?php echo $row['subject']; ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                                                            </div>
                                                            <div class="col-span-6 sm:col-span-3">
                                                                <label for="marks" class="block mb-2 text-sm font-medium text-gray-900">Mark</label>
                                                                <input type="number" name="marks" id="marks" value="<?php echo $row['marks']; ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b">
                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>


            <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white ">
                <div>
                    <button class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-1.5   " type="button" data-modal-target="addUserModal" data-modal-show="addUserModal">
                        <span class="sr-only">Action button</span>
                        Add
                    </button>


                    <!-- Add user modal -->
                    <div id="addUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <form class="relative bg-white rounded-lg shadow " action="add_student.php" method="POST">
                                <!-- Modal header -->
                                <div class="flex items-start justify-between p-4 border-b rounded-t">
                                    <h3 class="text-xl font-semibold text-gray-900 ">
                                        Add user
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center  " data-modal-hide="addUserModal">
                                        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <div class="grid grid-cols-1 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="student_name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                                            <input type="text" name="student_name" id="student_name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5  " placeholder="Shiv Yadab" required="">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 ">Subject</label>
                                            <input type="text" name="subject" id="subject" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5  " placeholder="Math" required="">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="marks" class="block mb-2 text-sm font-medium text-gray-900 ">Mark</label>
                                            <input type="number" name="marks" id="marks" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5  " placeholder="77" required="">
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="app.js"></script>

</body>

</html>