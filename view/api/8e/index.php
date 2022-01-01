<?php
$qq = $_GET['qq'];
if(!isset($_GET['debug'])){
error_reporting(0);
}
if(empty($qq)&&empty($_FILES["file"]["name"])){ ?>
<!DOCTYPE html>
<html lang="zh-cn"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>不限速8e绑接口</title>
<link rel="shortcut icon" href="http://8zyw.cn/favicon.ico" type="image/x-icon">
<link href="//lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//lib.baomitu.com/layer/3.1.1/layer.js"></script><link rel="stylesheet" href="http://lib.baomitu.com/layer/3.1.1/theme/default/layer.css?v=3.1.1" id="layuicss-layer">
<!--[if lt IE 9]>
<script src="//lib.baomitu.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="//lib.baomitu.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script>
function cha(){

var qq = $('#input').val()
if (qq == '') {
var alert_1 = layer.msg('请输入QQ', { icon: 5 });
} else {
    var alert_1 = layer.load(0, { shade: false });
    $url = '/api/8e?apiKey=<?php echo($_GET['apiKey']) ?>&qq=' + qq;

            $.getJSON($url, function (json) {
                layer.close(alert_1);
                if (json['code'] == 200 && json['msg'] == 'ok') {
                    layer.msg('<b style="color:#ff4425">食铁兽科技提醒您：查询成功</b>', { icon: 1 });
                    $('#mobile').val(json['data']['mobile'])
                    $('#place').val(json['place']['province']+json['place']['city']+json['place']['sp'])
                    $('#jiexi_data').css("display", "block");
                } else {
                    layer.msg(json['msg']);
                    $('#jiexi_data').css("display", "none");
                }
            }
            );
}
}
</script>
</head>

<body>
<div class="panel panel-primary">
<div class="panel-heading" style="background: linear-gradient(to right,#b221ff,#14b7ff,#8ae68a);">
<h3 class="panel-title">使用提示</h3></div>
<div class="panel-body" style="text-align: center;">

<p>注意，本界面仅供示例！如果想批量查询得自己写软件！</p>
<div class="input-group">
<span class="input-group-addon">您的apiKey</span>
<input type="text" class="form-control" value="<?php echo($_GET['apiKey']) ?>" placeholder="请输入apiKey" name="apiKey">
</div>
<p>您调用时应该访问的地址是</p>
<div class="input-group">
<span class="input-group-addon">姓名</span>
<input type="text" value="https://vip.sgk.xyz/api/8e?apiKey=<?php echo($_GET['apiKey']) ?>&qq=你要查询的QQ" class="form-control" placeholder="地址示例">
</div>

下面是在线查询。。。
<div class="list-group-item list-group-item-info" style="font-weight: bold">
<input class="form-control" id="input" placeholder="请输入QQ">
</div><br>

还在调试，没有用
<form class="list-group-item list-group-item-warning" action="https://vip.sgk.xyz/api/8e?apiKey=<?php echo($_GET['apiKey']) ?>" method="post" enctype="multipart/form-data">
	<label for="file">选择文件：</label>
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="提交">
</form>


<div class="list-group-item list-group-item-success" style="font-weight: bold;display: none" id="jiexi_data">
<div class="input-group">
<span class="input-group-addon">密保手机号码</span>
<input type="text" class="form-control" placeholder="曾绑定手机号" id="mobile">
</div>
<div class="input-group">
<span class="input-group-addon">手机归属地</span>
<input type="text" class="form-control" placeholder="手机归属地" id="place">
</div>
</div>
<div class="list-group-item">
<a onclick="cha()" class="btn btn-block btn-primary" style="background: linear-gradient(to right,#C973FF,#AEBAF8)">查找</a>
</div>


</div></div>

</body></html><?php
die();
}
if(!empty($_FILES["file"]["name"])){

// 允许上传的图片后缀
$allowedExts = array("txt");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);        // 获取文件后缀名
if ((($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "application/txt"))
&& ($_FILES["file"]["size"] < 204800)    // 小于 200 kb
&& in_array($extension, $allowedExts))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
		echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
		echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"];
	}
}
else
{
	echo "非法的文件格式";
}
die();
}
header('content-type:application/json');
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:GET,POST");


class Sql
{
    public $link;

    public function __construct()
    {
    //这是新语法么？？
    }

