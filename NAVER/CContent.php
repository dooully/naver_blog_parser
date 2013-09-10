<?php
class CContent
{
	private $TagBlock;
	
	function __construct($Tag)
	{
		$this->TagBlock	= $Tag;
	}
	
	public function getTitle()
	{		
		preg_match_all("'(?<=\<span class\=\"pcol1 itemSubjectBoldfont\"\>)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\<\/span\>)'", $this->TagBlock, $title);
		return $title[0][0];
	}
	
	public function getContent()
	{
		preg_match_all("'((?<=post\-view pcol2 \_param\([0-9]\)\"\>)|(?<=post\-view pcol2 \_param\([0-9]{2}\)\"\>))[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\</div>

						

					
					
					

					
					
						<div class=\"post_footer_contents\">)'", $this->TagBlock, $temp);
		$domain  = 'http://'. $_SERVER['HTTP_HOST'];
		$content = str_replace("http://postfiles", $domain."/blogrss/NAVER/get_image.php?p=http://postfiles", $temp[0][0]);
		//$content = preg_replace("'(?<=type\=w[0-9]\" width\=)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s\"]*?(?= id\=\")'", "100%",$content);
		//$content = preg_replace("'(?<=width\=)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s\"]*?(?=\")'", "100%",$content);
		//$content = preg_replace("'(?<=width\:)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s\"]*?(?=\;)'", "100%",$content);
		
		$content	= preg_replace("/ width=(\"|\')?\d+(\"|\')?/","",$content);
		$content	= preg_replace("'\ width:[가-힣ㄱ-ㅎㅏ-ㅣ\=\w\W\s\"]*?(?=\;)'","",$content);
		
		return $content;
	}
	
	public function getThumContent()
	{
		return strip_tags ($this->getContent());
	}
		
	public function getThumImg($type, $default = null)
	{
		$content		= $this->getContent();
		$SERVER_NAME	= $_SERVER['SERVER_NAME'];
		preg_match("'(?<=img src\=\")http://www.$SERVER_NAME/[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?type='", $content, $ThumImg);
		switch($type)
		{
			case 's':
				$tempType	= 's1';
				break;
			case 'm':
				$tempType	= 's2';
				break;
			case 'l':
				$tempType	= 's3';
				break;
			default:
				$tempType	= 's1';
		}		
		if(is_string($ThumImg[0])) 	return 	$ThumImg[0].$tempType;
		else 						return  $default;
	}
	
	public function getDate()
	{
		//preg_match_all("'(?<=\<p class\=\"date fil5 pcol2 \_postAddDate\"\>)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=</p>)'", $this->TagBlock, $Date); // 시, 분, 초까지 나
		preg_match("'(?<=\<p class\=\"date fil5 pcol2 \_postAddDate\"\>)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?= )'", $this->TagBlock, $Date); // 날짜만 나
		return $Date[0];
	}
		
	public function getUrl()
	{
		preg_match("'(?<=fil5 pcol2\">)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\<\/a>)'", $this->TagBlock, $url);
		return $url[0];
	}
	
	public function getLogNo()
	{
		preg_match("'(?<=\/)[\d]*?(?=\<\/a\>)'", $this->TagBlock, $LogNo);
		return $LogNo[0];
	}
}
?>