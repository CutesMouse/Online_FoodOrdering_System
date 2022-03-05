<head>
    <link rel="stylesheet" type="text/css" href="style/schedule.css">
    <script src="../jquery-3.6.0.min.js"></script>
    <script src="script/schedule.js"></script>
    <script src="script/back.js"></script>
    <link rel="stylesheet" type="text/css" href="style/back.css">
    <title>點餐系統 日程表設定</title>
</head>
<body>
<div class="back"></div>
<div class="table_box">
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>日期</th>
                <th>選定餐廳</th>
                <th>已提交資料數</th>
                <th>填寫</th>
                <th>刪除</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //            <tr>
            //                <td>2021/09/12</td>
            //                <td>Slimlix</td>
            //                <td>15</td>
            //                <td><input></td>
            //            </tr>
            include_once __DIR__ . "/../database.php";
            $mysqli = get_mysql();
            $result = $mysqli->query("select time,name,enable from schedule order by time desc limit 10");

            while ($data = $result->fetch_assoc()) {
                $date = $data["time"];

                $name = $data["name"];
                $enable = boolval($data["enable"]);
                $time = date("Y/m/d",strtotime($date));
                $count = $mysqli->query("select count(*) as 'count' from customer where date='$date'")->fetch_assoc()["count"];
                $checked = $enable ? " checked" : "";
                echo "<tr>
                            <td>$time</td>
                            <td>$name</td>
                            <td>$count</td>
                            <td><input date='{$data["time"]}' type='checkbox' class='check'{$checked}></td>
                            <td><span class='delete' target='{$data["time"]}'></span></td>
                        </tr>";
            }

            ?>

            </tbody>
        </table>
    </div>
    <div class="new" target="create">
        新增日程
    </div>
    <div class="save">
        儲存變更
    </div>
</div>

<div class="new_background_invisible"></div>
<div class="new_invisible">

    <label class="label">
        時間
        <input class="time input" type="date">
    </label>

    <label class="label">
        餐廳
        <select class="name input">
            <?php
            $res = $mysqli->query("select name from restaurant");
            while ($re = $res->fetch_assoc()) {
                $last = $mysqli->query("select time from schedule where name='{$re["name"]}' order by time limit 1")->fetch_assoc();
                $display = $last ? "[".date("Y/m/d",strtotime($last["time"]))."] {$re["name"]}" : $re["name"];
                echo "<option value='{$re["name"]}'>$display</option>";
            }
            ?>
            ?>
        </select>
    </label>

    <button class="create_submit">Submit</button>
</div>
</body>
<?php
