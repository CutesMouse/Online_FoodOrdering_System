<head>
    <link rel="stylesheet" type="text/css" href="style/student.css">
    <script src="../../jquery-3.6.0.min.js"></script>
    <script src="script/student.js"></script>    <script src="script/back.js"></script>
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
$result = $mysqli->query("select distinct cnt,ip from customer c1 join (select ip as p,date as d, count(ip) as cnt from customer group by p,d) c2
                                                  on (c1.ip = c2.p and c1.date = c2.d) order by cnt desc");
while ($source = $result->fetch_assoc()) {
    echo "
    <div class='ip_block redirect_block' target='query.php?mode=ip&ip={$source["ip"]}'>
    <span class='cnt'>{$source["cnt"]}</span><br>
    <span class='ip'>{$source["ip"]}</span>
    </div>";


}


?>
