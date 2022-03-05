<?php
$success["success"] = false;
function get($name)
{
    return isset($_POST[$name]) ? $_POST[$name] : null;
}

$toggle = get("toggle");
$create = get("create");
$delete = get("delete");
if (!$toggle && !$create && !$delete) {
    echo json_encode($success);
    exit();
}
include_once __DIR__ . "/../../database.php";
$mysqli = get_mysql();
if ($toggle) {
    $list = json_decode($toggle);
    foreach ($list as $item) {
        $mysqli->query("update schedule set enable = !enable where time='$item'");
    }
}
if ($create) {
    $time = get("time");
    $name = get("name");
    if (!$time || !$name) {
        echo json_encode($success);
        exit();
    }
    if ($mysqli->query("select count(*) as count from schedule where time='$time'")->fetch_assoc()["count"]) {
        echo json_encode($success);
        exit();
    }
    $mysqli->query("insert into schedule (time,name) values ('$time','$name')");
}
if ($delete) {
    $mysqli->query("delete from schedule where time='$delete'");
    $mysqli->query("delete from customer where date='$delete'");
}
$success["success"] = true;
echo json_encode($success);