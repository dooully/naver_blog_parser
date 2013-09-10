<?php 

?>
<?php 
	class CComment{
		public 	$TagBlock;
		private $NaverId;
		private $NickName;
		private $Commnet;
		private $Date;
		
		public function getNaverId()
		{
			$temp = "";
		  
			preg_match("'(?<=<a href=\")[\w\W]*?(?=\")'", $this->TagBlock, $temp);
			$url	= $temp[0];
			
			if(AfxisExistsStr($url, "DomainDispatcher"))
			{
				preg_match("'(?<=id=)[\w]*?(?=\&)'", $url, $id);
					
			}elseif(AfxisExistsStr($url, "blog.naver.com"))
			{  
				preg_match("'(?<=com\/)[\w]*'", $url, $id);
			}											
			return $this->NaverId = $id[0];
		}
		
		public function getNickName()
		{
			preg_match("'id\=\"nick[\d]*?\"[\w\s\;\:\=\"\'\-]*\>[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=<\/a>)'", $this->TagBlock, $temp); //에러 난다. 이유를 모르겠다. 부분 에러다 http://myubel.blog.me/30155225763 접속했을때 nick3이 안보인다.
			preg_match("'(?<=\>)[가-힣ㄱ-ㅎㅏ-ㅣ\w\s\W]*'", $temp[0], $result);
			$this->NickName = iconv('CP949', 'UTF-8', $result[0]);
			return $this->NickName;
		}
		
		public function getComment()
		{
			$temp = "";
			preg_match("'(?<=value=\")[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\")'", $this->TagBlock, $temp);
			return $this->Comment = iconv('CP949', 'UTF-8', $temp[0]);
							
		}
		public function getDate()
		{
			preg_match("'(\d{4})\/(\d{2})\/(\d{2})\s(\d{2})\:(\d{2})'", $this->TagBlock, $result);
			return $this->Date = $result[0];
		}
		
	}
?>