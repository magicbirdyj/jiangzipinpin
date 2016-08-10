<?php
namespace Home\Model;
use Think\Model;

class  GoodsModel extends Model {
    protected $fields=array(
        'goods_id','cat_name','user_name', 'goods_name','goods_jianjie', 'goods_shuxing','click_count','1yuangou','choujiang','units','yuan_price', 'price',
        'tuan_price','tuan_number','fahuo_day', 'shuxing','goods_desc', 'goods_img','goods_img_qita', 'comment_number','buy_number',
        'add_time','sort_order','advert_shop_order','is_delete','score','daijinquan','fabu_name','last_update',
        '_pk'=>'goods_id','_autoinc'=>true
    );
}
