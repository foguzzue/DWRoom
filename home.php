<?php
session_start();
require("connect_db.php");
if (isset($_POST["addRoom"])) {

    $fileTmpPath = $_FILES["csvSubject"]["tmp_name"];

    // เปิดไฟล์ CSV
    $file = fopen($fileTmpPath, "r");
    //อ่านแถวแรก
    fgetcsv($file);

    // อ่านข้อมูลทีละบรรทัด
    while (($data = fgetcsv($file)) !== FALSE) {
        $roomName = $data[0];
        $roomType = $data[1];
        $floor = $data[2];
        $building = $data[3];
        $position = $data[4];

        $sqlroomType = "SELECT * FROM `roomtype` WHERE roomType.roomTypeName = '$roomType' ";
        $result_roomTypeId = $conn->query($sqlroomType);
        $row = $result_roomTypeId->fetch_assoc();
        $roomTypeId = $row['roomTypeId'];

        $sqlfloor = "SELECT * FROM floor WHERE floor.floorNumber = '$floor'";
        $chek1 = $conn->query($sqlfloor);
        /*while($row1 = $chek1->fetch_assoc()){
            if ($row1 == null) {
                $sql_insert_floor = "INSERT INTO `floor`(`floorId`, `floorNumber`) 
                    VALUES ('','$floor')";
                $conn->query($sql_insert_floor);
            }
        }*/
        $row1 = $chek1->fetch_assoc();
        if ($row1 == null) {
            $sql_insert_floor = "INSERT INTO `floor`(`floorId`, `floorNumber`) 
                VALUES ('','$floor')";
            $conn->query($sql_insert_floor);
        }
        $chek1 = $conn->query($sqlfloor);
        $row1 = $chek1->fetch_assoc();
        $floorId = $row1['floorId'];

        $sqlbuilding = "SELECT * FROM building WHERE building.buildingName = '$building'";
        $chek2 = $conn->query($sqlbuilding);
        $row2 = $chek2->fetch_assoc();
        if ($row2 == null) {
            $sql_insert_building = "INSERT INTO `building`(`buildingId`, `buildingName`) 
                VALUES ('','$building')";
            $conn->query($sql_insert_building);
        }
        $chek2 = $conn->query($sqlbuilding);
        $row2 = $chek2->fetch_assoc();
        $buildingId = $row2['buildingId'];

        $sqlposition = "SELECT * FROM `position` WHERE position.positionDetail = '$position' ";
        $result_positionId = $conn->query($sqlposition);
        $row3 = $result_positionId->fetch_assoc();
        $positionId = $row3['positionId'];

        // เตรียม SQL statement
        $sqlroomName = "SELECT * FROM `room` WHERE room.roomName = '$roomName' ";
        $result_roomName = $conn->query($sqlroomName);
        if (is_null($row3 = $result_roomName->fetch_assoc())) {
            $sql = "INSERT INTO room (roomId,roomName,roomTypeId,floorId,buildingId,positionId) 
            VALUES ('','$roomName', '$roomTypeId', '$floorId', '$buildingId', '$positionId')";
            // ดำเนินการ SQL statement
            if ($conn->query($sql) === FALSE) {
                echo "Error: " . $conn->error . "<br>";
            }
        }
    }
    // ปิดไฟล์
    fclose($file);
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

    <title>ระบบเพิ่มห้องเรียน</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/jpg" sizes="16x16" href="images/aifluke.jpg">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

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
                            <h5 class="card-title">เพิ่มห้องเรียน, ประเภทของห้อง, ชั้น, อาคารเรียน, อาคารภายใน/ภายนอก <br><br>
                            <a href="csv/template.xlsx" download="template.xlsx" class="btn btn-outline-primary">Download template ไฟล์ .csv</a>

                            </h5>
                            <div class="form-validation">
                                <form class="form-valide" action="" method="post" enctype="multipart/form-data">

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-currency">ข้อมูลทั้งหมด (รองรับไฟล์ชนิด csv เท่านั้น) <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="file" class="form-control" name="csvSubject" id="csvSubject" accept=".csv" required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-success" name="addRoom" value="send">ยืนยัน</button>

                                        </div>
                                    </div>
                                </form>
                            </div>

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

</body>

</html>