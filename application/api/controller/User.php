<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Validate;
use app\common\model\User as Model;


/**
 * 会员接口
 */
class User extends Api
{

    protected $noNeedLogin = ['login','findpass','mobiles','usernames','coupon_list', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third','chognfumobile'];
    protected $noNeedRight = '*';

    protected $model = null;
    
    public function _initialize()
    {
        $this->model = new  \app\common\model\User;
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: toresetpwdken, Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
//        echo  \appn\common\http\CrossDomain::appInit();
        parent::_initialize();
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }

    /**
     * 会员登录
     * 
     * @param string $account 账号
     * @param string $password 密码
     */
    public function login()
    {
        $account = $this->request->request('account');
        $password = $this->request->request('password');
        if (!$account || !$password)
        {
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->auth->login($account, $password);
        if ($ret)
        {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        }
        else
        {
            $this->error($this->auth->getError());
        }
    }
    /**
     * 手机判断存不存在
     */
    public function chognfumobile(){
        $mobile = $this->request->request('mobile');
        if($this->model->where('mobile="'.$mobile.'"')->find()==''){
            $this->success(__('手机号不存在请注册'),0);
        }else{
            $this->success(__('手机号存在'),1);
        }
    }
    /**
     * 手机验证码登录
     * 
     * @param string $mobile 手机号
     * @param string $captcha 验证码
     */
    public function mobilelogin()
    {
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');

        if (!$mobile || !$captcha)
        {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$"))
        {
            $this->error(__('Mobile is incorrect'));
        }
        if (!Sms::check($mobile, $captcha, 'login'))
        {
            $this->error(__('Captcha is incorrect'));
        }
        // 过期则清空该手机验证码
        //         Sms::flush($mobile, 'login');
        $user = \app\common\model\User::getByMobile($mobile);
        if ($user)
        {
            //如果已经有账号则直接登录
            $ret = $this->auth->direct($user->id);
        }
        else
        {
            $ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
        }
        if ($ret)
        {
            Sms::flush($mobile, 'mobilelogin');
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        }
        else
        {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 找回密码
     *
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email 邮箱
     * @param string $mobile 手机号
     */

//    public function reginmima(){
//
//    }
    /**
     * 注册会员
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email 邮箱
     * @param string $mobile 手机号
     */
    public function register()
    {
        $username = $this->request->request('username');
        $password = $this->request->request('password');
        $mobile = $this->request->request('mobile');
        $code = $this->request->request('code');
        $email = $this->request->request('email');
        $captcha = $this->request->request('captcha');
        if (!$username || !$password || !$mobile || !$captcha)
        {
            $this->error(__('Invalid parameters'));
        }
        if ($mobile && !Validate::regex($mobile, "^1\d{10}$"))
        {
            $this->error(__('Mobile is incorrect'));
        }
        if (!Sms::check($mobile, $captcha, 'register'))
        {
            $this->error(__('Captcha is incorrect'));
        }

        //优惠券
        $coupon = \think\Db::table("pml_coupon")->where(['id'=>1,'type'=>0])->find();
        // 过期则清空该手机验证码
//         Sms::flush($mobile, 'register');
        
        $ret = $this->auth->register($username, $password, $email, $mobile, ['verification'=>Random::uuid()]);
        if ($ret)
        {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            if (!empty($coupon)){
                //邀请码
                if($code){
                    $user = $this->model->get(['verification' => $code]);
                    $coupondata = [
                        'coupon_id' =>$coupon['id'],
                        'user_id' =>$user['id'],
                        'username' =>$user['username'],
                    ];
                    $res = \think\Db::table("pml_usercoupon")->insert($coupondata);
                    if($res) \think\Db::table("pml_usercoupon")->rollback();
                }
                //注册发放优惠券
                $udata = [
                    'coupon_id' =>$coupon['id'],
                    'user_id' =>$data['userinfo']['user_id'],
                    'username' =>$data['userinfo']['username'],
                ];
                $res = \think\Db::table("pml_usercoupon")->insert($udata);
                if($res) \think\Db::table("pml_usercoupon")->rollback();
            }
           
            $this->success(__('Sign up successful'), $data);
        }
        else
        {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 优惠券列表
     */
    public function coupon_list(){
        $page = $this->request->request('page');
        //销毁到期优惠券
        $coupon = \think\Db::table("pml_coupon")->where('type',1)->field('id')->whereTime('endtime', '<',date('Y-m-d', time()))->select();
        foreach ($coupon as $val){
            //用户优惠券
            \think\Db::table("pml_usercoupon")->where('coupon_id',$val['id'])->where('status',0)->delete();
        }
        $coupon_list = \think\Db::table("pml_coupon")
        ->field('id, price, num, endtime, amount')
        ->where('type',1)
        ->where('endtime', '>',date('Y-m-d', time()))
        ->page($page, '10')
        ->select();
        $this->success(__('Operation completed'), $coupon_list);

    }
    /**
     * 领取优惠券
     */
    public function get_coupon(){
        $token = $this->request->request('token');
        $coupon_id = $this->request->request('coupon_id');
        //用户信息
        $user =\app\common\library\Token::get($token);

        if(!$coupon_id)
        {
            $this->error(__('Invalid parameters'));
        }
        //是否领取
        $res = \think\Db::table("pml_usercoupon")->where(['coupon_id'=>$coupon_id,'user_id'=>$user['user_id']])->find();
        if($res)$this->error(__('Coupon repeat'));
        $coupon = \think\Db::table("pml_coupon")->where('id', $coupon_id)->find();
        
        //判断红包类型和数量
        if($coupon['type'] == 1&& $coupon['num'] <= 0){
            $this->error(__('Coupon not enough'));
        }
        $data = [
            'coupon_id' =>$coupon['id'],
            'user_id' =>$user['user_id'],
            'username' =>read_table_filed("pml_user", "username", ['id'=>$user['user_id']]),
        ];
        $res = \think\Db::table("pml_usercoupon")->insert($data);
        if($res) \think\Db::table("pml_usercoupon")->rollback();
        \think\Db::table("pml_coupon")->where('id', $coupon_id)->setDec('num');
        $this->success(__('Receive successful'));
    }
    
    /**
     * 我的优惠券
     */
    public function get_user_coupon(){
        $token = $this->request->request('token');
        $page = $this->request->request('page');
        //用户信息
        $user =\app\common\library\Token::get($token);
        $data = \think\Db::table("pml_usercoupon")
        ->alias('a')
        ->field('a.coupon_id, b.type, b.price, a.status,b.endtime, b.amount')
        ->join('pml_coupon b','a.coupon_id = b.id')
        ->where('a.user_id',$user['user_id'])
        ->whereOr('endtime', '>', date('Y-m-d',time()))
        ->page($page, '10')
        ->group('a.coupon_id')
        ->select();
        $this->success(__('Operation completed'), $data);
    }
    
    /**
     * 取得用户信息
     */
    public function get_userinfo(){
        $user = $this->auth->getUserinfo();

        $this->success(__('Operation completed'), $user);
    }
    
    /**
     * 注销登录
     */
    public function logout()
    {
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }

    /**
     * 修改会员个人信息
     * 
     * @param string $avatar 头像地址
     * @param string $username 用户名
     * @param string $nickname 昵称
     * @param string $bio 个人简介
     */
    public function profile()
    {
        $user = $this->auth->getUser();

        $username = $this->request->request('username');
        $avatar = $this->request->request('avatar');
        $password = $this->request->request('password');
        $email = $this->request->request('email');

        if($password==''){
            $user->username = $username;
            $user->avatar = $avatar;
            $user->email = $email;
            $user->save();
            // $data = [
            //     'username'=>$username,
            //     'avatar'=>$avatar,
            //     'email'=>$email,
            //     'status'=>1
            // ];
            $this->success(__('Successful'), $user);;
        }
//        print_r($this->auth->pase($password));
        $user->username = $username;
        $user->avatar = $avatar;
        $user->salt=Random::alnum();
        $user->password =$this->auth->pase($password,$user->salt);
        $user->email = $email;

        $user->save();
        // $data = [
        //     'username'=>$username,
        //     'avatar'=>$avatar,
        //     'email'=>$email,
        //     'status'=>2
        // ];
        // $this->auth->logout();
        $this->success(__('Successful'), $user);
    }

    /**
     * 修改邮箱
     * 
     * @param string $email 邮箱
     * @param string $captcha 验证码
     */
    public function changeemail()
    {
        $user = $this->auth->getUser();
        $email = $this->request->post('email');
        $captcha = $this->request->request('captcha');
        if (!$email || !$captcha)
        {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::is($email, "email"))
        {
            $this->error(__('Email is incorrect'));
        }
        if (\app\common\model\User::where('email', $email)->where('id', '<>', $user->id)->find())
        {
            $this->error(__('Email already exists'));
        }
        $result = Ems::check($email, $captcha, 'changeemail');
        if (!$result)
        {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->email = 1;
        $user->verification = $verification;
        $user->email = $email;
        $user->save();

        Ems::flush($email, 'changeemail');
        $this->success(__('Successful'), $user);
    }

    /**
     * 验证手机号
     * @param string $email 手机号
     * @param string $captcha 验证码
     */
    public function checkmobile(){
        $user = $this->auth->getUser();
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');
        $token = $this->request->request('token');
        if (!$mobile || !$captcha)
        {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$"))
        {
            $this->error(__('Mobile is incorrect'));
        }
        if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find())
        {
            $this->error(__('Mobile already exists'));
        }
        $result = Sms::check($mobile, $captcha, 'checkmobile');
        Sms::flush($mobile, 'checkmobile');
        if (!$result)
        {
            $this->error(__('Captcha is incorrect'));
        }
        $this->success();
    }
    
    /**
     * 修改手机号
     * 
     * @param string $email 手机号
     * @param stri  ng $captcha 验证码
     */
    public function changemobile()
    {
        $user = $this->auth->getUser();
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');
        if (!$mobile || !$captcha)
        {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$"))
        {
            $this->error(__('Mobile is incorrect'));
        }
        if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find())
        {
            $this->error(__('Mobile already exists'));
        }
        $result = Sms::check($mobile, $captcha, 'changemobile');
        if (!$result)
        {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->mobile = 1;
        $user->verification = $verification;
        $user->mobile = $mobile;
        $user->save();

        Sms::flush($mobile, 'changemobile');
        $this->success(__('Successful'), 1);
    }

    /**
     * 第三方登录
     * 
     * @param string $platform 平台名称
     * @param string $code Code码
     */
    public function third()
    {
        $url = url('user/index');
        $platform = $this->request->request("platform");
        $code = $this->request->request("code");
        $config = get_addon_config('third');
        if (!$config || !isset($config[$platform]))
        {
            $this->error(__('Invalid parameters'));
        }
        $app = new \addons\third\library\Application($config);
        //通过code换access_token和绑定会员
        $result = $app->{$platform}->getUserInfo(['code' => $code]);
        if ($result)
        {
            $loginret = \addons\third\library\Service::connect($platform, $result);
            if ($loginret)
            {
                $data = [
                    'userinfo'  => $this->auth->getUserinfo(),
                    'thirdinfo' => $result
                ];
                $this->success(__('Logged in successful'), $data);
            }
        }
        $this->error(__('Operation failed'), $url);
    }

    /**
     * 重置密码
     * 
     * @param string $mobile 手机号
     * @param string $newpassword 新密码
     * @param string $captcha 验证码
     */
    public function change_user_info()
    {
        $email = $this->request->request("email");
        $newpassword = $this->request->request("newpassword");
        $avatar = $this->request->request("avatar");
        $token = $this->request->request('token');
        if (!$token)
        {
            $this->error(__('Invalid parameters'));
        }
        //用户信息
        $userdata =\app\common\library\Token::get($token);
        //token是否可用
         if(!\app\common\library\Token::check($token, $userdata['user_id'])){
            $this->error(__('Token is Invalid'));
        } 
        //\app\common\library\Token::delete($token);
        $user = new Model();
        $userdata = $user->find($userdata['user_id']);
        
        if($email)$data['email'] = $email;
        if($avatar)$data['avatar'] = $avatar;
        //保存用户信息
        if($newpassword){
            //模拟一次登录
            $data['password'] =  $this->auth->getEncryptPassword($newpassword, $userdata['salt']);
        }
        $res = $user->save($data,['id'=>$userdata['id']]);
        if($res){
            $data = $this->auth->getUserinfo();
            $this->success(__('Operation completed'), $data);
        }else{
            $this->error($this->auth->getError());
        }
    }
    /**
     * 找回密码
     *
     * @param string $mobile 手机号
     * @param string $newpassword 新密码
     * @param string $captcha 验证码
     */
    public function findpass(){
        $username = $this->request->request('username');
        $mobile = $this->request->request('mobile');
        $password = $this->request->request('password');
        $res = $this->model->where('username="'.$username.'" and mobile="'.$mobile.'"')->find();
        if($res){
            $data['password'] =  $this->auth->getEncryptPassword($password, $res['salt']);
            $info = array(
                'password'=>$data['password'],
            );
            $res_one = $this->model->where('username="'.$username.'" and mobile="'.$mobile.'"')->update($info);
            if($res_one){
                $this->success('修改成功',1);
            }else{
                $this->success('修改失败',0);
            }
        }else{
            $this->success('修改失败', 0);
        }
    }
    /**
    *判断用户存在不存在
     **/
    public function usernames(){
        $username = $this->request->request('username');
        $res = $this->model->where('username="'.$username.'"')->count();
        if($res==1){
            $this->success('用户存在', 1);
        }else{
            $this->success('用户不存在',0);
        }
    }
    /**
     *判断用户下手机号存在不存在
     **/
    public function mobiles(){
        $username = $this->request->request('username');
        $mobile = $this->request->request('mobile');
        $res = $this->model->where('username="'.$username.'" and mobile="'.$mobile.'"')->count();
//        print_r($res);die;
        if($res==1){
            $this->success('用户手机号一致',1);
        }else{
            $this->success('手机号和用户不一致',0);
        }
    }
    /**
     * 新增地址
     */
    public function add_address(){
        $usename = $this->request->request("usename");
        $city = $this->request->request("city");
        $street = $this->request->request("street");
        $mobile = $this->request->request("phone");
        $post_code = $this->request->request("post_code");
        $is_default = $this->request->request("is_default");
        $data = $this->request->request();
        $token = $this->request->request('token');
        unset($data['token']);
//        if (!$usename || !$city || !$street || !$mobile)
//        {
//            $this->error(__('Invalid parameters'));
//        }
        //用户信息
        $userdata =\app\common\library\Token::get($token);

        //计算地址数量是否超过五个
        if( \think\Db::table("pml_user_address")->where(['user_id'=>$userdata['user_id']])->count() >= 5){
            $this->error(__("Address num 5"));
        }

        //判断是否默认地址是修改原默认地址
        if($is_default){
            $address = \think\Db::table("pml_user_address")
            ->where(['user_id'=>$userdata['user_id'],'is_default'=>1])
            ->setField('is_default',0);
        }

        $data['user_id'] = $userdata['user_id'];
        unset($data['s']);

        if(\think\Db::table("pml_user_address")->insert($data)){

            $this->success(__('Operation completed'));
        }else{
            $this->error($this->auth->getError());
        }
    }
    
    /**
     * 编辑用户地址
     */
    public function edit_address(){
        $data = $this->request->request();
        $token = $this->request->request('token');
        unset($data['token']);
        //用户信息
        $userdata =\app\common\library\Token::get($token);
        //判断是否默认地址是修改原默认地址
        if($data['is_default']){
            $address = \think\Db::table("pml_user_address")
            ->where(['user_id'=>$userdata['user_id'],'is_default'=>1])
            ->setField('is_default',0);
        }
        unset($data['s']);
        \think\Db::table("pml_user_address")->update($data);
        $this->success(__('Operation completed'));
    }
    
    /**
     * 删除用户地址
     */
    public function del_user_address(){
        $id = $this->request->request('id');
        $token = $this->request->request('token');
        //用户信息
        $userdata =\app\common\library\Token::get($token);
        //判断是否是默认地址
        if(\think\Db::table("pml_user_address")->where(['id'=>$id,'is_default'=>1])->find()){
            $this->error(__("Is default"));
        }
        \think\Db::table("pml_user_address")->where(['id'=>$id])->delete();
        $this->success(__('Operation completed'));
    }
    
    /**
     * 取得用户的地址
     */
    public function get_user_address(){
        $token = $this->request->request('token');
        //用户信息
        $userdata =\app\common\library\Token::get($token);
        $data = \think\Db::table("pml_user_address")->where(['user_id'=>$userdata['user_id']])->order('is_default desc')->select();
        $this->success(__('Operation completed'), $data);
    }
    
    
    
    
    
    
    
    
    
}
