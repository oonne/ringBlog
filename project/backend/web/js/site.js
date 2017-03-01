$(function() {
    // 初始化菜单栏
    $('#side-menu').metisMenu();
    var element = $('#side-menu li.active').parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
    // 让圆圈可以实现刷新时跟随滚动
    var now = new Date();
    var d = (-now.getSeconds())+'s';
    $('.sidebar-logo').css({
        'animation-delay':d,
        'background-image':'linear-gradient(135deg, #e7604a, #de6262)'
    });
    $('.logo-rotation').css({
        'display':'block',
        'animation-delay':d,
    })
});