<?php
$mode = isset($_GET["mode"]) ? $_GET["mode"] : 0;
if (!$mode) {
    echo "<script>window.open('../index.php','_self')</script>";
    exit(0);
}
// $arg is an array with key => default value(GET)
function get_data($arg)
{
    $d = [];
    foreach ($arg as $key => $value) {
        $d[$key] = isset($_GET[$key]) ? $_GET[$key] : $value;
    }
    return $d;
}

include_once __DIR__."/../../database.php";
$mysqli = get_mysql();

$query = "";
$d = 0;
switch ($mode) {
    case "student":
        $d = get_data(["number" => 0, "student_number" => 0]);
        if ($d["number"]) {
            $query = "select * from customer where number={$d["number"]} and student_number={$d["student_number"]} order by date desc";
        }
        break;
    case "date":
        $d = get_data(["date" => 0]);
        if ($d["date"]) {
            $query = "select * from customer where date='{$d["date"]}' order by number";
        }
        break;
    case "ip":
        $d = get_data(["ip" => 0]);
        if ($d["ip"]) {
            $query = "select * from customer c1 join (select date as d,ip as p,count(*) as cnt from customer group by d,p) c2
on (c1.date = c2.d and c1.ip = c2.p) where ip='{$d["ip"]}' order by cnt desc";
        }
        break;
    default:
        echo "<script>window.open('../index.php','_self')</script>";
        break;
}
?>
<head>
    <link rel="stylesheet" type="text/css" href="style/query.css">
    <link rel="stylesheet" type="text/css" href="../style/today.css">
    <script src="../../jquery-3.6.0.min.js"></script>
    <script src="script/query.js"></script>
    <script src="script/back.js"></script>
    <link rel="stylesheet" type="text/css" href="../style/back.css">
    <title>點餐系統 進階設定 查詢</title>
</head>
<body>
<div class="back"></div>
<div class="tool_box">
    <label><input type="checkbox" checked name="number">座號</label>
    <label><input type="checkbox" checked name="name">姓名</label>
    <label><input type="checkbox" checked name="date">日期</label>
    <label><input type="checkbox" name="restaurant">餐廳</label><br>
    <label><input type="checkbox" checked name="order">項目</label>
    <label><input type="checkbox" checked name="price">金額</label>
    <label><input type="checkbox" name="ip">IP</label>
    <label><input type="checkbox" name="time">繳交時間</label>
</div>
<div class="table_box"><br>
<table>
    <thead>
    <tr>
        <th class="number">座號</th>
        <th class="name">姓名</th>
        <th class="date">日期</th>
        <th class="restaurant invis">餐廳</th>
        <th class="order">項目</th>
        <th class="price">金額</th>
        <th class="ip invis">IP</th>
        <th class="time invis">繳交時間</th>
        <th>刪除</th>
    </tr>
    </thead>
    <tbody>
    <?php
    require_once __DIR__."/../bg/restaurant_manager.php";
    $result = $mysqli->query($query);
    while ($data = $result->fetch_assoc()) {
        $student = $mysqli->query("select * from student where student_number={$data["student_number"]}")->fetch_assoc();
        $schedule = $mysqli->query("select * from schedule where time='{$data["date"]}'")->fetch_assoc();
        $price_list = getPriceList($schedule["name"]);
        if ($mode === "ip") $data["ip"] .= "({$data["cnt"]})";
        echo "<tr>
        <td class='number'>{$data["number"]}</td>
        <td class='name'>{$student["name"]}</td>
        <td class='date'>{$data["date"]}</td>
        <td class='restaurant invis'>{$schedule["name"]}</td>
        <td class='order'>{$data["order"]}</td>
        <td class='price'>{$price_list[$data["order"]]}</td>
        <td class='ip invis'>{$data["ip"]}</td>
        <td class='time invis'>{$data["time"]}</td>
        <td><span class='delete' uid='{$data["uid"]}'></span></td>
    </tr>";
    }
    ?>
    </tbody>
</table>
</body>
