<?php
namespace Home\Model;
use Think\Model;

class  Order_actionModel extends Model {
    protected $fields=array(
        'action_id','order_id','action_type','actionuser_id','actionuser_name', 'order_status','pay_status', 'pay_status','action_note','log_time', '_pk'=>'action_id','_autoinc'=>true
    );
}
