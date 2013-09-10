<?
require 'Snoopy.class.php';
require 'CIdentify.php';
require 'CComment.php';
require 'CScripforId.php';
require 'CScripforUrl.php';
require 'JSON.php';
require 'CVisiter.php';
require 'CPostTitleList.php';
require 'CContent.php';
require 'CCategory.php';

?>

<?php 
class CNaverBlog
{
	public $ComentList;
	public $IdentifyList;
	public $ComentListcripList;
	public $blogId;
	public $Visiters;
	public $Category;
	
	public function __construct()
	{
		$this->ComentList 		= new SplObjectStorage ();
		$this->IdentifyList 	= new SplObjectStorage ();
		$this->ScripList 		= new SplObjectStorage ();	// input : naver id, output : pages subject
		$this->Visiters			= new SplObjectStorage ();
		$this->Category          = new SplObjectStorage ();
	}
	

	public function PostTitleList($blogid = NULL, $currentPage = NULL , $categoryNo = NULL, $parentCategoryNo = NULL, $countPerPage = NULL)
	{
		$url		= "http://blog.naver.com/PostTitleListAsync.nhn?blogId=$blogid&currentPage=$currentPage&categoryNo=$categoryNo&parentCategoryNo=$parentCategoryNo&countPerPage=$countPerPage"; // +page
		$snoopy 	= new snoopy;
		$snoopy->fetch($url);
		$jsonPage	= $snoopy->results;
		
		$json 		= new Services_JSON();		
		$pageinfo	= $json->decode($jsonPage);
		$result		= new CPostTitleList($pageinfo);
		
		return $result;
		
	}

	
	public function PostList($blogid = NULL, $from = NULL , $categoryNo = NULL, $parentCategoryNo = NULL, $currentPage = 1)
	{
		$contents	= Array();
		$url		= "http://blog.naver.com/PostList.nhn?blogId=$blogid&from=$from&categoryNo=$categoryNo&parentCategoryNo=$parentCategoryNo&currentPage=$currentPage"; // +page
		$snoopy 	= new snoopy;
		$snoopy->fetch($url);
		preg_match_all("'(?<=\" class=\"post-body\" cellspacing=\"0\" cellpadding=\"0\"\>)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?\<div class\=\"post\_footer\_contents\"\>'", iconv('CP949', 'UTF-8', $snoopy->results), $PostList);
		foreach ($PostList[0] as $content)
		{
			$contents[]	= new CContent($content);			
		}
						 
		return $contents;
	}

	public function PostView($blogid, $logNo, $categoryNo, $parentCategoryNo, $userTopListCurrentPage )
	{
		$__s	= new snoopy;
		$url	= "http://blog.naver.com/PostView.nhn?blogId=$blogid&logNo=$logNo&categoryNo=$categoryNo&parentCategoryNo=$parentCategoryNo&userTopListCurrentPage=$userTopListCurrentPage";
		$snoopy 	= new snoopy;
		$snoopy->fetch($url);
		$content	= iconv('CP949', 'UTF-8', $snoopy->results);
		$content	= new CContent($content);
		
		return 	$content;		
	}
	//blogId=magpass&listNumVisitor=5&isVisitorOpen=false&isBuddyOpen=false&selectCategoryNo=0&skinId=0&skinType=&isCategoryOpen=true&isEnglish=true&listNumComment=5&areaCode=11B10101&weatherType=1&currencySign=ALL&enableWidgetKeys=content%2Cprofile%2Ccategory%2Cmapview%2Csearch%2Clibrary%2Cpowered%2Ccounter%2Crss%2Cvisitor%2Cvisitorgp%2C1263987%2C1263988%2Ctitle%2Cmenu%2Cgnb%2Cexternalwidget%2Cmusic&writingMaterialListType=1
	
