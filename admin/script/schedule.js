$(function () {
    var toggle = [];
    // 隱藏式選單
    $('.new').click(function () {
        $('.new_background_invisible').addClass('new_background');
        $('.new_invisible').addClass('new_visible').removeClass('new_invisible');
    });
    $('.new_background_invisible').click(function () {
        $('.new_visible').addClass('new_invisible').removeClass('new_visible');
        $('.new_background_invisible').removeClass('new_background');
    });

    //寄送資料@bool success
    function sendData() {
        $.ajax({
            url: "bg/schedule.php",
            type: "POST",
            dataType: "json",
            data: {
                create: true,
                time: $('.time').val(),
                name: $('.name').val()
            },
            success: function(data) {
                if (data.success) {
                    alert("執行成功! 即將開始跳轉!");
                    history.go(0)
                } else {
                    alert("創立失敗")
                }
            }

        })
    }

    //寄送toggle資料@bool success
    function sendToggleData() {
        $.ajax({
            url: "bg/schedule.php",
            type: "POST",
            dataType: "json",
            data: {
                toggle: JSON.stringify(toggle)
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
    //刪除data@bool success
    function sendDeleteData(date) {
        $.ajax({
            url: "bg/schedule.php",
            type: "POST",
            dataType: "json",
            data: {
                delete: date
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
    //save
    $('.save').click(function() {
        sendToggleData();
    })
    //update
    $("input[type='checkbox']").click(function() {
        let index = toggle.indexOf($(this).attr("date"));
        if (index !== -1) {
            toggle.splice(index,1);
        } else {
            toggle.push($(this).attr("date"))
        }
    });
    $('.create_submit').click(function() {
        sendData();
    })
    $(".delete").click(function() {
        let attr = $(this).attr('target');
        if (confirm("您確定要刪除 \""+attr+"\" 嗎?\n*此動作無法復原\n*會連帶刪除所有與此日程相關的紀錄")) {
            sendDeleteData(attr);
        }
    })
})