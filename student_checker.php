<?php
$number = isset($_POST["number"]) ? $_POST["number"] : 0;
$student_number = isset($_POST["student_number"]) ? $_POST["student_number"] : 0;

if ($number && $student_number) {
    include_once "database.php";
    $mysqli = get_mysql();
    $data = $mysqli->query("select name from student where number={$number} and student_number={$student_number}")->fetch_assoc();
    $return = [];
    if ($data) {
        $return["success"] = true;
        $return["name"] = $data["name"];
    }
    echo json_encode($return);
    die(0);
}
echo json_encode(["success" => false]);