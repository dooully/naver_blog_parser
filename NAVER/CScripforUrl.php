<?php 
class CScripforUrl
{
	public	$Date;
	public	$title;
	public	$logNo;
	public 	$TagBlock;
	
	public	function getTitle()
	{
		preg_match("'(?<=<span class=\"pcol1 itemSubjectBoldfont\">)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\<\/span\>)'", $this->TagBlock, $result);
		return $this->title =  iconv("CP949", "UTF-8", $result[0]);
		//return $this->title =  $result[0];
	}
	
	public	function getlogNo()
	{
		return $this->logNo;
	}
	
	public	function getDate()
	{
		return $this->Date;
	}
}
?>
