<?php

class HandleController extends Controllers
{
    public function authverify(){
        if (config('user', 'verify') == 1) {
            $name = $_GET['name'];
            $key = $_GET['key'];
            if (empty($name) || empty($key)) {
                die("<script>alert('请从邮箱里打开验证链接！');window.location.href='/user';</script>");
            }
            $data = self::$db->fetchRow(USER_LOGIN, [$name]);
            if ($data['u_id'] > 0 && $key == md5(md5($data['u_id']).md5($data['u_name']).md5($data['u_passwd']).md5($data['u_email']))) {
                $res = self::$db->exec(USER_STATE, [1,$data['u_id']]);
                if ($res > 0) {
                    die("<script>alert('验证成功~');window.location.href='/user';</script>");
                } else {
                    die("<script>alert('验证失败~');window.location.href='/user';</script>");
                }
            } else {
                die("<script>alert('验证信息错误~');window.location.href='/user';</script>");
            }
        }
    }

    //用户注册
    public function register()
    {
        $val = Request::post();
        //关键字段
        $val_name = ['username', 'password', 'email', 'code'];
        //判断验证码
        if (strtoupper($val['code']) != strtoupper($_SESSION['registercode'])) {
            return response_tips(["code" => "204", 'msg' => "验证码错误"]);
        }
        //判断关键字段是否为空
        if (is_empty($val_name, $val)) {
            //验证邮箱格式
            if (!filter_var($val['email'], FILTER_VALIDATE_EMAIL)) {
                return response_tips(["code" => "204", 'msg' => "邮箱格式不正确"]);
            }
            //查询用户是否存在
            $data = self::$db->fetchRow(USER_LOGIN, [$val['username']]);
            //判断查询结果
            if ($data > 0) {
                return response_tips(["code" => "203", 'msg' => "用户已存在"]);
            }
            $data = self::$db->fetchRow(USER_LOGIN_EMAIL, [$val['email']]);
            //判断邮箱是否已经使用
            if ($data > 0) {
                return response_tips(["code" => "203", 'msg' => "该邮箱已绑定"]);
            }
            //添加新数据
            if(config('user', 'verify') == 1){
                $sql = [$val['username'], api_md5($val['password']), $val['email'], 0, 0];
            }else {
                $sql = [$val['username'], api_md5($val['password']), $val['email'], 0, 1];
            }
            $res = self::$db->exec(USER_REGISTER, $sql);

            //判断添加状态
            if ($res > 0) {
                if (config('user', 'verify') == 1) {
                    $username = $val['username'];
                    $data = self::$db->fetchRow(USER_LOGIN, [$username]);
                    $info['to'] = $val['email'];
                    $key = md5(md5($data['u_id']).md5($data['u_name']).md5($data['u_passwd']).md5($data['u_email']));
                    $info['title'] = $_SERVER['HTTP_HOST'] . "注册账号成功";
                    $vurl =  'https://' . $_SERVER['HTTP_HOST'] . "/user/auth/verify?name=" . $data['u_name'] . "&key=" . $key;
                    $info['content'] = <<<EOF
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="renderer"content="webkit"><meta name="viewport"content="width=device-width, initial-scale=1"><title>请验证您的食铁兽科技账号</title><style>.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.05);box-shadow:0 1px 1px rgba(0,0,0,0.05)}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-right-radius:3px;border-top-left-radius:3px}.panel-heading>.dropdown.dropdown-toggle{color:#fff}.panel-title{margin-top:0;margin-bottom:0;font-size:16px;color:#fff}.h3{font-family:inherit;font-weight:500;line-height:1.1;color:#fff}</style></head><body><div class="container"><div class="panel"style="background: #eef;"><div class="panel-heading"style="background: linear-gradient(to right,#b221ff,#14b7ff,#8ae68a)"><h3 class="panel-title">请验证您的食铁兽科技账号</h3></div><div class="panel-body"><div class="panel-body"><b>$username 你好！</b><br><p>您已在<b>食铁兽科技</b>成功注册，还差一步就可以登录了，请点击下面链接激活您的账户。</p><br><div style="text-align: center;"><p><a target="_blank"href="$vurl">$vurl</a></p><p style="color:#F00;">注意，如果您在QQ微信等应用内阅读此邮件，请长按链接，在浏览器里打开！</p><hr><p>power by食铁兽科技</p><a href="https://vip.sgk.xyz/"target="_blank">vip.sgk.xyz</a><a href="mailto:admin@zeyudada.cn"target="_blank">联系我们</a></div></div></div></div></div></body></html>
EOF;
                    $ts = false;
                    require APP_PLUGIN_PATH . "/smtp/index.php";
                }
                return response_tips(["code" => "200", 'msg' => "注册成功"]);
            } else {
                return response_tips(["code" => "203", 'msg' => "注册失败"]);
            }
        } else {
            return response_tips(['code' => '412', 'msg' => '信息请填写完整']);
        }
    }

    //用户登录
    public function login()
    {
        $val = Request::post();
        //判断验证码
        if (strtoupper($val['code']) != strtoupper($_SESSION['logincode'])) {
            return response_tips(["code" => "204", 'msg' => "验证码错误"]);
        }
        //验证关键字段是否为空
        if (is_empty(['username', 'password'], $val)) {
            // 是否需要验证
            $verify = config('user', 'verify');
            //查询信息
            $data = self::$db->fetchRow(USER_LOGIN, [$val['username']]);
            //判断信息是否为空
            if ($data && api_md5($val['password']) == $data['u_passwd']) {
                if ($data['u_state'] == 1) {
                    //记录登录状态
                    $_SESSION[api_user_auth] = true;
                    //记录用户信息
                    $_SESSION['userinfo'] = $data;
                    //响应信息
                    return response_tips(["code" => "200", 'msg' => "登录成功"]);
                } elseif ($verify == 1 && $data['u_state'] == 0) {
                    $rev = reverify($data);
                    return response_tips(["code" => "204", 'msg' => "当前账号未通过邮箱验证~".$rev]);
                } else {
                    return response_tips(["code" => "204", 'msg' => "当前账号因违规已被封禁，如有疑问请联系管理员！"]);
                }
            } else {
                //记录登录状态
                $_SESSION[api_user_auth] = false;
                //响应信息
                return response_tips(["code" => "203", 'msg' => "账号密码错误"]);
            }
        } else {
            //响应信息
            return response_tips(["code" => "412", 'msg' => "账号密码不能为空"]);
        }
    }

    //用户注销
    public function logout()
    {
        unset($_SESSION[api_user_auth]);
        unset($_SESSION['userinfo']);
        redirect("/user/login.html");
    }

    //修改密码
    public function passwd()
    {
        Authentication::UserAuth(false);
        $val = Request::post();
        $val_name = ["old_passwd", 'new_passwd', 'news_passwd'];
        if (is_empty($val_name, $val)) {
            if (api_md5($val['old_passwd']) == $_SESSION['info']['u_passwd']) {
                if ($val['new_passwd'] == $val['news_passwd']) {
                    // 设置更新信息
                    $info = [api_md5($val['new_passwd']), $_SESSION['userinfo']['u_name']];
                    $res = self::$db->exec(USER_PASSWD_EDIT, $info); //修改接口
                    if ($res > 0) return response_tips(["code" => "200", 'msg' => "修改成功"]);
                    else return response_tips(["code" => "200", 'msg' => "无数据修改"]);
                } else return response_tips(['code' => '203', 'msg' => '两次密码不一致']);
            } else return response_tips(['code' => '203', 'msg' => '原密码输入错误']);
        } else return response_tips(['code' => '412', 'msg' => '传递参数错误']);
    }


    //下单购买
    public function order()
    {
        Authentication::UserAuth(false);
        $val = Request::post();
        $val_name = ['id', "type"];
        if (is_empty($val_name, $val)) {
            $u_id = $_SESSION['userinfo']['u_id']; //用户ID
            $l_id = $val['id']; //接口ID
            $time = time(); //时间
            $date = date('Ymdhis', $time) . $time;
            $md5 = md5(md5($_SESSION['userinfo']['u_name']) . $time); //密钥 公式=用户名.时间
            $u_price = floatval($_SESSION['userinfo']['u_balance']); //用户余额
            $data = self::$db->fetchRow(GOODS_DESC, [$l_id]); //查询接口信息
            $l_title =  $data['l_title']; //接口名称
            $price = SetMealType($val['type']); //价格
            //判断账户余额
            if ($u_price - $data[$price] < 0) {
                return response_tips(["code" => "204", 'msg' => "余额不足，请充值！"]);
            }

            //判断价格是否免费
            if ($data[$price] == 0) {
                $res = 1;
            } else {
                //新余额
                $new_price = $u_price  - $data[$price];
                $res = self::$db->exec(Pay_user_up, [$new_price, $u_id]); //扣款
            }
            //判断扣款情况
            if ($res <= 0) {
                return response_tips(["code" => "203", 'msg' => "扣款失败"]);
            }
            $record = self::$db->fetchRow(Pay_API_RPW, [$l_id, $u_id]); //查询是否已购买
            $username = $_SESSION['userinfo']['u_name'];
            $p = $data[$price];
            //判断记录是否存在
            if ($record > 0) {
                //校准时间
                if ((date("Y-m-d H-i-s", $record['ow_end_time'])) > (date("Y-m-d H-i-s", $time))) {
                    $log_time = SetMealTiime($val['type'], $record['ow_end_time']); //更新到期时间
                } else {
                    $log_time = SetMealTiime($val['type']); //获取时间
                }
                $res = self::$db->exec(Pay_api_edit, [$log_time, $l_id]); //续费商品
                if ($res > 0) {
                    $info = [$u_id, $l_id, $l_title, $date, 2, $data[$price], $log_time]; //订单记录信息
                    $res = self::$db->exec(Pay_shopp, $info); //写入订单记录
                    $info['to'] = $_SESSION['userinfo']['u_email'];
                    $info['title'] = $_SERVER['HTTP_HOST'] . "产品续费成功";
                    $info['content'] = <<<EOF
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="renderer"content="webkit"><meta name="viewport"content="width=device-width, initial-scale=1"><title>产品续费成功</title><style>.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.05);box-shadow:0 1px 1px rgba(0,0,0,0.05)}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-right-radius:3px;border-top-left-radius:3px}.panel-heading>.dropdown.dropdown-toggle{color:#fff}.panel-title{margin-top:0;margin-bottom:0;font-size:16px;color:#fff}.h3{font-family:inherit;font-weight:500;line-height:1.1;color:#fff}</style></head><body><div class="container"><div class="panel"style="background: #eef;"><div class="panel-heading"style="background: linear-gradient(to right,#b221ff,#14b7ff,#8ae68a)"><h3 class="panel-title">产品续费成功</h3></div><div class="panel-body"><div class="panel-body"><b>$username你好！</b><br><p>您已在<b>食铁兽科技</b>成功续费$l_title 。</p><p>产品价格：$p 元，还剩余额$new_price 元</p><br><div style="text-align: center;"><hr><p>power by食铁兽科技</p><a href="https://vip.sgk.xyz/"target="_blank">vip.sgk.xyz</a><a href="mailto:admin@zeyudada.cn"target="_blank">联系我们</a></div></div></div></div></div></body></html>
EOF;
                    $ts = false;
                    require APP_PLUGIN_PATH . "/smtp/index.php";
                    return response_tips(["code" => "200", 'msg' => "续费成功"]);
                } else {
                    return response_tips(["code" => "203", 'msg' => "续费失败"]);
                }
            } else {
                $log_time = SetMealTiime($val['type']); //获取到期时间
                $info = [$u_id, $l_id, $md5, $time, $log_time]; //用户记录信息
                $res = self::$db->exec(Pay_api, $info); //购买商品
                if ($res > 0) {
                    $info = [$u_id, $l_id, $l_title, $date, 1, $data[$price], $log_time]; //订单记录信息
                    $res = self::$db->exec(Pay_shopp, $info); //写入订单记录
                    $info['to'] = $_SESSION['userinfo']['u_email'];
                    $info['title'] = $_SERVER['HTTP_HOST'] . "购买商品成功";
                    $info['content'] = <<<EOF
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="renderer"content="webkit"><meta name="viewport"content="width=device-width, initial-scale=1"><title>购买商品成功</title><style>.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.05);box-shadow:0 1px 1px rgba(0,0,0,0.05)}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-right-radius:3px;border-top-left-radius:3px}.panel-heading>.dropdown.dropdown-toggle{color:#fff}.panel-title{margin-top:0;margin-bottom:0;font-size:16px;color:#fff}.h3{font-family:inherit;font-weight:500;line-height:1.1;color:#fff}</style></head><body><div class="container"><div class="panel"style="background: #eef;"><div class="panel-heading"style="background: linear-gradient(to right,#b221ff,#14b7ff,#8ae68a)"><h3 class="panel-title">购买商品成功</h3></div><div class="panel-body"><div class="panel-body"><b>$username你好！</b><br><p>您已在<b>食铁兽科技</b>成功购买$l_title 。</p><p>产品价格：$p 元，还剩余额$new_price 元</p><br><div style="text-align: center;"><hr><p>power by食铁兽科技</p><a href="https://vip.sgk.xyz/"target="_blank">vip.sgk.xyz</a><a href="mailto:admin@zeyudada.cn"target="_blank">联系我们</a></div></div></div></div></div></body></html>
EOF;
                    $ts = false;
                    require APP_PLUGIN_PATH . "/smtp/index.php";
                    return response_tips(["code" => "200", 'msg' => "购买成功"]);
                } else {
                    return response_tips(["code" => "203", 'msg' => "购买失败"]);
                }
            }
        } else {
            return response_tips(['code' => '412', 'msg' => '传递参数错误']);
        }
    }

    //回调事件
    public function notify()
    {
        $url = isset($_SESSION['query_url']) ? $_SESSION['query_url'] : ''; //获取回调地址
        //判断创建标识
        if (!isset($_SESSION["Recharge"]) && empty($_SESSION["Recharge"])) {
            header('Location: ../');
            return;
        }
        //删除创建标识
        unset($_SESSION["Recharge"]);
        //查询订单
        $data = file_get_contents($url);
        $data = json_decode($data, true);
        //判断订单数据返回
        if (isset($data["data"]['status']) && !empty($data['data']['status'])) {
            // echo $data['data']['status'];
            if ($data['data']['status'] == "settled") {
                if ($data['data']['type'] == "alipay") {
                    $type = 1;
                }
                if ($data['data']['type'] == "wechat") {
                    $type = 3;
                }
                //查询账号
                $q = self::$db->fetchRow(USER_LOGIN, [$data['data']['extend']]);
                if ($q > 0) {
                    $balance = $data['data']['price'] + $q['u_balance'];
                    //修改数据
                    $info = [$q['u_name'], $q['u_email'], $balance, $q['u_id']];
                    $res = self::$db->exec(ADMIN_USER_EDIT, $info); //修改余额
                    if ($res > 0) {
                        $log = [$data['data']['extend'], $data['data']['realprice'], $data['data']['price'], $type,  $data['data']['out_order_id'], "自助充值", time(), 2, time()];
                        $r = self::$db->exec(WEB_USER_ADDFUNDS, [$log]); //添加加款记录

                        if ($r >= 0) {
                            header('Location: ' . $_SESSION['pay_jump']);
                        } else {
                            header('Location: ' . $_SESSION['pay_jump']);
                        }
                    } else {
                        echo "<script>alert('充值记录记录错误');window.location.href='" . $_SESSION['pay_jump'] . "';</script>";
                    }
                } else {
                    echo "<script>alert('不存在的充值用户');window.location.href='" . $_SESSION['pay_jump'] . "';</script>";
                }
            } else {
                echo "<script>alert('非法访问');window.location.href='" . $_SESSION['pay_jump'] . "';</script>";
            }
        } else {
            echo "<script>alert('充值失败');window.location.href='" . $_SESSION['pay_jump'] . "';</script>";
        }
    }

    //密钥修改
    public function owned()
    {
        Authentication::UserAuth(false);
        $id = Request::post('id');
        //判断ID是否为空
        if (!empty($id)) {
            $time = time();
            $md5 = md5(md5($_SESSION['userinfo']['u_name']) . $time); //密钥 公式=用户名.时间
            $res = self::$db->exec(USER_API_MD5, [$md5, $id]); //重置密钥
            if ($res > 0) {
                return response_tips(["code" => "200", 'msg' => "重置成功"]);
            } else {
                return response_tips(["code" => "203", 'msg' => "重置失败"]);
            }
        } else {
            return response_tips(['code' => '412', 'msg' => '传递参数错误']);
        }
    }

    //找回密码
    public function forget()
    {
        $val = Request::post();
        //判断验证码
        if (strtoupper($val['code']) != strtoupper($_SESSION['forgetcode'])) {
            return response_tips(["code" => "204", 'msg' => "验证码错误"]);
        }
        //验证
        if (is_empty(['username', "email"], $val)) {
            $data = self::$db->fetchRow(USER_FORGET, [$val['username'], $val['email']]);
            //判断邮箱是否已经使用 
            if ($data > 0) {
                //获取重置密码
                $pass = getRandomStr(10);
                //保存重置密码
                $res = self::$db->exec(USER_Reset_pass, [api_md5($pass), $val['username']]); //重置密钥
                //判断保存结果
                if ($res > 0) {
                	$username = $val['username'];
                    $info['to'] = $val['email'];
                    $info['title'] = $_SERVER['HTTP_HOST'] . "密码找回";
                    $info['content'] = <<<EOF
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="renderer"content="webkit"><meta name="viewport"content="width=device-width, initial-scale=1"><title>密码找回</title><style>.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.05);box-shadow:0 1px 1px rgba(0,0,0,0.05)}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-right-radius:3px;border-top-left-radius:3px}.panel-heading>.dropdown.dropdown-toggle{color:#fff}.panel-title{margin-top:0;margin-bottom:0;font-size:16px;color:#fff}.h3{font-family:inherit;font-weight:500;line-height:1.1;color:#fff}</style></head><body><div class="container"><div class="panel"style="background: #eef;"><div class="panel-heading"style="background: linear-gradient(to right,#b221ff,#14b7ff,#8ae68a)"><h3 class="panel-title">密码找回</h3></div><div class="panel-body"><div class="panel-body"><b>$username你好！</b><br><p>您正在<b>食铁兽科技</b>找回密码。</p><p>您的新密码是：$pass ，请使用新密码登录</p><p style="color:#f00">注意，复制密码时不要把空格复制上！</p><br><div style="text-align: center;"><hr><p>power by 食铁兽科技</p><a href="https://vip.sgk.xyz/"target="_blank">vip.sgk.xyz</a><a href="mailto:admin@zeyudada.cn"target="_blank">联系我们</a></div></div></div></div></div></body></html>
EOF;
                    $ts = true;
                    require APP_PLUGIN_PATH . "/smtp/index.php";
                } else return response_tips(["code" => "203", 'msg' => "密码找回失败"]);
            } else return response_tips(["code" => "203", 'msg' => "不存在的用户或邮箱"]);
        } else return response_tips(['code' => '412', 'msg' => '填写信息错误']);
    }

    //白名单
    public function apiip()
    {
        Authentication::UserAuth(false);
        $val = Request::post();
        $val_name = ['roster'];
        // if (is_empty($val_name, $val)) {
        $ip = explode(';', $val['roster']);
        $xz = config('redis');
        if (count($ip) > $xz['redis_ips']) return response_tips(["code" => "204", 'msg' => "超出白名单上限"]);
        $re = self::$db->exec(API_DEL_IP, [$_SESSION['userinfo']['u_id']]);

        $res = self::$db->exec(API_IPs, [$_SESSION['userinfo']['u_id'], $val['roster']]); //白名单
        if ($res >= 0) return response_tips(["code" => "200", 'msg' => "保存成功"]);
        else return response_tips(["code" => "203", 'msg' => "保存失败"]);
        // } else {
        //     return response_tips(['code' => '412', 'msg' => '填写信息错误']);
        // }
    }

    // 卡密充值
    public function kami()
    {
        Authentication::UserAuth(false);
        $user = Request::post('user');
        $param = Request::post('param');
        $kami = Request::post('kami');
        $salt = Request::post('salt');
        $time = time();
        //查询账号
        $user_info = self::$db->fetchRow(USER_LOGIN, [$user]);
        // 用户是否存在
        if ($user_info) {
            $kami_info = self::$db->fetchRow(GET_KAMI, [$kami]);
            // 验证卡密是否存在
            if ($kami_info && $kami_info['a_k_state'] == 1) {
                // 单号
                $payno = "kami" . $kami_info['a_k_id'];
                // 卡密余额
                $price = $kami_info['a_k_money'];
                // 新的余额
                $balance = $user_info['u_balance'] + $price;
                if (self::$db->exec(USER_BALANCE, [$balance, $user_info['u_id']])) {
                    //先修改余额！
                    //修改数据
                    $res = self::$db->exec(SET_KAMI, [2, $user, $kami_info['a_k_id']]);
                } else return response_tips(['code' => '400', 'msg' => '充值异常']);
                if ($res) {
                    // 日志信息
                    $log = [$user_info['u_name'], $price, $price, $salt,  $payno, "卡密充值", $time, 2, $time];
                    $res = self::$db->exec(WEB_USER_ADDFUNDS, [$log]); //添加加款记录
                    // 返回处理结果
                    if ($res) {
                    	$info['to'] = $user_info['u_email'];
                    $info['title'] = $_SERVER['HTTP_HOST'] . "余额充值成功";
                    $info['content'] = <<<EOF
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="renderer"content="webkit"><meta name="viewport"content="width=device-width, initial-scale=1"><title>余额充值成功</title><style>.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.05);box-shadow:0 1px 1px rgba(0,0,0,0.05)}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-right-radius:3px;border-top-left-radius:3px}.panel-heading>.dropdown.dropdown-toggle{color:#fff}.panel-title{margin-top:0;margin-bottom:0;font-size:16px;color:#fff}.h3{font-family:inherit;font-weight:500;line-height:1.1;color:#fff}</style></head><body><div class="container"><div class="panel"style="background: #eef;"><div class="panel-heading"style="background: linear-gradient(to right,#b221ff,#14b7ff,#8ae68a)"><h3 class="panel-title">余额充值成功</h3></div><div class="panel-body"><div class="panel-body"><b>$username你好！</b><br><p>您已在<b>食铁兽科技</b>成功充值余额$price 元。</p><p>您还剩余额$balance 元，下一步，欢迎购买我们的产品!</p><br><div style="text-align: center;"><hr><p>power by 食铁兽科技</p><a href="https://vip.sgk.xyz/"target="_blank">vip.sgk.xyz</a><a href="mailto:admin@zeyudada.cn"target="_blank">联系我们</a></div></div></div></div></div></body></html>
EOF;
                    $ts = false;
                    require APP_PLUGIN_PATH . "/smtp/index.php";
                        return response_tips(["code" => "200", 'msg' => "充值成功"]);
                    } else return response_tips(["code" => "203", 'msg' => "记录失败"]);
                } else return response_tips(['code' => '400', 'msg' => '充值失败']);
            } else if($kami_info['a_k_state'] == 2) return response_tips(['code' => '400', 'msg' => '卡密已经被用户【'.$kami_info['a_u_name'].'】使用！']);
            else return response_tips(['code' => '400', 'msg' => '卡密不存在！']);
        } else return response_tips(['code' => '412', 'msg' => '传递参数错误']);
    }
}
