<?php
session_start();

if(isset($_POST['submit'])) {
    $_SESSION['event_name'] = $_POST['eventName'];
    $_SESSION['start_time'] = $_POST['startTime'];
    $_SESSION['end_time'] = $_POST['endTime'];
    $_SESSION['event_type'] = $_POST['eventType'];
    $_SESSION['event_details'] = $_POST['eventDetails'];

    // Handle file upload if a file is selected
    if(isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === 0) {
        $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
        $fileName = $_FILES['fileUpload']['name'];
        $fileSize = $_FILES['fileUpload']['size'];
        $fileType = $_FILES['fileUpload']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // You can specify the upload directory
        $uploadDir = 'uploads/';
        $newFileName = uniqid() . '.' . $fileExtension;
        $destFilePath = $uploadDir . $newFileName;

        // Move the uploaded file to the desired location
        if(move_uploaded_file($fileTmpPath, $destFilePath)) {
            $_SESSION['image_path'] = $destFilePath; // Store the file path in the session
            echo "File uploaded successfully. Image path: " . $_SESSION['image_path']; // For debugging
        } else {
            // Handle upload failure
            echo "File upload failed!";
        }
    }

    header("Location: preview.php");
    exit();
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../style/style1.css">
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
                    <button type="button" class="btn btn-primary btn-lg">
                        Create Event 
                    </button>
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
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                        
                    <div class="mr-3 col-auto">
                     <h1 class="h2" style="margin-right:10px;">Discover Events</h1>
                    </div>
                        <div class="input-group">
                            <div class="form-outline">
                                <input type="search" id="form1" class="form-control" />
                            </div>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <a href="#" class="nav-link">
                            <i class="fas fa-bell"></i>
                        </a>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../login.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <div>
    <div class="container">
        <h2 class="mt-4 mb-3">Propose New Event</h2>
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Event Name/Title</label>
                        <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Enter event name/title" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="startTime" class="form-label">Event Start Time</label>
                        <input type="datetime-local" class="form-control" id="startTime" name="startTime" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="endTime" class="form-label">Event End Time</label>
                        <input type="datetime-local" class="form-control" id="endTime" name="endTime" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="eventType" class="form-label">Event Type</label>
                        <select class="form-select" id="eventType" name="eventType" required>
                            <option value="" selected disabled>Select event type</option>
                            <option value="type1">Type 1</option>
                            <option value="type2">Type 2</option>
                            <option value="type3">Type 3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="eventDetails" class="form-label">Event Details</label>
                        <textarea class="form-control" id="eventDetails" name="eventDetails" rows="3" placeholder="Enter event details"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" name="submit" class="btn btn-primary">Next</button>
                </div>
            </div>
        </form>
    </div>
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
