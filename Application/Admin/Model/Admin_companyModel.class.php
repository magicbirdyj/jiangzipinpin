<?php
namespace Admin\Model;
use Think\Model;

class  Admin_companyModel extends Model {
    protected $fields=array(
        'id','name','url','text','add_user', 'add_user_name',  'edit_time',
        '_pk'=>'id','_autoinc'=>true
    );
}
