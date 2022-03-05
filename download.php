<?php
include_once __DIR__."/database.php";
include_once __DIR__."/admin/bg/restaurant_manager.php";
$from = isset($_GET["from"])? $_GET["from"] :0;
$to = isset($_GET["to"]) ? $_GET["to"] : 0;
if (!($from && $to)) {
    echo "not enough info";
    die(0);
}

$GLOBALS["status"] = [];
$GLOBALS["from"] = $from;
$GLOBALS["to"] = date("Y-m-d",strtotime($to."+ 1 days"));

$mysqli = get_mysql();

//"2021/11/08 12:28:08 上午 GMT+8","邱硯廷","大腸蚵仔麵線 $45","","","","","咖哩蛋包飯 $55","雞排飯 $80",""
echo "\"座號\",\"姓名\",\"學號\"";

for ($date = $GLOBALS["from"]; $date != $GLOBALS["to"]; $date = date("Y-m-d",strtotime($date.'+1days'))) {
    $display = $date;
    $restaurant = $mysqli->query("select time,name,tel from schedule c1
    join (select name as restaurant,tel as tel from restaurant) c2
    on (c1.name = c2.restaurant) where time='{$date}'")->fetch_assoc();
    if (!$restaurant) continue;
    $display .= " {$restaurant["name"]} {$restaurant["tel"]}";
    echo ",\"{$display}\"";
    $GLOBALS["status"][$date] = true;
}

echo ",\"總金額\"";

class student {
    public $name;
    public $number;
    public $student_number;
    public $orders = [];
    public $price_sum;

    public function __construct($name, $number, $student_number) {
        $this->name = $name;
        $this->number = $number;
        $this->student_number = $student_number;
    }

    public function create_order($date, $order, $price) {
        if(isset($this->orders[$date])) {
            $this->orders[$date] .= ";";
        } else {
            $this->orders[$date] = "";
        }
        $this->orders[$date] .= $order." \${$price}";
        $this->price_sum += intval($price);
    }

    public function get_line() {
        $c = "\n\"{$this->number}\",\"{$this->name}\",\"{$this->student_number}\"";
        for ($date = $GLOBALS["from"]; $date != $GLOBALS["to"]; $date = date("Y-m-d",strtotime($date.'+1days'))) {
            if (!isset($GLOBALS["status"][$date])) continue;
            if (isset($this->orders[$date])) $c .= ",\"{$this->orders[$date]}\"";
            else $c .= ",\"\"";
        }
        $c .= ",\"{$this->price_sum}\"";
        return $c;
    }
}
$map = [];
$price_table = [];
$result = $mysqli->query("select * from customer c1
    join (select number as n, student_number as sn, name from student) c2
        on (c1.number = c2.n && c1.student_number = c2.sn)
    join (select name as restaurant,time as c3t from schedule) c3
        on (c1.date = c3.c3t) where date >= '{$from}' and date < '{$to}' order by number");
while ($d = $result->fetch_assoc()) {
    $student = 0;
    if (isset($map[$d["number"]])) $student = $map[$d["number"]];
    else $student = new student($d["name"],$d["number"],$d["student_number"]);
    if (!(isset($price_table[$d["restaurant"]]))) {
        $price_table[$d["restaurant"]] = getPriceList($d["restaurant"]);
    }
    $student->create_order($d["date"],$d["order"],$price_table[$d["restaurant"]][$d["order"]]);
    $map[$d["number"]] = $student;
}
foreach ($map as $number => $student) {
    echo $student->get_line();
}

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=orders_{$_GET["from"]}_{$_GET["to"]}.csv");