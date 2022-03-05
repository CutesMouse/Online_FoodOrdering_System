$(function() {
    $(".block").click(function() {
        let url = $(this).attr("target");
        if (!url) return;
        window.open(url,"_self");
    });
});