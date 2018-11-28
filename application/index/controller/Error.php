<?php
namespace app\index\controller;

class Error extends \think\Controller{
    public function index()
    {
        return $this->error('无效的控制器');
    }
}