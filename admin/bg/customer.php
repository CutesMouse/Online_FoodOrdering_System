<?php
$uid = isset($_POST["uid"]) ? $_POST["uid"] : 0;
if (!$uid) die(0);

include_once __DIR__."/../../database.php";

$mysqli = get_mysql();

if ($mysqli->query("select count(*) as amount from customer where uid={$uid}")->fetch_assoc()["amount"]) {
    $mysqli->query("delete from customer where uid={$uid}");
    echo json_encode(["status" => true]);
} else {
    echo json_encode(["status" => false]);
}