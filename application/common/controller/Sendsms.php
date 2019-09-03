<?php
/*
 * 此文件用于验证短信服务API接口，供开发时参考
 * 执行验证前请确保文件为utf-8编码，并替换相应参数为您自己的信息，并取消相关调用的注释
 * 建议验证前先执行Test.php验证PHP环境
 *
 * 2017/11/30
 */

namespace app\common\controller;
use fast\Random;
use app\common\controller\Signaturehelper;
use think\Controller;
use think\Lang;
use think\view\driver\Think;
use fast\Http;

header('Access-Control-Allow-Origin:*');
class Sendsms extends Controller
{
    protected $noNeedRight = '*';
    
    public function _initialize()
    {
        parent::_initialize();
    }
    
    /**
     * 手机验证码
     */
    public function code($phone){
        $code['code'] = Random::numeric(6);
        $code['time'] = 10*60;
        $code['send_time'] = time();
        return $code['code'];
    }
    
    /**
     * 发送短信
     */
    public function sendsms($phone, $event="register"){
        
        $url = 'http://120.55.197.77:1210/Services/MsgSend.asmx/SendMsg?';
        //取得参数配置
        $sms = config('sms');
        if(empty($sms)){
            return -1;
        }
        $sms['DesNo'] = $phone;
        $sms['Channel'] = 0;
        $data['mobile'] = $phone;
        $data['event'] = $event;
        $data['code'] = $this->code($phone);
        $data['ip'] = $this->request->ip();
        $data['createtime'] = time();
        switch ($event){
            case 'register':
                $sms['Msg'] = "验证码：".$data['code']."该验证码仅用于身份验证，请勿泄露给他人使用【燃图】";
            case 'login':
                $sms['Msg'] = "验证码：".$data['code']."该验证码仅用于身份验证，请勿泄露给他人使用【燃图】";
            case 'pwd':
                $sms['Msg'] = "验证码：".$data['code']."该验证码仅用于身份验证，请勿泄露给他人使用【燃图】";
            case 'changemobile':
                $sms['Msg'] = "验证码：".$data['code']."该验证码仅用于身份验证，请勿泄露给他人使用【燃图】";
            case 'checkmobile':
                $sms['Msg'] = "验证码：".$data['code']."该验证码仅用于身份验证，请勿泄露给他人使用【燃图】";
        }
        \app\common\model\Sms::insert($data);
        $res = 1;
         $res = Http::post($url,$sms);
        return $res >0 ? true : -2;  
    }
    
    /**
     * 发送短信
     */
    public function aliyun($phone) {
        
        $params = array ();
        
        // *** 需用户填写部分 ***
        // fixme 必填：是否启用https
        $security = false;
        
        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "";
        $accessKeySecret = "";
        
        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $phone;
        
        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "";
        
        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "";
        
        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => $code,
            "product" => "dsd"
            );
        
        // fixme 可选: 设置发送短信流水号
        $params['OutId'] = "12345";
        
        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";
        
        
        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new Signaturehelper();
        
        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            )),
            $security
            );
        return $content;
    }
    
    /**
     * 校验验证码
     */
    public function check_code($phone, $code){
        $data = \think\Db::name("sms")->where(['mobile'=>$phone])->find();
        if(empty($data)) 
            $this->error(__("Code Invalid"));
        
        //时间
        if(time() - $data['createtime'] > 600)
            $this->error(__("Code time Invalid"));
      return $code != $data['code']?false : true;
    }
    
}
