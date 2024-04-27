<?php
session_start();

// Include your database connection file
include 'db_connection.php';

// Initialize variable to track insertion status
$inserted = false;

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve data from session
    $eventName = isset($_SESSION['event_name']) ? $_SESSION['event_name'] : '';
    
    // Convert string date to timestamp
    $startTime = isset($_SESSION['start_time']) ? strtotime($_SESSION['start_time']) : '';
    $endTime = isset($_SESSION['end_time']) ? strtotime($_SESSION['end_time']) : '';

    // Format dates as YYYY-MM-DD HH:MI:SS
    $formattedStartTime = date('Y-m-d H:i:s', $startTime);
    $formattedEndTime = date('Y-m-d H:i:s', $endTime);

    $eventType = isset($_SESSION['event_type']) ? $_SESSION['event_type'] : '';
    $eventDetails = isset($_SESSION['event_details']) ? $_SESSION['event_details'] : '';

    // Retrieve data from form
    $letterOfApproval = isset($_POST['letterOfApproval']) ? $_POST['letterOfApproval'] : '';

    // Handle file upload if a file is selected
    $imagePath = null;
    if(isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === 0) {
        $fileTmpPath = $_FILES['imageUpload']['tmp_name'];
        $fileName = $_FILES['imageUpload']['name'];
        $fileSize = $_FILES['imageUpload']['size'];
        $fileType = $_FILES['imageUpload']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // You can specify the upload directory
        $uploadDir = '../uploads/';

        // Move the uploaded file to the desired location
        $newFileName = uniqid() . '.' . $fileExtension;
        $destFilePath = $uploadDir . $newFileName;
        if(move_uploaded_file($fileTmpPath, $destFilePath)) {
            $imagePath = $destFilePath; // Store the file path
        } else {
            // Handle upload failure
            echo "File upload failed!";
            exit; // Terminate the script if file upload fails
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO SE.EVENTS (EVENT_ID, EVENT_NAME, START_TIME, END_TIME, EVENT_TYPE, EVENT_DETAILS, LETTER_OF_APPROVAL, IMAGE_PATH) 
            VALUES (SE.EVENT_ID_SEQ.NEXTVAL, :eventName, TO_TIMESTAMP(:startTime, 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP(:endTime, 'YYYY-MM-DD HH24:MI:SS'), :eventType, :eventDetails, :letterOfApproval, :imagePath)";

    $stmt = oci_parse($conn, $sql); // Prepare the statement
    oci_bind_by_name($stmt, ':eventName', $eventName);
    oci_bind_by_name($stmt, ':startTime', $formattedStartTime);
    oci_bind_by_name($stmt, ':endTime', $formattedEndTime);
    oci_bind_by_name($stmt, ':eventType', $eventType);
    oci_bind_by_name($stmt, ':eventDetails', $eventDetails);
    oci_bind_by_name($stmt, ':letterOfApproval', $letterOfApproval);
    oci_bind_by_name($stmt, ':imagePath', $imagePath); // Bind the image path parameter

    // Execute the statement and set $inserted to true if successful
    $inserted = oci_execute($stmt);

    if($inserted) {
        // Output the success message container
        echo '<div class="success-container">';
        echo '<i class="fas fa-check-circle"></i>';
        echo '<span>Event inserted successfully into the database.</span>';
        echo '</div>';
    } else {
        // Handle insertion failure
        echo "Failed to insert event into the database.";
    }
}
?>




    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="../style/style2.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    </head>
    <body>
 


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid m-1 p-3 rounded-pill custom-rounded shadow-lg">
            <div class="d-flex">
                <img src="../images/qculogo.png" class="custom-wh rounded-pill" alt="">
                <h1>Kiyusiyu Connect</h1>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3 rounded-3">
        <div class="row">
            <nav class="col-md-2 col-lg-2 col-xl-2 col-12 bg-light sidebar">
                <div class="sidebar-sticky p-3 shadow-lg">
                <div class="sidebar-sticky p-3 shadow-lg">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="moderator.php" class="btn btn-primary btn-lg">
                            Create Event 
                        </a>
                    </div>
                </div>



                    <ul class="nav flex-column">
                    

                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black; font-size:24;"></i> QCU Registrar and Admission Division
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black; font-size:24;"></i> Pending for Approval
                            </a>
                        </li>


                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="container-fluid">
                <div class="row">
            <!-- Your HTML content to display saved data -->
                <h2>Preview Event</h2>
                <p>Event Name: <?php echo isset($_SESSION['event_name']) ? $_SESSION['event_name'] : 'Not set'; ?></p>
                <p>Start Time: <?php echo isset($_SESSION['start_time']) ? $_SESSION['start_time'] : 'Not set'; ?></p>
                <p>End Time: <?php echo isset($_SESSION['end_time']) ? $_SESSION['end_time'] : 'Not set'; ?></p>
                <p>Event Type: <?php echo isset($_SESSION['event_type']) ? $_SESSION['event_type'] : 'Not set'; ?></p>
                <p>Event Details: <?php echo isset($_SESSION['event_details']) ? $_SESSION['event_details'] : 'Not set'; ?></p>
                <!-- Display uploaded image -->
          

                <!-- Text area for letter of approval -->
                <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="imageUpload" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="imageUpload" name="imageUpload">
                </div>

                    <div class="mb-3">
                        <label for="letterOfApproval" class="form-label">Letter of Approval</label>
                        <textarea class="form-control" id="letterOfApproval" name="letterOfApproval" rows="5" placeholder="Enter letter of approval"></textarea>
                    </div>

                    <!-- Submit button -->
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <!-- End of HTML content -->
                </div>
            </div>
                
            </main>


                </div>
            </div>

    <!-- 
    <footer class="footer">
        <div class="container">
            <span>Footer Content</span>
        </div>
    </footer> -->

    <!-- Bootstrap Bundle with Popper.js -->
    <script>
        function redirectToReview() {
            window.location.href = 'review.php';
        }
    </script>

    <script src="../index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
