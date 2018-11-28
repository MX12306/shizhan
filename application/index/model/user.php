<?php
namespace app\index\model;
use think\Model;
use think\Session;
class user extends Model{
    /**
     * 登录处理
     *
     * @param $user
     * @param $password
     * @return int
     */
    public function login($user,$password){
        $ret = $this->where('user',$user)->find();
        if(empty($ret->data)){
            return -1;//用户不存在
        }
        if($ret->data['password'] == $password){
            Session::set('login','1');
            Session::set('user',$ret->data['user']);
            Session::set('userID',$ret->data['id']);
            Session::set('isadmin',$ret->data['isadmin']);
            return 0;
        }
        return -2;
    }

    /**
     * 用户名取ID
     *
     * @param $username
     * @return mixed
     */
    public function getUserID($username){
        $res = $this->where('user', $username)->find();
        if(empty($res->data)){
            return 'NULL';
        }
        return $res->data['id'];
    }

    /**
     * ID取用户名
     *
     * @param $id
     * @return string
     */
    public function getIDUser($id){
        $res = $this->where('id', $id)->find();
        if(empty($res->data)){
            return 'NULL';
        }
        return $res->data['user'];
    }

    /**
     * 判断用户名是否存在
     *
     * @param $user
     * @return bool
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