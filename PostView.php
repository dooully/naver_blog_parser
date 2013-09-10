<?php 
require_once './NAVER/CNaverBlog.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>

<?php
$blogid					= $_GET[blogId];
$logNo					= $_GET[logNo];
$categoryNo				= $_GET[categoryNo];
$parentCategoryNo		= $_GET[parentCategoryNo];
$userTopListCurrentPage	= $_GET[userTopListCurrentPage];

//only Post title List var
$currentPage		= $_GET[currentPage];
$countPerPage		= $_GET[countPerPage]; // 최소 : 5, 다음 10 이외의 숫자는 디폴트로(5)로 처리한다.


if(!$_GET[blogId] || $_GET[blogId] = '' ){ // 제일 처음 들어 왔을때 get파라메터에 아무것도 없으면 실행
	echo "first join";
	$blogid				= "ateon1";
	$currentPage		= "30";
	$categoryNo			= "0";
	$parentCategoryNo	= "0";
	$countPerPage		= "5"; // 최소 : 5, 다음 10 이외의 숫자는 디폴트로(5)로 처리한다.
	$userTopListCurrentPage	= "1";
}

?>


<?php 
function DisplayTitle($Storage)
{
	global $blogid;
	global $currentPage;
	global $categoryNo;
	global $parentCategoryNo;
	global $countPerPage;
	global $userTopListCurrentPage; // titlelist의 네비게이션 바에 
	
	echo "<table>";
	echo "<tr><td>Title</td> <td>스크랩</td> <td>엮인글</td> <td>댓글 개수</td> <td>날짜</td></tr>";
	for($i = 0; $i < $Storage->getCountPerPage(); $i++)
	{		
		echo "<tr>";		
		echo "<td>";
			echo "<a href='./PostView.php?blogId=$blogid&logNo=".$Storage->getPostLogNo($i)."&categoryNo=".$Storage->getCategoryNo()."&parentCategoryNo=".$Storage->getParentCategoryNo()."&userTopListCurrentPage=$userTopListCurrentPage'>";
				echo $Storage->getPostTitle($i);
			echo "</a>";			
		echo "</td>";
		echo "<td>".$Storage->getPostScrapCount($i)."</td>";
		echo "<td>".$Storage->getPostRelayCount($i)."</td>";
		echo "<td>".$Storage->getPostcommentCount($i)."</td>";
		echo "<td>".$Storage->getPostAddDate($i)."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

function DisplayPageing($Storage)
{
	global $blogid;
	global $currentPage;
	global $categoryNo;
	global $parentCategoryNo;
	global $countPerPage;
	global $logNo;
	echo "<table>";
	for($i = 0; $i < $Storage->getPageNaviCount(); $i++)
	{
		$pageNum	= $i+1;
		//$pageurl	= $Storage->getPageUrl($blogid, $currentPage, $categoryNo, $parentCategoryNo, $countPerPage);
		echo "<td>";
			echo "<a href='./PostView.php?blogId=$blogid&currentPage=$pageNum&categoryNo=$categoryNo&parentCategoryNo=$parentCategoryNo&countPerPage=$countPerPage&userTopListCurrentPage=$pageNum&logNo=$logNo'>";
				echo $pageNum;
			echo "</a>";
		echo "</td>";
	}
	echo "</table>";
}


function DisplayContent($content)
{
	echo "<br><br><br><br><br><br>";
	echo "<table>";
		echo "<tr>";		
			echo "<td>".$content->getDate()."</td>";
			echo "<td>".$content->getTitle()."</td>";
		echo "</tr>";
		echo "<tr >";
			echo "<td colspan=2>".$content->getContent()."</td>";
		echo "</tr>";
	echo "</table>";
}

function DisplayCategory($categorys)
{
	echo "<br><br><br><br><br><br>";
	echo "<table>";
	foreach ($categorys as $category)
	{
		
		echo "<tr>";
			echo "<td>";
			if(!$category->isParentCategory())
				echo "--";
			echo "<a href=".$category->getCategoryUrl().">";
				echo $category->getCategoryName();
			echo "</a>";
			echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>

<?php

$Naver 		=  new CNaverBlog();
$result		= $Naver->PostTitleList($blogid, $currentPage, $categoryNo, $parentCategoryNo, $countPerPage);
DisplayTitle($result);
DisplayPageing($result);


$content		= $Naver->PostView($blogid, $logNo, $categoryNo, $parentCategoryNo, $userTopListCurrentPage);
DisplayContent($content);


$categorys		= $Naver->fetchCategory($blogid);
DisplayCategory($categorys)
?>

</body>
</html>