<?php
namespace Admin\Model;
use Think\Model;

class  Admin_inforModel extends Model {
    protected $fields=array(
        'id','web_name','key_word','description','copy',
        '_pk'=>'id','_autoinc'=>true
    );
}
