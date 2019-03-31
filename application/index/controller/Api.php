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
    protected function start(){
        $configMod = new config();
        $configMod->startConfig();//初始化系统配置
        unset($configMod);
    }
    /**
     * Flag提交处理函数
     */
    public function flag(){
        if(session('login') != 1){//没登录302到登陆页面
            return $this->redirect('/login');
        }

        $aid = intval(Request::instance()->post('aid'));
        $flag = Request::instance()->post('flag');
        //基础验证
        if($flag === ''){
            return json(['code' => 1]);//空内容视为错误答案
        }

        $answerMod = new model\answer();
        //验证题目
        if(!$answerMod->yn_Answer($aid)){
            return json(['code' => -2]);//题目不在/不让做
        }

        $configMod = new model\config();
        $data = $configMod->getTimeInfo(true);
        if(config('open_time') == 1){
            if($data['left_time'] <= 0){
                return json(['code' => 4]);//超时,不能答题
            }
        }

        //验证提交时间
        if(!session('time')){//判断有没有时间阈值
            Session::set('time',time());
        }else{
            $time = time();
            if(($time - session('time')) > 10){
                Session::set('time',time());//大于十秒,可以提交重新设置时间限制
            }else{
                return json(['code' => -1]);//10s只能提交一次
            }
        }

        $logMod = new model\log();
        $userMod = new model\user();
        $scoreMod = new model\score();
        //验证是否已经回答过
        if($scoreMod->yn_answer(
                $userMod->getUserID(Session::get('user')),
                $aid) == true){
            return json(['code' => '3']);
        }

        //验证答案
        if($answerMod->answer($aid,$flag) == true){
            $logMod->insertData(
                $userMod->getUserID(Session::get('user')),//用户名
                $aid,//题目ID
                $flag,//答案
                date('H:i:s',time()),
                1//是否答对
            );//添加到提交记录中

            $scoreMod->insertData(
                $userMod->getUserID(Session::get('user')),//用户
                $aid,//题目ID
                date('H:i:s',time())
            );//添加积分表
            return json(['code' => 0]);//答对了
        }else{
            $logMod->insertData(
                $userMod->getUserID(Session::get('user')),
                $aid,
                $flag,
                date('H:i:s',time())
            );//添加到提交记录中
            return json(['code' => 1]);//答错了
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

//后台操作API
    /**
     * 添加题目分类
     */
    public function add_timu_class(){
        if(session('isadmin') != 1){
            return $this->redirect('/login');
        }
        $name = Request::instance()->post('timuname');
        $clsMod = new model\AnswerCls();
        $clsMod->insert(['name' => $name]);
        $this->success("添加成功", '/admin.php/addclass');
    }

    /**
     * 删除题目分类
     */
    public function del_timu_class(){
        if(session('isadmin') != 1){
            return $this->redirect('/login');
        }
        $id = Request::instance()->get('id');
        $clsMod = new model\AnswerCls();
        $aMod = new model\answer();
        $clsMod->where('id',$id)->delete();
        $aMod->where('cid',$id)->delete();
        $this->success("删除成功", '/admin.php/addclass');
    }

    /**
     * 设置题目调度,设置当前要作答的题目类型ID
     */
    public function start_timu_class(){
        if(session('isadmin') != 1){
            return $this->redirect('/login');
        }
        $id = Request::instance()->get('id');
        $configMod = new model\config();
        $configMod->where('keys','timu')->cache('config')->update(['value'=>$id]);
        Cache::rm('allAnswer');
        $this->success("题目调度完成", '/admin.php/addclass');
    }

    /**
     * 删除题目作答记录
     */
    public function del_timu_class_log(){
        if(session('isadmin') != 1){
            return $this->redirect('/login');
        }
        $id = Request::instance()->get('id');
        $logMod = new model\log();
        $scoreMod = new model\score();
        $logMod->where('cid', $id)->delete();
        $scoreMod->where('cid', $id)->delete();
        $this->success("题目答题记录已删除", '/admin.php/addclass');
    }

    /**
     * 删除题目
     */
    public function del_tanswer(){
        if(session('isadmin') != 1){
            return $this->redirect('/login');
        }
        $id = Request::instance()->get('id');
        $cid = Request::instance()->get('cid');
        $aMod = new model\answer();
        $aMod->where('cid', $cid)->where('id',$id)->delete();
        $this->success("题目已删除", '/admin.php/addclass');
    }

    /**
     * 添加题目与编辑题目
     */
    public function add_answer(){
        if(session('isadmin') != 1){
            return $this->redirect('/login');
        }

        $_POST['score'] = intval(Request::instance()->post('score'));
        //优先验证编辑模式
        $cid = Request::instance()->post('cid');
        $aModel = new model\answer($_POST);
        if(Request::instance()->post('edit') == 1){
            $id  = Request::instance()->post('id');
            if(!empty($id)){
                $id = intval(Request::instance()->post('id'));
                $ret = $aModel->where('id', $id)->update([
                    'name'=>Request::instance()->post('name'),
                    'content'=>Request::instance()->post('content'),
                    'flag'=>Request::instance()->post('flag'),
                    'score'=>Request::instance()->post('score'),
                ]);
                if($ret == 1){
                    Cache::rm('answer_'.$id);
                    $this->success('更新成功','/admin.php/add?cid=' . $cid);
                }
                $this->error('更新失败');
            }
            $this->error('不规范的操作行为');
        }

        if($aModel->allowField(true)->save() == 1){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }
}