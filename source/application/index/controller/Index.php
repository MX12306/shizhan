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
            return $this->redirect(url('index/login/login'));
        }
        $configMod = new model\config();
        $configMod->startConfig();//初始化系统配置
        $this->assign('title',string_htmlspecialchars(config('title')));
        unset($configMod);
    }
//////////////////////////////////////////////////////////////////////////
    /**
     * 赛题首页
     *
     * @return mixed|void
     */
    public function index(){
        $answerMod = new model\answer();
        $clsMod = new model\AnswerCls();//题目分类表
        $userMod = new model\user();
        $this->assign('display', 0);
        //$this->assign('title', string_htmlspecialchars(config('title')));
        $this->assign('_title', '赛场公告');
        $this->assign('content', remove_xss(config('announcement')));//获取config表的公告信息,作为默认页面

        $this->assign('term_name',$clsMod->idGetName(config('timu')));//顶部标题

        //获取靶机信息
        $info = $userMod->getUserInfo(session('userID'));
        if($info !== null){
            $this->assign('info', remove_xss($info));
        }
        $list = $answerMod->getAll();
        $this->assign('list',$list);//左侧题目列表区域
        return $this->fetch('index');//渲染赛题页面模板
    }

    public function getAnswer(){
        $id = intval(Request::instance()->get('id'));
        $id = intval($id);
        $configMod = new model\config();
        if(empty($id)){
            return json([
                'code'=> 0,
                'msg'=> '题目ID不能为0或空'
            ]);
        }
        //实例化相关模型
        $answerMod = new model\answer();
        $scoreMod = new model\score();
        $timeData = $configMod->getTimeInfo();
        //验证时间
        if(config('open_time') == 1){
            if($timeData['left_time'] <= 0){
                return json([
                    'code'=> 0,
                    'msg'=> '比赛时间未到或已结束'
                ]);
            }
        }
        //验证题目是否符合条件
        //提醒：题目有变动时记得刷新缓存或者删除
        $data = $answerMod->where('visible',1)->where('cid', config('timu'))->where('id', $id)->cache('answer_'. $id)->find();
        if(empty($data)){
            return json([
                'code'=> 0,
                'msg'=> '题目不存在'
            ]);
        }
        //数据有了,验证以下是否可以回答
        if($scoreMod->where('cid', config('timu'))->where('uid',Session::get('userID'))->where('aid',$id)->count()){
            $huida = 0;
        }else{
            $huida = 1;
        }
        $data = $data->getData();
        //返回数据
        return json([
            'code'=> 200,
            'huida'=> $huida,
            'id'=> $data['id'],
            'name'=> string_htmlspecialchars($data['name']),
            'content'=> remove_xss($data['content']),
            'score'=> $data['score']
        ]);
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

        return $this->fetch('score');
    }

    /**
     * 排行榜页面
     *
     * @return mixed
     */
    public function ranking(){
        if(session('isadmin') !== 1 && config('display_ranking') != 1){
            return '排行榜页面暂时未对普通用户开放';
        }
        return $this->fetch('ranking');
    }

    /**
     *获得最新状态
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getstatus(){
        if(session('isadmin') !== 1 && config('display_ranking') != 1){
            return json([
                'code'=> 0,
                'msg'=> '排行榜页面暂时未对普通用户开放',
            ]);
        }
        $configMod = new model\config();
        $timeData = $configMod->getTimeInfo();
        //验证时间
        if(config('open_time') == 1){
            if($timeData['left_time'] <= 0){
                return json([
                    'code'=> 0,
                    'msg'=> '比赛时间未到或已结束',
                ]);
            }
        }
        $scoreMod = new model\score();
        $answerMod = new model\answer();
        //获取最新一条得分记录,取出aid uid
        $scoreData = $scoreMod->field('aid,uid')->where('cid', config('timu'))->where(1)->order('id desc')->find();
        if(empty($scoreData)){
            return json([
                'code' => 0,
                'msg' => '暂时无最新信息',
            ]);
        }
        //拿到数据后就要到题库里面取东西了
        $scoreData = $scoreData->getData();
        $data = $answerMod->where('cid', config('timu'))->where('id', $scoreData['aid'])->cache('answer_'. $scoreData['aid'])->find();
        if(empty($data)){
            return json([
                'code' => 0,
                'msg' => '题目故障',
            ]);
        }else{
            $data = $data->getData();
        }

        return json([
            'code' => 200,
            'username'=> IdGetName($scoreData['uid']),
            'answer' => string_htmlspecialchars($data['name']),
            'score' => $data['score']
        ]);
    }

    /**
     * 获取排名信息
     * @return \think\response\Json
     */
    public function getranking(){
        if(session('isadmin') !== 1 && config('display_ranking') != 1){
            return json([
                'code'=> 0,
                'msg'=> '排行榜页面暂时未对普通用户开放',
            ]);
        }
        $scoreMod = new model\score();
        $score_data = $scoreMod->showRanking(true);
        $data = [];
        foreach ($score_data as $value){
            $value['answer'] = countScore($value['uid']);
            $value['uid'] = IdGetName($value['uid']);
            $data[] = $value;
        }
        return json($data);
    }
}
