$(function() {
    $('.redirect_block').click(function() {
        window.open($(this).attr('target'),'_self');
    })
})