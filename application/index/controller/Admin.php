<?php
namespace app\index\controller;
use app\index\model\answer;
use app\index\model\AnswerCls;
use app\index\model\config;
use think\Cache;
use think\Request;

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