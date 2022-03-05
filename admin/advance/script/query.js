$(function() {
    $('input').click(function() {
        let checked = this.checked;
        let class_name = $(this).attr('name');
        if (checked) {
            $('.' + class_name).removeClass('invis');
        } else {
            $('.' + class_name).addClass('invis');
        }
    });
    $(".delete").click(function() {
        $.ajax({
            url: "../bg/customer.php",
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
    });
})