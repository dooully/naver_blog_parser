<?php
class CVisiter
{
	public 	$TagBlock;

	public	function getUrl()
	{
		preg_match("'(?<=<a href=\")[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\")'", $this->TagBlock, $result);
		return $result[0];
	}

	public	function getNickName()
	{
		preg_match("'(?<=widget_visited_blogger\)\">)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=</a>)'", $this->TagBlock, $result);
		return $result[0];
	}
	
	public	function getId()
	{
		return $this->logNo;
	}
}
?>