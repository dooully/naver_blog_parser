<?
class CCategory
{
	private	$TagBlock;
	private $domain;
	
	public function __construct($tag, $domain)
	{
		$this->TagBlock	= $tag;
		$this->domain	= $domain;
	}
	
	public function getCategoryUrl()
	{
		preg_match("'(?<=href=\")[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\")'", $this->TagBlock, $result);
		$url	= str_replace('nhn', 'php', $result[0]);
		return $this->domain.trim($url);
	}
	
	public function getCategoryNumber()
	{
		$cateurl = $this->getCategoryUrl();
		$cate_1 = explode("categoryNo=",$cateurl);
		preg_match("/^([0-9])*/", $cate_1[1], $result);	
		return $result[0];
	}	
	
	public function isParentCategory()
	{
		if($this->getchilledNumber() == -1) return true; // 부모이면 true
		else 								false;		
	}
	
	public function isChildCategory()
	{
		if($this->getparentNumber()) return true; // 자식이면 true
		else 								false;		
	}
	
	public function getparentNumber()
	{
		$cateurl = $this->getCategoryUrl();
		$cate_1 = explode("parentCategoryNo=",$cateurl);
		preg_match("/^([0-9])*/", $cate_1[1], $result);	
		if($result[0] == NULL)
			return false;
		
		return $result[0];
	}
	
	public function getchilledNumber()
	{
		$cate_1 = explode("parentcategoryno_",$this->TagBlock);
		
		preg_match("/^([-0-9])*/", $cate_1[1], $result);
		
		if($result[0] == NULL)
			return false;
		
		return $result[0];
	}
	
	public	function getCategoryName()
	{
		preg_match("'(?<=[0-9]\) \">)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=</a>)'", $this->TagBlock, $result);
		$name	= html_entity_decode($result[0]);
		return $name;
	}
}
?>