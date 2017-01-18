<?php
require_once("function/cURL-HTTP-function/curl.php");
require_once("function/TNFSH-Login/Login.php");

$id = "";
$pwd = "";
if (checklogin($id, $pwd)){
	$html=cURL_HTTP_Request("http://svrsql.tnfsh.tn.edu.tw/webschool/STD_DAY.asp",null,false,"cookie.txt")->html;
	$html=iconv("BIG5", "UTF-8", $html);
	$html=str_replace("Big5", "UTF-8", $html);
	$html=str_replace("\r\n", "", $html);
	$html=preg_match_all('/<tr><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td><td class="DataTDX?"><font class="DataFONTX?">.*?&nbsp;<\/font><\/td> <\/tr>/', $html, $match);
	$absence = false;
	foreach ($match[0] as $temp) {
		if(strpos($temp, "曠課")!==false||strpos($temp, "遲到")!==false||strpos($temp, "缺席")!==false){
			$absence = true;
		}
	}
	if ($absence) {
		echo "There is absence\n";
		return 1;
	} else {
		echo "No absence\n";
		return 0;
	}
} else {
	echo "Login failed\n";
	return 100;
}
