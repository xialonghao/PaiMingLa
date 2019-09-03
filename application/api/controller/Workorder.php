<?php
namespace app\api\controller;
use app\common\controller\Api;
use think\Controller;
use fast\Random;
use think\Db;
use think\Validate;
use think\Request;
class Workorder extends Api{
        protected $noNeedLogin = ['add_workorder'];
        protected $noNeedRight = '*';
        public function _initialize(){
            $this->worder = new \app\admin\model\Worder;
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: toresetpwdken, Origin, X-Requested-With, Content-Type, Accept, Authorization");
            header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
            parent::_initialize();
        }
/**
  *创建工单
 */
    public function add_workorder(){
        $users = $this->auth->getUser();
        $title = $this->request->request('title');
        $content = $this->request->request('content');
        $mobile = $this->request->request('mobile');
        $e_mail = $this->request->request('e_mail');
        $images = $this->request->request('images');
        $token = $this->request->request('token');
        $user =\app\common\library\Token::get($token);
        if(!$title || !$content || !$mobile || !$e_mail){
            $this->error(__('Invalid parameters'));
        }

        if($mobile && !Validate::regex($mobile,'^1\d{10}$')){
            $this->error(__('Mobile is incorrect'));
        }

        if (!Validate::is($e_mail, "email"))
        {
            $this->error(__('Email is incorrect'));
        }

        $data=array(
            'title'     => $title,
            'contect'   => $content,
            'mobile'    => $mobile,
            'e_mail'    =>  $e_mail,
            'images'    => $images,
            'user_id'   => $user['user_id'],
            'username'  => $users->username,
            'worder_sn' => 'GD'.date('YmdHis', time()).$user['user_id'],
            'status'    => 0,

        );

        $res = $this->worder->insertGetId($data);
        $word_id = array(
            'id'=>$res
        );
        $workcontent['worder_id'] = $res;
        $rescontnet = $this->worder->where('id="'.$res.'"')->field('worder_sn,contect')->find();
        $data_content = array(
            'worder_sn' => $rescontnet->worder_sn,
            'worder_id' => $workcontent['worder_id'],
            'user_id'   => $user['user_id'],
            'username'  => $users->username,
            'contect'   => $rescontnet->contect,
            'adminstatus'=>0,
        );

        $worder_1 =  \app\common\model\WorderComment::insertGetId($data_content);
        if($worder_1)
        {
            $this->success(__('Successful'),$word_id);
        }
        else
        {
            $this->error($this->worder->getError());
        }


    }
/**
 *工单回复列表
 */
   public function worder_replylist(){

        $id = $this->request->request('id');

        $token = $this->request->request('token');
        $user =\app\common\library\Token::get($token);
        if(!$id || !$token){
            $this->error(__('Invalid parameters'));
        }
        $worder_replylist1 = $this->worder->alias('a')
        ->join('pml_worder_comment b','b.user_id=a.user_id')
        ->where('a.id="'.$id.'" and b.worder_id="'.$id.'"and a.user_id="'.$user['user_id'].'"')
        ->select();
        if($worder_replylist1){
            $this->success(__("Successful"),$worder_replylist1);
        }else{
            $this->error($this->worder->getError());
        }

   }
/**
*工单留言
*/
    public function worder_liuyan(){
        $id = $this->request->request('id');
        $token = $this->request->request('token');
        $contect = $this->request->request('content');
        $user = \app\common\library\Token::get($token);
        if(!$id || !$token || !$contect){
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->worder->where('id="'.$id.'" and user_id="'.$user['user_id'].'"')->find();
        $data = array(
            'worder_id' =>$id,
            'worder_sn' =>$ret->worder_sn,
            'contect'   =>$contect,
            'user_id'   =>$ret->user_id,
            'username'  =>$ret->username,
            'adminstatus'=>0,
        );
        $res = \app\common\model\WorderComment::insert($data);
        if($res){
            $this->success(__("Successful"));
        }else{
            $this->error($this->worder->getError());
        }
    }
/**
*工单提交信息
*/
    public function worder_title(){
        $id = $this->request->request('id');
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        if(!$id){
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->worder->where('id="'.$id.'"and user_id="'.$user['user_id'].'"')->field('title,worder_sn,create_time,status')->find();
        if($ret){
            $this->success(__("Successful"),$ret);
        }else{
            $this->error($this->worder->getError());
        }
    }

/**
 *工单状态
 */
    public function worder_status(){
        $id = $this->request->request('id');
        $token = $this->request->request('token');
        $status = 2;
        $user = \app\common\library\Token::get($token);

        if(!$id || !$token){
            $this->error(__('Invalid parameters'));
        }
        $data = array(

            'status' =>$status,
        );
        $res = $this->worder->where('id="'.$id.'"and user_id="'.$user['user_id'].'"')->update($data);
        if($res){
            $this->success(__("Successful"),$res);
        }else{
            $this->error($this->worder->getError());
        }
    }
/**
*工单评分
*/
    public function worder_grade(){
        $id = $this->request->request('id');
        $token = $this->request->request('token');
        $content = $this->request->request('content');
        $grade = $this->request->request('grade');
        $status = $this->request->request('status');
        $user = \app\common\library\Token::get($token);
        if(!$id || !$token){
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->worder->where('id="'.$id.'"and status="2"and user_id="'.$user['user_id'].'"')->find();
        $data = array(
            'user_id'=>$user['user_id'],
            'worder_id'=>$id,
            'content'=>$content,
            'grade'=>$grade,
            'status'=>$status,
            'worder_sn'=>$ret['worder_sn'],
            'username'=>$ret['username'],
        );

        $coun = \app\common\model\WorderGrade::where('id="'.$id.'"')->count();
        if($coun>0){
            $this->error(__('Submit Again'));
        }
        $res = \app\common\model\WorderGrade::insert($data);
        if($res){
            $this->success(__("Successful"));
        }else{
            $this->error(__("不可提交"));
        }

    }
    /**
     *工单评分列表
     */
    public function worder_gradelist(){
        $id = $this->request->request('worder_id');
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        $res =  \think\Db::table("pml_worder_grade")->where('user_id="'.$user['user_id'].'" and worder_id="'.$id.'"')->find();
        if($res==0){
            $this->success(__("未评价"),$res);
        }
        if($res){
            $this->success(__("Successful"),$res);
        }else{
            $this->error($this->worder->getError());
        }
    }
/**
*历史工单详细列表
*/
    public function worder_done(){
        $id = $this->request->request('id');
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        if(!$id || !$token){
            $this->error(__('Invalid parameters'));
        }
        $res = $this->worder->alias('a')
        ->join('pml_worder_comment b','a.user_id=b.user_id','LEFT')
        ->join('pml_worder_grade c','c.worder_sn=b.worder_sn','LEFT')
        ->where('a.status="2" and a.user_id="'.$user['user_id'].'" and a.id="'.$id.'"')
        ->select();
        if($res){
          $this->success(__("Sucdessful"),$res);
        }else{
            $this->error($this->worder->getError());
        }
    }
/**
*历史工单
*/
    public function worder_history(){
        $token = $this->request->request('token');
        $id =$this->request->request('id');
        $user = \app\common\library\Token::get($token);
        $res = $this->worder->where('user_id="'.$user['user_id'].'" and status="2" or status="-1"')->select();
        if($res){
            $this->success(__("Successful"),$res);
        }else{
            $this->error(__("数据为空"));
        }
    }
/**
 *投诉建议创建
 */
    public function complaint_add(){
            $users = $this->auth->getUser();
            $title = $this->request->request('title');
            $content = $this->request->request('content');
            $mobile = $this->request->request('mobile');
            $images = $this->request->request('images');
            $token = $this->request->request('token');
            $user = \app\common\library\Token::get($token);
            if(!$content || !$mobile  || !$token || !$title){
                $this->error(__('Invalid parameters'));
            }
            if($mobile && Validate::regex($mobile,'^1\d{10}$')){
                $this->error(__('Mobile is incorrect'));
            }
            $data = array(
                'user_id' => $user['user_id'],
                'username'=>$users->username,
                'images'=>$images,
                'title'   =>$title,
                'content' =>$content,
                'phone'   =>$mobile,
                'num'     => 'XM_'.date('YmdHis', time())."_".Random::alnum().'_SD_'.$user['user_id'],
            );
            $res = \app\admin\model\Complaint::insert($data);
            if($res){
                $this->success(__("Successful"));
            }else{
                $this->error($this->worder->getError());
            }
    }
    /**
     *工单列表
     */
    public function workorder_list()
    {
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        $res = $this->worder->where('user_id="' . $user['user_id'].'" and (status="0" or status="1")')->field('id,worder_sn,title,contect,create_time,status')->select();
        if($res){
            $this->success(__("Successful"),$res);
        }else{
            $this->error(__("数据为空"));
        }
    }
    /**
     *工单删除
     */
    public function workorder_del(){
        $token = $this->request->request('token');
        $id = $this->request->request('id');
        $user = \app\common\library\Token::get($token);
        $res = $this->worder->where('user_id="'.$user['user_id'].'"and id="'.$id.'"')->delete();
        if($res){
            $this->success(__("Successful"),$res);
        }else{
            $this->error($this->worder->getError());
        }
    }
}

?>