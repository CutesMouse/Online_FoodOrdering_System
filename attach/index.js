$(function () {
    var money = 0;
    var itemList = [];
    function getOrderInfo() {
        if (!itemList) return {};
        let newList = [];
        itemList.forEach(function (item) {
            let sp = item.indexOf(":");
            let time = item.substr(0, sp);
            let order = item.substr(time.length + 1, item.length);
            newList.push({
                time: time,
                order: order
            });
        });
        return newList;
    }
    function check(q) {
        let m = parseInt($(q).attr("price"));
        let name = $(q).attr("item");
        let date = $(q).attr("date");
        if (!$(q).prop("checked")) {
            m *= -1;
            let index = itemList.indexOf(date + ":" + name);
            if (index !== -1) itemList.splice(index, 1);
        } else {
            itemList.push(date + ":" + name);
        }
        money += m;
        if (money === 0) {
            $('.money').removeClass('money_show');
            return;
        }
        $('.money').addClass('money_show');
        $('.exact_money').text(money);
    }
    $('.item_checkbox').click(function () {
        check(this);
    });
    $('.info').click(function () {
        $('.pay_background_invisible').addClass('pay_background');
        $('.pay_info_invisible').addClass('pay_info').removeClass('pay_info_invisible');
    });
    $('.pay_submit').click(function () {
        let student_number = $('.pay_student_number_blank').val();
        let number = $('.pay_number_blank').val();
        if (!student_number || !number) return;
        $.ajax({
            type: "POST",
            url: "student_checker.php",
            dataType: "json",
            data: {
                student_number: student_number,
                number: number
            },
            success: function (data) {
                if (!data.success) {
                    alert('讀取學生資訊錯誤! 請確認資料是否正確!');
                    return;
                }
                if (confirm("你是 \"" + data.name + "\" 嗎?")) {
                    $.ajax({
                        type: "POST",
                        url: "info_handler.php",
                        dataType: "json",
                        data: {
                            orders: JSON.stringify(getOrderInfo()),
                            student_number: $('.pay_student_number_blank').val(),
                            number: $('.pay_number_blank').val()
                        },
                        success: function (data) {
                            if (data.success) {
                                alert("系統已收到你的回覆!")
                                history.go(0);
                            } else {
                                alert("failed! please call the owner of this website!");
                            }
                        }
                    })
                }
            }
        });

    });
    $('.pay_background_invisible').click(function () {
        $('.pay_info').addClass('pay_info_invisible').removeClass('pay_info');
        $('.pay_background_invisible').removeClass('pay_background');
    });
    $('.item').click(function() {
        $('input',this).each(function() {
            this.checked = !this.checked;
            check(this);
        })
    })
    $('input[type=checkbox]').click(function(e) {
        e.stopPropagation();
    })
});