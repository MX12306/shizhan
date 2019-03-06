<?php
namespace app\index\model;
use think\Model;

class score extends Model{
    public function getScore(){
    }

    /**
     * 插入积分数据
     * 已答对的题目会加入到这个表
     * @param $uid
     * @param $aid
     * @return int|string
     */
    public function insertData($uid,$aid,$time){
        $answerMod = new \app\index\model\Answer();
        return $this->insert([
            'uid'       => $uid,
            'aid'       => $aid,
            'cid'       => config('timu'),//当前所调度的题目-题目分类中的id
            'score'     => $answerMod->getScore($aid),
            'an_time'   => $time
        ]);
    }

    /**
     * 判断是否已经回答过此题
     *
     * @param $uid
     * @param $aid
     * @return bool
     */
    public function yn_answer($uid,$aid){
        $res = $this->where('cid', config('timu'))->where('uid',$uid)->where('aid',$aid)->find();
        if(empty($res->data)) {
            return false;
        }
        return true;
    }

    /**
     * 输出排名
     *
     * @return array
     */
    public function showRanking($source = false){
        $get_data = $this->field('uid,sum(score) as score ')->where('cid', 5)->group('uid')->order('score desc')->buildSql();
        $res = $this->table($get_data.' rank, (SELECT @rownum:=0) r')->field('rank.*,@rownum:=@rownum+1 as rownum')->select();
        if($source == false){
            $data = [];
            foreach($res as $value){
                $data[$value['uid']]            = $value['uid'];
                $data[$value['uid']] = [];
                $data[$value['uid']]['score']   = $value['score'];
                $data[$value['uid']]['rownum']   = $value['rownum'];
            }
            return $data;
        }
        return $res;
    }

    /**
     * 获得UID的排名信息
     *
     * @return mixed
     */
    public function getMyRanking(){
        if(empty(score::showRanking()[session('userID')])){
            return ['rownum'=>'暂无信息', 'score'=>'0'];
        }
        return score::showRanking()[session('userID')];

    }

    /**
     * 获得提交记录
     *
     * @return mixed
     */
    public function getLog(){
        $sql = 'select '.config('database.prefix').'answer.score,'.config('database.prefix').'answer.name,'.config('database.prefix').'log.* from ';
        $sql .= config('database.prefix').'answer,'.config('database.prefix').'log where ';
        $sql .= config('database.prefix').'log.aid = '.config('database.prefix').'answer.id and '.config('database.prefix').'log.cid=' .config('timu').' and uid="'.session('userID').'" order by id DESC';

        $res = $this->query($sql);
        return $res;
    }

    /**
     * 统计答题数量
     *
     * @param $uid
     * @return int|string
     */
    public function countScore($uid){
        return $this->where('cid',  config('timu'))->where('uid',$uid)->count('score');
    }
}