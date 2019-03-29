<?php
namespace app\index\controller;
use think\Request;
use app\index\model;
use think\Session;

require ROOT_PATH.'vendor'.DS.'PHPExcel.php';
use PHPExcel;
use PHPExcel_Reader_Excel5;
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
        $answerMod = new model\answer();
        $clsMod = new model\AnswerCls();//题目分类表
        $userMod = new model\user();
        $this->assign('display', 0);
        $this->assign('title', '赛场公告');
        $this->assign('content',config('announcement'));//获取config表的公告信息,作为默认页面

        //$this->assign('term_name',$clsMod->idGetName(config('timu'))['name']);//顶部标题

        //获取靶机信息
        $info = $userMod->getUserInfo(session('userID'));
        if($info !== null){
            $this->assign('info', $info);
        }
        $list = $answerMod->getAll();
        $this->assign('list',$list);//左侧题目列表区域
        return $this->fetch('index/index');//渲染赛题页面模板
    }

    public function getAnswer(){
        $id = intval(Request::instance()->get('id'));
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
                    'msg'=> '时间未到未能答题'
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
            'name'=>  $data['name'],
            'content'=> $data['content'],
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

        return $this->fetch('index:score');
    }

    /**
     * 排行榜页面
     *
     * @return mixed
     */
    public function ranking(){
        echo url('index/index/test');
        $scoreMod = new model\score();
        $this->assign('rankingLog',$scoreMod->showRanking(true));
        return $this->fetch('index:ranking');
    }

    public function test(){
        $PHPReader =  new PHPExcel_Reader_Excel5();
        $objReader = $PHPReader->load('D:\phpobj\shizhan\public\1.xls');
        $currentSheet=$objReader->getSheet(0);
        $allColumn=$currentSheet->getHighestColumn();
        $allRow=$currentSheet->getHighestRow();
        for($rowIndex=2;$rowIndex<=$allRow;$rowIndex++){
            for($colIndex='A';$colIndex<=$allColumn;$colIndex++){
                $addr = $colIndex.$rowIndex;
                $cell = $currentSheet->getCell($addr)->getValue();
                if($cell instanceof PHPExcel_RichText){
                    $cell = $cell->__toString();
                }
                $data[$rowIndex][$colIndex] = $cell;
            }
        }
        //转换数据
        $answerMod = new model\answer();
        $answerClsMod = new model\AnswerCls();
        $acsname = '';//分类名称,记录上一个类名
        $errorinfo = "";
        $i = 2;
        $insdata = [];
        foreach ($data as $value){
            if($acsname !== $value['A']){//如果上一个类名和当前类名一致,则为同一套题目
                //不相同则查询当前类名是否存在,存在则直接返回类ID
                $acsdata = $answerClsMod->where('name', $value['A'])->find();
                if(empty($acsdata)){
                    //创建
                    $emmmm = $answerClsMod::create([
                        'name'=> $value['A']
                    ]);
                    //验证是否创建成功
                    if(!empty($emmmm)){
                        $acsid = $emmmm->id;
                    }else{
                        $errorinfo = '创建题目分类失败,请检查名称:'.$value['A'];
                        return false;
                    }
                }else{
                    //返回ID
                    $acsid = $acsdata->getData('id');
                }
            }
            //拼接数据
            $insdata[$i]['cid'] = $acsid;
            $insdata[$i]['name'] = $value['B'];
            $insdata[$i]['content'] = $value['C'];
            $insdata[$i]['flag'] = $value['D'];
            $insdata[$i]['score'] = intval($value['E']);
            $insdata[$i]['visible'] = intval($value['F']);
            $i = $i + 1;
        }
        $a23333 = $answerMod->saveAll($insdata);
        var_dump($a23333);
    }
}
