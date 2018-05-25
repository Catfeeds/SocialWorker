var base = window.base;
base.getLocalStorage('token') || (window.location.href = 'login.html');

base.getData({
    url: '/users/self',
    tokenFlag: true,
    success: function (res) {
        console.log(res);
    }
});

layui.use(['element', 'layer'], function () {
    var element = layui.element;

    base.loadLocalHtml('member.html', '.layui-body');

    $('#equipment').on('click', function () {
        base.loadLocalHtml('equipment.html', '.layui-body');
    });

    $('#member').on('click', function () {
        base.loadLocalHtml('member.html', '.layui-body');
    });

    $('#cash').on('click', function () {
        base.loadLocalHtml('cash.html', '.layui-body');
    });

    $('#teachBanner').on('click', function () {
        base.loadLocalHtml('banner.html', '.layui-body');
    });

    $('#studentBanner').on('click', function () {
        base.loadLocalHtml('banner.html', '.layui-body');
    });

    $('#clubBanner').on('click', function () {
        base.loadLocalHtml('banner.html', '.layui-body');
    });

    $('#aboutMe').on('click', function () {
        base.loadLocalHtml('about-me.html', '.layui-body');
    });

    $('#course').on('click', function () {
        base.loadLocalHtml('course.html', '.layui-body');
    });

    $('#club').on('click', function () {
        base.loadLocalHtml('club.html', '.layui-body');
    });

    $('#student').on('click', function () {
        base.loadLocalHtml('student.html', '.layui-body');
    });

    $('#teach').on('click', function () {
        base.loadLocalHtml('teach.html', '.layui-body');
    });

    $('#order').on('click', function () {
        base.loadLocalHtml('order.html', '.layui-body');
    });

    $('#logout').on('click', function () {
        base.deleteLocalStorage('token');
        base.deleteLocalStorage('refresh_token');
        window.location.href = 'login.html';
    });
});