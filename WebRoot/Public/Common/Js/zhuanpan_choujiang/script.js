function randomnum(smin, smax) {// 获取2个值之间的随机数
	var Range = smax - smin;
	var Rand = Math.random();
	return (smin + Math.round(Rand * Range));
}

function runzp() {
    
	var data = '[{"id":0,"prize":"首单免费","v":20.0},{"id":15,"prize":"15元代金券","v":30.0},{"id":10,"prize":"10元代金券","v":40.0},{"id":5,"prize":"5元代金券","v":50.0}]';// 奖项json
	var obj = eval('(' + data + ')');
	var result = randomnum(1, 100);
	var index = 0;

	if(result>=1&&result<=10){
            index = 0;
        }else if(result>=11&&result<=20){
            index = 1;
        }else if(result>=21&&result<=40){
            index = 2;
        }else if(result>=41&&result<=100){
            index = 3;
        }
        returnobj = obj[index]; 
	var angle = 330;
	var message = "";
	var myreturn = new Object;
        var r,r0,r1,r2;
		switch (index) {
		case 0:// 首单免费
                    angle0 = [ 343, 378 ];//首单免费
                    angle1 = [ 218, 246 ];//首单免费
                    angle2 = [ 113, 139 ];//首单免费
                    r = randomnum(0, 2);
                    switch (r) {
                    case 0:
			var r0 = randomnum(angle0[0], angle0[1]);
			angle = r0;
			break;
                    case 1:
			var r1 = randomnum(angle1[0], angle1[1]);
			angle = r1;
			break;
                    case 2:
			var r2 = randomnum(angle2[0], angle2[1]);
			angle = r2;
			break;
                    }
                    break;
		case 1:// 十五元代金券
                    angle0 = [ 312, 342 ];//15元
                    angle1 = [ 193, 217 ];//15元
                    angle2 = [ 85, 112 ];//15元
                    r = randomnum(0, 2);
                    switch (r) {
                    case 0:
			var r0 = randomnum(angle0[0], angle0[1]);
			angle = r0;
			break;
                    case 1:
			var r1 = randomnum(angle1[0], angle1[1]);
			angle = r1;
			break;
                    case 2:
			var r2 = randomnum(angle2[0], angle2[1]);
			angle = r2;
			break;
                    }
                    break;
		case 2:// 10元
                    angle0 = [ 277, 310 ];//10元
                    angle1 = [ 166, 192 ];//10元
                    angle2 = [ 52, 84 ];//10元
                    r = randomnum(0, 2);
                    switch (r) {
                    case 0:
			var r0 = randomnum(angle0[0], angle0[1]);
			angle = r0;
			break;
                    case 1:
			var r1 = randomnum(angle1[0], angle1[1]);
			angle = r1;
			break;
                    case 2:
			var r2 = randomnum(angle2[0], angle2[1]);
			angle = r2;
			break;
                    }
			break;
		
                case 3:// 5元
                    angle0 = [ 249, 274 ];// 5元
                    angle1 = [ 143, 164 ];//5元
                    angle2 = [ 19, 48];// 5元
                    r = randomnum(0, 2);
                    switch (r) {
                    case 0:
			var r0 = randomnum(angle0[0], angle0[1]);
			angle = r0;
			break;
                    case 1:
			var r1 = randomnum(angle1[0], angle1[1]);
			angle = r1;
			break;
                    case 2:
			var r2 = randomnum(angle2[0], angle2[1]);
			angle = r2;
			break;
                    }
			break;
		}
		
             
        myreturn.prize = returnobj.prize;
        myreturn.id = returnobj.id;
	myreturn.angle = angle;
	return myreturn;
}