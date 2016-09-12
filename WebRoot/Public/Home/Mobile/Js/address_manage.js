//给默认地址
$('.address_ul>li').eq(parseInt(default_eq)).find('.moren_text').css('color','#F90505');
$('.address_ul>li').eq(parseInt(default_eq)).find('.moren_text').html('已设为默认');
$('.address_ul>li').eq(parseInt(default_eq)).find('.tb_moren').css('background-color','#F90505');

var save_or_add;

    
    
    
var arr_province=["请选择省市","北京市","天津市","上海市","重庆市","河北省","山西省","内蒙古","辽宁省","吉林省","黑龙江省","江苏省","浙江省","安徽省","福建省","江西省","山东省","河南省","湖北省","湖南省","广东省","广西","海南省","四川省","贵州省","云南省","西藏","陕西省","甘肃省","青海省","宁夏","新疆"];//,"香港","澳门","台湾省"];
var arr_city=[
["请选择市区"],

["北京市"],

["天津市"],

["上海市"],

["重庆市"],

["石家庄市","唐山市","秦皇岛市","邯郸市","邢台市","保定市","张家口市","承德市","沧州市","廊坊市","衡水市"],

["太原市","大同市","阳泉市","长治市","晋城市","朔州市","晋中市","运城市","忻州市","临汾市","吕梁地区"],

["呼和浩特","包头市","乌海市","赤峰市","通辽市","鄂尔多斯","呼伦贝尔","乌兰察布盟","锡林郭勒盟","巴彦淖尔盟","阿拉善盟","兴安盟"],

["沈阳市","大连市","鞍山市","抚顺市","本溪市","丹东市","锦州市","葫芦岛市","营口市","盘锦市","阜新市","辽阳市","铁岭市","朝阳市"],

["长春市","吉林市","四平市","辽源市","通化市","白山市","松原市","白城市","延边"],

["哈尔滨市","齐齐哈尔","鹤岗市","双鸭山市","鸡西市","大庆市","伊春市","牡丹江市","佳木斯市","七台河市","黑河市","绥化市","大兴安岭"],

["南京市","徐州市","连云港市","淮安市","宿迁市","盐城市","扬州市","泰州市","南通市","镇江市","常州市","无锡市","苏州市"],

["杭州市","宁波市","温州市","嘉兴市","湖州市","绍兴市","金华市","衢州市","舟山市","台州市","丽水市"],

["合肥市","芜湖市","蚌埠市","淮南市","马鞍山市","淮北市","铜陵市","安庆市","黄山市","滁州市","阜阳市","宿州市","巢湖市","六安市","亳州市","池州市","宣城市"],

["福州市","厦门市","三明市","莆田市","泉州市","漳州市","南平市","龙岩市","宁德市"],

["南昌市","景德镇市","萍乡市","九江市","新余市","鹰潭市","赣州市","吉安市","宜春市","抚州市","上饶市"],

["济南市","青岛市","淄博市","枣庄市","东营市","潍坊市","台市","烟威海市","泰安市","日照市","莱芜市","临沂市","德州市","聊城市","滨州市","菏泽市","济宁市"],

["郑州市","开封市","洛阳市","平顶山市","焦作市","鹤壁市","新乡市","安阳市","濮阳市","许昌市","漯河市","三门峡市","南阳市","商丘市","信阳市","周口市","驻马店市"],

["武汉市","黄石市","襄樊市","十堰市","荆州市","宜昌市","荆门市","鄂州市","孝感市","黄冈市","咸宁市","随州市","恩施"],

["长沙市","株洲市","湘潭市","衡阳市","邵阳市","岳阳市","常德市","张家界市","益阳市","郴州市","永州市","怀化市","娄底市","湘西"],

["广州市","深圳市","珠海市","汕头市","韶关市","河源市","梅州市","惠州市","汕尾市","东莞市","中山市","江门市","佛山市","阳江市","湛江市","茂名市","肇庆市","清远市","潮州市","揭阳市","云浮市"],

["南宁市","桂林市","梧州市","北海市","防城港市","钦州市","贵港市","玉林市","百色市","贺州市","河池市","柳州市","来宾市","崇左市"],

["三亚市","海口市"],

["成都市","自贡市","攀枝花市","泸州市","德阳市","绵阳市","广元市","遂宁市","内江市","乐山市","南充市","宜宾市","广安市","达州市","眉山市","雅安市","巴中市","资阳市","阿坝","甘孜","凉山"],

["贵阳市","六盘水市","遵义市","安顺市","铜仁地区","毕节地区","黔西","黔东","黔南"],

["昆明市","曲靖市","玉溪市","保山市","昭通市","思茅地区","临沧地区","丽江市","文山","红河","西双版纳","楚雄","大理","德宏","怒江","迪庆"],

["拉萨市","那曲地区","昌都地区","山南地区","日喀则","阿里地区","林芝地区"],

["西安市","铜川市","宝鸡市","咸阳市","渭南市","延安市","汉中市","榆林市","安康市","商洛市"],

["兰州市","金昌市","白银市","天水市","武威市","张掖市","平凉市","酒泉市","庆阳市","定西地区","陇南地区","甘南","临夏"],

["西宁市","海东地区","海北","黄南","海南","果洛","玉树","海西"],

["银川市","石嘴山市","吴忠市","固原市","中卫市"],

["乌鲁木齐","克拉玛依","吐鲁番","哈密地区","和田地区","阿克苏","喀什地区","克孜勒","巴音郭楞","昌吉","博尔塔拉","伊犁","塔城地区","阿勒泰"]
]
;
var arr_county=[
[["请选择区县"]],
[["东城区","西城区","崇文区","宣武区","朝阳区","丰台区","石景山区","海淀区","门头沟区","房山区","通州区","顺义区","昌平区","大兴区","怀柔区","平谷区","密云县","延庆县","延庆镇"]],
[["和平区","河东区","河西区","南开区","河北区","红桥区","塘沽区","汉沽区","大港区","东丽区","西青区","津南区","北辰区","武清区","宝坻区","蓟县","宁河县","芦台镇","静海县","静海镇"]],
[["黄浦区","卢湾区","徐汇区","长宁区","静安区","普陀区","闸北区","虹口区","杨浦区","闵行区","宝山区","嘉定区","浦东新区","金山区","松江区","青浦区","南汇区","奉贤区","崇明县","城桥镇"]],
[["渝中区","大渡口区","江北区","沙坪坝区","九龙坡区","南岸区","北碚区","万盛区","双桥区","渝北区","巴南区","万州区","涪陵区","黔江区","长寿区","合川市","永川区市","江津市","南川市","綦江县","潼南县","铜梁县","大足县","荣昌县","璧山县","垫江县","武隆县","丰都县","城口县","梁平县","开县","巫溪县","巫山县","奉节县","云阳县","忠县","石柱县","彭水县","酉阳县","秀山县"]],
[["长安区","桥东区","桥西区","新华区","裕华区","井陉矿区","辛集市","藁城市","晋州市","新乐市","鹿泉市","井陉县","正定县","栾城县","行唐县","灵寿县","高邑县","深泽县","赞皇县","无极县","平山县","元氏县","赵县"],["路北区","路南区","古冶区","开平区","丰润区","丰南区","遵化市","迁安市","滦县","滦南县","乐亭县","迁西县","玉田县","唐海县"],["海港区","山海关区","北戴河区","南戴河区","昌黎县","抚宁县","卢龙县","青龙"],["丛台区","邯山区","复兴区","峰峰矿区","武安市","邯郸县","临漳县","成安县","大名县","涉县","磁县","肥乡县","永年县","邱县","鸡泽县","广平县","馆陶县","魏县","曲周县"],["桥东区","桥西区","南宫市","沙河市","邢台县","临城县","内丘县","柏乡县","隆尧县","任县","南和县","宁晋县","巨鹿县","新河县","广宗县","平乡县","威县","清河县","临西县"],["新市区","北市区","南市区","定州市","涿州市","安国市","高碑店市","满城县","清苑县","易县","徐水县","涞源县","定兴县","顺平县","唐县","望都县","涞水县","高阳县","安新县","雄县","容城县","曲阳县","阜平县","博野县","蠡县"],["桥西区","桥东区","宣化区","下花园区","宣化县","张北县","康保县","沽源县","尚义县","蔚县","阳原县","怀安县","万全县","怀来县","涿鹿县","赤城县","崇礼县"],["双桥区","双滦区","鹰手","承德县","兴隆县","平泉县","滦平县","隆化县","丰宁","宽城","围场"],["运河区","新华区","泊头市","任丘市","黄骅市","河间市","沧县","青县","东光县","海兴县","盐山县","肃宁县","南皮县","吴桥县","献县","孟村"],["安次区","广阳区","霸州市","三河市","固安县","永清县","香河县","大城县","文安县","大厂回族自治县"],["桃城区","冀州市","深州市","枣强县","武邑县","武强县","饶阳县","安平县","故城县","景县","阜城县"]],
[["小店区","迎泽区","尖草坪区","万柏林区","晋源区","古交市","清徐县","阳曲县","娄烦县"],["矿区","大同城区","南郊区","新荣区","阳高县","天镇县","广灵县","灵丘县","浑源县","左云县","大同县"],["矿区","阳泉市郊区","平定县","盂县"],["潞城市","长治县","襄垣县","屯留县","平顺县","黎城县","壶关县","长子县","武乡县","沁县","沁源县"],["高平市","沁水县","阳城县","陵川县"],["平鲁区","朔城区","山阴县","应县","右玉县","怀仁县"],["介休市","榆社县","左权县","和顺县","昔阳县","寿阳县","太谷县","祁县","平遥县","灵石县"],["永济市","盐湖区","河津市","芮城县","临猗县","万荣县","新绛县","稷山县","闻喜县","夏县","绛县","平陆县","垣曲县"],["原平市","定襄县","五台县","代县","繁峙县","宁武县","静乐县","神池县","五寨县","岢岚县","河曲县","保德县","偏关县"],["侯马市","霍州市","曲沃县","翼城县","襄汾县","洪洞县","古县","安泽县","浮山县","吉县","乡宁县","蒲县","大宁县","永和县","隰县","尧都区","汾西县"],["孝义市","汾阳市","文水县","中阳县","兴县","临县","方山县","柳林县","岚县","交口县","交城县","石楼县","离石区"]],
[["回民区","新城区","玉泉区","赛罕区","托克托县","武川县","和林格尔","清水河县","土默特左旗"],["昆都仑区","东河区","青山区","石拐区","白云矿区","九原区","固阳县","土默特右旗","达尔罕"],["海勃湾区","乌达区","海南区"],["红山区","元宝山区","松山区","宁城县","林西县","阿鲁科尔沁","巴林左旗","巴林右旗","克什克腾","翁牛特旗","喀喇沁旗","敖汉旗"],["科尔沁区","霍林郭勒","开鲁县","库伦旗","奈曼旗","扎鲁特旗","科尔沁左中","科尔沁左后"],["东胜区","达拉特旗","准格尔旗","鄂托克前旗","鄂托克旗","杭锦旗","乌审旗","伊金霍洛旗"],["海拉尔区","满洲里市","扎兰屯市","牙克石市","根河市","额尔古纳市","阿荣旗","新巴尔虎右","新巴尔虎左","陈巴尔虎旗","鄂伦春","鄂温克族","莫力达瓦达"],["集宁市","丰镇市","卓资县","化德县","商都县","兴和县","凉城县","察哈尔右前","察哈尔右中","察哈尔右后","四子王旗"],["锡林浩特市","二连浩特市","多伦县","阿巴嘎旗","苏尼特左旗","苏尼特右旗","东乌珠","西乌珠","太仆寺旗","镶黄旗","正镶白旗","正蓝旗"],["临河市","五原县","磴口县","乌拉特前旗","乌拉特中旗","乌拉特后旗","杭锦后旗"],["阿拉善左旗","阿拉善右旗","额济纳旗"],["乌兰浩特市","阿尔山市","突泉县","科尔沁右前","科尔沁右中"]],
[["和平区","沈河区","大东区","皇姑区","铁西区","苏家屯区","东陵区","新城子区","于洪区","新民市","辽中县","康平县","法库县"],["西岗区","中山区","沙河口区","甘井子区","旅顺口区","金州区","瓦房店市","普兰店市","庄河市","长海县"],["铁东区","铁西区","立山区","千山区","海城市","台安县","岫岩"],["新抚区","东洲区","望花区","顺城区","抚顺县","新宾","清原"],["平山区","溪湖区","明山区","南芬区","本溪","桓仁"],["振兴区","元宝区","振安区","凤城市","东港市","宽甸"],["太和区","古塔区","凌河区","凌海市","北宁市","黑山县","义县"],["龙港区","连山区","南票区","兴城市","绥中县","建昌县"],["站前区","西市区","鲅鱼圈区","老边区","大石桥市","盖州市"],["双台子区","兴隆台区","大洼县","盘山县"],["海州区","新邱区","太平区","清河门区","细河区","彰武县","阜新"],["白塔区","文圣区","宏伟区","弓长岭区","太子河区","灯塔市","辽阳县"],["银州区","清河区","调兵山市","开原市","铁岭县","西丰县","昌图县"],["双塔区","龙城区","北票市","凌源市","朝阳县","建平县","喀喇沁左翼"]],
[["朝阳区","南关区","宽城区","二道区","绿园区","双阳区","德惠市","九台市","榆树市","农安县"],["船营区","龙潭区","昌邑区","丰满区","磐石市","蛟河市","桦甸市","舒兰市","永吉县"],["铁西区","铁东区","双辽市","公主岭市","梨树县","伊通"],["龙山区","西安区","东丰县","东辽县"],["东昌区","二道江区","梅河口市","集安市","通化县","辉南县","柳河县"],["八道江区","江源区","临江市","江源县","抚松县","靖宇县","长白"],["宁江区","扶余县","长岭县","乾安县","前郭尔罗斯"],["洮北区","大安市","洮南市","镇赉县","通榆县"],["延吉市","图们市","敦化市","珲春市","龙井市","和龙市","汪清县","安图县"]],
[["南岗区","道里区","道外区","松北区","呼兰区","太平区","香坊区","动力区","平房区","双城市","尚志市","五常市","阿城市","呼兰县","依兰县","方正县","宾县","巴彦县","木兰县","通河县","延寿县"],["龙沙区","梅里斯区","建华区","铁峰区","昂昂溪区","富拉尔基区","碾子山区","梅里斯","讷河市","龙江县","依安县","泰来县","甘南县","富裕县","克山县","克东县","拜泉县"],["兴山区","向阳区","工农区","南山区","兴安区","东山区","萝北县","绥滨县"],["尖山区","岭东区","四方台区","宝山区","集贤县","友谊县","宝清县","饶河县"],["鸡冠区","恒山区","滴道区","梨树区","城子河区","麻山区","虎林市","密山市","鸡东县"],["萨尔图区","龙凤区","让胡路区","大同区","红岗区","肇州县","肇源县","林甸县","杜尔伯特"],["伊春区","南岔区","友好区","西林区","翠峦区","新青区","美溪区","金山屯区","五营区","乌马河区","汤旺河区","带岭区","乌伊岭区","红星区","上甘岭区","铁力市","嘉荫县"],["爱民区","东安区","阳明区","西安区","穆棱市","绥芬河市","海林市","宁安市","东宁县","林口县"],["前进区","永红区","向阳区","东风区","佳木斯郊区","同江市","富锦市","桦南县","桦川县","汤原县","抚远县"],["桃山区","新兴区","茄子河区","勃利县"],["爱辉区","北安市","五大连池市","嫩江县","逊克县","孙吴县"],["北林区","安达市","肇东市","海伦市","望奎县","兰西县","青冈县","庆安县","明水县","绥棱县"],["呼玛县","塔河县","漠河县"]],
[["玄武区","白下区","浦口区","六合区","秦淮区","建邺区","鼓楼区","下关区","栖霞区","雨花台区","江宁区","溧水县","高淳县"],["云龙区","鼓楼区","九里区","贾汪区","泉山区","邳州市","新沂市","铜山县","睢宁县","沛县","丰县"],["新浦区","连云区","海州区","赣榆县","灌云县","东海县","灌南县"],["清河区","清浦区","楚州区","淮阴区","金湖县","盱眙县","洪泽县","涟水县"],["宿城区","宿豫县","沭阳县","泗阳县","泗洪县"],["城区","东台市","盐都区","大丰市","盐都县","射阳县","阜宁县","滨海县","响水县","建湖县"],["广陵区","维扬区","邗江区","仪征市","江都市","高邮市","宝应县"],["海陵区","高港区","靖江市","泰兴市","姜堰市","兴化市"],["崇川区","港闸区","海门市","启东市","通州市","如皋市","如东县","海安县"],["京口区","扬中市","润州区","丹徒区","丹阳市","句容市"],["戚墅堰区","钟楼区","天宁区","新北区","武进区","金坛市","溧阳市"],["崇安区","南长区","北塘区","滨湖区","惠山区","锡山区","江阴市","宜兴市"],["金阊区","沧浪区","平江区","虎丘区","吴中区","相城区","吴江市","昆山市","太仓市","常熟市","张家港市"]],
[["拱墅区","上城区","下城区","江干区","西湖区","滨江区","余杭区","萧山区","临安市","富阳市","建德市","桐庐县","淳安县"],["海曙区","江东区","江北区","镇海区","北仑区","鄞州区","余姚市","慈溪市","奉化市","宁海县","象山县"],["鹿城区","龙湾区","瓯海区","瑞安市","乐清市","永嘉县","文成县","平阳县","泰顺县","洞头县","苍南县"],["秀城区","南湖区","秀洲区","海宁市","平湖市","桐乡市","嘉善县","海盐县"],["长兴县","南浔区","德清县","安吉县"],["越城区","诸暨市","上虞市","嵊州市","绍兴县","新昌县"],["婺城区","金东区","兰溪市","永康市","义乌市","东阳市","武义县","浦江县","磐安县"],["柯城区","衢江区","江山市","常山县","开化县","龙游县"],["定海区","普陀区","岱山县","嵊泗县"],["椒江区","黄岩区","路桥区","临海市","温岭市","三门县","天台县","仙居县","玉环县"],["莲都区","龙泉市","缙云县","青田县","云和县","遂昌县","松阳县","庆元县","景宁"]],
[["瑶海区","庐阳区","蜀山区","包河区","长丰县","肥东县","肥西县"],["镜湖区","马塘区","新芜区","鸠江区","芜湖县","繁昌县","南陵县"],["中市区","东市区","西市区","蚌埠市郊","怀远县","五河县","固镇县"],["田家庵区","大通区","谢家集区","八公山区","潘集区","凤台县"],["雨山区","花山区","金家庄区","当涂县"],["相山区","杜集区","烈山区","濉溪县"],["铜官山区","狮子山区","铜陵市郊","铜陵县"],["迎江区","大观区","安庆市郊","桐城市","怀宁县","枞阳县","潜山县","太湖县","宿松县","望江县","岳西县"],["屯溪区","黄山区","徽州区","歙县","休宁县","黟县","祁门县"],["琅琊区","南谯区","明光市","天长市","来安县","全椒县","定远县","凤阳县"],["颖州区","颖东区","颖泉区","颍上县","界首市","临泉县","太和县","阜南县","颖上县"],["埇桥区","砀山县","萧县","灵璧县","泗县"],["居巢区","庐江县","无为县","含山县","和县"],["金安区","裕安区","寿县","霍邱县","舒城县","金寨县","霍山县"],["谯城区","涡阳县","蒙城县","利辛县"],["贵池区","东至县","石台县","青阳县"],["宣州区","宁国市","郎溪县","广德县","泾县","旌德县","绩溪县"]],
[["台江区","鼓楼区","仓山区","马尾区","晋安区","福清市","长乐市","闽侯县","连江县","罗源县","闽清县","永泰县","平潭县"],["鼓浪屿区","海沧区","思明区","杏林区","湖里区","集美区","同安区"],["三元区","永安市","明溪县","清流县","宁化县","大田县","尤溪县","沙县","将乐县","泰宁县","建宁县"],["丰泽区","洛江区","泉港区","石狮市","晋江市","南安市","惠安县","安溪县","永春县","德化县"],["龙文区","龙海市","云霄县","漳浦县","诏安县","长泰县","东山县","南靖县","平和县","华安县"],["邵武市","武夷山市","建瓯市","建阳市","顺昌县","浦城县","光泽县","松溪县","政和县"],["漳平市","长汀县","新罗区","永定县","上杭县","武平县","连城县"],["福安市","福鼎市","寿宁县","霞浦县","柘荣县","屏南县","古田县","周宁县"],["涵江区","城厢区","仙游县","荔城区"]],
[["西湖区","东湖区","青云谱区","湾里区","青山湖区","南昌县","新建县","安义县","进贤县"],["昌江区","乐平市","浮梁县"],["湘东区","安源区","莲花县","上栗县","芦溪县"],["庐山区","瑞昌市","九江县","武宁县","修水县","永修县","德安县","星子县","都昌县","湖口县","彭泽县"],["分宜县"],["贵溪市","余江县"],["瑞金市","南康市","赣县","信丰县","大余县","上犹县","崇义县","安远县","龙南县","定南县","全南县","宁都县","于都县","兴国县","会昌县","寻乌县","石城县"],["青原区","井冈山市","吉安县","吉水县","峡江县","新干县","永丰县","泰和县","遂川县","万安县","安福县","永新县"],["丰城市","樟树市","高安市","奉新县","万载县","上高县","宜丰县","靖安县","铜鼓县"],["南城县","临川区","黎川县","南丰县","崇仁县","乐安县","宜黄县","金溪县","资溪县","东乡县","广昌县"],["德兴市","上饶县","广丰县","玉山县","铅山县","横峰县","弋阳县","余干县","波阳县","万年县","婺源县"]],
[["市中区","历下区","槐荫区","天桥区","历城区","长清区","章丘市","平阴县","济阳县","商河县"],["市南区","市北区","四方区","黄岛区","崂山区","城阳区","李沧区","胶州市","即墨市","平度市","胶南市","莱西市"],["张店区","淄川区","博山区","临淄区","周村区","桓台县","高青县","沂源县"],["市中区","薛城区","峄城区","台儿庄区","山亭区","滕州市"],["东营区","河口区","垦利县","利津县","广饶县"],["潍城区","寒亭区","坊子区","奎文区","安丘市","昌邑市","高密市","青州市","诸城市","寿光市","临朐县","昌乐县"],["芝罘区","福山区","莱山区","牟平区","栖霞市","海阳市","龙口市","莱阳市","莱州市","蓬莱市","招远市","长岛县"],["环翠区","荣成市","乳山市","文登市"],["泰山区","岱岳区","新泰市","肥城市","宁阳县","东平县"],["东港区","岚山区","五莲县","莒县"],["莱城区","钢城区"],["兰山区","罗庄区","河东区","郯城县","苍山县","莒南县","沂水县","蒙阴县","平邑县","费县","沂南县","临沭县"],["德城区","乐陵市","禹城市","陵县","平原县","夏津县","武城县","齐河县","临邑县","宁津县","庆云县"],["东昌府区","临清市","阳谷县","莘县","茌平县","东阿县","冠县","高唐县"],["滨城区","惠民县","阳信县","无棣县","沾化县","博兴县","邹平县"],["牡丹区","曹县","定陶县","成武县","单县","巨野县","郓城县","鄄城县","东明县"],["曲阜市","微山县","梁山县","邹城市","汶上县","嘉祥县"]],
[["中原区","二七区","惠济区","管城","金水区","上街区","邙山区","新郑市","登封市","新密市","巩义市","荥阳市","中牟县"],["鼓楼区","龙亭区","顺河","南关区","开封市郊区","杞县","通许县","尉氏县","开封县","兰考县"],["西工区","老城区","瀍河","涧西区","吉利区","洛龙区","偃师市","孟津县","新安县","栾川县","嵩县","汝阳县","宜阳县","洛宁县","伊川县"],["新华区","卫东区","湛河区","石龙区","舞钢市","汝州市","宝丰县","叶县","鲁山县","郏县"],["山阳区","解放区","中站区","马村区","孟州市","沁阳市","修武县","博爱县","武陟县","温县"],["淇滨区","山城区","鹤山区","浚县","淇县"],["新华区","辉县市","红旗区","北站区","新乡市郊","卫辉市","辉县","新乡县","获嘉县","原阳县","延津县","封丘县","长垣县"],["林州市","北关区","文峰区","殷都区","龙安区","安阳县","汤阴县","滑县","内黄县"],["市区","清丰县","南乐县","范县","台前县","濮阳县"],["魏都区","禹州市","长葛市","许昌县","鄢陵县","襄城县"],["源汇区","临颍县","召陵区","舞阳县","临颖县","郾城县"],["湖滨区","义马市","灵宝市","渑池县","陕县","卢氏县"],["卧龙区","宛城区","邓州市","南召县","方城县","西峡县","镇平县","内乡县","淅川县","社旗县","唐河县","新野县","桐柏县"],["梁园区","睢阳区","永城市","虞城县","民权县","宁陵县","睢县","夏邑县","柘城县"],["浉河区","平桥区","息县","淮滨县","潢川县","光山县","固始县","商城县","罗山县","新县"],["川汇区","项城市","扶沟县","西华县","商水县","太康县","鹿邑县","郸城县","淮阳县","沈丘县"],["驿城区","确山县","泌阳县","遂平县","西平县","上蔡县","汝南县","平舆县","新蔡县","正阳县"]],
[["江岸区","江汉区","硚口区","汉阳区","武昌区","青山区","洪山区","东西湖区","汉南区","蔡甸区","江夏区","黄陂区","新洲区"],["黄石港区","西塞山区","下陆区","铁山区","大冶市","阳新县"],["襄城区","樊城区","襄阳区","老河口市","枣阳市","宜城市","南漳县","谷城县","保康县"],["张湾区","茅箭区","丹江口市","郧县","竹山县","房县","郧西县","竹溪县"],["沙市区","荆州区","石首市","洪湖市","松滋市","江陵县","公安县","监利县"],["西陵区","伍家岗区","点军区","猇亭区","夷陵区","枝江市","宜都市","当阳市","远安县","兴山县","秭归县","长阳土家族自治县","五峰"],["东宝区","掇刀区","钟祥市","沙洋县","京山县"],["鄂城区","梁子湖区","华容区"],["孝南区","应城市","安陆市","汉川市","孝昌县","大悟县","云梦县"],["黄州区","麻城市","武穴市","红安县","罗田县","英山县","浠水县","蕲春县","黄梅县","团风县"],["咸安区","赤壁市","嘉鱼县","通城县","崇阳县","通山县"],["曾都区","广水市"],["恩施市","利川市","建始县","巴东县","宣恩县","咸丰县","来凤县","鹤峰县"]],
[["岳麓区","芙蓉区","天心区","开福区","雨花区","浏阳市","长沙县","望城县","宁乡县"],["天元区","荷塘区","芦淞区","石峰区","醴陵市","株洲县","攸县","茶陵县","炎陵县"],["雨湖区","岳塘区","湘乡市","韶山市","湘潭县"],["雁峰区","珠晖区","石鼓区","蒸湘区","南岳区","常宁市","耒阳市","衡阳县","衡南县","衡山县","衡东县","祁东县"],["大祥区","北塔区","武冈市","邵东县","邵阳县","新邵县","隆回县","洞口县","绥宁县","新宁县","城步"],["岳阳楼区","君山区","云溪区","汨罗市","临湘市","岳阳县","华容县","湘阴县","平江县"],["武陵区","鼎城区","津市","安乡县","汉寿县","澧县","临澧县","桃源县","石门县"],["永定区","武陵源区","慈利县","桑植县"],["赫山区","资阳区","沅江市","南县","桃江县","安化县"],["北湖区","苏仙区","资兴市","桂阳县","永兴县","宜章县","嘉禾县","临武县","汝城县","桂东县","安仁县"],["冷水滩区","芝山区","东安县","道县","宁远县","江永县","蓝山县","新田县","双牌县","祁阳县","江华"],["洪江市","沅陵县","辰溪县","溆浦县","中方县","会同县","麻阳","新晃","芷江","靖州","通道"],["娄星区","冷水江市","涟源市","双峰县","新化县"],["吉首市","泸溪县","凤凰县","花垣县","保靖县","古丈县","永顺县","龙山县","凤凰古城"]],
[["越秀区","海珠区","荔湾区","天河区","白云区","黄埔区","花都区","番禺区","萝岗区","南沙区","从化市","增城市"],["福田区","罗湖区","南山区","盐田区","宝安区","龙岗区","光明新区","坪山新区","龙华新区","大鹏新区"],["香洲区","斗门区","金湾区","横琴新区","万山区","高新区"],["金平区","龙湖区","潮阳区","潮南区","濠江区","澄海区","南澳县"],["南雄","乐昌","浈江区","武江区","曲江区","仁化","乳源","翁源","新丰","始兴"],["辖源城区","东源县","和平县","龙川县","紫金县","连平县"],["梅江区","梅县区","嘉应区","五华","丰顺","大埔","蕉岭","兴宁","平远"],["惠城区","仲恺高新区","惠阳区","大亚湾区","博罗县","惠东县","龙门县"],["城区","陆丰市","海丰县","陆河县"],["莞城","南城","万江","东城"],["石歧区","东区","西区","南区","五桂山区","火炬开发区"],["蓬江区","江海区","新会区","鹤山市","开平市","台山市","恩平市"],["禅城区","南海区","三水区","高明区","顺德区"],["江城区","海陵岛","岗侨管理区"," 阳西","阳东县"],["赤坎区","霞山区","坡头区","麻章区","廉江市","雷州市","吴川市","遂溪县","徐闻县"],["茂南区","茂港区","电白县","高州市","信宜市","化州市"],["端州","鼎湖","高要","四会","广宁","怀集","封开","德庆"],["清城区","清新区","英德市","连州市","佛冈县","阳山县"],["湘桥区","枫溪区","潮安县","饶平县"],["揭东","揭西","惠来","普宁","榕城区","东山区","试验区","梅云"],["云城区","罗定市","新兴县","郁南县","云安县"]],
[["新城区","兴宁区","青秀区","隆安县","邕宁区","城北区","江南区","永新区","邕宁县","武鸣县","宾阳县","上林县","马山县"],["秀峰区","叠彩区","象山区","七星区","雁山区","阳朔县","临桂县","灵川县","全州县","兴安县","永福县","灌阳县","资源县","平乐县","荔浦县","龙胜","恭城"],["万秀区","蝶山区","市郊区","岑溪市","苍梧县","藤县","蒙山县"],["海城区","银海区","铁山港区","合浦县"],["港口区","防城区","东兴市","上思县"],["钦南区","钦北区","灵山县","浦北县"],["港北区","港南区","桂平市","平南县"],["北流市","兴业县","玉州区","容县","陆川县","博白县"],["田阳县","田东县","右江区","平果县","德保县","靖西县","那坡县","凌云县","乐业县","西林县","田林县","隆林"],["昭平县","八步区","钟山县","富川"],["金城江区","宜州市","南丹县","天峨县","凤山县","东兰县","巴马","都安","大化","罗城","环江"],["柳江县","城中区","鱼峰区","柳南区","柳北区","柳城县","鹿寨县","融安县","融水","三江"],["兴宾区","合山市","象州县","武宣县","忻城县","金秀"],["凭祥市","扶绥县","大新县","天等县","宁明县","江州区","龙州县"]],
[["河东","河西"],["秀英区","新华区","振东区","琼山市","琼山区","美兰区"]],
[["青羊区","彭州市","锦江区","金牛区","武侯区","成华区","龙泉驿区","青白江区","新都区","温江区","崇州市","邛崃市","都江堰市","金堂县","双流县","郫县","大邑县","蒲江县","新津县"],["大安区","贡井区","自流井区","沿滩区","荣县","富顺县"],["东区","西区","仁和区","米易县","盐边县"],["江阳区","纳溪区","龙马潭区","泸县","合江县","叙永县","古蔺县"],["旌阳区","什邡市","广汉市","绵竹市","罗江县","中江县"],["涪城区","游仙区","江油市","三台县","盐亭县","安县","梓潼县","北川县","平武县"],["广元市中区","元坝区","朝天区","旺苍县","青川县","剑阁县","苍溪县"],["遂宁市中区","蓬溪县","射洪县","大英县"],["内江市中区","东兴区","威远县","资中县","隆昌县"],["乐山市中区","沙湾区","五通桥区","金口河区","峨眉山市","犍为县","井研县","夹江县","沐川县","峨边","马边"],["顺庆区","高坪区","阆中古城","嘉陵区","阆中市","南部县","营山县","蓬安县","仪陇县","西充县"],["翠屏区","宜宾县","南溪县","江安县","长宁县","高县","筠连县","珙县","兴文县","屏山县"],["广安区","华蓥市","岳池县","武胜县","邻水县"],["通川区","万源市","达县","宣汉县","开江县","大竹县","渠县"],["东坡区","仁寿县","彭山县","洪雅县","丹棱县","青神县"],["雨城区","名山县","荥经县","汉源县","石棉县","天全县","芦山县","宝兴县"],["巴州区","通江县","南江县","平昌县"],["雁江区","简阳市","乐至县","安岳县"],["马尔康县","汶川县","理县","茂县","松潘县","九寨沟县","金川县","小金县","黑水县","壤塘县","阿坝县","若尔盖县","红原县"],["康定县","泸定县","丹巴县","九龙县","雅江县","道孚县","炉霍县","甘孜县","新龙县","德格县","白玉县","石渠县","色达县","理塘县","巴塘县","乡城县","稻城县","得荣县"],["西昌市","盐源县","德昌县","会理县","会东县","宁南县","普格县","布拖县","金阳县","昭觉县","喜德县","冕宁县","越西县","甘洛县","美姑县","雷波县","木里"]],
[["南明区","云岩区","花溪区","乌当区","白云区","小河区","清镇市","开阳县","修文县","息烽县"],["钟山区","盘县","六枝特区","水城县"],["红花岗区","赤水市","仁怀市","遵义县","桐梓县","绥阳县","正安县","凤冈县","湄潭县","余庆县","习水县","道真","务川"],["西秀区","平坝县","普定县","关岭","镇宁","紫云"],["铜仁市","江口县","石阡县","思南县","德江县","玉屏","印江","沿河","松桃","万山特区"],["毕节市","大方县","黔西县","金沙县","织金县","纳雍县","赫章县","威宁"],["兴义市","兴仁县","普安县","晴隆县","贞丰县","望谟县","册亨县","安龙县"],["凯里市","黄平县","施秉县","三穗县","镇远县","岑巩县","天柱县","锦屏县","剑河县","台江县","黎平县","榕江县","从江县","雷山县","麻江县","丹寨县"],["都匀市","福泉市","荔波县","贵定县","瓮安县","独山县","平塘县","罗甸县","长顺县","龙里县","惠水县","三都"]],
[["盘龙区","五华区","官渡区","西山区","东川区","安宁市","呈贡县","晋宁县","富民县","宜良县","嵩明县","石林","禄劝","寻甸"],["麒麟区","宣威市","马龙县","沾益县","罗平县","师宗县","陆良县","会泽县"],["红塔区","江川县","澄江县","通海县","华宁县","易门县","峨山","新平","元江"],["隆阳区","施甸县","腾冲县","龙陵县","昌宁县"],["昭阳区","鲁甸县","巧家县","盐津县","大关县","永善县","绥江县","镇雄县","彝良县","威信县","水富县"],["思茅市","普洱","墨江","景东","景谷","镇沅","江城","孟连","澜沧","西盟"],["临沧县","凤庆县","云县","永德县","镇康县","双江","耿马","沧源"],["丽江","古城区","玉龙县","永胜县","华坪县","宁蒗"],["文山县","砚山县","西畴县","麻栗坡县","马关县","丘北县","广南县","富宁县"],["个旧市","开远市","蒙自县","绿春县","建水县","石屏县","弥勒县","泸西县","元阳县","红河县","金平","河口","屏边"],["景洪市","勐海县","勐腊县"],["楚雄市","双柏县","牟定县","南华县","姚安县","大姚县","永仁县","元谋县","武定县","禄丰县"],["大理市","祥云县","宾川县","弥渡县","永平县","云龙县","洱源县","剑川县","鹤庆县","漾濞","南涧","巍山"],["潞西市","瑞丽市","梁河县","盈江县","陇川县"],["泸水县","福贡县","贡山","兰坪"],["香格里拉","德钦县","维西"]],
[["城关区","林周县","当雄县","尼木县","曲水县","堆龙德庆县","达孜县","墨竹工卡县"],["那曲县","嘉黎县","比如县","聂荣县","安多县","申扎县","索县","班戈县","巴青县","尼玛县"],["昌都县","江达县","贡觉县","类乌齐县","丁青县","察雅县","八宿县","左贡县","芒康县","洛隆县","边坝县"],["乃东县","扎囊县","贡嘎县","桑日县","琼结县","曲松县","措美县","洛扎县","加查县","隆子县","错那县","浪卡子县"],["日喀则市","南木林县","江孜县","定日县","萨迦县","拉孜县","昂仁县","谢通门县","白朗县","仁布县","康马县","定结县","仲巴县","亚东县","吉隆县","聂拉木县","萨嘎县","岗巴县"],["噶尔县","普兰县","札达县","日土县","革吉县","改则县","措勤县"],["林芝县","工布江达县","米林县","墨脱县","波密县","察隅县","朗县"]],
[["莲湖区","新城区","碑林区","灞桥区","未央区","雁塔区","阎良区","临潼区","长安区","蓝田县","周至县","户县","高陵县"],["王益区","印台区","耀州区","宜君县"],["渭滨区","金台区","陈仓区","宝鸡县","凤翔县","岐山县","扶风县","眉县","陇县","千阳县","麟游县","凤县","太白县"],["秦都区","杨凌区","渭城区","兴平市","三原县","泾阳县","乾县","礼泉县","永寿县","彬县","长武县","旬邑县","淳化县","武功县"],["临渭区","华阴市","韩城市","华县","潼关县","大荔县","蒲城县","澄城县","白水县","合阳县","富平县"],["宝塔区","延长县","延川县","子长县","安塞县","志丹县","吴旗县","甘泉县","富县","洛川县","宜川县","黄龙县","黄陵县"],["汉台区","南郑县","城固县","洋县","西乡县","勉县","宁强县","略阳县","镇巴县","留坝县","佛坪县"],["榆阳区","神木县","府谷县","横山县","靖边县","定边县","绥德县","米脂县","佳县","吴堡县","清涧县","子洲县"],["汉滨区","汉阴县","石泉县","宁陕县","紫阳县","岚皋县","平利县","镇坪县","旬阳县","白河县"],["商州区","洛南县","丹凤县","商南县","山阳县","镇安县","柞水县"]],
[["城关区","七里河区","西固区","安宁区","红古区","永登县","皋兰县","榆中县"],["金川区","永昌县"],["白银区","平川区","靖远县","会宁县","景泰县"],["秦城区","北道区","麦积区","清水县","秦安县","甘谷县","武山县","张家川"],["凉州区","民勤县","古浪县","天祝"],["甘州区","民乐县","临泽县","高台县","山丹县","肃南"],["崆峒区","泾川县","灵台县","崇信县","华亭县","庄浪县","静宁县"],["肃州区","玉门市","敦煌市","金塔县","安西县","肃北","阿克塞"],["西峰区","庆城县","环县","华池县","合水县","正宁县","宁县","镇原县"],["定西县","通渭县","临洮县","漳县","岷县","渭源县","陇西县"],["成县","武都县","宕昌县","康县","文县","西和县","礼县","两当县","徽县"],["合作市","临潭县","卓尼县","舟曲县","迭部县","玛曲县","碌曲县","夏河县"],["临夏市","临夏县","康乐县","永靖县","广河县","和政县","东乡族","积石山"]],
[["城中区","城东区","城西区","城北区","大通","湟源县","湟中县"],["平安县","乐都县","民和","互助","化隆","循化"],["海晏县","祁连县","刚察县","门源"],["同仁县","尖扎县","泽库县","河南"],["共和县","同德县","贵德县","兴海县","贵南县"],["玛沁县","班玛县","甘德县","达日县","久治县","玛多县"],["玉树县","杂多县","称多县","治多县","囊谦县","曲麻莱县"],["德令哈市","格尔木市","乌兰县","都兰县","天峻县"]],
[["新城区","西夏区","兴庆区","永宁县","灵武市","贺兰县","银川市郊区"],["石嘴山区","大武口区","惠农区","平罗县","陶乐县","惠农县"],["利通区","青铜峡市","中卫县","中宁县","盐池县","同心县"],["原州区","海原县","西吉县","隆德县","泾源县","彭阳县"],["沙坡头区"]],
[["沙依巴克区","新市区","天山区","达坂城区","乌鲁木齐县","水磨沟区","头屯河区"],["克拉玛依区","独山子区","白碱滩区","乌尔禾区"],["吐鲁番市","鄯善县","托克逊县"],["哈密市","伊吾县","巴里坤"],["和田市","和田县","墨玉县","皮山县","洛浦县","策勒县","于田县","民丰县"],["阿克苏市","温宿县","库车县","沙雅县","新和县","拜城县","乌什县","阿瓦提县","柯坪县"],["喀什市","疏附县","疏勒县","英吉沙县","泽普县","莎车县","叶城县","麦盖提县","岳普湖县","伽师县","巴楚县","塔什库尔干"],["阿克陶县","阿合奇县","乌恰县"],["库尔勒市","轮台县","尉犁县","若羌县","且末县","和静县","和硕县","博湖县","焉耆"],["昌吉市","阜康市","米泉市","呼图壁县","玛纳斯县","奇台县","吉木萨尔县","木垒"],["博乐市","精河县","温泉县"],["奎屯市","伊宁县","霍城县","巩留县","新源县","昭苏县","特克斯县","尼勒克县","察布查尔"],["塔城市","乌苏市","额敏县","沙湾县","托里县","裕民县","和布克赛尔"],["阿勒泰市","布尔津县","富蕴县","福海县","哈巴河县","青河县","吉木乃县"]]
];



