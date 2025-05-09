<?php
error_reporting(0);
session_start();
$admin = $_SESSION['admin_email'];
if(!isset($admin)){
   header('location:adminlogin.php');
}
@include 'config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo1.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/table.css">
    <title>CarLux</title>
</head>

<body>

   <?php @include 'header.php'; ?>
    <div class="content">
        </nav>
        <!-- End of Navbar -->
        <main>
            <div class="header">
                <div class="left">
                    TIME
                        <div class="digital_clock "></div>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                            <div class="topbar-divider d-none d-sm-block"></div>
                    <ul class="breadcrumb">
                        <li><a href="#">
                        Dashboard
                            </a></li>
                        /
                        <li><a href="#">
                            Cars
                            </a></li>
                        /
                        <li><a href="#" class="active">fuel cars</a></li>
                    </ul>
                </div>
            </div>

            <div class="group">
                <svg class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
                <input id="search-input" placeholder="Search by car or brand" type="search" class="input">
            </div>

            <br><br>
            <table id="vehicle-table" class="table" >
                <thead>
                  <tr>
                    <th>Car id</th>
                    <th>IMAGE</th>
                    <th>car NAME</th>
                    <th>BRAND</th>
                    <th>PRICE</th>
                    <th>fueltype</th>
                    <th>placed date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                <a href='addfuelcar.php' class="addbtn">Add New</a><br><br>
                <?php
                mysqli_select_db($con, "carlux");
                $q1 = "SELECT * FROM `fuel_car`";
                $result = mysqli_query($con, $q1);
                if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                ?>

                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="vehicleimg/.<?php echo $row['image1']; ?>" height="60" alt="aks"></td>
                    <td><?php echo $row['carname']; ?></td>
                    <td><?php echo $row['brand']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['fueltype']; ?></td>
                    <td><?php echo $row['placed_date']; ?></td>
                    <td>
                        <a href="updatefuelcar.php?edit=<?php echo $row['id']; ?>" class="update-btn"><span class="material-symbols-outlined">edit</span></a>
                        <a href="viewfuelcar.php?delete=<?php echo $row['id']; ?>"  onclick="return confirm('are your sure you want to delete this?');" class="delete-btn" ><ico class="material-symbols-outlined">delete</ico>
                        <a href="carreview.php?review=<?php echo $row['carname']; ?>"  class="review-btn" ><span class="material-symbols-outlined">star</span>
                    </td>
                  </tr>
                  <?php
                  }    
                  }
               ?>
                </tbody>
                </table>
        </main>
    </div>
    <script src="js/admin.js"></script>
    <script src="js/time.js"></script>
    <script src="js/search.js"></script>
</body>
</html>
<?php
error_reporting(0);
session_start();
$con=mysqli_connect("localhost","root","","carlux");
if(!$con)
{
die("Failed to coonect");
}	

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_select_db($con, "carlux");
    $q1 = "DELETE FROM `fuel_car` WHERE id = $delete_id ";
    $result = mysqli_query($con, $q1);
    if($result){
        ?>
           <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                    });

                    // Redirect after 4 seconds (same as the timer duration)
                    setTimeout(() => {
                        window.location.href = "viewfuelcar.php";
                    }, 1500);
            </script>
            <?php
    }
 }
 
?>