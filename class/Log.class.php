<?php
define('FILE_NAME_ENCODE', 'gb18030');
define('TIME_ZONE', 'Asia/Shanghai'); // ����Ĭ��ʱ��
define("LOG_FILE_DIR", "/usr/local/apache2/htdocs/activity_records/log/");
// ������־������־
function save_log($msg,$username) {
    date_default_timezone_set(TIME_ZONE);
    $now_time = now_time();
    $ip = GET_IP();
    $file_name = date('Y-m-d');
    $file_name = LOG_FILE_DIR.$file_name.".log";
    $fp = fopen($file_name, "a");
    $msg = $now_time.";".$username."\t;".$msg."\t;".$ip."\n";
    fwrite($fp, $msg);
    fclose($fp);
}
// ��÷����û���IP
function GET_IP() {
    //php��ȡip���㷨
    if (getenv('HTTP_CLIENT_IP')) {
        $onlineip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $onlineip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR')) {
        $onlineip = getenv('REMOTE_ADDR');
    } else {
        $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    }
    return $onlineip;
}
// ��ȡ��ǰʱ���
function now_time() {
    date_default_timezone_set(TIME_ZONE);
    $now_time = date('Y-m-d G:i:s');
    return $now_time;
}


?>
