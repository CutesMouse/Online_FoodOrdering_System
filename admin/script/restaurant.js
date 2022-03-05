$(function() {

    $(".delete").click(function() {
        $('.create_submit').attr("target","delete");
        let attr = $(this).attr('target').substr(1);
        if (confirm("您確定要刪除 \""+attr+"\" 嗎?\n*此動作無法復原\n*會連帶刪除所有與此餐廳相關的日程/紀錄")) {
            $('.name').val($("td[present='"+attr+"'][type='name']").html())
            $('.tel').val($("td[present='"+attr+"'][type='tel']").html())
            $('.item').val($("td[present='"+attr+"'][type='item']").html())
            sendData();
        }
    })
    // 隱藏式選單
    $('.new,.modify').click(function () {
        let attr = $(this).attr('target');
        $('.create_submit').attr("target",attr);
        if (attr !== "create") {
            attr = attr.substr(1);
            $('.name').val($("td[present='"+attr+"'][type='name']").html())
            $('.tel').val($("td[present='"+attr+"'][type='tel']").html())
            $('.item').val($("td[present='"+attr+"'][type='item']").html())
        } else {
            $('.name').val("")
            $('.tel').val("")
            $('.item').val("")
        }
        $('.new_background_invisible').addClass('new_background');
        $('.new_invisible').addClass('new_visible').removeClass('new_invisible');
    });
    $('.new_background_invisible').click(function() {
        $('.new_visible').addClass('new_invisible').removeClass('new_visible');
        $('.new_background_invisible').removeClass('new_background');
    });
    // 資料傳送
    //擷取資料 return@object data
    function getMealData() {
        let original = $(".item").val();
        var list = [];
        original.split("/").forEach(function (object) {
            object = object.split("$");
            list.push({
                name: object[0],
                price: parseInt(object[1])
            });
        })
        return {item: list};
    }
    //寄送資料@bool success
    function sendData() {
        $.ajax({
            url: "bg/restaurant.php",
            type: "POST",
            dataType: "json",
            data: {
                target: $('.create_submit').attr('target'),
                name: $('.name').val(),
                item: JSON.stringify(getMealData()),
                tel: $('.tel').val()
            },
            success: function (data) {
                if (data.success) {
                    alert("執行成功! 即將開始跳轉!");
                    history.go(0)
                } else {
                    alert("創立失敗")
                }
            }

        })
    }
    // 送出
    $('.create_submit').click(function() {
        sendData();
    });
});