var select_province=document.address_form.address_province;
var select_city=document.address_form.address_city;
var select_county=document.address_form.address_county;
var province_index;

select_province.onchange=function (){province_onchange(this.selectedIndex);};
select_city.onchange=function (){city_onchange(this.selectedIndex);};
select_province.length=arr_province.length;
select_city.length=arr_city[0].length;
select_county.length=arr_county[0][0].length;
for(var i=0;i<arr_province.length;i++ ){
	select_province.options[i].text=arr_province[i];
        select_province.options[i].value=arr_province[i];
	}
for(var i=0;i<arr_city[0].length;i++){
	select_city.options[i].text=arr_city[0][i];
        select_city.options[i].value=arr_city[0][i];
	}
for(var i=0;i<arr_county[0][0].length;i++){
	select_county.options[i].text=arr_county[0][0][i];
        select_county.options[i].value=arr_county[0][0][i];
	}
function province_onchange(index){
	//obj.innerHTML="";
	province_index=index;
	select_city.length=0;
	select_city.length=arr_city[index].length;
	for(var i=0;i<arr_city[index].length;i++){
		select_city.options[i].text=arr_city[index][i];
                select_city.options[i].value=arr_city[index][i];
		}
	city_onchange(0);
	}

function city_onchange(index){
	select_county.length=0;
	select_county.length=arr_county[province_index][index].length;
	for(var i=0;i<arr_county[province_index][index].length;i++){
		select_county.options[i].text=arr_county[province_index][index][i];
                select_county.options[i].value=arr_county[province_index][index][i];
		}
	}