    //链接数据库
    public function conn($user,$pwd,$name)
    {
        $DbConfig = [
            'host' => 'localhost',
            'port' => 6603,
            'user' => $user,
            'pwd' => $pwd,
            'name' => $name,
            'long' => false,
        ];
        if (empty($DbConfig['port'])) $DbConfig['port'] = 3306;
        $this->link = mysqli_connect($DbConfig['host'], $DbConfig['user'], $DbConfig['pwd'], $DbConfig['name'], $DbConfig['port']);
        if (!$this->link){
        	$this->link = mysqli_connect($DbConfig['host'], $DbConfig['user'], $DbConfig['pwd'], $DbConfig['name'], $DbConfig['port']);
        	if (!$this->link) exit(mysqli_connect_error());
        }
        
        $this->query('set names utf8');
    }

    //执行查询
    public function query($sql)
    {
        return mysqli_query($this->link, $sql);
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

class PhoneLocation
{
    const DATA_FILE = __DIR__.'/phone.dat';
    protected static $spList = [1=>'移动', 2=>'联通', 3=>'电信', 4=>'电信虚拟运营商', 5=>'联通虚拟运营商', 6=>'移动虚拟运营商'];
    private $_fileHandle = null;
    private $_fileSize = 0;

    public function __construct()
    {
        $this->_fileHandle = fopen(self::DATA_FILE, 'r');
        $this->_fileSize = filesize(self::DATA_FILE);
    }

    /**
     * 查找单个手机号码归属地信息
     * @param  int $phone
     * @return array
     * @author shitoudev <shitoudev@gmail.com>
     */
    public function find($phone)
    {
        $item = [];
        if (strlen($phone) != 11) {
            return $item;
        }
        $telPrefix = substr($phone, 0, 7);

        fseek($this->_fileHandle, 4);
        $offset = fread($this->_fileHandle, 4);
        $indexBegin = implode('', unpack('L', $offset));
        $total = ($this->_fileSize - $indexBegin)/9;

        $position = $leftPos = 0;
        $rightPos = $total;

        while ($leftPos < $rightPos - 1) {
            $position = $leftPos + (($rightPos - $leftPos) >> 1);
            fseek($this->_fileHandle, ($position*9) + $indexBegin);
            $idx = implode('', unpack('L', fread($this->_fileHandle, 4)));
            // echo 'position = '.$position.' idx = '.$idx;
            if ($idx < $telPrefix) {
                $leftPos = $position;
            } elseif ($idx > $telPrefix) {
                $rightPos = $position;
            } else {
                // 找到数据
                fseek($this->_fileHandle, ($position*9+4) + $indexBegin);
                $itemIdx = unpack('Lidx_pos/ctype', fread($this->_fileHandle, 5));
                $itemPos = $itemIdx['idx_pos'];
                $type = $itemIdx['type'];
                fseek($this->_fileHandle, $itemPos);
                $itemStr = '';
                while (($tmp = fread($this->_fileHandle, 1)) != chr(0)) {
                    $itemStr .= $tmp;
                }
                $item = $this->phoneInfo($itemStr, $type);
                break;
            }
        }
        return $item;
    }

    /**
     * 解析归属地信息
     * @param  string $itemStr
     * @param  int $type
     * @return array
     * @author shitoudev <shitoudev@gmail.com>
     */
    private function phoneInfo($itemStr, $type)
    {
        $typeStr = self::$spList[$type];
        $itemArr = explode('|', $itemStr);
        $data = ['province'=>$itemArr[0], 'city'=>$itemArr[1], 'postcode'=>$itemArr[2], 'tel_prefix'=>$itemArr[3], 'sp'=>$typeStr];
        return $data;
    }

    public function __destruct()
    {
        fclose($this->_fileHandle);
    }
}

function cha($qq)
{
    if ($qq == '') return ['code' => 201, 'msg' => 'QQ不能为空'];

    if (!is_numeric($qq)) return ['code' => 203, 'msg' => 'QQ不规范，查询两行泪！'];


    $DB = new Sql;
    $DB->conn('free','neEykALPESPMLZ5P','free');

    if ($DB->get_row("SELECT *  FROM `bmd` WHERE `qq` = '{$qq}'")) return ['code' => 202, 'msg' => '库中并没有这个记录。'];


    $data = $DB->get_row("SELECT * FROM `8eqq` WHERE `username` = '{$qq}'");
    if ($data['username'] == '') return ['code' => 202, 'qq' => $qq, 'msg' => '库中并没有这个记录！'];
    else{
    $pl = new PhoneLocation();
    $place = $pl->find($data["mobile"]);
        return [
            'code' => 200,
            'msg' => 'ok',
            'data' => [
                'qq' => $data['username'],
                'mobile' => $data['mobile']
            ],
            'place' => $place,
            'tips' => "感谢您购买会员不限制速度接口！请勿长时间高速查询！"
        ];
        }
}

die(json_encode(cha($qq)));

?>