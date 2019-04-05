<?php
namespace app\index\controller;
use app\index\model\answer;
use app\index\model\AnswerCls;
use app\index\model\config;
use app\index\model\log;
use app\index\model\score;
use app\index\model\user;
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
            $this->redirect('/login');
        }else{
            if(session('isadmin') != 1){
                $this->redirect('/login');
            }
        }
        $configMod = new config();
        $configMod->startConfig();//初始化系统配置
        unset($configMod);
    }

    /**
     * 管理首页
     * @return mixed
     */
    public function index(){
        $this->assign('selected','selected');
        return $this->fetch('admin:admin');
    }

    /**
     * 添加分类接口
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addclass(){
        $this->assign('selected1','selected');
        $claModel = new AnswerCls();
        $this->assign('class_list', $claModel->where(1)->select());
        return $this->fetch('admin:addclass');
    }

    /**
     * 题目管理
     * @return mixed|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add(){
        $cid = intval(Request::instance()->get('cid'));
        $id = intval(Request::instance()->get('id'));
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

        $this->assign('acsname', $acModel->where('id', $cid)->find()->getData('name'));
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

    /**
     * 模板上传
     * @return \think\response\Json
     * @throws \Exception
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
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
                $insdata[$i]['name'] = string_htmlspecialchars($value['B']);
                $insdata[$i]['content'] = remove_xss($value['C']);
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

    /**
     * 保存配置
     */
    public function save(){
        $_POST['start_time'] = strtotime($_POST['start_time']);
        $_POST['stop_time'] = strtotime($_POST['stop_time']);
        $_POST['open_time'] = empty($_POST['open_time'])? 0: 1;
        $_POST['reg_switch'] = empty($_POST['reg_switch'])? 0: 1;
        $_POST['display_ranking'] = empty($_POST['display_ranking'])? 0: 1;
        $configMod = new config();
        $list = [
            'title',
            'announcement',
            'tips',
            'open_time',
            'start_time',
            'stop_time',
            'reg_switch',
            'display_ranking'

        ];
        foreach ($_POST as $key => $value){
            foreach ($list as $v){
                if($v === $key){
                    $configMod->where('keys',$v)->update(['value'=>remove_xss($value)]);
                }
            }
        }
        Cache::rm('config');
        $this->success('更新完成');
    }

    /**
     * 用户管理
     * @return mixed
     */
    public function user(){
        $this->assign('selected2','selected');
        return $this->fetch('user');
    }

    /**
     * 获取用户列表
     * @return \think\response\Json
     */
    public function getUserList(){
        $mod = new \app\common\model\user();
        $data = $mod->select();
        return json(
            $data
        );
    }

    /**
     * 删除用户
     * @return \think\response\Json
     */
    public function deluser(){
        $uid = Request::instance()->post('uid');
        $mod = new user();
        if($mod->where('id', $uid)->delete()){
            return json(
                ['code'=>200, 'msg'=>'用户已删除']
            );
        }
        return json(
            ['code'=>0, 'msg'=>'用户删除失败']
        );
    }

    /**
     * 获取用户信息
     * @return \think\response\Json
     */
    public function getUserInfo(){
        $uid = intval(Request::instance()->post('uid'));
        if(!$uid){
            return json(['code'=>0, 'msg'=>'无效的UID']);
        }
        $userModel = new user();
        if(!$userModel->where('id', $uid)->count()){
            return json([
                'code' => 0,
                'msg' => '用户不存在'
            ]);
        }
        $data = $userModel->field('user,info,isadmin')->where('id', $uid)->find();
        return json([
            'code'=> 200,
            'msg' => '',
            'data'=>$data
        ]);
    }

    /**
     * 更新用户信息
     * @return \think\response\Json
     */
    public function updateUser(){
        $data = Request::instance()->post();
        $data['isadmin'] = empty($data['isadmin'])? 0:1;
        $data['uid'] = intval($data['uid']);
        $data['info'] = remove_xss($data['info']);
        if(!empty($data['repass'])){
            $data['password'] = $data['repass'];
        }
        $userModel = new user();
        if($userModel->allowField(['password','info','isadmin'])->save($data,['id' => $data['uid']])){
            return json([
                'code'=> 200,
                'msg'=> '更新成功'
            ]);
        }else{
            return json([
                'code'=> 0,
                'msg'=> '更新失败'
            ]);
        }
    }
    //后台操作API
    /**
     * 添加题目分类
     */
    public function add_timu_class(){
        $name = Request::instance()->post('timuname');
        $clsMod = new AnswerCls();
        $clsMod->insert(['name' =>  string_htmlspecialchars($name)]);
        $this->success("添加成功");
    }

    /**
     * 删除题目分类
     */
    public function del_timu_class(){
        $id = Request::instance()->get('id');
        $id = intval($id);
        $clsMod = new AnswerCls();
        $aMod = new answer();
        $clsMod->where('id',$id)->delete();
        $aMod->where('cid',$id)->delete();
        $this->success("删除成功");
    }

    /**
     * 设置题目调度,设置当前要作答的题目类型ID
     */
    public function start_timu_class(){
        $id = Request::instance()->get('id');
        $id = intval($id);
        $configMod = new config();
        $configMod->where('keys','timu')->cache('config')->update(['value'=>$id]);
        Cache::rm('allAnswer');
        $this->success("题目调度完成");
    }

    /**
     * 删除题目作答记录
     */
    public function del_timu_class_log(){
        $id = Request::instance()->get('id');
        $id = intval($id);
        $logMod = new log();
        $scoreMod = new score();
        $logMod->where('cid', $id)->delete();
        $scoreMod->where('cid', $id)->delete();
        $this->success("题目答题记录已删除");
    }

    /**
     * 删除题目
     */
    public function del_tanswer(){
        $id = intval(Request::instance()->get('id'));
        $cid = intval(Request::instance()->get('cid'));
        $aMod = new answer();
        $aMod->where('cid', $cid)->where('id',$id)->delete();
        $this->success("题目已删除");
    }

    /**
     * 添加题目与编辑题目
     */
    public function add_answer(){
        $data = Request::instance()->post();
        $data['name'] = string_htmlspecialchars($data['name']);
        $data['name'] = string_htmlspecialchars($data['name']);
        $data['content'] = remove_xss($data['content']);
        $data['score'] = intval($data['score']);
        $data['visible'] = empty($data['visible'])? 0: 1;

        $cid = intval($data['cid']);
        $aModel = new answer($data);

        if($data['edit'] == 1){
            $id  = intval($data['id']);
            if(!empty($id)){
                $ret = $aModel->where('id', $id)->update([
                    'name'=> $data['name'],
                    'content'=> $data['content'],
                    'flag'=> $data['flag'],
                    'score'=> $data['score'],
                    'visible' => $data['visible']
                ]);
                if($ret){
                    Cache::rm('answer_'.$id);
                    $this->success('更新成功',url('index/admin/add').'?cid=' . $cid);
                }
                $this->error('更新失败');
            }
            $this->error('不规范的操作行为');
        }

        if($aModel->allowField(['cid', 'name','content', 'flag', 'score', 'visible'])->save() == 1){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }
}