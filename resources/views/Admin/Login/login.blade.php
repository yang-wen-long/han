<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后台登录</title>
    <meta name="author" content="DeathGhost" />
    <link rel="stylesheet" type="text/css" href="/static/admin/login/Css/style.css" />
    <style>
        body{height:100%;background:#16a085;overflow:hidden;}
        canvas{z-index:-10;position:absolute;}
    </style>
    <script src="/static/admin/login/Scripts/jquery.js"></script>
    <script src="/static/admin/login/Scripts/verificationnumbers.js"></script>
    <script src="/static/admin/login/Scripts/particleground.js"></script>
</head>
<body>
<dl class="admin_login">
    <dt>
        <strong>登录后台管理系统</strong>
        <em>Yang wen long's background login</em>
    </dt>
    <center>
        <font color="red">{{session("get")}}</font>
    </center>
    <form action="{{url('/desc/login')}}" method="post">
        @csrf
        <dd class="user_icon">
            <input type="text"  name="email" placeholder="账号" class="login_txtbx"/>
        </dd>
        <dd class="pwd_icon">
            <input type="password" name="password" placeholder="密码" class="login_txtbx"/>
        </dd>
        <dd>
            <input type="submit" value="立即登陆" class="submit_btn"/>
        </dd>
        <dd class="val_icon">
            <a href="{{url('/user/reg')}}" class="submit_btn"><input type="button" value="立即注册" class="submit_btn"/></a>
        </dd>
    </form>
    <dd>
        <p>© 2015-2016 DeathGhost 版权所有</p>
        <p>文 - 2382662404@qq.com -</p>
    </dd>
</dl>
</body>
</html>
<script>
    $(document).ready(function() {
        //粒子背景特效
        $('body').particleground({
            // dotColor: '#5cbdfa',
            dotColor: '#afccde',
            lineColor: '#5cbdfa'
        });
        //验证码
        createCode();
    });
</script>