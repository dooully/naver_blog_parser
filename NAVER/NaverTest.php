<html>
<head>
<title></title>
<meta http-equiv="content-Type" content="text/html" charset="utf-8">
<script type="text/javascript" src="../js/LayoutTopCommon-1038171.js"></script>
</head>
<body>

<?php 
	include_once 'CNaverBlog.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/SRC/CDB.php';
?>


<?php 
class CBlogVisiterDB{
	function insert_blog_visiter($bv_option, $Storage)
	{
		
		$sql	= "select * from blog_visiter order by bv_no asc limit 1";
		$result	= CDB::query($sql);
		$data	= CDB::Fetch_Array($result);		
		
		if($data[bv_no])
		{
			$sql	= "select * from blog_visitor where bv_no = '$data[bv_no]' order by bo_no asc";
			$result	= CDB::query($sql);
			
				
			$query 	= "INSERT INTO blog_visiter (bv_newcount, bv_option)  VALUES('0', '$bv_option')";
			
			$Storage->rewind();
			while($Storage->valid())
			{
				$object = $Storage->current(); // similar to current($this->ComentList)
				while($data	= CDB::Fetch_Array($result))
				{
					if(isEqualStr($data[bo_blognickname], $object->getNickName()))
					{
						
					}
				}															
				$Storage->next();
			}
			
		} else {
			$query 	= "INSERT INTO blog_visiter (bv_newcount, bv_option)  VALUES('0', '$bv_option');";	
		}				
	}
	
	function insert_blog_visitor($bv_no, $bo_blogurl, $bo_blognickname, $bo_blogid)
	{
		$query = "INSERT INTO blog_visitor (bv_no, bo_blogurl, bo_blognickname, bo_blogid)  VALUES('$bv_no', '$bo_blogurl', '$bo_blognickname', '$bo_blogid');";
	}
	
	function isEqualStr($str, $search)
	{
		$pos = strcmp($str, $search);
		if ($pos=='0') return true;
		else return false;
	}	
}

?>
<?php 
/*fetchpost($url) $url에 해당하는 공감, 댓글, 제목*/ 
$Naver				=  new CNaverBlog();
//$Naver->fetchContent("http://mangsangk.com/10164120025");
//$Naver->DisplayCommentStorage($Naver->ComentList);
//$Naver->DisplayIdentifyStorage($Naver->IdentifyList);


/*해당 포스팅에 대한 글의 제목을 바로 받아 온다.*/
//	echo $Naver->fetchContentSubject('http://helovestory.com/90140317109');

/*hmh3757의 블로그에 해당하는 모든 블로그 제목, 날짜 정보를 가져온다.*/
//	$Naver	=  new CNaverBlog();
// 	$Naver->fetchContentsToId("hmh3757");
//	$Naver->DisplayScripStorage($Naver->ScripList);

/*블로그 방문자 정보를 가지고 온다.*/
$Naver->fetchBlogVisiterToId("hyh820331");
$Naver->DisplayVisiterStorage($Naver->Visiters);

$Storage	= $Naver->Visiters;
$Storage->rewind();
while($Storage->valid())
{
	$object = $Storage->current(); // similar to current($this->ComentList)
	echo "<tr>";
	echo "<td>".$object->getUrl()."</td>";
	echo "<td>".$object->getNickName()."</td>";
	echo "</tr>";
	$Storage->next();
}

/*hmh3757의 닉네임을 받아 온다. naver id가 아닐경우 null 값을 리턴한다.*/
//	echo $Naver->fetchNickName("hmh3757");



?>
</body>
</html>

