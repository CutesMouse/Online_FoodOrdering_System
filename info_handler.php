<?php
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if ($ip) return $ip;
    return "-";
}
function get($name) {
    return isset($_POST[$name]) ? $_POST[$name] : 0;
}
$number = get("number");
$student_number = get("student_number");
$orders = get("orders");
if (!$number || !$student_number || !$orders) {
    $obj = ["success" => false];
    echo json_encode($obj);
    exit(0);
}
include_once "database.php";
$mysqli = get_mysql();

foreach (json_decode($orders) as $order) {
    $ip = getUserIpAddr();
    $mysqli->query("insert into customer (date,number,student_number,`order`,ip) values 
                   ('{$order->time}',{$number},{$student_number},'{$order->order}','$ip')");
}
$obj = ["success" => true];
echo json_encode($obj);