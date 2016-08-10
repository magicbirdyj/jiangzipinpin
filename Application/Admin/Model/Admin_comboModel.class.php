<?php
namespace Admin\Model;
use Think\Model;

class  Admin_comboModel extends Model {
    protected $fields=array(
        'combo_id','combo_name','combo_jieshao', 'user_id',  'time','content',
        '_pk'=>'combo_id','_autoinc'=>true
    );
}
