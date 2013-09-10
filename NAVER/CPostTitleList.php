<?php

class CPostTitleList
{
	private $TagBlock;
	
	function __construct($Tag)
	{
		$this->TagBlock	= $Tag;
	}

	function getCurrentPage()
	{
		return $this->TagBlock->parameters->currentPage;
	}	
	
	public function getPageUrl($blogid = "", $currentPage = "" , $categoryNo = "", $parentCategoryNo = "", $countPerPage = "")
	{
		return $this->ScripUrl	= "http://blog.naver.com/PostTitleListAsync.nhn?blogId=$blogid&currentPage=$currentPage&categoryNo=$categoryNo&parentCategoryNo=$parentCategoryNo&countPerPage=$countPerPage"; // +page
	}
	
	function getCountPerPage()
	{
		for($i = 0; $i < $this->TagBlock->parameters->countPerPage; $i++)
		{
			if(!is_string($this->TagBlock->postList[$i]->title))
			{
				return $i;
			}			
		}
		return $this->TagBlock->parameters->countPerPage;
	}
	
	function getCategoryNo()
	{
		return $this->TagBlock->parameters->categoryNo;
	}
	
	function getParentCategoryNo()
	{
		return $this->TagBlock->parameters->parentCategoryNo;
	}
	
	function getPostTitle($idx)
	{ 
		$title = $this->TagBlock->postList[$idx]->title;
		return urldecode($title);
	}
	
	function getPostLogNo($idx)
	{
		$title = $this->TagBlock->postList[$idx]->logNo;
		return ($title);
	}
	
	function getPostParentCategoryNo($idx)
	{
		$title = $this->TagBlock->postList[$idx]->parentCategoryNo;
		return ($title);
	}
	
	function getPostCategoryNo($idx)
	{
		$title = $this->TagBlock->postList[$idx]->categoryNo;
		return ($title);
	}
	
	
	function getPostcommentCount($idx)
	{
		$title = $this->TagBlock->postList[$idx]->commentCount;
		return ($title);
	}
	
	function getPostScrapCount($idx)
	{
		$title = $this->TagBlock->postList[$idx]->scrapCount;
		return ($title);
	}
	
	function getPostRelayCount($idx)
	{
		$title = $this->TagBlock->postList[$idx]->relayCount;
		return ($title);
	}
	
	function getPostAddDate($idx)
	{
		$addDate = $this->TagBlock->postList[$idx]->addDate;
		return ($addDate);
	}
	
	
	function getPageNaviCount()
	{
		if($this->TagBlock->countPerPage == 0) return;
		return ceil($this->TagBlock->totalCount / $this->TagBlock->countPerPage);
	}
	
	function getPageTotalCount()
	{
		return $this->TagBlock->totalCount;
	}
}
?>