	public function fetchCategory($blogId)
	{
		$categorys	= array();
		$__s	= new snoopy;
		$url	= "http://blog.naver.com/WidgetListAsync.nhn";
		$s['blogId']					="$blogId";
		$s['listNumVisitor']			="20";
		$s['isVisitorOpen']				="false";
		$s['enableWidgetKeys']			="visitor, category" ;
		$s['selectCategoryNo']			= "0";
		$s['isCategoryOpen']			= true;
		
		$__s->referer 	= "http://blog.naver.com/PostList.nhn?blogId=&widgetTypeCall=true&categoryNo=1";
		$__s->submit($url,$s);		
		
		$content	= iconv('CP949', 'UTF-8', $__s->results);
		
		$json 		= new Services_JSON();		
		$pageinfo	= $json->decode($content);
		preg_match_all("'(?<= parentcategoryno_)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?= </li>)'", $pageinfo->category->content, $results);
		
		//print_r($results[0]);
		foreach ($results[0] as $category)
		{
			preg_match_all("'(?<=\)\ \"\>)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*'", $category, $results);
			print_r( $results[0][0]);
			$categorys[]	= new CCategory($category);
		}
		
		
		//return $categorys;
		//print_r()
		/*
		$__s	= new snoopy;
		$url	= "http://blog.naver.com/WidgetListAsync.nhn";
		$s['blogId']					="$blogId";
		$s['listNumVisitor']			="20";
		$s['isVisitorOpen']				="true";
		$s['enableWidgetKeys']			="visitor";
		
		$__s->referer 	= "http://blog.naver.com/PostList.nhn?blogId=&widgetTypeCall=true&categoryNo=1";
		$__s->submit($url,$s);
		
		preg_match_all("'(?<=\<li>)<img src=\"[媛��ｃ꽦-�롢뀖-��w\W\s]*?(?=</li>)'", $__s->results, $visiters);
		print_r($visiters);
		*/
		/*
		preg_match_all("'(?<=\<li>)<img src=\"[媛��ｃ꽦-�롢뀖-��w\W\s]*?(?=</li>)'", $__s->results, $visiters);
		foreach ($visiters[0] as $visiter)
		{
			$CObject = new CVisiter();
			$CObject->TagBlock = $visiter;
			$this->Visiters->attach($CObject);
		}
		*/	
	}
	
	
	public function fetchBlogCategoryToId($id)  // naver id에 해당하는 모든 블로그 컨텐츠 정를 끌고 온다. 
	{
		$this->Category->rewind();
	
		$__s	= new Snoopy();
		$url	= "http://blog.naver.com/WidgetListAsync.nhn";
	
		$s['blogId']					= $id;
		$s['isCategoryOpen']				="true";
		$s['enableWidgetKeys']			="category";
		$__s->referer 	= "http://blog.naver.com/PostList.nhn";
		$__s->submit($url,$s);
	
		$content	= iconv('CP949', 'UTF-8', $__s->results);
	
		$get_content_1 = explode("<li class=\"", $content);
		//$get_content_2 = explode("</li>",$get_content_1[2]);
		
		$i = 1;
		while($get_content_1[$i])
		{
			$get_content_2 = explode("</li>",$get_content_1[$i]);
			$CObject = new CCategory(); 
			$CObject->TagBlock = $get_content_2[0];
			echo $CObject->getCategoryName();
			//echo iconv('UTF-8', 'CP949', $CObject->getCategoryName());
			$this->Category->attach($CObject);
			$i++;
		}
	}
	
	

	
	public function fetchNickName($id)
	{
		sleep(1);
		$url = "http://blog.naver.com/PostList.nhn?from=postList&blogId=$id&currentPage=0";
		$snoopy 		= new snoopy;
		$snoopy->fetch($url);
		$result 		= $snoopy->results;
		if(preg_match("'(?<=var nickName \= \')[가-힣ㄱ-ㅎㅏ-ㅣ\w\s\W]*?(?=\';)'", $result, $NickName))
		{
			if(iconv('CP949', 'UTF-8', $NickName[0]) == "") $Nick = $id;
			else $Nick = iconv('CP949', 'UTF-8', $NickName[0]);
			return $Nick;
		} else {
			return null;	
		}	
	}

