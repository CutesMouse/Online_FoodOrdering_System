<?php
function get_mysql() {
    $username = "root";
    $password = "";
    $host = "localhost";
    $database = "restaurant";
    $mysqli = new mysqli($host, $username, $password, $database);
    $mysqli->query("set names utf8");
    return $mysqli;
}