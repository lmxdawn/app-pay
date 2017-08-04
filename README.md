#  app_pay

APP 支付


## 安装

>composer require lmxdawn/app_pay

## 示例

 * 支付宝
 
    ```php
    // 测试数据开始
    $subject = "iPhone";
    $total_amount = "5688";
    $out_trade_no = "201612172344562";      // 订单号，不超过64位
    // 测试数据结束
    
    // 业务参数
    $bizContentArr = array(
        "timeout_express"       =>  "30m",      // 30分钟 —— 该笔订单允许的最晚付款时间，逾期将关闭交易。该参数数值不接受小数点
        "product_code"		    =>	"QUICK_MSECURITY_PAY",  // 固定值,销售产品码
        "total_amount"          =>  $total_amount,
        "subject"               =>  $subject,
        "out_trade_no"          =>  $out_trade_no,
    );
    
    // 公共参数
    $data = array(
        "charset"               =>  "UTF-8",
        "timestamp"             =>  date("Y-m-d H:i:s",time()),
        "biz_content"           =>  $bizContentArr
    );
    
    $alipay = new lmxdawn\app_pay\alipay\Alipay();
    $sign = $alipay->request($data);
    echo $sign;
    ```
 * 微信
 
    ```php
    // 测试数据开始，由客户端传递
    $body = "iPhone";
    $out_trade_no = "201609241165665169";
    $total_fee = "15";
    $spbill_create_ip = "115.28.95.67";
    // 测试数据结束
    
    $data = array(
        "body"              =>  $body,
        "out_trade_no"      =>  $out_trade_no,
        "total_fee"         =>  $total_fee,
        "spbill_create_ip"  =>  $spbill_create_ip
    );
    
    // 实例化签名类
    $pay = new lmxdawn\app_pay\wepay\WePay();
    $response = $pay->request($data);
    
    // 解析XML数据
    $xml = new lmxdawn\app_pay\wepay\XmlTransfer();
    $response = $xml->xml2Array($response);
    
    if (!empty($response))
    {
        if ("FAIL" == $response["return_code"])
        {
            $ret = array(
                'status'		=>	'FAIL',
                'msg'	        =>	$response["return_msg"]
            );
            echo json_encode($ret);
        }
        else
        {
            if ("SUCCESS" == $response["result_code"]) {
            	$resign = array(
    	            "appid"         =>  $response["appid"],
    	            "partnerid"     =>  $response["mch_id"],
    	            "prepayid"      =>  $response["prepay_id"],
    	            "noncestr"      =>  $response["nonce_str"],
    	            "timestamp"     =>  time(),
    	            "package"       =>  "Sign=WXPay"
    	        );
    	        $encpt = new lmxdawn\app_pay\wepay\WeEncryption();
    	        $sign = $encpt->signature($resign);
    	        $resign["sign"] = $sign;
    	        echo json_encode($resign);
            }
            else
            {
            	$ret = array(
                    'status'		=>	'FAIL',
                    'msg'	        =>	$response["err_code_des"]
                );
            	echo json_encode($ret);
            }
        }
    }
    ```