	public function fetchContent($URI)
	{
		$this->sUrl		= $URI;

		$snoopy 		= new snoopy;
		$snoopy->fetch($URI);
		$result 		= $snoopy->results;
		$ex				= explode("blogId=",$result); 
		$result 		= explode("\"",$ex[1]);
		$this->blogId	= $result[0];

		preg_match("/([0-9]+)$/", $URI, $matches); 
		$this->bbsNo 	= $matches[count($matches)-1];


		$this->CommentUrl		= "http://blog.naver.com/CommentList.nhn?blogId=$this->blogId&logNo=$this->bbsNo&"."currentPage=&isMemolog=false&focusingCommentNo=&showLastPage=true";
		$this->IdentifyUrl		= "http://blog.naver.com/SympathyHistoryList.nhn?blogId=$this->blogId&logNo=$this->bbsNo";
	
		$this->fetchPostInfo($this->CommentUrl, $this->ComentList, "CComment",  "<li id=\"postComment_");
		$this->fetchPostInfo($this->IdentifyUrl, $this->IdentifyList, "CIdentify",  "<tr>");
		//$this->DisplayCommentStorage($this->ComentList);
		//$this->DisplayIdentifyStorage($this->IdentifyList);
	}

	public function fetchContentsToId($id)  
	{
		$this->ScripUrl	= "http://blog.naver.com/PostTitleListAsync.nhn?blogId=$id&viewdate=&categoryNo=0&currentPage="; // +page
		$Storage	= $this->ScripList;
		$snoopy 	= new snoopy;
		$snoopy->fetch($this->ScripUrl."1");
		$jsonPage	= $snoopy->results;
		
		$json 		= new Services_JSON();
		$pageinfo	= $json->decode($jsonPage);
		$max		= $pageinfo->totalCount / $pageinfo->countPerPage;

			
		
//		print_r($pageinfo);
		for($pageCount = 1; $pageCount <= $max; $pageCount++)
		{
			$snoopy->fetch($this->ScripUrl.$pageCount);
			$jsonPage	= $snoopy->results;
			$pageinfo	= $json->decode($jsonPage);
			
			for($i = 0; $i <  $pageinfo->countPerPage; $i++)
			{
				$CObject 			= new CScripforId();
				$CObject->title 	= $pageinfo->postList[$i]->title; // 페이지 본문 소스 스크립 해오기
				$CObject->Date		= $pageinfo->postList[$i]->addDate;
				$CObject->logNo		= $pageinfo->postList[$i]->logNo;
				$Storage->attach($CObject);
			}
		}
		//$this->DisplayScripStorage($this->ScripList);
		
	}
	
	public function fetchContentSubject($url)
	{
		$snoopy = new snoopy;
		$snoopy->fetch($url);
		$txt 	= $snoopy->results;
	
		$ex		= explode('<frame id=',$txt);// 사용자 ID 받아 오기
		$result = explode(" ",$ex[1]);
	
		if($result[0] == "\"mainFrame\"") // 블로그 본문 파싱하기 (일반 네이버 블로그 주소를 사용할 경우)
		{
			$result = $this->getUrl($result[2]);
			$resultURL = "http://blog.naver.com".$result[0];
			$snoopy->fetch($resultURL);
			$txt 	= $snoopy->results;
			//print_r($txt);
		}
		else if ($result[0] == "\"screenFrame\"")  // 블로그 본문 파싱하기 (블로그 주소가 호스팅일 경우)
		{
			$result 	= $this->getUrl($result[2]);
			$resultURL 	= $result[0];
			$snoopy->fetch($resultURL);
			$txt 	= $snoopy->results;
	
			$ex		= explode('<frame id=',$txt); // 사용자 ID 받아 오기
			$result = explode(" ",$ex[1]);
			$result = $this->getUrl($result[2]);
			$resultURL = "http://blog.naver.com".$result[0];
			$snoopy->fetch($resultURL);
			$txt 	= $snoopy->results;
		}
	
		$CObject 			= new CScripforUrl();
		$CObject->TagBlock	= $txt;
		return $CObject->getTitle();
	}
	
