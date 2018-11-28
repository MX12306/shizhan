<?php
namespace app\index\model;
use think\Model;
class answer extends Model{
    /**
     * 验证题目答案
     *
     * @param $id
     * @param $flag
     * @return bool
     */
    public function Answer($id,$flag){
        $res = $this->where('id',$id)->find();
        if($res->data['flag'] === $flag){
            return true;
        }
        return false;
    }

    /**
     * 检查该题目是否可以被回答
     *
     * @param $id
     * @return bool
     */
    public function yn_Answer($id){
        $ret = $this->where('cid', config('timu'))->where('id',$id)->find();
        if(empty($ret->data)){
            return false;//题目不存在
        }
        if($ret->data['visible'] == 1){
            return true;
        }
        return false;//题目不允许被回答
    }

    /**
     * 得到题目信息
     *
     * @param $id
     * @return array|object
     */
    public function getAnswer($id){
        $data = $this->where('cid', config('timu')) ->where('id',$id)->find();
        if(!empty($data)){
            return $data->data;
        }
        return null;
    }

    /**
     * 题目ID获得分值
     *
     * @param $id
     * @return mixed
     */
    public function getScore($id){
        return $this->where('id',$id)->find()->data['score'];
    }

    public function getAll(){
        $r = $this->where('cid', config('timu'))->where('visible',1)->select();
        return $r;
    }

}