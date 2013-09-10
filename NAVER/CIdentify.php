<?php 
	class CIdentify
	{
		private $NaverId;
		private $NickName;
		private $Date;
		public $TagBlock;
		
		public function getNickName()
		{
			$temp = $this->getTitle();
			preg_match("'[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=\()'", $temp, $result);
			return $this->NickName = $result[0];
		}
		
		public function getNaverId()
		{
			$temp = $this->getTitle();
			// 보통 닉네임과 아이디를 다 입력 하면 키론의 빛(magpass) 이런식으로 표시가 되어서 ()안이 아이디 라고 추출하면 되는데 닉네임을 아이디와 같은걸 쓰면 luv414 처럼 아이디만 표시 됨으로 분리해서 추출한다.
			if(preg_match("'(?<=\()[\w]*?(?=\))'", $temp, $result));  // 아이디 닉네임 모두 입력한 경우 
			else $result[0] = $temp;   // 닉네임 입력 하지 않아서 아이디와 같은걸 사용하는 경우
			
			return $this->NaverId = $result[0];
		}
		
		public function getDate()
		{
			preg_match("'(\d{2})\/(\d{2})\s(\d{2})\:(\d{2})'", $this->TagBlock, $result);
			return $this->Date = $result[0];
		}
		
		public function getTitle()
		{
			preg_match("'(?<=style=\"cursor\:pointer\;\">)[가-힣ㄱ-ㅎㅏ-ㅣ\w\W\s]*?(?=</span>)'", $this->TagBlock, $result);
			return $result[0];
		}
	}
?>

