// JavaScript Document
window.onload=function(){
var index_this_s=0,index_this_x=0,left_s,right_s;//t是需要轮播图片张数,n记录一张图片走完
var time1,time2;
var body_scrolltop;

        
    start_lunbo();


  

document.getElementById("lunbo_m").onmouseover=function(){lunbo_icon_over('icon');};
document.getElementById("lunbo_m").onmouseout=function(){lunbo_icon_out('icon');};
document.getElementById("icon_r").onclick=function(){huadong_l();};
document.getElementById("icon_l").onclick=function(){huadong_r();};
document.getElementById("lunbo_mx").onmouseover=function(){lunbo_icon_over('iconx');}
document.getElementById("lunbo_mx").onmouseout=function(){lunbo_icon_out('iconx');}
document.getElementById("iconx_l").onclick=function(){huadong_x_r();}
document.getElementById("iconx_r").onclick=function(){huadong_x_l();}

function start_lunbo(){
	time1=setInterval(huadong_l,3000);
        time2=setInterval(huadong_x_l,3000);
	}


function huadong_l(){
	switch(index_this_s){
            case 0:
                left_s='-400%';
                break;
            case 1:
                left_s='-500%';
                break;
            case 2:
                left_s='-300%';
                break;
        }
        $('.lunbo_m').animate({"margin-left":left_s},'normal',function(){
            (index_this_s===2)?index_this_s=0:index_this_s++;
            if(index_this_s===2){
                $('.lunbo_m').css('margin-left','-200%');
            }
        });
    }
function huadong_r(){ 
    switch(index_this_s){
            case 0:
                right_s='-200%';
                break;
            case 2:
                right_s='-100%';
                break;
            case 1:
                right_s='-300%';
                break;
        }
        $('.lunbo_m').animate({"margin-left":right_s},'normal',function(){
            (index_this_s===0)?index_this_s=2:index_this_s--;
            if(index_this_s===1){
                $('.lunbo_m').css('margin-left','-400%');
            }
        });
    }
function lunbo_icon_over(ic1){
	var ic1;
	var obj_l=document.getElementById(ic1+"_l");
	var obj_r=document.getElementById(ic1+"_r");
	obj_l.style.cssText="display:block;";
	obj_r.style.cssText="display:block;";
	ic1==="icon" ? clearInterval(time1) : clearInterval(time2);
	}

function lunbo_icon_out(ic2){
	var ic2;
	var obj_l=document.getElementById(ic2+"_l");
	var obj_r=document.getElementById(ic2+"_r");
	obj_l.style.cssText="display:none;";
	obj_r.style.cssText="display:none;";
	ic2==="icon" ? time1=setInterval(huadong_l,3000) :time2=setInterval(huadong_x_l,3000) ;
	}

	
function huadong_x_l(){
    switch(index_this_x){
            case 0:
                left_x='-300%';
                break;
            case 1:
                left_x='-200%';
                break;
        }
        $('.lunbo_mx').animate({"margin-left":left_x},'normal',function(){
            (index_this_x===1)?index_this_x=0:index_this_x++;
            if(index_this_x===1){
                $('.lunbo_mx').css('margin-left','-100%');
            }
        });
}
function huadong_x_r(){
    switch(index_this_x){
            case 0:
                left_x='-100%';
                break;
            case 1:
                left_x='-0%';
                break;
        }
        $('.lunbo_mx').animate({"margin-left":left_x},'normal',function(){
            (index_this_x===0)?index_this_x=1:index_this_x--;
            if(index_this_x===0){
                $('.lunbo_mx').css('margin-left','-200%');
            }
        });
    }

function gj_l_onscroll(){
	var b=document.documentElement.scrollTop||document.body.scrollTop;
	var a=document.getElementById("a_gj_1").offsetTop,a1=document.getElementById("a_gj_11").offsetTop;
	var c=(window.innerHeight ? window.innerHeight : document.documentElement.clientHeight);

	if(b<(a+30)){
		var str="position:absolute;";
		str+="top:"+(a+80)+"px;";
		document.getElementById("gj_l").style.cssText=str;
	}
	else if(b>=(a1-c)){
		str="position:absolute;";
		str+="top:"+(a1-c+50)+"px;";
		document.getElementById("gj_l").style.cssText=str;
		}
	else{
		str="position:fixed;";
		str+="top:50px;";
		document.getElementById("gj_l").style.cssText=str;
		}
	
	for(var i=1;i<=10;i++){
	if(b>=document.getElementById("a_gj_"+i).offsetTop&&b<document.getElementById("a_gj_"+(i+1)).offsetTop){
		for(var n=1;n<=10;n++){
		document.getElementById("gj_l_"+n).style.cssText="background-color:#FFFFFF;color:#666;";
		}
		document.getElementById("gj_l_"+i).style.cssText="background-color:#03BA8A;color:#FFFFFF;";
		}		
	}
	}


        
        window.onscroll=function(){
	gj_l_onscroll();
	}
};
function a_mouse(obj){
	obj.style.cssText="background-color:#03BA8A;color:#FFFFFF;";
	}
function a_out(obj){
	var obj,obj1,obj2,b,i;
	b=document.documentElement.scrollTop||document.body.scrollTop;
	obj1=document.getElementById(obj.className);
	i=obj.className;
	i=i.charAt(i.length-1);
	i=(i=="0"? "10" : i );
	i=Number(i);
	obj2=document.getElementById("a_gj_"+(i+1));
	if(b<obj1.offsetTop||b>=obj2.offsetTop){obj.style.cssText="background-color:#FFFFFF;color:#666;";}
	}
function click_miaodian(obj){
	var obj,obj1,scrotop,s1=400,s2=100,s3=10;
	obj1=document.getElementById(obj.className);
	var time=setInterval(function (){
	scrotop=document.documentElement.scrollTop||document.body.scrollTop;
	if(obj1.offsetTop-scrotop>=s1){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=s1 : document.body.scrollTop+=s1;
		}
		else if(scrotop-obj1.offsetTop>=s1){
			document.documentElement.scrollTop ? document.documentElement.scrollTop-=s1 : document.body.scrollTop-=s1;
			}
		else if(obj1.offsetTop-scrotop<s1&&obj1.offsetTop-scrotop>=s2){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=s2 : document.body.scrollTop+=s2;
		}
		else if(obj1.offsetTop-scrotop<100&&obj1.offsetTop-scrotop>=10){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=s3 : document.body.scrollTop+=s3;
		}
		else if(obj1.offsetTop-scrotop<10&&obj1.offsetTop-scrotop>0){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=1 : document.body.scrollTop+=1;
		}
		else if(scrotop-obj1.offsetTop<400&&scrotop-obj1.offsetTop>=100){
		document.documentElement.scrollTop ? document.documentElement.scrollTop-=s2 : document.body.scrollTop-=s2;
		}
		else if(scrotop-obj1.offsetTop<100&&scrotop-obj1.offsetTop>=10){
		document.documentElement.scrollTop ? document.documentElement.scrollTop-=s3 : document.body.scrollTop-=s3;
		}
		else if(scrotop-obj1.offsetTop<10&&scrotop-obj1.offsetTop>0){
		document.documentElement.scrollTop ? document.documentElement.scrollTop-=1 : document.body.scrollTop-=1;
		}
		else{
				clearInterval(time);
				}
								   },1);
	return false;
	}
        
       $('.shopping').bind('mouseover',function(){
           $(this).css('border-color','red');
       });
       $('.shopping').bind('mouseout',function(){
           $(this).css('border-color','#DDD');
       });

//右侧广告最后一个取消下边框
$('.lunbo_r .guanggao:last').css('border','none');