<?php
/**
 * Created by PhpStorm.
 * User: Elvis Lee
 * Date: 2016/12/19
 * Time: 16:17
 */
header("Content-type:text/html;charset=utf8");

$response = $_POST;	//接受通知参数
if (!empty($response)) {
    echo "fail";	//请不要修改或删除
}

// 实例化支付宝支付类
$alipay = new \lmxdawn\appPay\alipay\Alipay();
// 验证结果
$result = $alipay->verify($response);

if(!$result) {
    //验证失败
    echo "fail";	//请不要修改或删除
}

//验证成功

//商户订单号
$out_trade_no = $_POST['out_trade_no'];

//支付宝交易号
$trade_no = $_POST['trade_no'];

//交易状态
$trade_status = $_POST['trade_status'];

//价格
$total_amount = $_POST['total_amount'];

//卖家支付宝用户号
$seller_id = $_POST['seller_id'];

//支付宝分配给开发者的应用Id
$app_id = $_POST['app_id'];


if($trade_status == 'TRADE_FINISHED') {

    //判断该笔订单是否在商户网站中已经做过处理
    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
    //如果有做过处理，不执行商户的业务程序

    //注意：
    //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
} else if ($trade_status == 'TRADE_SUCCESS') {
    //判断该笔订单是否在商户网站中已经做过处理
    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
    //如果有做过处理，不执行商户的业务程序
    //注意：
    //付款完成后，支付宝系统发送该交易状态通知

    $order = []; // 查询出来的订单信息
    // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
    // 2、判断该笔订单是否在商户网站中已经做过处理
    // 3、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
    // 4、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email），
    // 5、验证app_id是否为该商户本身
    if (!empty($order) && $order['status'] == 0 && $order['price'] == $total_amount && $seller_id == '2088721361501996' && $app_id == \lmxdawn\appPay\Config::getConf('ALI_APPID')){
        // 业务处理

    }

}
echo "success";		//请不要修改或删除