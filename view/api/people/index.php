<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:GET,POST");
if (!isset($_GET['zeyudadadebug'])) error_reporting(0);
    if (!isset($_GET['name'])&&!isset($_GET['tel'])&&!isset($_GET['mail'])) { 
    ?><!DOCTYPE html><html lang="zh-cn"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>泄露数据在线查询</title>
<link href="//lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body background="https://api.ixiaowai.cn/api/api.php">
<div class="container">
<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<br>
<div class="panel panel-primary">
<div class="panel-heading" style="background: linear-gradient(to right,#b221ff,#14b7ff,#8ae68a);">
<h3 class="panel-title">人口接口可视化界面</h3>
</div>
<div class="panel-body" style="text-align: center;">
<form action="/api/people" method="get">
<div class="list-group-item"><p>有人不会用接口，本页提供可视化查询，对接您的接口</p>
<div class="input-group">
<span class="input-group-addon">您的apiKey</span>
<input type="text" class="form-control" value="<?php echo($_GET['apiKey']) ?>" placeholder="请输入apiKey" name="apiKey">
</div></div>

<div class="list-group-item"><p>筛选方式，三选一！<br>如果都填了，优先级：姓名&gt;手机&gt;邮箱</p><div class="input-group">
<span class="input-group-addon">姓名</span>
<input type="text" class="form-control" placeholder="" name="name">
</div>
<div class="input-group">
<span class="input-group-addon">手机</span>
<input type="text" class="form-control" placeholder="" name="tel">
</div>
<div class="input-group">
<span class="input-group-addon">邮箱</span>
<input type="text" class="form-control" placeholder="" name="mail">
</div>
<div class="input-group">
<span class="input-group-addon">限制返回字数</span>
<input type="text" class="form-control" oninput="value=value.replace(/[^\d]/g,'')" placeholder="方便对接我们时防止字数太多" name="limit">
</div></div>
<div class="list-group-item">
<button type="submit" class="btn btn-block btn-primary" style="background: linear-gradient(to right,#833AB4,#FD1D1D,#FCB045)">提交查询</button></div>
</form>

</div>
</div>
</div></div>




</body></html><?php
        die();
    }

class Sql
{
    public $link;

    public function __construct()
    {
    $DbConfig = [
            'host' => 'localhost',
            'port' => 6603,
            'user' => 'people',
            'pwd' => '6syPLkDpYBiSLdHi',
            'name' => 'people',
            'long' => false,
        ];
        if (empty($DbConfig['port'])) $DbConfig['port'] = 3306;
        $this->link = mysqli_connect($DbConfig['host'], $DbConfig['user'], $DbConfig['pwd'], $DbConfig['name'], $DbConfig['port']);
        if (!$this->link) exit(mysqli_connect_error());
        $this->query('set names utf8');
    }

    //链接数据库
    public function conn($user,$pwd,$name)
    {
    }

    //执行查询
    public function query($sql)
    {
        return mysqli_query($this->link, $sql);
    }

	public function fetch($q){
		return mysqli_fetch_assoc($q);
	}

    //查询数据
    public function get_row($sql)
    {
        $res = $this->query($sql);
        if (!$res) return false;
        return mysqli_fetch_assoc($res);
    }

