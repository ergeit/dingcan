<?php

function sendMSG($send_to,$title,$body,$time=0){
    $RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
    $RootObj->ServerIP ='127.0.0.1';
    $RootObj->ServerPort ='8006';
    $status = $RootObj->SendNotify($send_to,$title,$time,$body);
    return $status;
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   
    if (isset($_GET['username']) and isset($_GET['realname'])) {
        $username=$_GET['username'];
	$realname=$_GET['realname'];
	$realname = iconv("utf-8","gb2312", $realname);
	
	$nowtime=date("Y��m��d�� H:i:s");  //��ȡ��ǰʱ��
        $title = "�������ʾ���";
        $messages =  $realname."ͬѧ \n�뾡���½ϵͳ���е��\n��͵�ַ:http://192.168.1.9:8081 \n��ʾʱ��:".$nowtime;
        $status = sendMSG("$username" , "$title" , "$messages");
	if($status == 0){
		echo "OK";
	}else{
		echo "NO";
	}
    }
}

?>