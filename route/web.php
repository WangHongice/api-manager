<?php

//前台首页
Route::get("/", "IndexController@index");

//详情页面
Route::get("/doc/{id}.html", "IndexController@doc");

//接口公共通道
Route::any("/api/{apiVal}", "IndexController@api");

// 接口列表
Route::any("/v1/apilist", "IndexController@getapilist");

#用户#################################################

//用户登录页
Route::get("/user/login.html", "User/IndexController@login");

//用户注册页
Route::get("/user/register.html", "User/IndexController@register");

//找回密码页
Route::get("/user/forget.html", "User/IndexController@forget");

//白名单 
Route::get("/user/whitelist.html", "User/IndexController@whitelist");

//用户首页
Route::get("/user", "User/IndexController@index");
Route::get("/user/", "User/IndexController@index");
Route::get("/user/index.html", "User/IndexController@index");
Route::get("/user/console.html", "User/IndexController@console");

//商品列表
Route::get("/user/goods.html", "User/IndexController@goods");

//购买记录
Route::get("/user/buyapi.html", "User/IndexController@buyapi");

//充值记录
Route::get("/user/buypay.html", "User/IndexController@buypay");

//自助充值
Route::get("/user/pay.html", "User/IndexController@pay");

//修改密码
Route::get("/user/passwd.html", "User/IndexController@passwd");

//商品订单页
Route::get("/user/order/{id}", "User/IndexController@order");

//已购接口
Route::get("/user/owned.html", "User/IndexController@owned");

//配置接口
Route::get("/user/apiedit/{id}", "User/IndexController@apiedit");

//登录验证码
Route::get("/code/login", function () {
    $code = "logincode";
    require APP_VIEW_PATH . "user/code.php";
});

//注册验证码
Route::get("/code/register", function () {
    $code = "registercode";
    require APP_VIEW_PATH . "user/code.php";
});

//注册验证码
Route::get("/code/forget", function () {
    $code = "forgetcode";
    require APP_VIEW_PATH . "user/code.php";
});

#用户数据处理#####################################################

//修改密钥 
Route::post("/user/owned", "User/HandleController@owned");

//更新白名单
Route::post("/user/apiip", "User/HandleController@apiip");

//下单购买 
Route::post("/user/order", "User/HandleController@order");

//用户注册
Route::post("/user/register", "User/HandleController@register");

//找回密码
Route::post("/user/forget", "User/HandleController@forget");

//用户登录
Route::post("/user/login", "User/HandleController@login");

//用户注销
Route::get("/user/logout", "User/HandleController@logout");

// 用户验证
Route::get("/user/auth/verify", "User/HandleController@authverify");

//修改密码
Route::post("/user/passwd", "User/HandleController@passwd");

// 卡密充值
Route::post("/user/recharge", "User/HandleController@kami");

#后台################################################

//后台登录页
Route::get("/zeyuadminnbvip666520lbwnb/login.html", "Admin/IndexController@login");

//后台首页
Route::get("/zeyuadminnbvip666520lbwnb", "Admin/IndexController@index");
Route::get('/zeyuadminnbvip666520lbwnb' . '/', "Admin/IndexController@index");
Route::get("/zeyuadminnbvip666520lbwnb/index.html", "Admin/IndexController@index");

//后台接口添加页
Route::get("/zeyuadminnbvip666520lbwnb/addapi.html", "Admin/IndexController@addapi");

//后台接口添加页
Route::get("/zeyuadminnbvip666520lbwnb/newkm.html", "Admin/IndexController@newkm");

//后台参数设置页
Route::get("/zeyuadminnbvip666520lbwnb/apiinfo.html", "Admin/IndexController@apiinfo");

//后台数据绑定页
Route::get("/zeyuadminnbvip666520lbwnb/datainfo.html", "Admin/IndexController@datainfo");

//后台文件绑定页
Route::get("/zeyuadminnbvip666520lbwnb/fileinfo.html", "Admin/IndexController@fileinfo");

//后台接口编辑页
Route::get("/zeyuadminnbvip666520lbwnb/editapi/{id}", "Admin/IndexController@editapi");

//后台接口列表页
Route::get("/zeyuadminnbvip666520lbwnb/apilist.html", "Admin/IndexController@apilist");

//后台网站设置页
Route::get("/zeyuadminnbvip666520lbwnb/webset.html", "Admin/IndexController@webset");

//后台会员列表页
Route::get("/zeyuadminnbvip666520lbwnb/userinfo.html", "Admin/IndexController@userinfo");

//后台支付设置页
Route::get("/zeyuadminnbvip666520lbwnb/payset.html", "Admin/IndexController@payset");

//后台退出登录
Route::get("/zeyuadminnbvip666520lbwnb/logout", "Admin/IndexController@logout");