//获取共享地址
function onreadyeditAddress(){
    WeixinJSBridge.invoke(  
	'editAddress',
        jsApiParameters,
	function(res){
            if(res.userName){
                var data={
                'open_id':open_id,
                'name': res.userName,
                'mobile':res.telNumber,
                'location':res.proviceFirstStageName+' '+res.addressCitySecondStageName+' '+res.addressCountiesThirdStageName,
                'address':res.addressDetailInfo,
                'id':-1,
                'check':'add'
                };
                save_or_add_address(data); 
            }
                               
        }
    );
}
	
	function calladd(){
        if (typeof WeixinJSBridge == "undefined"){
            if (document.addEventListener){
                document.addEventListener('WeixinJSBridgeReady', onreadyeditAddress, false);
            } else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', onreadyeditAddress);
                document.attachEvent('onWeixinJSBridgeReady', onreadyeditAddress);
            }
        } else{
            onreadyeditAddress();
        }
    }

    //点击设为默认按钮
    $('body').on('click','.edit_left',function(){
        if($(this).children('.moren_text').html()=='设为默认'){
            shezhi_moren($(this).attr('id'));
        }
        $(this).children('.moren_text').css('color','#F90505');
        $(this).children('.moren_text').html('已设为默认');
        $(this).children('.tb_moren').css('background-color','#F90505');
        $(this).parents('li').siblings('li').find('.tb_moren').css('background-color','#FFF');
        $(this).parents('li').siblings('li').find('.moren_text').css('color','#666');
        $(this).parents('li').siblings('li').find('.moren_text').html('设为默认');
        
    });
    
    
    
    //ajax设为默认地址
    function shezhi_moren(id){
        var data={
            'open_id':open_id,
            'item':id,
            'check':'shezhi_moren'
        }
        var url='/Home/Member/shezhi_moren_address';
        $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            data:data
        });
    }
    
    
    //点击编辑
     $('body').on('click','.bianji',function(){
        showOverlay('edit_address_div');
        $('#edit_address_div').css('top',($(window).height()-$('#edit_address_div').height())/2+'px');
        get_this_address($(this).parents('li'));
        var id=$(this).parents('li').attr('id');
        $(':hidden[name=eq]').val(id);
        save_or_add='save';
    });
    
    //点击保存
    $('#save_button').bind('click',function(){
        var address_province=Trim($('select[name=address_province]').val());
        var id=$(':hidden[name=eq]').val();
        var data={
            'open_id':open_id,
            'name': Trim($(":text[name='name']").val()),
            'mobile':Trim($(":text[name='tel']").val()),
            'location':address_province+' '+$('select[name=address_city]').val()+' '+$('select[name=address_county]').val(),
            'address':$(":text[name='address']").val(),
            'id':id,
            'check':save_or_add
        };
        if(data.name==''){
            tishi('tishi1','姓名不能为空','70px');
        }else if(data.mobile==''){
            tishi('tishi1','电话不能为空','70px');
        }else if(!is_shoujihao(data.mobile)){
            tishi('tishi1','手机号不正确');
        }else if(address_province=='请选择省市'){
            tishi('tishi1','请选择省、市、区县','70px');
        }else if(data.address==''){
            tishi('tishi1','街道详细地址不能为空','70px');
        }else{
            save_or_add_address(data);
            hideOverlay('edit_address_div');
        }
        
    });
    
    //获取当前编辑的地址信息 赋值给编辑器
    function get_this_address(obj){
        var name=obj.find('#name').html();
        var tel=obj.find('#tel').html();
        var location=obj.find('#location').html();
        var address=obj.find('#address').html();
        var arr_location=location.split(" ");
        var address_province=arr_location[0];
        var address_city=arr_location[1];
        var address_county=arr_location[2];
        $(":text[name='name']").val(name);
        $(":text[name='tel']").val(tel);
        $(":text[name='tel']").val(tel);
        $(":text[name='address']").val(address);
        $('select[name=address_province]>option[value='+address_province+']').attr('selected','selected');
        province_onchange($('select[name=address_province]').prop('selectedIndex'));
        $('select[name=address_city]>option[value='+address_city+']').attr('selected','selected');
        city_onchange($('select[name=address_city]').prop('selectedIndex'));
        $('select[name=address_county]>option[value='+address_county+']').attr('selected','selected');
    }
    
    // 保存编辑好的地址，写入数据库
    function save_or_add_address(data){
        var url='/Home/Member/save_or_add_address';
        $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            data:data,
            success:function(){
                if(data.check=='save'){
                    var obj=$('.address_ul>li').eq(parseInt(data.id));
                    obj.find('#name').html(data.name);
                    obj.find('#tel').html(data.mobile);
                    obj.find('#location').html(data.location);
                    obj.find('#address').html(data.address);
                }else if(data.check=='add'){
                    var number=$('.address_ul>li').length;
                    var li= "<li id='"+number+"'>";
                    li+="<div class='address_info'><span id='name'>"+data.name+"</span>， <span id='tel'>"+data.mobile+"</span></div>";
                    li+="<div class='address_info border-bottom'><span id='location'>"+data.location+"</span> <span id='address'>"+data.address+"</span></div>";
                    li+="<div class='edit_line'> <div class='edit_left' id='"+number+"'><div class='iconfont tb_moren'>&#xe635;</div><div class='moren_text'>设为默认</div></div>";
                    li+="<div class='edit_right'><div class='bianji'><div class='iconfont tb_bianji'>&#xe638;</div>编辑</div><div class='delete'><div class='iconfont tb_shanchu'>&#xe637;</div>删除</div></div></div></li>";
                    $('.address_ul').append(li);
                }
            }
        });
    }
    

    //保存时出现提示
    function tishi(tishi_id,text,bottom){
        $('#'+tishi_id).html(text);
        $('#'+tishi_id).css('display','block');
        $('#'+tishi_id).css('bottom',bottom);
        setTimeout("$('.fixed_tishi').css('display','none')",3000);
    }
    
    //点击删除
    $('body').on('click','.delete',function(){
        if(window.confirm('确定要删除该地址吗？')){
            var id=$(this).parents('li').attr('id');
            del(id);
        }
        
    });
    
    //删除地址函数
    function del(id){
        var obj=$('.address_ul>li').eq(parseInt(id));
        var data={
            'id':id,
            'open_id':open_id,
            'check':'del_address'
        };
        var url='/Home/Member/delete_address';
        $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            data:data,
            success:function(index){
                window.location.href="/Home/Ajaxnologin/address_tiaozhuan"; 
            }
        });  
    }
    
    
    //手动添加地址
    $('#address_shoudong').bind('click',function(){
        if($('.address_ul>li').length>=6){
            tishi('tishi2','最多添加6个收货地址','200px');
        }else{
            showOverlay('edit_address_div');
            $('#edit_address_div').css('top',($(window).height()-$('#edit_address_div').height())/2+'px');
            save_or_add='add';
        }
    });
    
    
