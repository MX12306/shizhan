<?php
namespace app\index\controller;
use app\index\model\answer;
use app\index\model\AnswerCls;
use app\index\model\config;
use think\Cache;
use think\Request;
require ROOT_PATH.'vendor'.DS.'PHPExcel.php';
use PHPExcel;
use PHPExcel_Reader_Excel5;
/**
 * 系统后台管理页面控制器
 *
 * Class Admin
 * @package app\index\controller
 */
class Admin extends \think\Controller{
    protected $beforeActionList = ['start'];//访问该控制器前执行的方法

    /**
     * 进入该模块时会执行该方法
     */
    protected function start(){
        if(session('login') != 1){//没登录302到登陆页面
            return $this->redirect('/login');
        }else{
            if(session('isadmin') != 1){
                return $this->redirect('/login');
            }
        }
        $configMod = new config();
        $configMod->startConfig();//初始化系统配置
        unset($configMod);
    }
    public function index(){

        $this->assign('selected','selected');
        return $this->fetch('admin:admin');
    }

    public function addclass(){
        $this->assign('selected1','selected');
        $claModel = new AnswerCls();
        $this->assign('class_list', $claModel->where(1)->select());
        return $this->fetch('admin:addclass');
    }

    public function add(){
        $cid = Request::instance()->get('cid');
        $id = Request::instance()->get('id');
        if(Request::instance()->get('edit') != 1){ #编辑状态不为1时 检查是否带有CID 分类ID
            if(empty($cid)){
                return "暂时不接受空访问";
            }
            $edit = false;
        }else if($_GET['edit'] == 1){
            if(empty($id)){
                return "暂时不接受空访问";
            }
            $edit = true;
        }

        $aModel = new answer();
        $acModel = new AnswerCls();
        $this->assign('edit', $edit);

        if($edit == false){
            $this->assign('name',$acModel->idGetName($cid));
            $this->assign('t_list',$aModel->where('cid',$cid)->order('id desc')->select());
        }else{
            $data = $aModel->where('id', $id)->find();
            if (!empty($data)){
                $this->assign('data',$data->toArray());
            }
        }
        return $this->fetch('admin:add');
    }

    public function uploadfile(){
        $file = request()->file('file');
        if (!$file){
            return json([
                'code'=> 0,
                'msg' => '没有文件'
            ]);
        }
        $info = $file->rule('md5')->validate(['ext'=>'xls'])->move(ROOT_PATH .DS.'uploads');
        if($info){
            $filename = $info->getSaveName();
            //导入功能实现
            $PHPReader =  new PHPExcel_Reader_Excel5();
            $objReader = $PHPReader->load(ROOT_PATH .'uploads'.DS.$filename);
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
            $answerMod = new answer();
            $answerClsMod = new AnswerCls();
            $acsname = '';//分类名称,记录上一个类名
            $i = 2;
            $s = 0;
            $insdata = [];
            foreach ($data as $value){

                if($acsname !== $value['A']){//如果上一个类名和当前类名一致,则为同一套题目
                    $acsname = $value['A'];
                    //不相同则查询当前类名是否存在,存在则直接返回类ID
                    $acsdata = $answerClsMod->where('name', $value['A'])->find();
                    $s = $s +1;
                    if(empty($acsdata)){
                        //创建
                        $emmmm = $answerClsMod::create([
                            'name'=> $value['A']
                        ]);
                        //验证是否创建成功
                        if(!empty($emmmm)){
                            $acsid = $emmmm->id;
                        }else{
                            return json([
                                'code'=> 0,
                                'msg' => '创建题目分类失败,请检查名称:'.$value['A']
                            ]);
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
            if($a23333){
                return json([
                    'code'=> 200,
                    'msg' => '导入成功',
                    'query'=> $s,
                ]);
            }else{
                return json([
                    'code'=> 0,
                    'msg' => '导入失败'
                ]);
            }

        }else{
            return json([
                'code'=> 0,
                'msg' => $file->getError()
            ]);
        }
    }

    public function save(){
        $_POST['start_time'] = strtotime($_POST['start_time']);
        $_POST['stop_time'] = strtotime($_POST['stop_time']);
        if(!empty($_POST['open_time'])){
            $_POST['open_time'] = 1;
        }else{
            $_POST['open_time'] = 0;
        }
        $configMod = new config();
        $list = [
            'title',
            'announcement',
            'tips',
            'open_time',
            'start_time',
            'stop_time'
        ];
        foreach ($_POST as $key => $value){
            foreach ($list as $v){
                if($v === $key){
                    $configMod->where('keys',$v)->update(['value'=>$value]);
                }
            }
        }
        Cache::rm('config');
        $this->success('更新完成', '/admin.php');
    }
}