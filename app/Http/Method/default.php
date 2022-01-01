<?php
/**
 * 重新发送一封验证邮件
 * @param array $data 从数据库取出来的用户行
 * @return 提示信息
 */
 function reverify($data){
    $username = $data['username'];
    $info['to'] = $data['u_email'];
    $key = md5(md5($data['u_id']).md5($data['u_name']).md5($data['u_passwd']).md5($data['u_email']));
    $info['title'] = $_SERVER['HTTP_HOST'] . "请验证您的食铁兽科技账号";
    $vurl =  'https://' . $_SERVER['HTTP_HOST'] . "/user/auth/verify?name=" . $data['u_name'] . "&key=" . $key;
    $info['content'] = <<<EOF
    <!DOCTYPE html><html><head> <meta charset="UTF-8"> <meta http-equiv="Content-type" content="text/html;charset=utf-8"> <title>请验证您的食铁兽科技账号</title> <style> html,body{background-color: transparent;} body{font-size:14px;font-family:arial,verdana,sans-serif;line-height:25px;padding:8px 10px;margin:0;word-wrap:break-word;} pre, .js-pre { white-space: pre-wrap;  white-space: -moz-pre-wrap;  white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word; font-size:14px;font-family:arial,verdana,sans-serif;line-height:25px;padding:8px 10px;margin:0; } .rm_line{border-top:2px solid #F1F1F1; font-size:0; margin:15px 0} .atchImg img{border:2px solid #c3d9ff;} .lnkTxt{ color:#0066CC} .rm_PicArea *{ font-family:Arial, sans-serif; font-size:14px;font-weight:700;} .fbk3{ color:#333; line-height:160%} .fTip{ font-size:11px; font-weight:normal}  img{border:none;} iframe{display:none;} *{word-break:break-word;} #neteaseEncryptedMail{display:none;} #jy-translate{ position: absolute; max-width: 500px; min-width: 100px; _width:300px; border: 1px solid rgb(204, 204, 204); padding: 4px 18px 4px 10px;  background-color: #f9f9f9; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px; -webkit-box-shadow:#dddddd 0px 0px 10px; -moz-box-shadow:#dddddd 0px 0px 10px; box-shadow:#dddddd 0px 0px 10px; } #jy-translate h2, #jy-translate p{color:#555;margin:0;padding:0;} #jy-translate h2{line-height: 28px;font-size: 14px;} #jy-translate p{line-height: 24px;font-size: 12px;} #jy-translate h2 span{font-weight:normal;} </style> </head> <body class="js-body" style="overflow-x: auto;"><div>   <style> *{margin:0;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;box-sizing:border-box;font-size:14px}img{max-width:100%}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100% !important;height:100%;line-height:1.6em}table td{vertical-align:top}body{background-color:#f6f6f6}.body-wrap{background-color:#f6f6f6;width:100%}.container{display:block !important;max-width:600px !important;margin:0 auto !important;clear:both !important}.content{max-width:600px;margin:0 auto;display:block;padding:20px}.main{background-color:#fff;border:1px solid #e9e9e9;border-radius:3px}.content-wrap{padding:20px}.content-block{padding:0 0 20px}.header{width:100%;margin-bottom:20px}.footer{width:100%;clear:both;color:#999;padding:20px}.footer p,.footer a,.footer td{color:#999;font-size:12px}h1,h2,h3{font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;color:#000;margin:40px 0 0;line-height:1.2em;font-weight:400}h1{font-size:32px;font-weight:500}h2{font-size:24px}h3{font-size:18px}h4{font-size:14px;font-weight:600}p,ul,ol{margin-bottom:10px;font-weight:normal}p li,ul li,ol li{margin-left:5px;list-style-position:inside}a{color:#348eda;text-decoration:underline}.btn-primary{text-decoration:none;color:#FFF;background-color:#348eda;border:solid #348eda;border-width:10px 20px;line-height:2em;font-weight:bold;text-align:center;cursor:pointer;display:inline-block;border-radius:5px;text-transform:capitalize}.last{margin-bottom:0}.first{margin-top:0}.aligncenter{text-align:center}.alignright{text-align:right}.alignleft{text-align:left}.clear{clear:both}.alert{font-size:16px;color:#fff;font-weight:500;padding:20px;text-align:center;border-radius:3px 3px 0 0}.alert a{color:#fff;text-decoration:none;font-weight:500;font-size:16px}.alert.alert-warning{background-color:#FF9F00}.alert.alert-bad{background-color:#D0021B}.alert.alert-good{background-color:#68B90F}.invoice{margin:40px auto;text-align:left;width:80%}.invoice td{padding:5px 0}.invoice .invoice-items{width:100%}.invoice .invoice-items td{border-top:#eee 1px solid}.invoice .invoice-items .total td{border-top:2px solid #333;border-bottom:2px solid #333;font-weight:700}.invoice .invoice-items .soustotal td{border-top:1px solid #000;border-bottom:1px solid #000;font-weight:400;color:#000}_media only screen and (max-width: 640px){body{padding:0 !important}h1,h2,h3,h4{font-weight:800 !important;margin:20px 0 5px !important}h1{font-size:22px !important}h2{font-size:18px !important}h3{font-size:16px !important}.container{padding:0 !important;width:100% !important}.content{padding:0 !important}.content-wrap{padding:10px !important}.invoice{width:100% !important}}	 </style>   <table class="body-wrap"> <tbody><tr> <td></td> <td class="container" width="600"> <div class="content"> <table class="main" width="100%" cellpadding="0" cellspacing="0"> <tbody><tr> <td class="content-wrap aligncenter"> <table width="100%" cellpadding="0" cellspacing="0"> <tbody><tr> <td class="content-block"> <h1 class="aligncenter">食铁兽科技</h1> </td> </tr> <tr> <td class="content-block aligncenter"> <b>$username 你好！</b>   <p>您已在 <b>食铁兽科技</b> 成功注册，还差一步就可以登录了，请点击下面链接激活您的账户。</p>   <p><a target="_blank" href="$vurl">$vurl </a></p> </td> </tr> </tbody></table> </td> </tr> </tbody></table> <div class="footer"> <table width="100%"> <tbody><tr> <td class="aligncenter content-block"> <p>食铁兽科技</p> <a href="https://vip.sgk.xyz/" target="_blank">vip.sgk.xyz</a>				 <a href="mailto:admin@zeyudada.cn" target="_blank">联系我们</a> </td> </tr> </tbody></table> </div></div> </td> <td></td> </tr> </tbody></table>     </div></body></html>
EOF;
        $ts = false;
        require APP_PLUGIN_PATH . "/smtp/index.php";
        return '<br>我们已经给您的邮箱重新发送了一次验证邮件，请打开您的邮箱，访问验证链接！'.$data['u_id'];
    }

/**
 * 获取指定目录下所有目录名
 * @param string $path 目录路径
 * @return return 返回目录下所有目录名
 */
function getCatalog($path)
{
    //路径地址
    $dir = $path;
    //判断路径是否存在
    if (is_dir($dir)) {
        //打开目录句柄
        if ($dh = opendir($dir)) {
            $i = 0;
            while (($file = readdir($dh)) !== false) {
                //判断目录或文件
                if (strstr($file, '.') == '') {
                    $tem[$i] = $file;
                    $i++;
                }
            }
            //关闭目录句柄
            closedir($dh);
        }
    }
    return $tem;
}

/**
 * 获取指定目录下所有文件名
 * @param string $path 目录路径
 * @param string $suffix 文件后缀
 * @return return 返回目录下所有文件名
 */
function getfilename($path, $suffix = '.html')
{
    //指定文件夹路径
    $handler = opendir($path);
    $i = 0;
    //遍历文件名
    while (($filename = readdir($handler)) !== false) {
        //略过目录下的名字为'.'和'..'的文件
        if ($filename != '.' && $filename != '..') {
            //获取'.'最后出现的位置
            $d = strrpos($filename, '.');
            //筛选掉文件夹
            if ($d > 0) {
                //获取文件名
                $fname = substr($filename, 0, $d);
                //获取文件后缀
                $suffix = substr($filename, $d);
                //判断是否为指定文件后缀
                if ($suffix == $suffix) {
                    //文件名
                    $data[$i]['val'] = iconv("GB2312", "UTF-8", $fname);
                    //文件名带后缀
                    $data[$i]['title'] = iconv("GB2312", "UTF-8", $filename);
                    $i++;
                }
            }
        }
    }
    //关闭目录句柄
    closedir($handler);
    return $data;
}

/**
 * 断点调适
 * @param mixed $data 断点数据
 * @param string $type 输出类型
 */

function dd($data = null, $type = "pre")
{
    if ($type == "pre") {
        echo '<textarea style="width: 100%; height: -webkit-fill-available;">';
        var_dump($data);
        echo '</textarea>';
    } else {
        echo json_encode($data);
    }
    exit();
}

/**
 * 提示方法
 * @param array $val 返回数据
 * @param mixed $ret 显示方式
 * @return return json
 */
function response_tips($val, $ret = 0)
{
    //判断是否是数据数据
    if (is_array($val)) {
        //遍历数据
        foreach ($val as $key => $value) {
            $data[$key] = $value;
        }
    } else {
        //文本数据
        $data = $val;
    }
    //判断显示方式
    if ($ret == 0) {
        echo json_encode($data);
    } else {
        return json_encode($data);
    }
}

/**
 * 参数不为空判断
 * @param array $name 参数名
 * @param array $val 参数原型(数组)
 * @return return true 或 false
 */
function is_empty($name = [], $val = [])
{
    //遍历参数
    foreach ($name as $k => $v) {
        //判断参数是否为空
        if (empty($val[$v])) {
            $state = false;
            break;
        } else {
            $state = true;
        }
    }
    return $state;
}

/**
 * 文件上传
 * @param mixed $file 文件 $_FILES
 * @param string $path 文件保存地址
 * @param string $name 文件名
 * @param array $filter 允许类型
 * @param string $size 文件大小
 * @return return 0上传错误 1上传成功 2类型错误 3请求错误 4大小错误
 */
function upload_file($file, $path, $name, $filter = [], $size = 1024)
{
    //判断上传是否出错
    if ($file["error"] > 0) {
        return ['code' => 0, "response" => $file['error']];
    } else {
        //获取文件类型
        $file_type = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        if ($filter[0] != '*') {
            //判断文件类型
            if (!in_array($file_type, $filter)) {
                return ['code' => 2, "response" => '不支持的文件类型'];
            }
        }

        //判断文件是临时副本是否存在
        if (!is_uploaded_file($file['tmp_name'])) {
            return ['code' => 3, "response" => '请通过HTTP POST上传文件'];
        }
        //判断文件上传大小
        if ($size < ($file['size'] / 1024)) {
            return ['code' => 4, "response" => '文件大小超过上传上限'];
        }
        //文件地址拼接
        $upload_path = $path . '/' . $name;
        //文件保存到服务器
        move_uploaded_file($file['tmp_name'], $upload_path);
        //图片地址
        $file_url = substr($upload_path, strlen(WWW_PATH));
        //成功返回
        return ['code' => 1, "response" => $file_url];
    }
}

/**
 * 验证码函数
 * @param string $obj 存储session里的对象名
 */
function captcha($obj)
{
    session_start();
    $image = imagecreatetruecolor(200, 60);
    //背景颜色为白色
    $color = imagecolorallocate($image, rand(230, 255), rand(230, 255), rand(230, 255));
    imagefill($image, 20, 20, $color);



//干扰字符
    for ($i = 0; $i < 40; $i++) {
        $fontSize = rand(1,4);
        $x = rand(5, 10) + $i * 200 / 40;
        $y = rand(5, 60);
        $data = '12345678ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $txt = substr($data, rand(0, strlen($data)-1), 1);
        $pointColor = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
        imagestring($image, $fontSize, $x, $y, $txt, $pointColor);
    }
    
    
    //验证码
    $code = '';
    $ttf = 'mcpsg';
    $font = substr($ttf, rand(0, strlen($ttf)-1), 1);
    for ($i = 0; $i < 4; $i++) {
        $Size = rand(30,35);
        $x = rand(5, 10) + $i * 200 / 4;
        $y = rand(40, 50);
        $data = '2345678ABCDEFGHJKLMNPQRTUVWXY';
        $string = substr($data, rand(0, strlen($data)-1), 1);
        $code .= $string;
        $color = imagecolorallocate($image, rand(0, 200), rand(0, 200), rand(0, 200));
        imagettftext($image, $Size, rand(-30,30), $x, $y, $color, __DIR__."/".$font.".ttf", $string);
    }
    $_SESSION[$obj] = $code; //存储在session里


//干扰点
    for ($i = 0; $i < 200; $i++) {
        $pointColor = imagecolorallocate($image, rand(10, 255), rand(10, 255), rand(10, 255));
        imagesetpixel($image, rand(0, 200), rand(0, 60), $pointColor);
    }
    
    
    //干扰线
    for ($i = 0; $i < 15; $i++) {
        $linePoint = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
        imageline($image, rand(0, 100), rand(0, 60), rand(100, 200), rand(0, 60), $linePoint);
    }
    ob_clean();
    header("Content-type:image/jpeg");
    imagepng($image);
    imagedestroy($image);
}

/**
 * 获取指定目录下所有文件名（包括二级）
 * @param string $path 目录路径
 * @return 返回目录下所有文件名
 */
function getFileNameAll($path, $dir = false)
{
    if ($dir) {
        $_path = '';
    } else {
        $_path = $path;
    }
    // 初始化文件夹
    $files = array();
    //使用匿名函数获取列表信息
    $dirList = function ($path, &$files) use (&$dirList, &$_path) {
        //如果不是文件，就度是目录了
        if (is_dir($path)) {
            $dp = dir($path);
            while ($file = $dp->read()) {
                if ($file !== "." && $file !== "..") {
                    // 闭包调用自身
                    $dirList($path . '/' . $file, $files);
                }
            }
            $dp->close();
        }
        if (is_file($path)) {
            $_files = iconv("GB2312", "UTF-8", $path);
            $files[] = str_replace($_path . '/', '', $_files);
        }
        return $files;
    };
    // 返回数据
    return  $dirList($path, $files);
}
