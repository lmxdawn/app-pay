<?php
/**
 * Created by PhpStorm.
 * User: Elvis Lee
 * Date: 2016/12/18
 * Time: 0:25
 */

namespace lmxdawn\appPay;


class Config
{
    /**
     * @var array   配置参数数组
     */
    private static $config = array(

        // 微信支付参数配置
        "WECHAT_APPID"              =>      "", // 绑定支付的APPID
        "WECHAT_MCHID"              =>      "", // 商户号
        "WECHAT_KEY"                =>      "",// 商户支付密钥
        "WECHAT_TRADE_TYPE"         =>      "APP", // 交易类型
        "WECHAT_NOTIFY_URL"         =>      "", // 交易回调地址
        "WECHAT_SSLCERT_PATH"       =>      "/certs/wechat/...", // 证书
        "WECHAT_SSLKEY_PATH"        =>      "/certs/wechat/...", //

        // 支付宝支付参数配置
        "ALI_APPID"                 =>      "",
        "ALI_PID"                   =>      "",
        "ALI_SIGN_TYPE"            =>      "RSA2",// 签名方式
        "ALI_PRIVATE_KEY"           =>      "/certs/ali/", // 私钥
        "ALI_ALIPAY_PUBLIC_KEY"     =>      "/certs/ali/", // 公钥
        "ALI_NOTIFY_URL"            =>      "", // 交易回调
    );

    /**
     * 获取参数配置
     * @param $key
     * @return mixed|void
     */
    public static function getConf($key)
    {
        if (is_string($key))
        {
            return self::$config[$key];
        }
        return "";
    }
}