<script>
function decodeURIComponentForJava(a){
    var b = decodeURIComponent(a.replace(/\+/g, "%20"));
    return b.replace(/\$/g, "&#0036;");
}
</script>

<?php 
class CScripforId
{
	public	$Date;
	public	$title;
	public	$logNo;
	public 	$TagBlock;
	
	public	function getTitle()
	{
		return "<script>document.write(decodeURIComponentForJava('$this->title'))</script>";
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
