<?php

//z支付宝配置
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者id，以2088开头的16位纯数字

$alipay_config['partner'] = '2088121986917031';
//收款支付宝账号，一般情况下收款账号就是签约账号
$alipay_config['seller_email'] = 'www17each@sina.com';
//安全检验码，以数字和字母组成的32位字符
$alipay_config['key'] = '8blnpivjesfyl0uysd4t78ddx36s6x60';
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
//签名方式 不需修改
$alipay_config['sign_type'] = strtoupper('MD5');
//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset'] = strtolower('utf-8');
//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    =dirname(__FILE__).DIRECTORY_SEPARATOR.'cacert.pem';
//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport'] = 'http';
define("PAY_HOST", "http://" . $_SERVER['HTTP_HOST']);

return array(
	//'配置项'=>'配置值'
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
    'APP_GROUP_LIST'        => 'Home,Admin',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
    'DEFAULT_GROUP'         => 'Home',  // 默认分组
     'URL_MODEL'            =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'TMPL_L_DELIM'=>'<{',//模板左分隔符
    'TMPL_R_DELIM'=>'}>',//模板右分隔符
    'URL_CASE_INSENSITIVE'  => true,  // 默认false 表示URL区分大小写 true则表示不区分大小写
    'DEFAULT_THEME'         =>  'Default',	// 默认模板主题名称
     'URL_HTML_SUFFIX'       =>  'html',  // URL伪静态后缀设置
    'TMPL_PARSE_STRING'     =>array(
        '__PUBLIC_HOME__'   =>'/Public/Home',
        '__PUBLIC_ADMIN__'   =>'/Public/Admin',
        '__PUBLIC_COMMON__'   =>'/Public/Common'
    ),
    'LAYOUT_ON'             =>  true, // 是否启用布局
    'LAYOUT_NAME'           =>  'layout', // 当前布局名称 默认为layout
     /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'qdm11457371_db',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'asd123321',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'm_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
        
    'ALIPAY_CONFIG'=>$alipay_config,
        'PAY_METHOD'=>array(
        1=>array("name"=>"支付宝","id"=>"1","img_url"=>""),
        2=>array("name"=>"微信支付","id"=>"2",'img_url'=>""),
    ),
);