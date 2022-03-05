<script src="jquery-3.6.0.min.js"></script>
<button class="function" request="today_order">今日點餐名單</button>
<button class="function" request="select_restaurant">指定餐廳</button>
<button class="function" request="new_restaurant">新增餐聽</button>
<button class="function" request="database">管理資料庫</button>
<div class="frame"></div>
<script>
    $(function () {
        $('.function').click(function () {
            if ($(this).attr("request") === "database") {
                window.open("admin/dbcontrol.php")
                return;
            }
            $.get("data_fetcher.php?request="+$(this).attr("request"), function(data) {
                $('.frame').html(data);
            })
        })
    });
</script>
