<?php
namespace app\index\controller;
/**
 * 系统全局请求处理控制器
 *
 * Class Api
 * @package app\index\controller
 */
use think\Cache;
use think\Request;
use think\Session;
use app\index\model\config;
use app\index\model;
class Api extends \think\Controller{
    protected $beforeActionList = ['start'];//访问该控制器前执行的方法

    /**
     * 进入该模块时会执行该方法
     */
    private $configMod;
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $configMod = new config();
        $configMod->startConfig();//初始化系统配置
        $this->configMod = $configMod;
    }

    protected function start(){
        if(session('login') != 1){//没登录302到登陆页面
            return $this->redirect(url('index/login/login'));
        }
    }
    /**
     * Flag提交处理函数
     */
    public function flag(){
        $aid = intval(Request::instance()->post('aid'));
        $flag = Request::instance()->post('flag');
        //验证时间
        $data = $this->configMod->getTimeInfo(true);
        if(config('open_time') == 1){
            if($data['left_time'] <= 0){
                return json(['code' => 4]);//超时,不能答题
            }
        }
        //基础验证
        if(strlen($flag) <=0 ){
            return json(['code' => 0, 'msg'=>'请填写答案']);//空内容视为错误答案
        }

        //验证题目
        $answerMod = new model\answer();
        if(!$answerMod->yn_Answer($aid)){
            return json(['code' => 0, 'msg'=>'题目不存在或不可被回答']);//题目不在/不让做
        }

        //验证提交时间
        if(!session('time')){//判断有没有时间阈值
            Session::set('time',time());
        }else{
            $time = time();
            if(($time - session('time')) > config('config.interval')){
                Session::set('time',time());//大于interval秒,可以提交重新设置时间限制
            }else{
                return json(['code' => 0, 'msg'=>config('config.interval').'s内只能提交一次']);
            }
        }

        $logMod = new model\log();
        $userMod = new model\user();
        $scoreMod = new model\score();
        //验证是否已经回答过
        if($scoreMod->yn_answer(Session::get('userID'),$aid)){
            return json(['code' => 0, 'msg'=>'你已回答过了,不可重复回答']);
        }

        //验证答案
        if($answerMod->answer($aid,$flag)){
            //回答正确
            $logMod->insertData(
                Session::get('userID'),//用户名
                $aid,//题目ID
                $flag,//答案
                date('H:i:s',time()),
                1//是否答对
            );//添加到提交记录中

            $scoreMod->insertData(
                Session::get('userID'),
                $aid,//题目ID
                date('H:i:s',time())
            );//添加积分表
            return json(['code'=>200, 'msg'=>'恭喜你回答正确']);//答对了
        }else{
            $logMod->insertData(
                $userMod->getUserID(Session::get('user')),
                $aid,
                $flag,
                date('H:i:s',time())
            );//添加到提交记录中
            return json(['code'=>0, 'msg'=>'很遗憾,离答案不远了']);//答错了
        }

    }

    /**
     * 获得时间信息
     *
     * @return mixed
     */
    public function getstarttime(){
        $configMod = new model\config();
        return json($configMod->getTimeInfo(true));
    }
}