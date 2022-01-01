<?php

class indexController extends Controllers
{
    
    //后台登录
    public function login()
    {
        //验证是否已经登录
        if (isset($_SESSION[api_admin_auth]) && $_SESSION[api_admin_auth] === true) {
            return redirect('index.html');
        }
        view("admin/login");
    }

    //接口编辑
    public function editapi()
    {
        Authentication::AdminAuth();
        //获取ID
        $id = Request::get('id');
        $data['info'] = self::$db->fetchRow(ADMIN_APIINFO, [$id]); //基本信息

        $data['data'] = self::$db->fetchRow(ADMIN_DATACHA, [$id]); //数据绑定

        $table = self::$db->fetchAll(ADMIN_TABLESALL); //获取数据库所有表名
        //获取数据库名
        $table_name =  config('database', 'dbname');
        //出去数据库所有表名
        foreach ($table as $key => $value) {
            $d[$key] = $value['Tables_in_' . $table_name];
        }
        $data['table'] = $d;

        //判断绑定数据是否存在
        if (!$data['data']['b_table'] == null) {
            //查询数表字段
            $field = self::$db->fetchAll(ADMIN_FIELD . $data['data']['b_table']);
            //表字段处理
            foreach ($field as $key => $value) {
                $c[$key] = $value['Field'];
            }
            $data['field'] = $c;
        }
        $data['price'] = self::$db->fetchRow(ADMIN_Price, [$id]); //价格
        $data['val'] = self::$db->fetchAll(ADMIN_VALDOC, [$data['info']['l_id']]); //参数
        // dd($data['field']);
        // dd($data);

        view("admin/editapi", ['data' => $data]);
    }

    //后台首页
    public function index()
    {
        Authentication::AdminAuth();
        //平台用户数
        $data['total'] = self::$db->fetchRow(WEB_USER);
        
        $data['ok'] = self::$db->fetchRow('SELECT count(*) FROM `api_user` WHERE `a_u_state` = ?',[1]);
        //注册人数
        $data['register'] = [];
        //$data['register'] = self::$db->fetchAll(WEB_USER_DAY, [date("Y-m-d")]);
        //$data['yesterday'] = reset(reset(self::$db->fetchAll(WEB_USER_DAY, [date("Y-m-d",strtotime("-1 day"))])));
        for ($x=30; $x>=0; $x--) {
            $result = self::$db->fetchRow(WEB_USER_DAY, [date("Y-m-d",strtotime("-$x day"))]);
            $data['register'][] = reset($result);
        }
        //累计收益
        $data['profit'] = [];
        for ($x=30; $x>=0; $x--) {
            $mn = self::$db->fetchAll(WEB_USER_PAY, [date("Y-m-d",strtotime("-$x day"))]);
            $m = 0;
            foreach ($mn as $key => $value) {
                $m = $m + $value['money'];
            }
            $data['profit'][] = $m;
        }
        
        //api总数
        $data['api'] =  self::$db->fetchAll(WEB_USER_API);
        
        view("admin/index", ['data' => $data]);
    }

    //添加接口页
    public function addapi()
    {
        Authentication::AdminAuth();
        view("admin/addapi");
    }

    //数据绑定页
    public function datainfo()
    {
        Authentication::AdminAuth();
        //接口数据查询
        $apilist = self::$db->fetchAll(ADMIN_ADDLIST);

        //获取绑定数据
        foreach ($apilist as $key => $value) {
            // if ($value['l_data'] == 1) {
            $apidata[$key] = $value;
            // }
        }
        // dd($apidata);
        $data['apilist'] = $apidata;
        //表查询
        $table = self::$db->fetchAll(ADMIN_TABLESALL);
        //获取表名
        $table_name =  config('database', 'dbname');
        foreach ($table as $key => $value) {
            $d[$key] = $value['Tables_in_' . $table_name];
        }
        $data['table'] = $d;
        view("admin/datainfo", ['data' => $data]);
    }

