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
    '/' => 'index/index/index',
    //登陆操作
    'login' => 'index/login/login',
    'register' => 'index/login/reg',
    'outlogin' => 'index/login/outlogin',

    //赛场路由
    'ranking' => 'index/index/ranking',
    'score' => 'index/index/score',
    'getstatus' => 'index/index/getstatus',

    //api路由
    'api/getanswer' => 'index/index/getAnswer',
    'api/flag' => 'index/Api/flag',
    'api/getstarttime' => 'index/Api/getstarttime',

    //admin路由
    'admin' => 'index/admin/index',
    'admin/save' => 'index/admin/save',
    'admin/add' => 'index/admin/add',
    'admin/addclass' => 'index/admin/addclass',
    'admin/user' => 'index/admin/user'
];
