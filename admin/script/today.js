$(function() {

    $(".delete").click(function() {
        $.ajax({
            url: "bg/customer.php",
            dataType: "json",
            type: "POST",
            data: {
                uid: $(this).attr("uid")
            },
            success: function(data) {
                if (data.status) {
                    alert("操作成功!");
                    history.go(0);
                } else {
                    alert("該項目已被刪除或不存在!");
                }
            }
        })

    })
    // 隱藏式選單
    $('.new').click(function () {
        $('.new_background_invisible').addClass('new_background');
        $('.new_invisible').addClass('new_visible').removeClass('new_invisible');
    });
    $('.new_background_invisible').click(function() {
        $('.new_visible').addClass('new_invisible').removeClass('new_visible');
        $('.new_background_invisible').removeClass('new_background');
    });
});