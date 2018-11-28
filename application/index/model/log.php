<?php
namespace app\index\model;
use think\Model;
class log extends Model{
    public function insertData($uid,$aid,$answer,$time,$yn = 0){
        return $this->insert([
            'uid'       => $uid,
            'aid'       => $aid,
            'cid'       => config('timu'),
            'answer'    => $answer,
            'yn'        => $yn,
            'an_time'   => $time
        ]);
    }
}