<?php
namespace app\index\controller;
use think\Request;
use app\index\model;
use think\Session;

/**
 * 赛题页面控制器
 *
 * Class Index
 * @package app\index\controller
 */
class Index extends \think\Controller{
    protected $beforeActionList = ['start'];//访问该控制器前执行的方法

    /**
     * 进入时会执行该方法
     */
    protected function start(){
        if(session('login') != 1){//没登录302到登陆页面
            return $this->redirect('/login');
        }
        $configMod = new model\config();
        $configMod->startConfig();//初始化系统配置
        $this->assign('title',config('title'));
        unset($configMod);
    }
//////////////////////////////////////////////////////////////////////////
    /**
     * 赛题首页
     *
     * @return mixed|void
     */
    public function index(){
        $id = intval(Request::instance()->get('id'));
        $answerMod = new model\answer();
        $configMod = new model\config();
        if(empty($id)){
            //没ID时使用公告作为首页
            $this->assign('display', 0);
            $this->assign('_title', '赛场公告');
            $this->assign('content',$configMod->getAnnouncement());//获取config表的公告信息,作为默认页面
        }else{
            //基本处理
            if($answerMod->yn_Answer($id) == false){//错误的题目ID 导致错误
                return $this->error('错误的ID,该题不存在/不可回答!', '/');
            }
            //时间处理
            $timeData = $configMod->getTimeInfo();
            if(config('open_time') == 1){
                if($timeData['left_time'] <= 0){
                    return $this->error('比赛时间尚未开始或比赛已结束', '/');
                }
            }
            //赛题处理
            $answerInfo = $answerMod->getAnswer($id);
            $scoreMod = new model\score();
            $a = $scoreMod->yn_answer(Session::get('userID'),$id);//检查题目是否已回答过
            if($a == true){
                $this->assign('yn', 0);//已答题
            }else{
                $this->assign('yn', 1);//没回答
            }
            //渲染处理
            $this->assign('display', 1);//显示提交答案区域
            $this->assign('id',$id);

            $this->assign('_title', $answerInfo['name'].'('.$answerInfo['score'].'分)');//题目名称与分值
            $this->assign('content',$answerInfo['content']);//题目内容
        }

        $clsMod = new model\AnswerCls();//题目分类表
        $this->assign('term_name',$clsMod->idGetName(config('timu'))['name']);//顶部标题
        $userMod = new model\user();
        $info = $userMod->getUserInfo(session('userID'));
        if($info !== null){
            $this->assign('info', $info);
        }
        $list = $answerMod->getAll();
        $this->assign('list',$list);//左侧题目列表区域
        return $this->fetch('index/index');//渲染赛题页面模板
    }

    /**
     * 成绩页面
     *
     * @return mixed
     */
    public function score(){
        $scoreMod = new model\score();
        $info = $scoreMod->getMyRanking();
        $this->assign('rownum',$info['rownum']);//排名
        $this->assign('score',$info['score']);//分数
        $this->assign('logList',$scoreMod->getLog());//答题情况

        return $this->fetch('index:score');
    }

    /**
     * 排行榜页面
     *
     * @return mixed
     */
    public function ranking(){
        $scoreMod = new model\score();
        $this->assign('rankingLog',$scoreMod->showRanking(true));
        return $this->fetch('index:ranking');
    }
}
