<head>
    <link rel="stylesheet" type="text/css" href="style/student.css">
    <script src="../../jquery-3.6.0.min.js"></script>
    <script src="script/student.js"></script>
    <script src="script/back.js"></script>
    <link rel="stylesheet" type="text/css" href="../style/back.css">
    <title>點餐系統 進階查詢 學生查詢</title>
</head>
<div class="back"></div>
<?php
$student_number = isset($_GET["student_number"]) ? $_GET["student_number"] : 0;
include_once __DIR__."/../../database.php";
$mysqli = get_mysql();
if ($student_number) {

    die(0);
}
$result = $mysqli->query("select distinct date from customer order by date desc limit 30");
while ($source = $result->fetch_assoc()) {

    $info = $mysqli->query("select * from schedule where time='{$source["date"]}'")->fetch_assoc();

    echo "
    <div class='date_block redirect_block' target='query.php?mode=date&date={$source["date"]}'>
    <span class='name'>{$info["name"]}</span><br>
    <span class='date'>{$source["date"]}</span>
    </div>";
}


?>
