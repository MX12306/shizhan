<?php
namespace app\index\model;
use think\Model;
use think\Session;
class user extends Model{

    public function getUserID($username){
        $res = $this->where('user', $username)->find();
        if(empty($res->data)){
            return 'NULL';
        }
        return $res->data['id'];
    }

    public function getIDUser($id){
        $id = intval($id);
        $res = $this->where('id', $id)->cache('idgetname_'.$id)->find();
        if(empty($res->data)){
            return 'NULL';
        }
        return $res->data['user'];
    }

    /**
     * 判断用户名是否存在
     * @param $user
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ifUser($user){
        $res = $this->where('user',$user)->find();
        if(empty($res->data)){
            return true;//不存在
        }
        return false;//存在
    }

    /**
     * 添加用户
     *
     * @param $user
     * @param $pass
     * @return bool
     */
    public function addUser($user,$pass){
        $this->data([
            'user'  => $user,
            'password'  => $pass
        ]);
        $res = $this->save();
        if($res){
            return true;
        }
        return false;
    }

    public function getUserInfo($uid){
        $data = $this->field('info')->where('id', $uid)->find();
        if(!empty($data)){
            $data  = $data->toArray();
            if(empty($data['info'])){
                return null;
            }
            return $data['info'];
        }
    }
}