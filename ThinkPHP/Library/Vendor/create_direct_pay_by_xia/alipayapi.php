<?php

/* *
 * 功能：即时到账交易接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * ************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

require_once("lib/alipay_submit.class.php");

class AlipayOption {

    //支付类型
    private $payment_type = "1";
    //必填，不能修改
    //服务器异步通知页面路径
//    private $notify_url = PAY_HOST . "/create_direct_pay_by_xia/notify_url.php";
    private $notify_url;
    //需http://格式的完整路径，不能加?id=123这类自定义参数
    //页面跳转同步通知页面路径
    private $return_url;
    //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
    //商户订单号
    private $out_trade_no;
    //商户网站订单系统中唯一订单号，必填
    //订单名称
    private $subject;
    //必填
    //付款金额
    var $total_fee;
    //必填
    //订单描述

    private $body;
    //商品展示地址
    private $show_url;
    //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
    //防钓鱼时间戳
    private $anti_phishing_key = "";
    //若要使用请调用类文件submit中的query_timestamp函数
    //客户端的IP地址
    private $exter_invoke_ip = "";
    var $_input_charset;
    var $alipay_config;
    var $parameter;

    //非局域网的外网IP地址，如：221.0.0.1
    function __construct(array $option, $alipay_conf) {

        $this->alipay_config = $alipay_conf;
        $this->alipay_config['cacert'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cacert.pem';
        $this->payment_type = $option["payment_type"] ? $option["payment_type"] : $this->payment_type;
        $this->notify_url = $option["notify_url"] ? $option["notify_url"] : PAY_HOST . "/create_direct_pay_by_xia/notify_url.php";
        $this->return_url = $option["return_url"] ? $option["return_url"] : $this->return_url;
        $this->out_trade_no = $option["out_trade_no"] ? $option["out_trade_no"] : microtime(true) . rand(1000, 9999);
        $this->subject = $option["subject"] ? $option["subject"] : $this->subject;
        $this->total_fee = $option["total_fee"] ? $option["total_fee"] : 0;
        $this->body = $option["body"] ? $option["body"] : 1;
        $this->show_url = $option["show_url"] ? $option["show_url"] : $this->show_url;
        $this->anti_phishing_key = $option["anti_phishing_key"] ? $option["anti_phishing_key"] : $this->anti_phishing_key;
        $this->exter_invoke_ip = $option["exter_invoke_ip"] ? $option["exter_invoke_ip"] : $this->exter_invoke_ip;
        $this->_input_charset = $option["_input_charset"] ? trim(strtolower($option["_input_charset"])) : trim(strtolower($this->alipay_config['input_charset']));

        $this->parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($this->alipay_config['partner']),
            "seller_id"  => trim($this->alipay_config['seller_id']),
            "seller_email"  => trim($this->alipay_config['seller_email']),
            "payment_type" => $this->payment_type,
            "notify_url" => $this->notify_url,
            "return_url" => $this->return_url,
            "out_trade_no" => $this->out_trade_no,
            "subject" => $this->subject,
            "total_fee" => $this->total_fee,
            "body" => $this->body,
            "show_url" => $this->show_url,
            "anti_phishing_key" => $this->anti_phishing_key,
            "exter_invoke_ip" => $this->exter_invoke_ip,
            "_input_charset" => $this->_input_charset
        );
    }

    public function alipaySubmit() {
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($this->parameter, "get", "确认");
        return $html_text;
    }

}