//后台密码修改
Route::get("/zeyuadminnbvip666520lbwnb/passwd.html", "Admin/IndexController@passwd");

//后台用户编辑
Route::get("/zeyuadminnbvip666520lbwnb/useredit/{id}", "Admin/IndexController@useredit");

//后台会员添加
Route::get("/zeyuadminnbvip666520lbwnb/adduser.html", "Admin/IndexController@adduser");

// 注册设置
Route::get("/zeyuadminnbvip666520lbwnb/setuser.html", "Admin/IndexController@setuser");

//后台邮箱配置
Route::get("/zeyuadminnbvip666520lbwnb/email.html", "Admin/IndexController@email");

//redis配置
Route::get("/zeyuadminnbvip666520lbwnb/redis.html", "Admin/IndexController@redis");

// 后台订单页
Route::get("/zeyuadminnbvip666520lbwnb/order.html", "Admin/IndexController@order");

//添加卡密页
Route::get("/zeyuadminnbvip666520lbwnb/addkami.html", "Admin/IndexController@addkami");

// 卡密管理页
Route::get("/zeyuadminnbvip666520lbwnb/kami.html", "Admin/IndexController@kami");

#数据处理##########################################

//登录用户账号
Route::post("/zeyuadminnbvip666520lbwnb/loginuser", "Admin/HandleController@loginuser");

// 添加卡密
Route::post("/zeyuadminnbvip666520lbwnb/addkami", "Admin/HandleController@addkami");

//redis保存
Route::post("/zeyuadminnbvip666520lbwnb/redis", "Admin/HandleController@redis");

//接口价格修改 
Route::post("/zeyuadminnbvip666520lbwnb/charge", "Admin/HandleController@charge");

//添加用户
Route::post("/zeyuadminnbvip666520lbwnb/adduser", "Admin/HandleController@adduser");

//邮箱配置
Route::post("/zeyuadminnbvip666520lbwnb/email", "Admin/HandleController@email");

//修改登录密码
Route::post("/zeyuadminnbvip666520lbwnb/passwd", "Admin/HandleController@passwd");

//会员编辑
Route::post("/zeyuadminnbvip666520lbwnb/useredit", "Admin/HandleController@useredit");

//会员删除
Route::post("/zeyuadminnbvip666520lbwnb/deluser", "Admin/HandleController@deluser");

//登录验证
Route::post("/zeyuadminnbvip666520lbwnb/login", "Admin/HandleController@login");

//网站设置保存
Route::post("/zeyuadminnbvip666520lbwnb/webset", "Admin/HandleController@webset");

// 注册设置
Route::post("/zeyuadminnbvip666520lbwnb/setuser", "Admin/HandleController@setuser");

//支付设置保存
Route::post("/zeyuadminnbvip666520lbwnb/payset", "Admin/HandleController@payset");

//接口添加
Route::post("/zeyuadminnbvip666520lbwnb/addapi", "Admin/HandleController@addapi");

//获取表字段
Route::post("/zeyuadminnbvip666520lbwnb/getField", "Admin/HandleController@getField");

//获取接口文件列表
Route::post("/zeyuadminnbvip666520lbwnb/getApiFile", "Admin/HandleController@getApiFile");

// 获取接口文件内容 getApiFileC
Route::post("/zeyuadminnbvip666520lbwnb/getApiFileC", "Admin/HandleController@getApiFileC");

// 接口文件上传 putApiFile
Route::post("/zeyuadminnbvip666520lbwnb/putApiFile", "Admin/HandleController@putApiFile");

// 接口文件保存 editFile
Route::post("/zeyuadminnbvip666520lbwnb/editFile", "Admin/HandleController@editFile");

//添加数据绑定
Route::post("/zeyuadminnbvip666520lbwnb/datainfo", "Admin/HandleController@datainfo");

//删除接口
Route::post("/zeyuadminnbvip666520lbwnb/delapi", "Admin/HandleController@delapi");

//添加参数绑定 
Route::post("/zeyuadminnbvip666520lbwnb/apiinfo", "Admin/HandleController@apiinfo");

//删除参数
Route::post("/zeyuadminnbvip666520lbwnb/delval", "Admin/HandleController@delval");

//获取参数
Route::post("/zeyuadminnbvip666520lbwnb/getVal", "Admin/HandleController@getVal");

//修改接口
Route::post("/zeyuadminnbvip666520lbwnb/editapi", "Admin/HandleController@editapi");


//欢迎页面
// Route::get("/welcome", "IndexController@welcome");

//测试页面
// Route::get("/dist", "IndexController@dist");

//图片上传接口
// Route::post('/uploads', "Common/CommonController@upload");
