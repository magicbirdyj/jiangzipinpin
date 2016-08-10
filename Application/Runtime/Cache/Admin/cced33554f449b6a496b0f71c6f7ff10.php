<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--
<META HTTP-EQUIV="pragma" CONTENT="no-cache" /> 
<META HTTP-EQUIV="Cache-Control" CONTENT="no-store, must-revalidate" /> 
<META HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT" /> 
<META HTTP-EQUIV="expires" CONTENT="0" /> 
-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo ($keywords); ?>" />
<meta name="description" content="<?php echo ($description); ?>" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/public.css"/>
<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script> 
<title><?php echo ($title); ?></title>


 
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/member.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/release_goods.css">
<script src="/Public/Common/Js/jquery.min.js"></script>
<script src="/Public/Common/Js/jquery.form.js"></script> 
<script src="/Public/Common/Js/function.js"></script>
<script src="/Public/Common/Js/kindeditor/kindeditor.js"></script>
<script src="/Public/Common/Js/kindeditor/lang/zh_CN.js"></script>
</head>

<body>
    <div class="release">
        <div class="div1">
            商品编辑：
        </div>
      
        <form name="sv_cont" method="post" action="<?php echo U('Goodsmanage/bianji_check',"goods_id=$goods_id");?>" >
            <div class="tr">
                <div class="tr_td1">商品分类</div>
                <select name="server_content" class="tr_td2 release_select" >
                    <?php if(is_array($arr_sc)): $i = 0; $__LIST__ = $arr_sc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>" <?php echo ($$vo); ?>> <?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <span id="span_select"></span>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <input name="sc_hidden" value="server_content" type="hidden"/>    
        </form>
        
        
        
        <form name="release_goods" method="post" enctype="multipart/form-data" action="<?php echo U('Goodsmanage/bianji_check',"goods_id=$goods_id");?>" onsubmit="editor.sync()">
            <input name="server_content" value="<?php echo ($server_content); ?>" type="hidden"/> 
            <input name="goods_img" value="" type="hidden"/> 
            <input name="goods_zhanshitu" value="" type="hidden"/> 
            <div class="tr">
                <div class="tr_td1">商品标题</div>
                <input name="title" type="text" class="text" value="<?php echo ($goods['goods_name']); ?>"  />
                <span id="info_title"></span>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">商品简介</div>
                <textarea name="goods_jianjie"  class="goods_jianjie" ><?php echo ($goods['goods_jianjie']); ?></textarea>
                <span id="info_jianjie"></span>
            </div>
            <div style="width:600px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">单位重量</div>
                <input name="units" type="text" class="text" value="<?php echo ($goods['units']); ?>"  />
                <span id="info_units"></span>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">发货天数</div>
                    <select name="select_fahuo" class="tr_td2 release_select" >
                        <option value="1" >1天</option>
                        <option value="3" >3天</option>
                        <option value="7" >7天</option>
                    </select>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">成团人数</div>
                    <select name="select_tuan_num" class="tr_td2 release_select" >
                        <option value="2" >2人团</option>
                        <option value="5" >5人团</option>
                        <option value="10" >10人团</option>
                    </select>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            
            <div  class="tr" id="insert_img_one">
                <div class="tr_td1" style="height: 35px;line-height: 35px;">展示图</div>
                <div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src="<?php echo ($goods['goods_img']); ?>" /><a id="a_zhanshitu" title="删除"></a></div>
                <div class="file_jia" id="file_jia_zhanshitu" style="display: none">+</div>                
                <span id="span_zhanshitu"></span>
                <span class="file_tishi">(请上传分辨率为250：250正方形，最高5M)</span>
            </div>

            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
        
        <div  class="tr" id="insert_img">
                <div class="tr_td1" style="height: 35px;line-height: 35px;">商品图<i style="margin-left: 3px;">(<i id="img_count">0</i>/4)</i></div>
                <?php if(is_array($goods['goods_img_qita'])): $i = 0; $__LIST__ = $goods['goods_img_qita'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img goods_shangpintu" src="<?php echo ($vo); ?>" /><a id="a_shangpintu" title="删除"></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="file_jia" id="file_jia">+</div>                
                <span id="span_touxiang"></span>
                <span class="file_tishi">(第一张为250：250正方形，其余请上传分辨率750：400的图片，最高5M)</span>
            </div>

            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            





          
            
            
            <div class="tr">
                <div class="tr_td1">价格</div>
                <input name="price" type="text" class="text price_text" value="<?php echo (intval($goods['price'])); ?>"  />
                <span style="font-size: 14px;">元</span>
                <span id="info_price"></span>
            </div>
            <div class="tr">
                <div class="tr_td1">原价</div>
                <input name="yuan_price" type="text" class="text price_text" value="<?php echo (intval($goods['yuan_price'])); ?>"  />
                <span style="font-size: 14px;">元</span>
                <span id="info_yuan_price"></span>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">团购价</div>
                <input name="tuan_price" type="text" class="text price_text" value="<?php echo (intval($goods['tuan_price'])); ?>"  />
                <span style="font-size: 14px;">元</span>
                <span id="info_tuan_price"></span>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            
            <?php if(is_array($arr_shuxing)): $i = 0; $__LIST__ = $arr_shuxing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="tr">
                <div class="tr_td1"><?php echo ($key); ?></div>
                <select name="shuxing[]" class="tr_td2 release_select" >
                    <?php if(is_array($vo)): foreach($vo as $k=>$value): ?><option value="<?php echo ($value); ?>" <?php if(is_numeric($value)){$a=$key.$value;echo $$a;}else{echo $$value;} ?> > <?php echo ($value); ?></option><?php endforeach; endif; ?>
                </select>
                <span id="span_select"></span>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">参加代金券</div>
                <div class="tr_td2">
                    <input name="radio_daijinquan" type="radio" class="radio" value="1" checked="checked" id="daijinquan_y" />是
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="radio_daijinquan" type="radio" class="radio" value="0" id="daijinquan_n" />否
                    <a href="javascript:void(0)" id="daijinquan_help" style="margin-left: 30px;border: 1px solid #888;padding:1px 5px;font-size: 12px;position: relative;bottom:2px;">查看详情</a>
                </div>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">参加1元购</div>
                    <div class="tr_td2">
                    <input name="radio_1yuangou" type="radio" class="radio" value="1" checked="checked" id="1yuangou_y" />是
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="radio_1yuangou" type="radio" class="radio" value="0"  id="1yuangou_n"/>否
                    <a href="<?php echo U('Company/index','name=daijinquan');?>" id="daijinquan_help" style="margin-left: 30px;border: 1px solid #888;padding:1px 5px;font-size: 12px;position: relative;bottom:2px;">查看详情</a>
                </div>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            <div class="tr">
                <div class="tr_td1">参加抽奖</div>
                    <div class="tr_td2">
                    <input name="radio_choujiang" type="radio" class="radio" value="1" checked="checked" id="choujiang_y" />是
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="radio_choujiang" type="radio" class="radio" value="0" id="choujiang_n" />否
                    <a href="<?php echo U('Company/index','name=daijinquan');?>" id="daijinquan_help" style="margin-left: 30px;border: 1px solid #888;padding:1px 5px;font-size: 12px;position: relative;bottom:2px;">查看详情</a>
                </div>
            </div>
            <div style="width:400px;height:0px;border-top:1px dashed #666;"></div>
            
            <div class="tr">
                <div class="tr_td1">商品描述</div>
            </div>
            <div class="tr">
                <textarea id="content" name="content" style="width:90%;height:300px;visibility:hidden;">
                    <?php echo ($goods['goods_desc']); ?>
                </textarea>
            </div>
            
            
            <a href="javascript:void(0)" id="xiayibu" class="xyb">立刻发布</a>
            <{__TOKEN__}>
        </form>
    </div>
    
<form id = "form_file_jia" enctype="multipart/form-data" action="<?php echo U('Goodsmanage/file_jia','name=file_img&width=43.5&height=23.2');?>" method="get">   
        <input name="file_img" type="file"  style="visibility:hidden; width:0px; height: 0px;"/>
</form>    
<form id = "form_file_jia_zhanshitu" enctype="multipart/form-data" action="<?php echo U('Goodsmanage/file_jia','name=file_img_zhanshitu&width=50&height=50');?>" method="get">   
        <input name="file_img_zhanshitu" type="file"  style="visibility:hidden; width:0px; height: 0px;"/>
</form>

<iframe height="1" frameborder="0" width="1" style="position:absolute;top:0;left:-9999px;" src="<?php echo U('index/menu');?>"></iframe>
<script src="/Public/Home/Js/release_goods.js" type="text/javascript"></script>
<script  type="text/javascript">
    //发货天数选项赋值
    var fahuo_day="<?php echo ($goods['fahuo_day']); ?>";
    $('select[name=select_fahuo]>option[value='+fahuo_day+']').attr('selected','selected');
    //成团人数选项赋值select_tuan_num
    var tuan_number="<?php echo ($goods['tuan_number']); ?>";
    $('select[name=select_tuan_num]>option[value='+tuan_number+']').attr('selected','selected');
    
    //代金券赋值
    if("<?php echo ($goods['daijinquan']); ?>"==='0'){
        $('#daijinquan_y').attr('checked','');
        $('#daijinquan_n').attr('checked','checked');
    }
    //1元购赋值
    if("<?php echo ($goods['1yuangou']); ?>"==='0'){
        $('#1yuangou_y').attr('checked','');
        $('#1yuangou_n').attr('checked','checked');
    }
    //抽奖赋值
    if("<?php echo ($goods['choujiang']); ?>"==='0'){
        $('#choujiang_y').attr('checked','');
        $('#choujiang_n').attr('checked','checked');
    }
   
   
   
   var goods_zhanshitu="<?php echo ($goods[goods_img]); ?>";
   $('input[name=goods_zhanshitu]').attr('value',goods_zhanshitu);
    var goods_img="";
    $('#img_count').html($('.goods_shangpintu').length);
    <?php if(is_array($goods['goods_img_qita'])): $i = 0; $__LIST__ = $goods['goods_img_qita'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>if(goods_img===''){
        goods_img+="<?php echo (substr($vo,1)); ?>";
        }else{
            goods_img+='+img+'+"<?php echo (substr($vo,1)); ?>";
        }<?php endforeach; endif; else: echo "" ;endif; ?>
    $('input[name=goods_img]').attr('value',goods_img);
</script>