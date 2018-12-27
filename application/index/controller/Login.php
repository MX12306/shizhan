<?php
namespace app\index\controller;
/**
 * 系统登陆页面控制器
 *
 * Class Login
 * @package app\index\controller
 */
use think\Session;
use app\index\model;
class Login extends \think\Controller{
    /**
     * 登录页面
     *
     * @return mixed|void
     */
    public function login(){
        if(session('login') == 1){//已经登录就302到首页
            $this->redirect('/');
        }
        $configMod = new model\config();
        $configMod->startConfig();
        $this->assign('title',config('title'));
        $this->assign('tips',config('tips'));
        return $this->fetch('login:login');//渲染登录页面模板
    }

    public function reg(){
        $configMod = new model\config();
        $configMod->startConfig();
        $this->assign('title',config('title'));
        $this->assign('tips',config('tips'));
        return $this->fetch('login:reg');
    }
    /**
     * 退出登录
     */
    public function outlogin(){
        session_unset();
        return $this->success('已退出登录','/login');//退出后跳转到登陆页面
    }
}