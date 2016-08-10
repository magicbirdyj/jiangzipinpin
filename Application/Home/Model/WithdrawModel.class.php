<?php
namespace Home\Model;
use Think\Model;

class  WithdrawModel extends Model {
    protected $fields=array(
        'withdraw_id','user_id','account_style','account_number', 'withdraw_money','time','_pk'=>'withdraw_id','_autoinc'=>true
    );
}
