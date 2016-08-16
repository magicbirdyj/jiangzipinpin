var timestamp = (Date.parse(new Date()))/1000;
var  maxtime = created-timestamp;
var timer = setInterval("CountDown()",1000);
function CountDown(){   
    if(maxtime>=0){
        hours=(Math.floor((maxtime/60)/60)<10?'0'+Math.floor((maxtime/60)/60):Math.floor((maxtime/60)/60));
        minutes =  (Math.floor((maxtime/60)%60)<10?'0'+Math.floor((maxtime/60)%60):Math.floor((maxtime/60)%60));
        seconds = (Math.floor(maxtime%60)<10?'0'+Math.floor(maxtime%60):Math.floor(maxtime%60)); 
        $('#hours').html(hours);
        $('#minutes').html(minutes);
        $('#seconds').html(seconds);
        maxtime--;
    }else{
        clearInterval(timer);
        $('#tishi_span').css('display','none');
        $('.time').html('已结束');
        document.URL=location.href;
    }
};