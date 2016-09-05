<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function ismobile(){
    return false;
}

function get_status($status,$pay_status,$tuan_no){
    switch ($status){
        case '1':
            if($pay_status==1&&$tuan_no==0){
                return '待发货';
            }elseif($pay_status==1&&$tuan_no!=0){
                return '等待成团';
            } else{
                return '等待付款';
            };
        case '2':
            if($pay_status==1){
                return '待发货';
            }elseif($pay_status==2){
                return '申请退款';
            }elseif($pay_status==3){
                return '申请换货';
            }elseif($pay_status==4){
                return '退款成功';
            }elseif($pay_status==5){
                return '换货成功';
            };
        case '3':
            return '已发货';
        case '4':
            return '已收货';
        case '5':
            return '已评价';
        case '6':
            return '拼团失败';
        case '7':
            return '取消订单';
    }
}


function get_admin_order($arr_address){
    return '收货人:'.$arr_address['name'].' | 电话:'.$arr_address['mobile'].' | 地址:'.$arr_address['location'].' '.$arr_address['address'];
}

function get_pay_status($pay_status){
    if($pay_status==0){
        return '未付款';
    }elseif($pay_status==1){
        return '已付款';
    }elseif($pay_status==2){
        return '申请退款';
    }elseif($pay_status==3){
        return '退款成功';
    }
}