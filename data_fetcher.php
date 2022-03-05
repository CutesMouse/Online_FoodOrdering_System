<?php
include_once "database.php";
if (isset($_GET["request"])) {
    $verified = true;
    switch ($_GET["request"]) {
        case "today_order":
            $json = get_mysql()->query("select * from customer where date = curdate() order by number")->fetch_all();
            include_once "admin/today_order.php";
            break;
        case "select_restaurant":
            include_once "admin/select_restaurant.php";
            break;
        case "new_restaurant":
            include_once "admin/new_restaurant.php";
            break;
        case "database":
            include_once "admin/dbcontrol.php";
            break;
    }
}