<?php
session_start();

// Include your database connection file
include 'db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the event ID from the request
    $event_id = $_POST['event_id'];

    // Check the action from the request (approve or reject)
    if (isset($_POST['approve'])) {
        $action = 'APPROVED';
    } elseif (isset($_POST['reject'])) {
        $action = 'REJECTED';
    }

    // Update the status of the event in the database
    $sql = "UPDATE SE.EVENTS SET STATUS = :action WHERE EVENT_ID = :event_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':action', $action);
    oci_bind_by_name($stmt, ':event_id', $event_id);
    oci_execute($stmt);

    // Redirect the user back to the pending events page
    header('Location: appevents.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="icon" type="image/x-icon" href="images/qculogo.png">
    <link rel="stylesheet" href="../style/adminstyle.css">
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
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="admin.php"> Dashboard </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="appevents.php"> Pending Events </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="newmod.php"> Add New Moderator </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="col-md-10 col-lg-10 col-xl-10 col-12 shadow-lg" id="content">
                <div class="topper">
                    <h1 class="dash">Pending Events</h1>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../login.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <table class="table table-bordered">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Event Type</th>
                <th>Event Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include your database connection file
            include 'db_connection.php';

            // Fetch pending events from the database
            $sql = "SELECT * FROM SE.EVENTS WHERE STATUS = 'PENDING' OR STATUS IS NULL";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);
            $events = array();
            while ($row = oci_fetch_array($stmt, OCI_ASSOC | OCI_RETURN_LOBS)) {
                $events[] = $row;
            }

            foreach ($events as $row) {
            ?>
                <tr>
                    <form method="post" action="">
                        <input type="hidden" name="event_id" value="<?php echo $row['EVENT_ID']; ?>">
                        <td><?php echo $row['EVENT_NAME']; ?></td>
                        <td><?php echo $row['START_TIME']; ?></td>
                        <td><?php echo $row['END_TIME']; ?></td>
                        <td><?php echo $row['EVENT_TYPE']; ?></td>
                        <td>
                            <?php
                            // Check if EVENT_DETAILS is a CLOB
                            if (is_object($row['EVENT_DETAILS'])) {
                                // Read the contents of the CLOB object using oci_lob_read()
                                $eventDetails = $row['EVENT_DETAILS'];
                            } else {
                                // EVENT_DETAILS is already a string, so assign it directly
                                $eventDetails = $row['EVENT_DETAILS'];
                            }
                            ?>
                            <?php echo is_null($eventDetails) ? '' : $eventDetails; ?>
                        </td>
                        <td>
                            <!-- Approve and Delete buttons with Font Awesome icons -->
                            <button type="submit" name="approve" class="btn btn-success"><i class="fas fa-check"></i> Approve</button>
                            <button type="submit" name="reject" class="btn btn-danger"><i class="fas fa-trash"></i> Reject</button>
                        </td>
                    </form>
                </tr>
            <?php } ?>
        </tbody>
    </table>
            </div>
        </div>
    </div>
    </main>
    </div>
    </div>
    <script src="../index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
