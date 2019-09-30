<?php

namespace App\Logic;

use Illuminate\Support\Facades\Session;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Phone{

    public function send($phone,$param){

        $data = [
            'status'=>1,
            'message'=>'信息发送成功，请查收',
        ];

        $code_json = json_encode($param);
        $key = env('SMS_KEY');
        $value = env('SMS_VALUE');
        $sign = env('SMS_SIGN');
        $template = env('SMS_TEMPLATE_CODE');

        try {

            //短信发送
            AlibabaCloud::accessKeyClient($key, $value)
                ->regionId('cn-hangzhou') // replace regionId as you need
                ->asDefaultClient();

            AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'RegionId' => "default",
                        'PhoneNumbers' => $phone,
                        'SignName' => $sign,
                        'TemplateCode' => $template,
                        'TemplateParam' => $code_json,
                    ],
                ])
                ->request();

        } catch (ClientException $e) {
            $data['status']=0;
            $data['message']=$e->getErrorMessage();
        } catch (ServerException $e) {
            $data['status']=0;
            $data['message']='系统正在出小差中，请联系管理员解决。错误如下：'.$e->getErrorMessage();
        }catch (\Exception $e) {
            $data['status']=0;
            $data['message']=$e->getMessage();
        }
        return $data;
    }
}
