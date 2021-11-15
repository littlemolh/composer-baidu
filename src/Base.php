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
 * Aip Base 基类
 * 
 * @ApiInternal
 */
class Base
{


    /**
     * apiKey
     * @var string
     */
    protected $apiKey = '';


    /**
     * secretKey
     * @var string
     */
    protected $secretKey = '';

    /**
     * plan_id
     * 方案的id信息，人脸实名认证：请在控制台查看创建的H5方案的方案ID信息
     * @var string
     */
    protected $planId = null;

    /**
     * 成功消息
     *
     * @var [type]
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-12
     * @version 2021-11-12
     */
    protected static $message = null;

    /**
     * 错误消息
     *
     * @var [type]
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-12
     * @version 2021-11-12
     */
    protected static $error_msg = null;

    /**
     * 完整的消息
     *
     * @var array
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-12
     * @version 2021-11-12
     */
    protected static $intact_msg = [];

    /**
     * @param string $apiKey
     * @param string $secretKey
     */
    public function _initialize($apiKey, $secretKey, $planId = '')
    {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
        $this->planId = $planId;
    }

    /**
     * 获取Access Token
     * 
     * 文档 https://ai.baidu.com/ai-doc/REFERENCE/Ck3dwjhhu
     * 
     * @description 百度AIP开放平台使用OAuth2.0授权调用开放API，调用API时必须在URL中带上access_token参数
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-09-17
     * @version 2021-09-17
     * @param string    $grant_type     //必须参数，固定为client_credentials；
     * @return void
     */
    protected function access_token($grant_type = 'client_credentials')
    {

        $url = 'https://aip.baidubce.com/oauth/2.0/token';
        $params = [
            'grant_type' => $grant_type, //必须参数，固定为client_credentials；
            'client_id' =>  $this->apiKey, //必须参数，应用的API Key；
            'client_secret' => $this->secretKey, //必须参数，应用的Secret Key；
        ];

        return $this->init_result((new HttpClient)->post($url, [], $params));
    }

    /**
     * 整理接口返回结果
     *
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-12
     * @version 2021-11-12
     * @param [type] $result
     * @return void
     */
    protected function init_result($result, $error_field = 'error', $error_code = '')
    {
        static::$intact_msg[] = $result;

        $content = $result['content'];
        $content =  !empty($content) ? json_decode($content, true) : $content;
        $error_des = $result['error_des'];

        if ($result['code'] === 0 || $content === false) {
            static::$error_msg = $error_des;
            return false;
        } else {
            if ($content[$error_field] !== $error_code) {
                static::$error_msg = $error_des ?: $content;
                return false;
            }
            static::$message = $content;
            return true;
        }
    }

    /**
     * 返回成功消息
     *
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-12
     * @version 2021-11-12
     * @return void
     */
    public function getMessage()
    {
        return self::$message;
    }

    /**
     * 返回失败消息
     *
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-12
     * @version 2021-11-12
     * @return void
     */
    public function getErrorMsg()
    {
        return self::$error_msg;
    }

    /**
     * 返回完整的消息
     *
     * @description
     * @example
     * @author LittleMo 25362583@qq.com
     * @since 2021-11-12
     * @version 2021-11-12
     * @return void
     */
    public function getIntactMsg()
    {
        return self::$intact_msg;
    }
}
