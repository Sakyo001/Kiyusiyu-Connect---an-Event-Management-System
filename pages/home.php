

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
                    <div class="text-center">
                        <h2>Categories</h2>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <span class="nav-link disabled">Organizations</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> QCU Supreme Student Council
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> QCU Creative Student Society - LIKHA Production
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> QCU Times Publication
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link disabled">Divisions</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> Quezon City University Affairs and Services Division
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> QCU Registrar and Admission Division
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> QCU Scholarship, Placement, and Alumni
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link disabled">Departments</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> QCU Creative Student Society - LIKHA Production
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home" style="color: black;"></i> QCU Times Publication
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
                <div class="container col-md-8 d-flex flex-row">
                    <div class="col-auto">
                        <h1 class="h3">Recently Posted</h1>
                    </div>
                    <!-- Date dropdown -->
                    <input type="date" class="form-control mx-2" id="dateDropdown">
                    <!-- Dropdown for "posted from" -->
                    <select class="form-select mx-2" id="postedFromDropdown">
                        <option selected>Posted From</option>
                        <!-- Add your posted from options here -->
                        <option value="link1">Link 1</option>
                        <option value="link2">Link 2</option>
                        <option value="link3">Link 3</option>
                    </select>
                </div>

                <div class="container">
    <div class="row mt-5">
        <?php
        // Include your database connection file
        include 'db_connection.php';

        // Fetch only APPROVED events from the database
        $sql = "SELECT * FROM SE.EVENTS WHERE STATUS = 'APPROVED'";
        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);
        $events = array();
        while ($row = oci_fetch_array($stmt, OCI_ASSOC | OCI_RETURN_LOBS)) {
            $events[] = $row;
        }

        foreach ($events as $event) { ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm rounded"> <!-- Add rounded corners to the card -->
                    <div class="card-header text-center"> <!-- Center align the text -->
                        <h2 class="my-0 font-weight-normal"><?php echo $event['EVENT_NAME']; ?></h2>
                        <small class="text-center d-block mx-auto"><?php echo date('F j, Y', strtotime($event['START_TIME'])); ?></small> <!-- Center the date -->
                    </div>
                    <div class="card-body text-center"> <!-- Center the content within the card body -->
                        <!-- Modify the src attribute to point to the correct directory -->
                        <img src="../uploads/<?php echo $event['IMAGE_PATH']; ?>" class="img-fluid mx-auto d-block rounded" alt="Event Image"> <!-- Center the image horizontally and add rounded corners -->
                        <div class="container px-4"> <!-- Add padding for spacing -->
                            <h4 class="card-text px-4 py-2"><?php echo $event['EVENT_TYPE']; ?></h4> <!-- Wrap the event type in a container for padding -->
                        </div>
                        <!-- Change the structure for full width buttons and add background colors -->
                        <div class="d-flex border-pill justify-content-between align-items-center mt-3"> <!-- Add margin top for spacing -->
                            <button type="button" class="btn btn-sm btn-outline-secondary w-50 text-white p-3 border-0" style="background-color: blue;">View</button> <!-- Use inline style for white background and black text -->
                            <button type="button" class="btn btn-sm btn-outline-secondary w-25 text-blue p-3 border-0" style="background-color: lightblue; color: blue;"> <!-- Use inline style for blue background and white text -->
                                <i class="fas fa-thumbs-up"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary w-25 text-white p-3 border-0" style="background-color: green;"> <!-- Use inline style for green background and white text -->
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>



            </main>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper.js -->
    <script src="../index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
