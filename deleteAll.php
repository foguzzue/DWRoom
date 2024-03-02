<?php
session_start();
require("connect_db.php");
if (isset($_POST["deleteAll"])) {

    // เตรียม SQL statement
    $sql = "DELETE FROM room";

    // ดำเนินการ SQL statement
    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $conn->error . "<br>";
    }

    $conn->query("ALTER TABLE `room` AUTO_INCREMENT = 0");

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- theme meta -->
    <meta name="theme-name" content="quixlab" />

    <title>ระบบลบห้องเรียนทั้งหมด</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/jpg" sizes="16x16" href="images/aifluke.jpg">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">


</head>

<body>




    <?php include('./layout.php'); ?>

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-10" style="display: block; justify-content: center; align-items: center;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ลบข้อมูลห้องเรียนทั้งหมด<br><br>
                                <form class="form-valide" action="" method="post"enctype="multipart/form-data">
                                    <button type="submit" class="btn btn-danger delete-btn">ลบทั้งหมด</button>
                                </form>
                            </h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
            Content body end
        ***********************************-->


    <!--**********************************
            Footer start
        ***********************************-->

    <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="./js/dashboard/dashboard-1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(".delete-btn").click(function(e) {
            e.preventDefault();
            deleteConfirm();
        })

        function deleteConfirm() {
            Swal.fire({
                title: 'Are you sure?',
                text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '##008000',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'deleteAll.php',
                                type: 'POST',
                                data: 'deleteAll',
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'Data deleted successfully!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'home.php';
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong!', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        }
    </script>

</body>

</html>