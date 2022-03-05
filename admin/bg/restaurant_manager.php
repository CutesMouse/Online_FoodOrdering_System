<?php
function getPriceList($name) {
    require_once __DIR__."/../../database.php";
    $mysqli = get_mysql();
// {"item":[{"name":"A","price":100},{"name":"B","price":100}]}
    $arrays = json_decode($mysqli->query("select item from restaurant where name='$name'")->fetch_assoc()["item"])->item;
    $price_list = [];
    foreach ($arrays as $array) {
        $price_list[$array->name] = $array->price;
    }
    return $price_list;
}