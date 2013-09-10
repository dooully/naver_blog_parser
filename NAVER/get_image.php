<?
$aa = $_GET["p"];



$path = pathinfo($aa);			//파일에 대한 정보를 얻음
$ext = strtolower($path['extension']);		//확장자를 연관배열에서 가져옴, 소문자 변환
$name = basename($aa, strrchr($aa, '.'));

$aa =  str_replace($name.".".$ext, "aa".".".$ext, $aa);



// echo $aa; 
// $aa =  "http%3A%2F%2Fpostfiles6.naver.net%2F20130501_21%2Fetland21th_1367396052267W4hbE_JPEG%2F%3F%3F%3F%3F%3F.jpg%3Ftype%3Dw2";
$bb = 'http://blog.naver.com' ;
 if($aa) {
  $tUrl = $aa; //가져올 이미지의 주소
  $rUrl = $bb; //Referer
  $path_parts = pathinfo($tUrl);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $tUrl);
  curl_setopt($ch, CURLOPT_REFERER, $rUrl);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322; .NET CLR 3.0.04506.30) '); //브라우저 종류 - Explorer 7.0
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, false);
  $f = curl_exec($ch);
  curl_close($ch);
  
  $len = strlen($f);
    header("Content-type: image/png"); //.jpg 만 지원.. gif, png 등은 $tUrl을 파싱하여 적절히 조치하면 됨..
  header("Content-Disposition: attachment; filename=".$path_parts['basename']); //우클릭으로 저장할 때 bmp 로 저장되는 문제 해결
  header("Content-Transfer-Encoding: binary");
   header("Content-Length: ".$len);
echo $f;

 }
?>

<!--http://postfiles4.naver.net/20130517_35/ateon1_1368719225562HXSIR_JPEG/a.jpg?type=w2-->


