<head>
    <link rel="stylesheet" type="text/css" href="style/restaurant.css">
    <script src="../jquery-3.6.0.min.js"></script>
    <script src="script/restaurant.js"></script>
    <script src="script/back.js"></script>
    <link rel="stylesheet" type="text/css" href="style/back.css">
    <title>點餐系統 餐廳設定</title>
</head>
<body>
<div class="back"></div>
<div class="table_box">
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>餐廳名稱</th>
                <th>餐廳電話</th>
                <th>餐廳項目</th>
                <th>動作</th>
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
            $result = $mysqli->query("select name,item,tel from restaurant");

            while ($data = $result->fetch_assoc()) {
                $meal = "";
                $array = json_decode($data["item"])->item;
                foreach ($array as $singleMeal) {
                    $meal.= "/".$singleMeal->name."$".$singleMeal->price;
                }
                if ($meal) $meal = mb_substr($meal,1);
                echo "<tr>
                <td present='{$data["name"]}' type='name'>{$data["name"]}</td>
                <td present='{$data["name"]}' type='tel'>{$data["tel"]}</td>
                <td present='{$data["name"]}' type='item'>{$meal}</td>
                <td><span class='delete' target='m{$data["name"]}'></span><span class='modify' target='m{$data["name"]}'></span></td>
            </tr>";
            }

            ?>

            </tbody>
        </table>
    </div>
    <div class="new" target="create">
        新增餐廳
    </div>
</div>

<div class="new_background_invisible"></div>
<div class="new_invisible">

    <label class="label">
        餐廳名稱
        <input class="name input" type="text">
    </label>

    <label class="label">
        電話
        <input class="tel input" type="text">
    </label>

    <label class="label">
        餐點
        <input class="item input" type="text">
    </label>
    <div class="note">格式: 牛肉$100/豬肉$80/雞肉$70...</div>

    <button class="create_submit" target='create'>Submit</button>
</div>
</body>
<?php
