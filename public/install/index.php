<?php
/**
 * 安装向导
 */
header('Content-type:text/html;charset=utf-8');
// 检测是否安装过
if (file_exists('./install.lock')) {
    echo '你已经安装过该系统，请删除./install/install.lock文件';
    die;
}
// 同意协议页面
if (@!isset($_GET['c']) || @$_GET['c'] == 'agreement') {
    require './agreement.html';
}
// 检测环境页面
if (@$_GET['c'] == 'test') {
    require './test.html';
}
// 创建数据库页面
if (@$_GET['c'] == 'create') {
    require './create.html';
}
// 安装成功页面
if (@$_GET['c'] == 'success') {
    
    // 判断是否为post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $data = $_POST;
        if (!preg_match("/^[a-zA-Z]{1}([0-9a-zA-Z]|[._]){4,19}$/", $data['admin_user'])) {
            die("<script>alert('后台管理用户名不符合规范：至少包含4个字符，需以字母开头');history.go(-1)</script>");
        }
       
        if (!preg_match("/^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,22}$/", $data['admin_pass'])) {
            die("<script>alert('登录密码至少包含6个字符。可使用字母，数字和符号。');history.go(-1)</script>");
        }
        if ($data['admin_pass'] != $data['admin_pass2']) {
            die("<script>alert('两次输入的密码不一致');history.go(-1)</script>");
        }
        $_SESSION['adminusername'] = $data['admin_user'];
        // 生成管理员
        $password = '';
        $username = $data['admin_user'];
        $password = $data['admin_pass'];
        if(class_exists('mysqli')){
            $link = @new mysqli($data['db_ip'].':'.$data['db_port'], $data['db_username'], $data['db_password']);
            // 获取错误信息
            $error = $link->connect_error;
            if (!is_null($error)) {
                $error = addslashes($error);
                die("<script>alert('数据库链接失败:$error');history.go(-1)</script>");
            }
            if (function_exists('curl_init')){
                $curl = curl_init();
                //统计接口地址
                //请勿搞破坏谢谢~
                curl_setopt($curl, CURLOPT_URL, "http://api.ld80.cn/api/index/sendcountinfo/appkey/33483377c35e8682817c66b139e6b39a/type/add/domain/{$_SERVER['HTTP_HOST']}.html");
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($curl);
                curl_close($curl);
                var_dump(json_decode($data));
            }else{
                die("<script>alert('缺少curl扩展!');history.go(-1)</script>");
            }
            // 设置字符集
            $link->query("SET NAMES 'utf8'");
            $link->server_info > 5.0 or die("<script>alert('请将您的mysql升级到5.0以上');history.go(-1)</script>");
            // 创建数据库并选中
            if (!$link->select_db($data['db_dbname'])) {
                $create_sql = 'CREATE DATABASE IF NOT EXISTS ' . $data['db_dbname'] . ' DEFAULT CHARACTER SET utf8;';
                $link->query($create_sql) or die('创建数据库失败');
                $link->select_db($data['db_dbname']);
            }
            // 导入sql数据并创建表
            $shujuku_str = file_get_contents('./install.sql');
            $sql_array = preg_split("/;[\r\n]+/", str_replace('sx_', $data['db_prefix'], $shujuku_str));
            foreach ($sql_array as $k => $v) {
                if (!empty($v)) {
                    $link->query($v);
                }
            }
            $table_admin = $data['db_prefix'] . "user";
            $link->query("UPDATE $table_admin SET `user` = '{$username}', password = '{$password}' WHERE id = 1");
            $link->close();
        }else{
            die("<script>alert('缺少mysqli扩展!');history.go(-1)</script>");
        }
        $db_str = <<<php
<?php

return [
    'type'            => 'mysql',
    'hostname'        => '{$data['db_ip']}',
    'database'        => '{$data['db_dbname']}',
    'username'        => '{$data['db_username']}',
    'password'        => '{$data['db_password']}',
    'hostport'        => '{$data['db_port']}',
    'dsn'             => '',
    'params'          => [],
    'charset'         => 'utf8',
    'prefix'          => '{$data['db_prefix']}',
    'debug'           => false,
    'deploy'          => 0,
    'rw_separate'     => false,
    'master_num'      => 1,
    'slave_no'        => '',
    'fields_strict'   => true,
    'resultset_type'  => 'array',
    'auto_timestamp'  => false,
    'datetime_format' => 'Y-m-d H:i:s',
    'sql_explain'     => false,
    'builder'         => '',
    'query'           => '\\think\\db\\Query',
];
php;
        // 创建数据库链接配置文件
        $fp = fopen('../../application/database.php', "w");
        fputs($fp, $db_str);
        fclose($fp);

        require './success.html';
		@touch('./install.lock');
    }
}
