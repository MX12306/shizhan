<?php
namespace app\index\controller;
/**
 * 系统登陆页面控制器
 *
 * Class Login
 * @package app\index\controller
 */
use app\index\model;
use think\Request;
use think\Session;
class Login extends \think\Controller{
    /**
     * 初始化配置信息
     * Login constructor.
     * @param Request|null $request
     */
    private $http;
    protected $beforeActionList = [
        'start' => [
            'except' => 'outlogin'
        ]
    ];//访问该控制器前执行的方法

    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->http = Request::instance();
        $configMod = new model\config();
        $configMod->startConfig();
    }
    protected function start(){
        if(session('login') == 1){//已经登录就302到首页
            $this->redirect('/');
        }
    }

    /**
     * 登陆实现
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login(){
        if($this->http->isPost()){
            $data = $this->http->post();
            $data['user'] = string_htmlspecialchars($data['user']);
            //验证token
            if(empty($data['token'])){
                $this->error('令牌错误');
            }elseif (!form_token_verification($data['token'],'login')){
                $this->error('令牌验证失败');
            }
            //验证账户
            if(empty($data['user'])||empty($data['password'])){
                $this->error('用户/密码不能为空');
            }
            $userMod = new model\user();
            $ret = $userMod->field('id,user,password,isadmin')->where('user', $data['user'])->find();
            if(empty($ret)){
                $this->error('用户名不存在');
            }
            //验证密码
            if($ret->getData('password') === $data['password']){
                Session::set('login', '1');
                Session::set('user', $ret->getData('user'));
                Session::set('userID', $ret->getData('id'));
                Session::set('isadmin', $ret->getData('isadmin'));
                $userMod->update(['login_ip' => request()->ip(), 'login_time' => time()],['user'=>$ret->getData('user')]);//更新记录
                $this->redirect('/');//登陆成功,302到赛题页面
            }
            $this->error('用户/密码错误');
        }
        //前端渲染
        $token = form_token_create('login');
        $this->assign('_token', $token);
        $this->assign('title', remove_xss(config('title'))); //输出过滤 输入过滤
        $this->assign('tips', remove_xss(config('tips'))); //输出过滤 输入过滤
        return $this->fetch('login');
    }

    /**
     * 注册实现
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function reg(){
        if($this->http->isPost()){
            $data = $this->http->post();
            //验证token
            if(empty($data['token'])){
                $this->error('令牌错误');
            }elseif (!form_token_verification($data['token'],'reg')){
                $this->error('令牌验证失败');
            }
            if(empty($data['user'])||empty($data['password'])){
                $this->error('用户/密码不能为空');
            }
            if(intval(config('reg_switch')) !== 1){
                $this->error('系统当前不允许任何用户注册');
            }
            $userMod = new model\user();
            if($userMod->ifUser($data['user']) == false){
                $this->error('用户已存在');
            }
            if($userMod->addUser(string_htmlspecialchars($data['user']),$data['password']) == true){
                $this->success('注册成功','/login');
            }
            $this->error('注册失败,请重试');
        }
        $token = form_token_create('reg');
        $this->assign('_token', $token);
        $this->assign('title', remove_xss(config('title'))); //输出过滤 输入过滤
        $this->assign('tips', remove_xss(config('tips'))); //输出过滤 输入过滤
        return $this->fetch('reg');
    }

    /**
     * 退出登录
     */
    public function outlogin(){
        session(null);
        $this->success('已退出登录',url('index/login/login'));//退出后跳转到登陆页面
    }
}