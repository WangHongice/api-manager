<?php

/**
 *	Entry name：项目名称
 *	Description：起始文件
 *	Author：ZERO-ART
 *	Author Url：http://www.lykep.com
 * 	Contact：708298599  656001878
 *	2019-12-25 16:16:22
 */
// error_reporting(0);

// echo json_encode($_SERVER);
// echo $_SERVER['REQUEST_URI'];
// exit();
//初始化
require __DIR__ . '/../app/init.php';

// echo json_encode($_SERVER);
file_put_contents('sb.html','<br><br>操作IP: '.$_SERVER['REMOTE_ADDR'].'<br>'.$_SERVER['HTTP_USER_AGENT'].'<br>操作时间: '.strftime('%Y-%m-%d %H:%M:%S').'<br>操作页面:'.$_SERVER['PHP_SELF'].'<br>提交方式: '.$_SERVER['REQUEST_METHOD'].'<br>提交参数: '.$StrFiltKey.'<br>提交数据: '.$StrFiltValue.'<br>访问的地址：'.$url.'<br>来源地址（为空就是手动输入）：'.$_SERVER['HTTP_REFERER'].'<br>当前请求的Accept头部的内容：'.$_SERVER['HTTP_ACCEPT'].'<br>',FILE_APPEND | LOCK_EX);