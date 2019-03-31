<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [

    //登陆操作
    'login' => 'index/login/login',
    'register' => 'index/login/reg',
    'outlogin' => 'index/login/outlogin',

    //赛场路由
    '/ranking' => 'index/index/ranking',
    '/score' => 'index/index/score',
    '/getstatus' => 'index/index/getstatus',

    //api路由
    'api/getanswer' => 'index/index/getAnswer',
    'api/flag' => 'index/Api/flag',
    'api/getstarttime' => 'index/Api/getstarttime',
    'api/add_timu_class' => 'index/Api/add_timu_class',
    'api/del_timu_class' => 'index/Api/del_timu_class',
    'api/start_timu_class' => 'index/Api/start_timu_class',
    'api/del_timu_class_log' => 'index/Api/del_timu_class_log',
    'api/del_tanswer' => 'index/Api/del_tanswer',
    'api/add_answer' => 'index/Api/add_answer',
    'api/del_tanswer' => 'index/Api/del_tanswer',
    'api/add_answer' => 'index/Api/add_answer',

];
