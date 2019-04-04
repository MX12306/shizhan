<?php
namespace app\common\model;
use think\Model;
class user extends Model{

    protected function getIsadminAttr($value){
        if($value === 1){
            return '管理员';
        }else{
            return '用户';
        }
    }

    protected function getLoginTimeAttr($value){
        if(empty($value)){
            return '从未登录过';
        }
        return date("Y-m-d H:i:s", $value);
    }
}