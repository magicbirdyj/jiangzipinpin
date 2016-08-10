<?php
namespace Home\Model;
use Think\Model;

class  CategoryModel extends Model {
    protected $fields=array(
        'cat_id','cat_name','keywords','pid', 'sort_order', 'deleted','shuxing',
        '_pk'=>'cat_id','_autoinc'=>true
    );
}
