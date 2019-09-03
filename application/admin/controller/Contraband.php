<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use fast\Http;

/**
 * 违禁词管理
 *
 * @icon fa fa-circle-o
 */
class Contraband extends Backend
{
    
    /**
     * Contraband模型对象
     * @var \app\admin\model\Contraband
     */
    protected $model = null;

    protected  $host = "http://api.ezhihuo.com/api/word/";
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Contraband;

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    function pty_token(){
        $url ='http://api.ezhihuo.com/token/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 520);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $message = json_decode($output,true);
        $_SESSION['code'] = $message['code'];
        return $output;
    }
    /**
     *
     * 添加关键词
     *
     * */
    public function adds(){
        $word = input('post.');
        $worder = $word['word']['remark'];
        $pty_token = json_decode($this->pty_token(),true);
        if($pty_token['success']['token']==''){
            $this->success('token为空');
        }
        $url = 'http://api.ezhihuo.com/api/word/';
        $post_data=array('word'=>$worder);
        $headers = array(
            "token:".$pty_token['success']['token'].""
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $re_success = json_decode($output,true);
//        print_r($re_success);die;

        if(!empty($re_success['pk'])){

            $data =[
                'code_id'=>$re_success['pk'],
                'code'=>$re_success['word'],
                'create_time'=>time(),
            ];
            $res = $this->model->fetchSql()->insert($data);

            if($res){
                return json(
                    array(
                        'code'=>'200',
                        'msg'=>'添加成功',
                        'data'=>1,
                    )
                );
            }
        }else{
            return json(
                array(
                    'code'=>'500',
                    'msg'=>'关键词已添加',
                    'data'=>0,
                )
            );
        }

    }
    /**
     *
     * list列表
     *
     * */
    public function lists(){
        $pty_token = json_decode($this->pty_token(),true);
        if($pty_token['success']['token']==''){
            $this->success('token为空');
        }
        $url = 'http://api.ezhihuo.com/api/word/';
        $headers = array(
            "token:".$pty_token['success']['token'].""
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $re_success = json_decode($output,true);
        if(empty($re_success)){
            return json(
                array(
                    'code'=>'500',
                    'msg'=>'获取失败',
                    'data'=>0,
                )
            );
        }else{
            return json(
                array(
                    'code'=>'200',
                    'msg'=>'获取成功',
                    'data'=>$re_success,
                )
            );
        }
    }

    /**
     *
     * 关键词删除
     *
     * */
    public function dels(){
        $id = input('get.ids');
        $pty_token = json_decode($this->pty_token(),true);
        if($pty_token['success']['token']==''){
            $this->success('token为空');
        }

        $headers = array(
            "token:".$pty_token['success']['token'].""
        );
        $url ='http://api.ezhihuo.com/api/word/'.$id.'/';
        $ch = curl_init();
        curl_setopt ($ch,CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $output = curl_exec($ch);
        curl_close($ch);
        if($output){
            return json(
                array(
                    'code'=>'200',
                    'msg'=>'删除成功',
                    'data'=>1,
                )
            );
        }
    }
    /**
     *
     * 关键词编辑
     *
     * */
    public function updatas(){

        $pty_token = json_decode($this->pty_token(),true);
        if($pty_token['success']['token']==''){
            $this->success('token为空');
        }
        $ids = input('post.');
        $ids_one = $ids['ids'];
        $worder = $ids['words'];
        $data = array('word'=>$worder);
        $headers = array(
            "token:".$pty_token['success']['token'].""
        );
        $url ='http://api.ezhihuo.com/api/word/'.$ids_one.'/';
        $ch = curl_init();
        curl_setopt ($ch,CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        $re_success = json_decode($output,true);
        if($re_success['word']==$worder){
            return json(
                array(
                    'code'=>'200',
                    'msg'=>'修改成功',
                    'data'=>1,
                )
            );
        }else{
            return json(
                array(
                    'code'=>'200',
                    'msg'=>'修改失败',
                    'data'=>1,
                )
            );
        }

    }
//    /**
//     * 查看
//     */
//    public function index()
//    {
//
//        //当前是否为关联查询
//        $this->relationSearch = false;
//        //设置过滤方法
//        $this->request->filter(['strip_tags']);
//        if ($this->request->isAjax())
//        {
//            //如果发送的来源是Selectpage，则转发到Selectpage
//            if ($this->request->request('keyField'))
//            {
//                return $this->selectpage();
//            }
//
//
//            $data = json_decode(Http::get($this->host),true);
//
//            $total = count($data);
//            foreach ($data as $key=>$val){
//                $data[$key]['id'] = $val['pk'];
//            }
//            $result = array("total" => $total, "rows" => $data);
//
//            return json($result);
//        }
//        return $this->view->fetch();
//    }
    
//    /**
//     * 添加违禁词
//     */
//    /**
//     * 添加
//     */
//    public function add()
//    {
//        if ($this->request->isPost()) {
//            $params = $this->request->post("row/a");
//            if ($params) {
//                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
//                    $params[$this->dataLimitField] = $this->auth->id;
//                }
//                try {
//                    $res = json_decode(Http::post($this->host,['word'=>$params['code']]),true);
//                    if (!empty($res['pk'])) {
//                        $this->success();
//                    } else {
//                        $this->error(__($res['word']['0']));
//                    }
//                } catch (\think\exception\PDOException $e) {
//                    $this->error($e->getMessage());
//                } catch (\think\Exception $e) {
//                    $this->error($e->getMessage());
//                }
//            }
//            $this->error(__('Parameter %s can not be empty', ''));
//        }
//        return $this->view->fetch();
//    }
//
//    /**
//     * 删除
//     */
//    public function del($ids = "")
//    {
//        if ($ids) {
//            $res = Http::sendRequest($this->host.$ids."/", '', 'DELETE');
//            if($res['ret']){
//                $this->success(__("Operation completed"));
//            }else{
//                $this->error(__("Operation failed"));
//            }
//        }
//        $this->error(__('Parameter %s can not be empty', 'ids'));
//    }
//
//    /**
//     * 检测违禁词
//     */
//    public function checkword($wordkey=""){
//        $url = "http://api.ezhihuo.com/api/examine/";
//        $res = json_decode(Http::post($url,['wordkey'=>$wordkey]),true);
//        if($res['code'] == 1 && $res['result'] == 1){
//            $result = true;
//        }else{
//            $result = false;
//        }
//        return $result;
//    }
    
}
