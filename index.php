<html>
<title>點餐系統</title>
<script src="jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="attach/index.css">
<script src="attach/index.js"></script>
<?php
include_once "database.php";
$mysql = get_mysql();
$date = isset($_GET["date"]) ? $_GET["date"] : date("y-m-d");
$sc = $mysql->query("select count(*) as 'count' from schedule where enable=true");
if (!$sc->fetch_assoc()["count"]) {
    echo "<div class='box'>
    <div class='title'>
        目前不開放填寫!
    </div>";
    die;
}
$sc = $mysql->query("select time,name from schedule where enable=true");
?>
<div class="box">
    <?php
    while ($rest = $sc->fetch_assoc()) {
        $data = $mysql->query("select name,item,tel from restaurant where name='{$rest["name"]}'")->fetch_assoc();
        $display_date = date("Y/m/d", strtotime($rest["time"]));
        $display_day = "星期" . ["日", "一", "二", "三", "四", "五", "六"][date("w", strtotime($rest["time"]))];
        echo "<div class='title'>{$display_date} {$display_day}: {$data["name"]}</div>";
        echo "<div class='content'>";
        $content = json_decode($data["item"])->item;

        foreach ($content as $item) {
            echo "<div class='item'>
            <div class='item_title'>{$item->name}</div>
            <div class='item_info_box'>
                <div class='item_check'>
                    <input type='checkbox' class='item_checkbox' price='{$item->price}' item='{$item->name}' date='{$rest["time"]}'>
                </div>
                <div class='item_price'>$<span>{$item->price}</span></div>
            </div>
        </div>";
        }
    }
    ?>

    <div class="info">
        <div class="money">【送出】應繳金額: $<span class="exact_money"></span></div>
    </div>

    <div class="pay_background_invisible">
    </div>
    <div class="pay_info_invisible">
        <label class="pay_blank pay_student_number">
            學號
            <input class="pay_input pay_student_number_blank" type="text">
        </label>
        <label class="pay_blank pay_number">
            座號
            <input class="pay_input pay_number_blank" type="text">
        </label>
        <button class="pay_input pay_submit">Submit</button>
    </div>

</div>
</html>