    //查询全部数据
    public function getAll($sql)
    {
        $res = $this->query($sql);
        while ($row =  mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    //报错信息
    public function error()
    {
        return mysqli_error($this->link);
    }

    //关闭数据库链接
    public function close()
    {
        return mysqli_close($this->link);
    }
}

function name($qq)
{
    if ($qq == '') die('查询数据不能为空');

    $db = new Sql;
    //$db->conn();

    if ($db->get_row("SELECT *  FROM `bmd` WHERE `name` = '{$qq}'")) {
    } else {
    	$echo = '';
        $rs = $db->getAll("SELECT * FROM `car` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\naddress:" .$res['place']. "\nmobile:" . $res['tel'] . "\ncar:" . $res['car'] . "\ncarname:" . $res['carname'] . "\ncolor:" . $res['color'] . "\nmotor:" . $res['motor'] . "\ndate:" . $res['date'] . "\nsource:全国车主\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `kf` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\naddress:" .$res['address']. "\nmobile:" . $res['mobile'] . "\nfax:" . $res['fax'] . "\nsource:开房\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `jingdong` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name']. "\nuser:" . $res['user'] . "\npwd:" . $res['pwd'] . "\nsfz:" . $res['sfz'] . "\nmail:" . $res['mail'] . "\nmobile:" . $res['mobile'] . "\nsource:京东1.4e数据库\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `fixman` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\nmobile:" . $res['mobile'] . "\nsource:混合1\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `fixman2` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\nmobile:" . $res['mobile'] . "\nsource:混合2\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `jxydvip` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['three'] . "\nmobile:" . $res['mobile'] . "\nsource:江西移动VIP\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `shunfeng` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nplace:" .$res['provinces'].$res['city'].$res['place'] . "\nmobile:" . $res['mobile'] . "\nsource:顺丰\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `vancl` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nplace:" . $res['address'] . "\nmobile:" . $res['tel'] . "\nzip:" . $res['zip'] . "\nsource:凡客诚品买家信息\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `police` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\nmobile:" . $res['mobile'] . "\nplace:" .$res['provinces'] . "\nsource:公安户籍数据：".$res['source']."\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `pabx` WHERE `name` = '{$qq}' LIMIT 0,100");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nplace:" .$res['provinces'].$res['city'] . "\nmobile:" . $res['tel'] . "\nsfz:" . $res['sfz'] . "\nmail:" . $res['mail'] . "\nmail:" . $res['mail'] . "\nsource:平安保险\n";
            $yes = "yes";
        }
        if($yes != "yes") die("查询方式姓名".$qq."没有数据");
        return $echo;
    }
}

function tel($qq)
{
    if ($qq == '') die('查询数据不能为空');
    if (!is_numeric($qq)) return '查询数据格式不正确';

    $db = new Sql;
    $db->conn();

    if ($db->get_row("SELECT *  FROM `bmd` WHERE `name` = '{$qq}'")) {
    } else {
    	$echo = '';
        $rs = $db->getAll("SELECT * FROM `car` WHERE `tel` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\naddress:" .$res['place']. "\nmobile:" . $res['tel'] . "\ncar:" . $res['car'] . "\ncarname:" . $res['carname'] . "\ncolor:" . $res['color'] . "\nmotor:" . $res['motor'] . "\ndate:" . $res['date'] . "\nsource:全国车主\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `jingdong` WHERE `mobile` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name']. "\nuser:" . $res['user'] . "\npwd:" . $res['pwd'] . "\nsfz:" . $res['sfz'] . "\nmail:" . $res['mail'] . "\nmobile:" . $res['mobile'] . "\nsource:京东1.4e数据库\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `fixman` WHERE `mobile` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\nmobile:" . $res['mobile'] . "\nsource:混合1\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `fixman2` WHERE `mobile` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\nmobile:" . $res['mobile'] . "\nsource:混合2\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `jxydvip` WHERE `mobile` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['three'] . "\nmobile:" . $res['mobile'] . "\nsource:江西移动VIP\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `shunfeng` WHERE `mobile` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nplace:" .$res['provinces'].$res['city'].$res['place'] . "\nmobile:" . $res['mobile'] . "\nsource:顺丰\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `vancl` WHERE `tel` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nplace:" . $res['address'] . "\nmobile:" . $res['tel'] . "\nzip:" . $res['zip'] . "\nsource:凡客诚品买家信息\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `police` WHERE `mobile` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\nmobile:" . $res['mobile'] . "\nplace:" .$res['provinces'] . "\nsource:公安户籍数据：".$res['source']."\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `pabx` WHERE `tel` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nplace:" .$res['provinces'].$res['city'] . "\nmobile:" . $res['tel'] . "\nsfz:" . $res['sfz'] . "\nmail:" . $res['mail'] . "\nmail:" . $res['mail'] . "\nsource:平安保险\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `kf` WHERE `mobile` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nsfz:" . $res['sfz'] . "\naddress:" .$res['address']. "\nmobile:" . $res['mobile'] . "\nfax:" . $res['fax'] . "\nsource:开房\n";
            $yes = "yes";
        }
        if($yes != "yes") die("查询方式手机".$qq."没有数据");
        return $echo;
    }
}

function chamail($qq)
{
    if ($qq == '') die('查询数据不能为空');

    $db = new Sql;
    $db->conn();

    if ($db->get_row("SELECT *  FROM `bmd` WHERE `name` = '{$qq}'")) {
    } else {
    	$echo = '';
        $rs = $db->getAll("SELECT * FROM `jingdong` WHERE `mail` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name']. "\nuser:" . $res['user'] . "\npwd:" . $res['pwd'] . "\nsfz:" . $res['sfz'] . "\nmail:" . $res['mail'] . "\nmobile:" . $res['mobile'] . "\nsource:京东1.4e数据库\n";
            $yes = "yes";
        }
        $rs = $db->getAll("SELECT * FROM `pabx` WHERE `mail` = '{$qq}'");
        foreach ($rs as $res) {
            $echo .= 'txt:' . $res['name'] . "\nplace:" .$res['provinces'].$res['city'] . "\nmobile:" . $res['tel'] . "\nsfz:" . $res['sfz'] . "\nmail:" . $res['mail'] . "\nmail:" . $res['mail'] . "\nsource:平安保险\n";
            $yes = "yes";
        }
        if($yes != "yes") echo("查询方式邮箱".$qq."没有数据");
        return $echo;
    }
}


header('content-type:text/plain');

if ($_GET['name']) {
	$echo = name($_GET['name']);
}elseif ($_GET['tel']) {
	$echo = tel($_GET['tel']);
}elseif ($_GET['mail']) {
	$echo = chamail($_GET['mail']);
}elseif ($_GET['cha']) {
	die("该参数用来给食铁兽科技APP查询使用『name|tel|mail』");
}else{
	die("提交参数错误");
}

if(!empty($_GET['limit'])){
	die(mb_substr($echo,0,$_GET['limit'],'UTF8'));
}else{
	die($echo);
}

?>