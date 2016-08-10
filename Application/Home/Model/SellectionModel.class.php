<?php
namespace Home\Model;
use Think\Model;

class  SellectionModel extends Model {
    protected $fields=array(
        'sellection_id','user_id','goods_id','add_time',
        '_pk'=>'sellection_id','_autoinc'=>true
    );
}
