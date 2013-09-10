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
$categoryNo				= $_GET[categoryNo];
$parentCategoryNo		= $_GET[parentCategoryNo];
$countPerPage			= $_GET[countPerPage]; // 타이틀 리스트 보여지는 개수 최소 : 5, 다음 10 이외의 숫자는 디폴트로(5)로 처리한다.
$currentPostListPage	= $_GET[currentPostListPage];


$currentPage			= $_GET[currentPage];			// current title navig page number 실질적으로 $userTopListCurrentPage와 같다.
$userTopListCurrentPage	= $_GET[userTopListCurrentPage]; // current title navig page number 실질적으로 $currentPage 같다. 하지만 PostView에서 PostView()인자로 넣어 해당 view를 가져올때 사용한다.  
$ContentcurrentPage		= $_GET[ContentcurrentPage]; 	// current content navig page number

if(!$_GET[blogId] || $_GET[blogId] = '' ){ // 제일 처음 들어 왔을때 get파라메터에 아무것도 없으면 실행
	echo "first join";
	$blogid				= "hj1ds";
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
	global $userTopListCurrentPage;
	
	if(is_null($Storage))
	{
		echo 'Title null';
		return;
	}
	
	echo "<table>";
	echo "<tr><td>Title</td> <td>스크랩</td> <td>엮인글</td> <td>댓글 개수</td> <td>날짜</td></tr>";
	for($i = 0; $i < $Storage->getCountPerPage(); $i++)
	{		
		echo "<tr>";		
		echo "<td>";
			//echo "<a href='./PostView.php?blogId=$blogid&logNo=".$Storage->getPostLogNo($i)."&categoryNo=".$Storage->getCategoryNo()."&parentCategoryNo=".$Storage->getParentCategoryNo()."&userTopListCurrentPage=$userTopListCurrentPage'>";
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
	global $currentPostListPage;
	echo "<table>";
	for($i = 0; $i < $Storage->getPageNaviCount(); $i++)
	{
		$pageNum	= $i+1;
		echo "<td>";
		echo "<a href='./PostList.php?blogId=$blogid&currentPage=$pageNum&categoryNo=$categoryNo&parentCategoryNo=$parentCategoryNo&countPerPage=$countPerPage&userTopListCurrentPage=$userTopListCurrentPage&currentPostListPage=$currentPostListPage'>";
				echo $pageNum;
			echo "</a>";
		echo "</td>";
	}
	echo "</table>";
	echo "<br><br>";
}

function DisplayContent($contents)
{
	echo "<table>";
	foreach ($contents as $content)
	{
		echo "<tr>";		
			echo "<td>".$content->getDate()."</td>";
			echo "<td>".$content->getTitle()."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=2>".$content->getContent()."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

function DisplayContentPageing($CategoryTotalCount, $ListCount, $from)
{
	global $blogid;
	global $categoryNo;
	global $parentCategoryNo;
	global $currentPage;
	
	//부모에 0이 오는 오류를 막기 위해  $ListCount(한페이지에 보여지는 컨텐츠)를 검사한다. 
	if($ListCount == 0) $pageCount	= 1;
	else  $pageCount = ceil($CategoryTotalCount / $ListCount);

	echo "<table>";
	for($i = 0; $i < $pageCount; $i++)
	{
		$pageNum	= $i+1;
		echo "<td>";
		echo "<a href='./PostList.php?from=$from&blogId=$blogid&categoryNo=$categoryNo&parentCategoryNo=$parentCategoryNo&currentPostListPage=$pageNum'>";
		echo $pageNum;
		echo "</a>";
	echo "</td>";
	}
		echo "</table>";
}

function DisplayCategorys($categorys)
{
	if(is_null($categorys))
	{
		echo 'categorys null';
		return;
	}
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

function DisplayCategory($category)
{
	if(is_null($category)) 
	{
		echo 'category null';
		return;
	} 
	echo "category <br>";
	echo "<br><br><br><br><br><br>";
	echo "<table>";
		echo "<tr>";
			echo "<td>";
				if(!$category->isParentCategory())
					echo "--";
				echo "<a href=".$category->getCategoryUrl().">";
				echo $category->getCategoryName();
				echo "</a>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}
?>

<?php
$Naver 		=  new CNaverBlog();
$result		= $Naver->PostTitleList($blogid, $currentPage, $categoryNo, $parentCategoryNo, $countPerPage);
DisplayTitle($result);
DisplayPageing($result);

$category		= $Naver->selecCategory($blogid, 'Enjoy');
echo $category->getCategoryNumber();
//DisplayCategory($category);

$contents		= $Naver->PostList($blogid, "postList", $categoryNo, $parentCategoryNo, $currentPostListPage);
DisplayContent($contents);
DisplayContentPageing($result->getPageTotalCount(), $Naver->getPagePerPostCount() , 'postList');

$categorys		= $Naver->fetchCategory($blogid);
DisplayCategorys($categorys);
?>
</body>
</html>