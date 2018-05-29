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

    $('#category').on('click', function () {
        base.loadLocalHtml('category.html', '.layui-body');
    });

    $('#goods').on('click', function () {
        base.loadLocalHtml('goods.html', '.layui-body');
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