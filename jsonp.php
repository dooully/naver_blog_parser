<?php 
require_once './NAVER/CNaverBlog.php';
?>

<?php

$Naver =  new CNaverBlog();
//$Naver->fetchContentsToId("hmh3757");
//$Naver->DisplayScripStorage($Naver->ScripList);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-KR">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript"></script>
<script>
/*
$(document).ready(function(){
	  $("button").click(function(){

		 x
			 var xhr = new XMLHttpRequest(); 
	    	 var hUrl = 'http://blog.naver.com/PostTitleListAsync.nhn?blogId=magpass&viewdate=&categoryNo=0&currentPage=1';
	    	 xhr.open('GET', hUrl, true);		    	 	    	 	    	 
	    	 xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=utf-8");
	    	 xhr.setRequestHeader("Access-Control-Allow-Origin", "*");
	    	 xhr.setRequestHeader("Access-Control-Allow-Methods", "GET");
	    	 xhr.setRequestHeader("Access-Control-Allow-Methods", "Content-Type");
	    	 xhr.setRequestHeader("Origin", "http://blog.naver.com/PostList.nhn?blogId=&widgetTypeCall=true&categoryNo=1");
	    	 xhr.setRequestHeader("Referer", "http://blog.naver.com/PostList.nhn?blogId=&widgetTypeCall=true&categoryNo=1");
	    	 var hParams = 'blogId=magpass&viewdate=&categoryNo=0&currentPage=1';
	    	 xhr.send(hParams);
	    	x
	    
	    $.get("http://blog.naver.com/PostTitleListAsync.nhn?blogId=magpass&viewdate=&categoryNo=0&currentPage=1%20Request%20Headersview%20source",
	    function(result){
		    alert('abcde');
			alert('abc');	
	    });
		
	    
	  });
	});
*/

/*	
$(document).ready(function(){
  $("button").click(function(){
    $.post("http://blog.naver.com/PostTitleListAsync.nhn?blogId=magpass&viewdate=&categoryNo=0&currentPage=1",
    {
      name:"Park's의 블로그",
      thank:"감사드립니다"
    },
    function(data,status){
      alert("Data: " + data + "\nStatus: " + status);
    });
  });
});
*/
</script>

<script>

function myJsonMethod(data)
{
	alert('myjsonmethod');
}

function jQuery1910424003838095814_1373775928951(data)
{
	alert('abc');
}

function successFunction(data) {
	  if (jQuery.browser.msie) {
	    data = jQuery.parseJSON(data);
	  }
	  /* Yes, if you're using IE, you get text back, not a JSON object */
	}
	
function makeRequest() {
		var queryURL = "http://blog.naver.com/PostTitleListAsync.nhn?blogId=magpass&viewdate=&categoryNo=0&currentPage=1";
		 

		  jQuery.ajax({
		    type: 'GET',
		    url: queryURL,
		    dataType: "json",
		    success: function(data, textStatus, jqXHR) { successFunction(data); },
		    error: function(jqXHR, textStatus, errorThrown) { /* error handling here */ }
		  });
	

	
	/*
	$.ajax({
	    url : "http://blog.naver.com/PostTitleListAsync.nhn?blogId=magpass&viewdate=&categoryNo=0&currentPage=1",
	    data : "id=user",
	    dataType : "jsonp",
	    jsonp : "callback",
	    success: function(data) {
	        if(data != null)    {
	            alert(data.result + ", " +  data.go);
	        }
	    }
	});*/
	/*
	$.ajax(
			   {
				   success:function(data){
					     alert(data.messages);
					    },
					    error:function(jqXHR, textStatus, errorThrown){
					    	alert("jqXHR.status: " + jqXHR.getAllResponseHeaders.resultcode+ "\njqXHR.statusText: " + jqXHR.statusText + "\ntextStatus: " + textStatus + "\nerrorThrown: " + errorThrown);
					    },
			    url:'http://blog.naver.com/PostTitleListAsync.nhn?blogId=magpass&viewdate=&categoryNo=0&currentPage=1&callback=myJsonMethod',
			    type:"GET",
			    async:false,
			    jsonpCallback: "myJsonMethod()",
			    dataType:"jsonp",
			    //dataType:"text/json",
			    crossDomain: true,			    
			    jsonp: 'jsonp'
			   }
			  );
	  */
/*
	$.ajax({
	    type : "Get",
	    url :"http://blog.naver.com/PostTitleListAsync.nhn",
	    data :"blogId=magpass&viewdate=&categoryNo=0&currentPage=1",
	    dataType :"jsonp",
	    jsonp: false,
	    jsonpCallback: "myJsonMethod",
	    success : function(data){
	        alert(data);},
	    error : function(httpReq,status,exception){
	    	alert(httpReq.responseText);
	        alert(status+" "+exception);
	    }
	});
*/


}
</script>


</head>
<body>
<button>post() </button>
<input type="button" value="Call Xml" onclick="makeRequest();"/>
</body>
</html>