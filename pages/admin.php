

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
                        <a class="nav-link active" href="admin.php">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="appevents.php">
                            Pending Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="newmod.php">
                            Add New Moderator
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="col-md-10 col-lg-10 col-xl-10 col-12 shadow-lg" id="content">
            <div class="topper">            
            <h1 class="dash">Dashboard</h1>
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
            <div class="boxes">
                <div class="box box1 shadow-lg">
                    <h2>0</h2>
                    <p>Pending Approvals</p>
                    <div class="detailslink"><a href="#" class="view-details">View Details</a><i class="fa-solid fa-arrow-right"></i></div>
                </div>
                <div class="box box2 shadow-lg">
                    <h2>0</h2>
                    <p>Pending Edits</p>
                    <div class="detailslink"><a href="#" class="view-details">View Details</a><i class="fa-solid fa-arrow-right"></i></div>
                </div>
                <div class="box box3 shadow-lg">
                    <h2>0</h2>
                    <p>Total Events</p>
                    <div class="detailslink"><a href="#" class="view-details">View Details</a><i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </div>
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