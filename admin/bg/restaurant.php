<?php
$success["success"] = false;
function get($name)
{
    return isset($_POST[$name]) ? $_POST[$name] : null;
}

$name = get("name");
$item = get("item");
$tel = get("tel");
$target = get("target");
if (!$name || !$item || !$tel || !$target) {
    echo json_encode($success);
    exit();
}
include_once __DIR__ . "/../../database.php";
$mysqli = get_mysql();
if ($target === "create") {
    if ($mysqli->query("select count(*) as count from restaurant where name='$name'")->fetch_assoc()["count"]) {
        echo json_encode($success);
        exit();
    }
    $mysqli->query("insert into restaurant (name,item,tel) values ('$name','$item','$tel')");
} else if ($target === "delete") {
    $mysqli->query("delete from restaurant where name='$name'");
    $records = $mysqli->query("select time from schedule where name='$name'");
    while ($record = $records->fetch_assoc()) {
        $mysqli->query("delete from customer where date='{$record["time"]}'");
    }
    $mysqli->query("delete from schedule where name='{$name}'");

} else {
    $target = mb_substr($target, 1);
    $mysqli->query("update restaurant set item='$item', tel='$tel', `name`='$name' where `name`='$target'");
    $mysqli->query("update schedule set `name`='$name' where `name`='$target'");
}
$success["success"] = true;
echo json_encode($success);