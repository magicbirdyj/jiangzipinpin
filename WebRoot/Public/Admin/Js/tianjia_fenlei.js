/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#qd').bind('click',function(){
    var cat_name=Trim($(':text[name=cat_name]').val());
    if(cat_name!=''){
        return true;
    }else{
        alert('分类名不能为空');
        return false;
    }
});