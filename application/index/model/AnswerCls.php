<?php
namespace app\index\model;
use think\Model;
class AnswerCls extends Model{
    public function idGetName($id){
        $data = $this->where('id',$id)->find();
        if(!empty($data)){
            return $data->toArray();
        }
        return null;
    }
}
