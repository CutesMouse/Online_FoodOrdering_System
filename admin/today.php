<head>
    <link rel="stylesheet" type="text/css" href="style/today.css">
    <script src="../jquery-3.6.0.min.js"></script>
    <script src="script/back.js"></script>
    <link rel="stylesheet" type="text/css" href="style/back.css">
    <script src="script/today.js"></script>
    <title>點餐系統 餐廳設定</title>
</head>
<body>
<div class="back">
</div>
<div class="table_box">
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>座號</th>
                <th>姓名</th>
                <th>學號</th>
                <th>項目</th>
                <th>金額</th>
                <th>刪除</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //            <tr>
            //                <td>Slimlix</td>
            //                <td>09565656565</td>
            //                <td>牛肉$30/豬肉$60/羊肉$70</td>
            //                <td><span class="delete"></span><span class="modify"></span></td>
            //            </tr>
            include_once __DIR__ . "/../database.php";
            $mysqli = get_mysql();
            $today = new DateTime("now", new DateTimeZone('Asia/Taipei'));
            $today = $today->format("Y-m-d");
            $result = $mysqli->query("select ip,uid,time,number,student_number,`order` from customer where date='{$today}' order by number");
            $restaurant = $mysqli->query("select name from schedule where time='$today'")->fetch_assoc()["name"];
            $tel = $mysqli->query("select tel from restaurant where name='$restaurant'")->fetch_assoc()["tel"];
            $amount = [];
            if (!$restaurant) die;

            include_once "bg/restaurant_manager.php";
            $price_table = getPriceList($restaurant);

            while ($data = $result->fetch_assoc()) {
                if (!isset($amount[$data["order"]])) $amount[$data["order"]] = 1;
                else $amount[$data["order"]]++;
                $same_ip = $mysqli->query("select count(*) as 'count' from customer where date='{$today}' and ip='{$data["ip"]}'")->fetch_assoc()["count"];
                $modify = "";
                if (intval($same_ip) > 1) {
                    $modify = " class='same_ip'";
                }
                $name = $mysqli->query("select name from student where number={$data["number"]}")->fetch_assoc()["name"];
                echo "<tr{$modify}>
                <td>{$data["number"]}</td>
                <td>{$name}</td>
                <td>{$data["student_number"]}</td>
                <td>{$data["order"]}</td>
                <td>{$price_table[$data["order"]]}</td>
                <td><span class='delete' uid='{$data["uid"]}'></span></td>
            </tr>";
            }

            ?>

            </tbody>
        </table>
    </div>
    <div class="new">
        詳細資料
    </div>
</div>

<div class="new_background_invisible"></div>
<div class="new_invisible">

    <div class="description">
        餐廳名稱
        <div class="blank"><?php echo $restaurant; ?></div>
    </div>

    <div class="description">
        電話
        <div class="blank"><?php echo $tel; ?></div>
    </div>

    <div class="description">
        餐點
            <?php
            foreach ($amount as $order_name => $amount) {
                echo "<div class='blank'><div class='amount'>{$amount}x</div>$order_name</div>";
            }
            ?>
        </div>
    </div>
    <!--    <div class="note">格式: 牛肉$100/豬肉$80/雞肉$70...</div>-->
</div>
<!--    <button class="create_submit" target='create'>Submit</button>-->
</body>
<?php
