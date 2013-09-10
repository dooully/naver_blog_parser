<?php


$a	= array("http://blog.naver.com/firstwind88"=>1, "http://blog.naver.com/dmsl6908"=>2, "http://blog.naver.com/kyehdgus11"=>3, "http://blog.naver.com/rebecca80"=>4, "http://blog.naver.com/arch337"=>5,
		"http://blog.naver.com/cpsych86", "http://blog.naver.com/gu_1113", "http://blog.naver.com/ymms0322", "http://blog.naver.com/keunhk", "http://blog.naver.com/hi7355", "http://blog.naver.com/janggangi",
		"http://blog.naver.com/chltmddkek", "http://blog.naver.com/skaksqhk_1", "http://blog.naver.com/jay7river", "http://blog.naver.com/wldms7037", "http://blog.naver.com/hu0321", "http://blog.naver.com/frj85",
		"http://blog.naver.com/hyhs0326", "http://blog.naver.com/everheidi", "http://blog.naver.com/oaoao222");

$b	= array("http://blog.naver.com/jdg707", "http://blog.naver.com/dlwjddk34", "http://blog.naver.com/ohyoochan", "http://blog.naver.com/abcvsxyz", "http://blog.naver.com/a369123", "http://blog.naver.com/loveloo21", "http://blog.naver.com/cauwon00",
		"http://blog.naver.com/binna0913", "http://blog.naver.com/tjswlddl1695", "http://blog.naver.com/m0728l", "http://blog.naver.com/hy0580", "http://blog.naver.com/demonhym", "http://karam0505.blog.me",
		"http://blog.naver.com/firstwind88", "http://blog.naver.com/dmsl6908"=>2, "http://blog.naver.com/kyehdgus11"=>3, "http://blog.naver.com/rebecca80", "http://blog.naver.com/arch337",
		"http://blog.naver.com/cpsych86", "http://blog.naver.com/gu_1113");


//echo $c = implode('',array_intersect($a, $b)); // abcd
print_r(array_intersect_key($a, $b)); // abcd


// print_r(findMostDuplicatedStr(
//  array("http://karam0505.blog.me http://blog.naver.com/firstwind88 http://blog.naver.com/dmsl6908 http://blog.naver.com/kyehdgus11 http://blog.naver.com/rebecca80 http://blog.naver.com/arch337 http://blog.naver.com/cpsych86 http://blog.naver.com/gu_1113 http://blog.naver.com/ymms0322 http://blog.naver.com/keunhk http://blog.naver.com/hi7355 http://blog.naver.com/janggangi 
//  		http://blog.naver.com/chltmddkek http://blog.naver.com/skaksqhk_1 http://blog.naver.com/jay7river http://blog.naver.com/wldms7037 http://blog.naver.com/hu0321 http://blog.naver.com/frj85 
//  		http://blog.naver.com/hyhs0326 http://blog.naver.com/everheidi",
 		
//  		"http://blog.naver.com/firstwind88 http://blog.naver.com/dmsl6908 http://blog.naver.com/kyehdgus11 http://blog.naver.com/rebecca80 http://blog.naver.com/arch337 http://blog.naver.com/cpsych86 http://blog.naver.com/gu_1113 http://blog.naver.com/ymms0322 http://blog.naver.com/keunhk http://blog.naver.com/hi7355 http://blog.naver.com/janggangi
//  		http://blog.naver.com/chltmddkek http://blog.naver.com/skaksqhk_1 http://blog.naver.com/jay7river http://blog.naver.com/wldms7037 http://blog.naver.com/hu0321 http://blog.naver.com/frj85
//  		http://blog.naver.com/hyhs0326 http://blog.naver.com/everheidi http://blog.naver.com/oaoao222" ), "EUC-KR")
// );




//	http://blog.naver.com/NVisitorgp4Ajax.nhn?blogId=$id 를 통해서 오늘 방문자 수를 알아 낼 수 있다.
  
?>