<?php
namespace app\index\model;
use think\Model;
class AnswerCls extends Model{
    public function idGetName($id){
        $id = intval($id);
        $data = $this->where('id',$id)->cache('answercls_'.$id)->find();
        if(!empty($data)){
            return $data->getData('name');
        }
        return null;
    }
}
