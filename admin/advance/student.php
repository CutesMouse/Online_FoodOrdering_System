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
$result = $mysqli->query("select distinct student_number from customer order by number");
while ($source = $result->fetch_assoc()) {

    $info = $mysqli->query("select * from student where student_number='{$source["student_number"]}'")->fetch_assoc();

    echo "
    <div class='student_block redirect_block' target='query.php?mode=student&number={$info["number"]}&student_number={$source["student_number"]}'>
    <span class='seat_number'>{$info["number"]}</span><br>
    <span class='student_name'>{$info["name"]}</span>
    </div>";


}


?>
