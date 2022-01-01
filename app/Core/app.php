<?php

/**
 *	API管理系统
 *	Description：应用载入
 *	Author：zeyudada ZERO-ART
 *	Author Url：http://zeyudada.cn http://www.lykep.com
 * 	E-mail: admin@zeyudada.cn
 *	2022-1-1 13:56
 */

//安全
require __DIR__ . '/safe.php';
//引入全局控制常量
require __DIR__ . '/env.php';
//引入全局自定义常量
require __DIR__ . '/default.php';
//引入路由注册功能
require __DIR__ . '/route/Route.php';
//引入参数接收处理功能
require __DIR__ . '/route/Request.php';
//引入mysql操作功能
require __DIR__ . '/database/mysql_db.php';
//引入方法库
require __DIR__ . '/method/app.php';
//引入数据语句
require __DIR__ . '/../Http/Model/app.php';
//公共控制器
require __DIR__ . '/../Http/Controller/Controller.php';
//引入自定义方法库
require __DIR__ . '/../Http/Method/app.php';
