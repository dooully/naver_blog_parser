<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php 
$wow  = "http://postfiles4.naver.net/20130712_51/etland21th_1373592503109R7wdd_PNG/%3F%3F%B1%FD.png?type=w2";
//$wow  = "http://postfiles9.naver.net/20130712_152/etland21th_1373594426882erqK4_PNG/1.png?type=w2";

$path = pathinfo($wow);			//파일에 대한 정보를 얻음
$ext = strtolower($path['extension']);		//확장자를 연관배열에서 가져옴, 소문자 변환
$name = basename($wow, strrchr($wow, '.'));

$finaltemp =  str_replace($name.".".$ext, "aa".".".$ext, $wow);




?>
<img src='http://contentworld.co.kr/blogrss/NAVER/get_image.php?p=<?=$finaltemp?>'>