	public function fetchBlogVisiterToId($id)
	{
		$this->Visiters->rewind();
		
		$__s	= new snoopy;
		$url	= "http://blog.naver.com/WidgetListAsync.nhn";
		$s['blogId']					="$id";
		$s['listNumVisitor']			="20";
		$s['isVisitorOpen']				="true";
		$s['enableWidgetKeys']			="visitor";
		
		$__s->referer 	= "http://blog.naver.com/PostList.nhn?blogId=&widgetTypeCall=true&categoryNo=1";
		$__s->submit($url,$s);
		
		preg_match_all("'(?<=\<li>)<img src=\"[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=</li>)'", $__s->results, $visiters);
		foreach ($visiters[0] as $visiter)
		{
			$CObject = new CVisiter();
			$CObject->TagBlock = $visiter;
			$this->Visiters->attach($CObject);
		}						
				
	}
	

	/*fechpost Display*/
	
	public function DisplayVisiterStorage($Storage)
	{
		$Storage->rewind();
		echo "<table>";
		echo "<tr><td>url</td> <td>title</td> </tr>";
		while($Storage->valid())
		{
			$object = $Storage->current(); // similar to current($this->ComentList)
			echo "<tr>";
			echo "<td>".$object->getUrl()."</td>";
			echo "<td>".$object->getNickName()."</td>";
			echo "</tr>";
			$Storage->next();
		}
		echo "</table>";
	}
	
	
	public function DisplayScripStorage($Storage)
	{
		$Storage->rewind();
		echo "<table>";
		echo "<tr><td>title</td> <td>Date</td> <td>logNo</td> </tr>";
		while($Storage->valid())
		{
			$object = $Storage->current(); // similar to current($this->ComentList)
			echo "<tr>";
			echo "<td>".$object->getTitle()."</td>";
			echo "<td>".$object->getDate()."</td>";
			echo "<td>".$object->getlogNo()."</td>";
			echo "</tr>";
			$Storage->next();
		}
		echo "</table>";
	}
	
	public function DisplayCommentStorage($Storage)
	{
		$Storage->rewind();
		echo "<table>";
		echo "<tr><td>NaverId</td> <td>NickName</td> <td>Commnet</td> <td>Date</td></tr>";
		while($Storage->valid())
		{
			$object = $Storage->current(); // similar to current($this->ComentList)
			echo "<tr>";
			echo "<td>".$object->getNaverId()."</td>";
			echo "<td>".$object->getNickName()."</td>";
			echo "<td>".$object->getComment()."</td>";
			echo "<td>".$object->getDate()."</td>";
			echo "</tr>";
			$Storage->next();
		}
		echo "</table>";
	}
	
	public function DisplayIdentifyStorage($Storage)
	{
		$Storage->rewind();
		echo "<table>";
		echo "<tr><td>NickName</td> <td>NaverId</td> <td>Date</td></tr>";
		while($Storage->valid())
		{
			$object	= $Storage->current();
			echo "<tr>";
			echo "<td>".$object->getNickName()."</td>";
			echo "<td>".$object->getNaverId()."</td>";
			echo "<td>".$object->getDate()."</td>";
			echo "</tr>";
			$Storage->next();
		}
		echo "</table>";
	}
	
	
	/*private*/
	private function getUrl($src)
	{
		$ex		= explode('src="',$src); // 사용자 ID 받아 오기
		$result = explode('"',$ex[1]);
		return $result;
	}
	

	
	
	
	private function fetchPostInfo($document, &$Storage, $ClassName, $patten)
	{
		$snoopy 	= new snoopy;
		$snoopy->fetch($document);
		$document	= $snoopy->results;

		$output = explode($patten, $document);
		foreach ($output as $comment)
		{
			$CObject = new $ClassName();
			$CObject->TagBlock = $comment;
			$Storage->attach($CObject);
		}
		$Storage->rewind();
	}
	
	
	private $Url 			= "";
	private $CommentUrl 	= "";
	private $IdentifyUrl	= "";
	
	private $bbsNo;
	
	
}
?>
