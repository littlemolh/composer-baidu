<?php

// +----------------------------------------------------------------------
// | Little Mo - Tool [ WE CAN DO IT JUST TIDY UP IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2021 http://ggui.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: littlemo <25362583@qq.com>
// +----------------------------------------------------------------------

namespace littlemo\baidu;

use littlemo\utils\HttpClient;

/**
 * 明镜实名认证方案（H5）
 *
 * @description
 * @example
 * @author LittleMo 25362583@qq.com
 * @since 2021-11-05
 * @version 2021-11-05
 */
class Face extends  Base
{

    /**
     * 设置方案ID
     *
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-05
     * @version 2021-11-05
     * @param string $planId    方案的id信息，请在人脸实名认证控制台查看创建的H5方案的方案ID信息
     */
    public function setPlanid($planId)
    {
        $this->planId = $planId;
    }

    /**
     * 获取verify_token接口
     * 
     * 文档https://ai.baidu.com/ai-doc/FACE/Bk8k29mmq#1%E3%80%81%E8%8E%B7%E5%8F%96verify_token%E6%8E%A5%E5%8F%A3
     * 
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-08-16
     * @version 2021-08-16
     * @param string    $access_token   通过API Key和Secret Key获取的access_token
     * @return void
     */
    protected function verify_token($access_token = '')
    {

        $url = 'https://aip.baidubce.com/rpc/2.0/brain/solution/faceprint/verifyToken/generate';
        $params = [
            'access_token' => $access_token, //通过API Key和Secret Key获取的access_token
        ];
        $data = [
            'plan_id' => $this->planId, //方案的id信息，请在人脸实名认证控制台查看创建的H5方案的方案ID信息
        ];
        return $this->init_result((new HttpClient)->post($url, json_encode($data), $params,  ['Content-Type' => 'application/json']));
    }

    /**
     * 指定用户信息上报接口
     *
     * @description 
     * @ApiSummary (本接口用于，前端在方案中选择身份信息录入-身份信息录入方式-指定用户身份核验时，需要先调用此接口输入指定用户的姓名+身份证号信息，再请求url跳转页面。)
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-08-16
     * @version 2021-08-16
     * @ApiMethod (POST)
     * @param string $verify_token      verify_token
     * @param string $id_name           指定输入用户的姓名信息
     * @param int    $id_no             指定输入用户的身份证件号信息
     * @param int    $certificate_type  证件类型：0大陆居民二代身份证，1港澳台居民来往内地通行证，2外国人永久居留证，3定居国外的中国公民护照
     * @return void
     */
    public function idcard($verify_token, $id_name = '', $id_no = '', $certificate_type = 0)
    {

        $api = 'https://brain.baidu.com/solution/faceprint/idcard/submit';

        $body =  [
            "verify_token" => $verify_token,
            "id_name" => $id_name,
            "id_no" => $id_no,
            "certificate_type" => $certificate_type
        ];

        return $this->init_result((new HttpClient())->post($api, json_encode($body), [],  ['Content-Type' => 'application/json']));
    }

    /**
     * 获取认证url
     *
     * @description
     * @ApiSummary (业务H5网页通过获取Token接口返回的verify_token信息请求认证H5页面，进行用户端流程操作。)
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-08-16
     * @version 2021-08-16
     * @ApiMethod (POST)
     * @param string $verify_token     verify_token
     * @param string $success_url      请求成功跳转的网址，网址需要加http/https前缀
     * @param int    $failed_url       请求失败跳转的网址，网址需要加http/https前缀
     * @return void
     */
    public function url($verify_token, $success_url = '', $failed_url = '')
    {

        $url = 'https://brain.baidu.com/face/print/';

        $params = [
            'token' => $verify_token,
            'successUrl' => $success_url,
            'failedUrl' => $failed_url,
        ];

        return (new HttpClient())->buildUrl($url, $params);
    }


    /**
     * 获取认证人脸接口
     * 
     * 文档：https://ai.baidu.com/ai-doc/FACE/Bk8k29mmq#1%E8%8E%B7%E5%8F%96%E8%AE%A4%E8%AF%81%E4%BA%BA%E8%84%B8%E6%8E%A5%E5%8F%A3
     * 
     * @description 本接口返回进行人脸实名认证过程中进行认证的最终采集的人脸信息（仅在认证成功时返回人脸信息，认证失败返回错误码）。
     * @description 根据Verify_token返回的结果信息会在云端保留两个小时，您可根据需要在此期间进行调取查询。
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-08-16
     * @version 2021-08-16
     * @param string $access_token      通过API Key和Secret Key获取的access_token
     * @param string $token             verify_token
     * @return void
     */
    public function result_simple($access_token, $verify_token)
    {
        $api = 'https://aip.baidubce.com/rpc/2.0/brain/solution/faceprint/result/simple';

        $params = ['access_token' => $access_token];

        $body = ["verify_token" => $verify_token];

        return (new HttpClient())->post($api, json_encode($body), $params,  ['Content-Type' => 'application/json']);
    }

    /**
     * 查询认证结果接口
     * 
     * 文档：https://ai.baidu.com/ai-doc/FACE/Bk8k29mmq#2%E6%9F%A5%E8%AF%A2%E8%AE%A4%E8%AF%81%E7%BB%93%E6%9E%9C%E6%8E%A5%E5%8F%A3
     * 
     * @description 本接口为请求返回的认证结果信息查询，包含身份证OCR识别信息、用户二次确认的身份证信息，活体检测信息、及用户对权威数据源图片进行比对的分数信息。
     * @description （仅在认证成功时返回上述信息，认证失败返回错误码）根据Verify_token返回的结果信息会在云端保留三天，您可根据需要在此期间进行调取查询。
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-08-16
     * @version 2021-08-16
     * @param string $access_token          通过API Key和Secret Key获取的access_token
     * @param string $verify_token          verify_token
     * @return void
     */
    public function result_detail($access_token, $verify_token)
    {
        $api = 'https://aip.baidubce.com/rpc/2.0/brain/solution/faceprint/result/detail';

        $params = ['access_token' => $access_token];

        $body = ["verify_token" => $verify_token];

        return $this->init_result((new HttpClient())->post($api, json_encode($body), $params,  ['Content-Type' => 'application/json']));
    }

    /**
     * 查询统计结果
     * 
     * 文档：https://ai.baidu.com/ai-doc/FACE/Bk8k29mmq#3%E6%9F%A5%E8%AF%A2%E7%BB%9F%E8%AE%A1%E7%BB%93%E6%9E%9C
     * 
     * @description 据Verify_token返回的结果信息会在云端保留三天，您可根据需要在此期间进行调取查询。
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-08-16
     * @version 2021-08-16
     * @param string $access_token          通过API Key和Secret Key获取的access_token
     * @param string $verify_token          verify_token
     * @return void
     */
    public function result_stat($access_token, $verify_token)
    {
        $api = 'https://aip.baidubce.com/rpc/2.0/brain/solution/faceprint/result/stat';

        $params = ['access_token' => $access_token];

        $body = ["verify_token" => $verify_token];

        return $this->init_result((new HttpClient())->post($api, json_encode($body), $params,  ['Content-Type' => 'application/json']));
    }
}
