<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function IdGetName($id){
    $userMod = new app\index\model\user();
    return $userMod->getIDUser($id);
}

function countScore($uid){
    $scoreMod = new app\index\model\score();
    return $scoreMod->countScore($uid);
}

/**
 * 后台设置页面时间
 * @return array
 */
function showTime(){
    $time = time();

    $start = $time + 300; //提前5分钟
    $end = $start + 6000; //100分钟结束

    return[
        'start' => date('Y-m-d H:i:s',$start),
        'end'   => date('Y-m-d H:i:s',$end)
    ];
}

function showSetTime(){
    return [];
}


/**
 * 过滤XSS标签
 * @param $html
 * @return mixed|string
 */
function remove_xss($html)
{
    $html = htmlspecialchars_decode($html);
    preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

    $searchs[]  = '<';
    $replaces[] = '&lt;';
    $searchs[]  = '>';
    $replaces[] = '&gt;';

    if ($ms[1]) {
        $allowtags = config('config.allowtags');
        $ms[1]     = array_unique($ms[1]);
        foreach ($ms[1] as $value) {
            $searchs[] = "&lt;" . $value . "&gt;";

            $value = str_replace('&amp;', '_uch_tmp_str_', $value);
            $value = string_htmlspecialchars($value);
            $value = str_replace('_uch_tmp_str_', '&amp;', $value);

            $value    = str_replace(array('\\', '/*'), array('.', '/.'), $value);
            $skipkeys = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate',
                'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange',
                'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick',
                'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate',
                'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
                'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel',
                'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart',
                'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop',
                'onsubmit', 'onunload', 'javascript', 'script', 'eval', 'behaviour', 'expression');
            $skipstr = implode('|', $skipkeys);
            $value   = preg_replace(array("/($skipstr)/i"), '.', $value);
            if (!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
                $value = '';
            }
            $replaces[] = empty($value) ? '' : "<" . str_replace('&quot;', '"', $value) . ">";
        }
    }
    $html = str_replace($searchs, $replaces, $html);
    return $html;
}

/**
 * 特殊字符进行HTML实体编码
 * @param $string
 * @param null $flags
 * @return array|mixed|string
 */
function string_htmlspecialchars($string, $flags = null)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = string_htmlspecialchars($val, $flags);
        }
    } else {
        if ($flags === null) {
            $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
            if (strpos($string, '&amp;#') !== false) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        } else {
            if (PHP_VERSION < '5.4.0') {
                $string = htmlspecialchars($string, $flags);
            } else {
                if (!defined('CHARSET') || (strtolower(CHARSET) == 'utf-8')) {
                    $charset = 'UTF-8';
                } else {
                    $charset = 'ISO-8859-1';
                }
                $string = htmlspecialchars($string, $flags, $charset);
            }
        }
    }

    return $string;
}

/**
 * 创建token
 * @return string
 */
function create_token(){
    return sha1(time().md5('www.ld80.cn')).create_rand_string();
}

/**
 * 创建随机字符串
 * @param int $length
 * @return string
 */
function create_rand_string($length = 4) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * 生成表单令牌
 * @param $domain
 * @return string
 */
function form_token_create($domain){
    $token = create_token();
    \think\Session::set($domain, $token, 'form');
    return $token;
}

/**
 * 表单令牌验证
 * @param $token
 * @param $domain
 * @param bool $lasting #token持久
 * @return bool
 */
function form_token_verification($token, $domain, $lasting = false){
    if(\think\Session::has($domain,'form')){
        if($lasting){
            $stoken = \think\Session::get($domain, 'form');
        }else{
            $stoken = \think\Session::pull($domain, 'form');
        }
        if($stoken === $token){
            return true;
        }
    }
    return false;
}