    // 文件绑定页
    public function fileinfo()
    {
        Authentication::AdminAuth();
        //接口数据查询
        $apilist = self::$db->fetchAll(ADMIN_ADDLIST);
        //获取绑定数据
        foreach ($apilist as $key => $value) {
            // if ($value['l_data'] == 1) {
            $apidata[$key] = $value;
            // }
        }
        $data['apilist'] = $apidata;
        //表查询
        $table = self::$db->fetchAll(ADMIN_TABLESALL);
        //获取表名
        $table_name =  config('database', 'dbname');
        foreach ($table as $key => $value) {
            $d[$key] = $value['Tables_in_' . $table_name];
        }
        $data['table'] = $d;
        view("admin/fileinfo", ['data' => $data]);
    }

    //参数设置页
    public function apiinfo()
    {
        Authentication::AdminAuth();
        //接口数据查询
        $data = self::$db->fetchAll(ADMIN_ADDLIST);
        view("admin/apiinfo", ['data' => $data]);
    }

    //接口列表页
    public function apilist()
    {
        Authentication::AdminAuth();
        //数据查询
        $data = self::$db->fetchAll(ADMIN_ADDLIST);
        view('admin/apilist', ['data' => $data]);
    }

    //网站设置页
    public function webset()
    {
        Authentication::AdminAuth();
        //获取网站数据
        $web = config('webset');
        view("admin/webset", ['web' => $web]);
    }

    //会员列表页
    public function userinfo()
    {
        Authentication::AdminAuth();

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = $page - 1;

        $size = isset($_GET['size']) ? $_GET['size'] : 100;

        $wd = $_GET['wd'];
        if (config('user', 'verify') == 1) {
            if (!empty($wd)) {
                $sql = "SELECT a_u_id AS u_id,a_u_name AS u_name,a_u_passwd AS u_passwd,a_u_email AS u_email,a_u_balance AS u_balance,a_u_found_time AS u_found_time,a_u_state AS u_state FROM `vip`.`api_user` WHERE `a_u_id` = '".$wd."' OR `a_u_name` LIKE '%".$wd."%' OR `a_u_email` LIKE '%".$wd."%' LIMIT " . $page * $size . "," . $size;
            } else {
                $sql = "SELECT api_user.a_u_id AS u_id,a_u_name AS u_name,a_u_passwd AS u_passwd,a_u_email AS u_email,a_u_balance AS u_balance,a_u_found_time AS u_found_time,a_u_state AS u_state,a_u_state AS u_state FROM api_user order by u_id desc LIMIT " . $page * $size . "," . $size;
            }
        } else {
            if (!empty($wd)) {
                $sql =
                    "SELECT a_u_id AS u_id,a_u_name AS u_name,a_u_passwd AS u_passwd,a_u_email AS u_email,a_u_balance AS u_balance,a_u_found_time AS u_found_time,a_u_state AS u_state FROM api_user WHERE `a_u_name` LIKE '%".$wd."%' OR `a_u_email` LIKE '%".$wd."%' OR `a_u_balance` LIKE '%".$wd."%' OR `a_u_id` = ".$wd." LIMIT" . $page * $size . "," . $size;
            } else {
                $sql =
                    "SELECT a_u_id AS u_id,a_u_name AS u_name,a_u_passwd AS u_passwd,a_u_email AS u_email,a_u_balance AS u_balance,a_u_found_time AS u_found_time,a_u_state AS u_state FROM api_user order by u_id desc LIMIT" . $page * $size . "," . $size;
            }

            // $data = self::$db->fetchAll(ADMIN_USER);
        }
        
        //dd($sql);

        $data = self::$db->fetchAll($sql);

        $paging = self::$db->fetchRow("SELECT count(*) as paging FROM api_user"); //分页

        view('admin/userinfo', ['data' => $data, 'paging' => $paging['paging'], "page" => $page + 1, 'wd' => $_GET['wd']]);
    }
    
