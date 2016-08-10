<?php
namespace Admin\Model;
use Think\Model;

class  Admin_advertModel extends Model {
    protected $fields=array(
        'id','position','xuhao','img_url','title','advert_desc','add_user','add_user_name','add_time',
        '_pk'=>'id','_autoinc'=>true
    );
}
