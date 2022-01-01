<?php
if(empty($_GET["auth"])&&empty($_GET["content"])&&!isset($_GET["kefu"])) die("<h1>请把此链接复制到软件授权框中</h1>");

if($_GET["auth"]){
class Aes {
 
    private $key = null;
 
    /**
     *
     * @param $key 		密钥
     * @return String
     */
    public function __construct() {
        // 需要小伙伴在配置文件app.php中定义aeskey
        //$this->key = 'hm8rmtf4e2dhj6c270mbpac9dcbar3yj';
    }
 
    /**
     * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
     * @return HexString
     */
    public function encrypt($input = '') {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, "70mbpac9dcbar3yj", $iv);
 
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
 
        return $data;
 
    }
    /**
     * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
     * @return String
     */
    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
 
    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public function decrypt($sStr) {
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,"hm8rmtf4e2dhj6c2",base64_decode($sStr), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
 
        return $decrypted;
    }
 
}

$aes = new Aes();
$auth = $aes->decrypt($_GET["auth"]);
//var_dump($auth);
if(strpos($auth,"ywjfvxohtz") == 0){
$re = substr($auth,10);
//var_dump($re);
die(openssl_encrypt($re,"AES-128-ECB","70mbpac9dcbar3yj"));
}else die("<h1>请把此链接复制到软件授权框中。请不要尝试破解软件。。。</h1>");


}elseif($_GET["content"]){
if(strlen($_GET["content"])>10){
$file = __DIR__."/feedback/".$_GET["apiKey"].".txt";
if(file_exists($file)) die("您已经提交过一次反馈了！");


file_put_contents($file,$_GET["content"]);
die("我们已经收到您的宝贵意见，感谢您的反馈，每人只能反馈一次！");
}else{
die("反馈内容必须大于十字！");
}
}elseif($_GET["kefu"]){
die("〖1968785729〗<h1>会员专属客服。。。</h1>");
}else die("<h1>请把此链接复制到软件授权框中</h1>");
?>