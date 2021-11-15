
百度 LittleMo
===============

[![Total Downloads](https://poser.pugx.org/littlemo/baidu/downloads)](https://packagist.org/packages/littlemo/baidu)
[![Latest Stable Version](https://poser.pugx.org/littlemo/baidu/v/stable)](https://packagist.org/packages/littlemo/baidu)
[![Latest Unstable Version](https://poser.pugx.org/littlemo/baidu/v/unstable)](https://packagist.org/packages/littlemo/baidu)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.0-8892BF.svg)](http://www.php.net/)
[![License](https://poser.pugx.org/littlemo/baidu/license)](https://packagist.org/packages/littlemo/baidu)

### 介绍
php常用工具库


### 安装教程

composer.json
```json
{
    "require": {
        "littlemo/baidu": "~1.0.0"
    }
}
```

### 使用说明

#### 公共
===

> 公共部分被所有方法继承，实例化任意类均可调用


```php
use littlemo\baidu\Class;

$Class = new Class($apiKey, $secretKey, $planId );

```
实例化参数
|   参数    |  类型  | 是否必填 | 说明                                                                     |
| :-------: | :----: | :------: | :----------------------------------------------------------------------- |
|  apiKey   | string |    N     | 应用的API Key                                                            |
| secretKey | string |    N     | 应用的Secret Key                                                         |
|  planId   | string |    N     | 方案的id信息，请在（人脸实名认证）控制台查看创建的（H5）方案的方案ID信息 |

#### 获取Access Token

> 百度AIP开放平台使用OAuth2.0授权调用开放API，调用API时必须在URL中带上access_token参数


##### 示例代码


```php
use littlemo\wechat\Class;

$Class = new Class($apiKey, $secretKey);

$result = $Class->access_token();

if ($result) {
    echo '获取Access token成功';
    $token = $Class->getMessage();
} else {
    echo "获取Access token失败";
    $errorMsg = $Class->getErrorMsg();
}

//查询完整的回调消息
$intactMsg = $Class->getIntactMsg();


```

**返回示例**
```json
{
  "refresh_token": "25.b55fe1d287227ca97aab219bb249b8ab.315360000.1798284651.282335-8574074",
  "expires_in": 2592000,
  "scope": "public wise_adapt",
  "session_key": "9mzdDZXu3dENdFZQurfg0Vz8slgSgvvOAUebNFzyzcpQ5EnbxbF+hfG9DQkpUVQdh4p6HbQcAiz5RmuBAja1JJGgIdJI",
  "access_token": "24.6c5e1ff107f0e8bcef8c46d3424a0e78.2592000.1485516651.282335-8574074",
  "session_secret": "dfac94a3489fe9fca7c3221cbf7525ff"
}
```

> [官方文档](https://ai.baidu.com/ai-doc/REFERENCE/Ck3dwjhhu)



#### 明镜实名认证方案（H5）

> 整理中...


### 参与贡献

1.  littlemo


### 特技

- 统一、精简
