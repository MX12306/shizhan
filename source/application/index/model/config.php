<?php
namespace app\index\model;

use think\Model;
class config extends Model{
    /**
     * 将config表的设置注册为配置
     *
     */
    public function startConfig(){
        $ret = $this->where(1)->cache('config')->select();
        foreach($ret as $key=>$value){
            config($value->data['keys'],$value->data['value']);
        }
    }

    /**
     * 获得比赛时间信息
     *
     * @param bool $get
     * @return array
     */
    public function getTimeInfo($get = false){

        if($get == true){//防止startConfig重复执行
            config::startConfig();
        }

        if(config('open_time') == 0){//open_time 为1 则打开计时
            return ['left_time' => 0];
        }

        $startTime      = config('start_time');
        $stopTime       = config('stop_time');
        $currentTime    = time();
        $left = $stopTime - $currentTime;//计算剩下的时间
        if($startTime >= $currentTime){
            $left = 0;
        }

        if($left <= 0){//比赛结束时 left 为0
            $left = 0;
        }

        return [
            'start_time'    => $startTime,
            'left_time'     => $left,
            'stop_time'     => $stopTime,
            'current'       => $currentTime
        ];
    }
}