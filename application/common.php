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