    //已购买的接口列表页
    public function ownedinfo()
    {
        Authentication::AdminAuth();

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = $page - 1;

        $size = isset($_GET['size']) ? $_GET['size'] : 100;

        $wd = $_GET['wd'];
        if (!empty($wd)) {
            $sql = "SELECT * FROM `api_owned` WHERE `ow_md5` LIKE '%bb8c9e%' order by ow_id desc LIMIT " . $page * $size . "," . $size;
        } else {
            $sql = "SELECT * FROM `api_owned` order by ow_id desc LIMIT " . $page * $size . "," . $size;
        }
        
        //dd($sql);

        $data = self::$db->fetchAll($sql);

        $paging = self::$db->fetchRow("SELECT count(*) as paging FROM `api_owned`"); //分页

        view('admin/ownedinfo', ['data' => $data, 'paging' => $paging['paging'], "page" => $page + 1, 'wd' => $_GET['wd']]);
    }

    //已购买接口编辑
    public function ownededit()
    {
        Authentication::AdminAuth();
        $id = Request::get('id');
        $data = self::$db->fetchRow(ADMIN_OWNED_ROW, [$id]);
        view("admin/ownededit", ['data' => $data]);
    }

    //修改密码
    public function passwd()
    {
        Authentication::AdminAuth();
        view("admin/passwd");
    }

    //退出登录
    public function logout()
    {
        //清除Session
        unset($_SESSION[api_admin_auth]);
        unset($_SESSION['info']);
        redirect("./login.html");
    }

    //用户编辑
    public function useredit()
    {
        Authentication::AdminAuth();
        $id = Request::get('id');
        $data = self::$db->fetchRow(ADMIN_USER_ROW, [$id]);
        view("admin/useredit", ['data' => $data]);
    }

    //用户添加
    public function adduser()
    {
        Authentication::AdminAuth();
        view("admin/adduser");
    }

    //邮箱配置
    public function email()
    {
        Authentication::AdminAuth();
        $web = config('email');
        view("admin/email", ["web" => $web]);
    }

    //redis
    public function redis()
    {
        Authentication::AdminAuth();
        $web = config('redis');
        view("admin/redis", ['web' => $web]);
    }

    // 注册设置
    public function setuser()
    {
        Authentication::AdminAuth();
        $web = config('user');
        view("admin/setuser", ['web' => $web]);
    }

    // 订单页
    public function order()
    {
        Authentication::AdminAuth();
        $sql = "SELECT * FROM api_order INNER JOIN api_user ON api_order.o_u_id = api_user.a_u_id ORDER BY o_id DESC";
        $data = self::$db->fetchAll($sql);
        view("admin/order", ['data' => $data]);
    }

    // 卡密列表页
    public function kami()
    {
        Authentication::AdminAuth();

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = $page - 1;

        $size = isset($_GET['size']) ? $_GET['size'] : 100;

        if (!empty($_GET['wd'])) {
            $sql = "SELECT * FROM api_kami WHERE a_k_content = '" . $_GET['wd'] . "'";
            $paging = self::$db->fetchRow("SELECT count(*) as paging FROM api_kami WHERE a_k_content = '" . $_GET['wd'] . "'"); //分页
        } else {
            $sql = "SELECT * FROM api_kami ORDER BY a_k_id desc LIMIT " . $page * $size . ", " . $size . " ";
            $paging = self::$db->fetchRow("SELECT count(*) as paging FROM api_kami"); //分页
        }

        $data = self::$db->fetchAll($sql);

        // $kami = setKami();
        view("admin/kami", ['data' => $data, 'paging' => $paging['paging'], "page" => $page + 1, 'wd' => $_GET['wd']]);
    }

    // 卡密添加页
    public function addkami()
    {
        Authentication::AdminAuth();
        return view("admin/addkami");
    }
}
