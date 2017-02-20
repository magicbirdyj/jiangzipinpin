<?php
namespace Home\Model;
use Think\Model;

class  NewsModel extends Model {
    protected $fields=array(
        'news_id','news_name','img','news_content','read_count','sort_order','fabu_open_id','is_deleted','created','updata',
        '_pk'=>'news_id','_autoinc'=>true
    );
}
