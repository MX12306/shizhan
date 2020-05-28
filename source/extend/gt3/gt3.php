<?php
namespace gt3;
use gt3\lib\GeetestLib;
use think\Session;

class gt3{
    private $switch;
    private $id;
    private $key;
    private $req;

    function __construct($req){
        $data = config('geetest');
        $this->key = $data['key'];
        $this->id = $data['id'];
        $this->switch = $data['enable'];
        $this->req = $req;
    }

    /**
     * 初始化
     * @return mixed|void
     */
    public function StartCaptchaServlet(){
        if (!$this->switch){
            return ;
        }
        $GtSdk = new GeetestLib($this->id, $this->key);
        $data = array(
            'user_id' => sha1(session_id()),
            'client_type' => 'web',
            'ip_address' => $this->req->ip()
        );
        $status = $GtSdk->pre_process($data, 1);
        Session::set('gtserver', $status);
        return $GtSdk->get_response_str();
    }

    /**
     * 二次验证
     * @return bool
     */
    public function VerifyLoginServlet(){
        if (!$this->switch){
            return true;
        }
        $GtSdk = new GeetestLib($this->id, $this->key);
        $data = array(
            'user_id' => sha1(session_id()),
            'client_type' => 'web',
            'ip_address' => $this->req->ip()
        );
        $geetest_challenge = $this->req->post('geetest_challenge');
        $geetest_validate = $this->req->post('geetest_validate');
        $geetest_seccode = $this->req->post('geetest_seccode');

        if (Session::get('gtserver') == 1) {   //服务器正常
            $result = $GtSdk->success_validate($geetest_challenge, $geetest_validate, $geetest_seccode, $data);
            if ($result) {
                return true;
            } else{
                return false;
            }
        }else{  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($geetest_challenge, $geetest_validate, $geetest_seccode)) {
                return true;
            } else{
                return false;
            }
        }
    }

}