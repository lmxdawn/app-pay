<?php
/**
 * Created by PhpStorm.
 * User: Elvis Lee
 * Date: 2016/12/16
 * Time: 14:51
 */

$postXml = $GLOBALS["HTTP_RAW_POST_DATA"];	//接受通知参数；

if (empty($postXml))
{
    echo "FAIL";
    exit;
}

$xmlTransfer = new \lmxdawn\appPay\wepay\XmlTransfer();
$response = $xmlTransfer->xml2Array($postXml);

if (empty($response['return_code']) || $response['return_code'] != 'SUCCESS') {
    echo "FAIL";
    exit;
}

$encpt = new \lmxdawn\appPay\wepay\WeEncryption();
$data = array(
    "appid"				=>	$response["appid"],
    "mch_id"			=>	$response["mch_id"],
    "nonce_str"			=>	$response["nonce_str"],
    "result_code"		=>	$response["result_code"],
    "openid"			=>	$response["openid"],
    "trade_type"		=>	$response["trade_type"],
    "bank_type"			=>	$response["bank_type"],
    "total_fee"			=>	$response["total_fee"],
    "cash_fee"			=>	$response["cash_fee"],
    "transaction_id"	=>	$response["transaction_id"],
    "out_trade_no"		=>	$response["out_trade_no"],
    "time_end"			=>	$response["time_end"]
);
$sign = $encpt->signature($data);
if ($sign == $response["sign"]) { //验签

    // 商户订单号
    $out_trade_no = $response['out_trade_no'];
    //交易金额
    $total_fee = $response['total_fee'] / 100; // 因为微信以分为单位 所以需要转为 元
    //微信开放平台审核通过的应用APPID
    $appid = $response['appid'];
    // 微信支付分配的商户号
    $mch_id = $response['mch_id'];

    // 业务代码

    $reply = array(
        "return_code"   =>  "SUCCESS",
        "return_msg"    =>  "OK"
    );
    $reply = $xmlTransfer->array2XML($reply);
    echo $reply;
    exit;
} else {
    echo "FAIL";
    exit;
}