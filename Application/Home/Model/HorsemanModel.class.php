<?php
namespace Home\Model;
use Think\Model;

class  HorsemanModel extends Model {
    protected $fields=array(
        'horseman_id','open_id','mobile_phone', 'horse_man','card_id','email','password','ad_salt','add_time','last_login','last_ip',
        '_pk'=>'horseman_id','_autoinc'=>true
    );
}
