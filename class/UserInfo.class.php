<?php
require_once 'DBConn.class.php';
//include_once '../conf.php';

# GM�û���
class UserInfo extends DBConn {

    function construct() {
        parent::__construct();
    }

    // �û���Ϣ
    function user_list(){
        $sql = "select * from user_info";
        $rs = $this->select($sql);
        return $rs;
    }

    // ��ȡ�����û���Ϣ
    function get_user_info($uid){
        $sql = "select * from user_info where id=$uid";
        $rs = $this->select($sql);
        return $rs;
    }

    //ɾ���û�
    function user_del($id){
        $id = addslashes(trim($id));                                                                              
        $sql = "delete from user_info where id=$id";
		$sql2 = "delete from order_info where user_id = $id";
		$sql3 = "delete from balance_log where user_id = $id";
		$this->begintransaction();
        $rs = $this->delete($sql);
		$rs2 = $this->delete($sql2);
		$rs3 = $this->delete($sql3);
        if ($rs and $rs2 and $rs3) {
            $this->commit();
            return TRUE;
        } else {
            $this->rollback();
            return FALSE;
        }
    }
	
    //����û�                                                                                               
    function check_user($username){                                                                     
        $username = addslashes(trim($username));
        $sql= "select * from user_info where username='$username'";     
        $rs = $this->select($sql);
        if ($rs) {                                                                                                
            return $rs;
        } else {                                                                                                    
            $url="http://192.168.1.2:8900/dish/get_realname.php?username=$username";
			$realname = file_get_contents($url);
			$add_sql = "insert into user_info(username,realname) values('$username','$realname')";
			$rs = $this->insert($add_sql);
			if ($rs) {
				$sql= "select * from user_info where username='$username'";
				$rs = $this->select($sql);
				return $rs;
			} else {
				return FALSE;
			}
        }
    }                                                                                                             
    
	//����                                                                                     
    function modify_realname($uid , $realname) {
		$uid = addslashes(trim($uid));
        $realname = addslashes(trim($realname));
        $sql = "update user_info set realname = '$realname' where id=$uid";
		$this->begintransaction();
        $rs = $this->update($sql); 
        if ($rs) {
            $this->commit();
            return TRUE;
        } else {
            $this->rollback();
            return FALSE;
        }
    }

    //�޸��Ƿ��ǹ���Ա
    function change_isadmin($uid){ //20110408 add by dzb
        $uid = addslashes(trim($uid));
		$sql= "select isadmin from user_info where id=$uid"; 
		$rs = $this->select($sql);
		$isadmin = $rs[0]['isadmin'];
		if($isadmin == 1){
			$sql_update = "update user_info set isadmin=0 where id=$uid ";
		}else{
			$sql_update = "update user_info set isadmin=1 where id=$uid ";
		}
        $this->update($sql_update);
        $rs = $this->select($sql);
		return $rs[0]['isadmin'];
    }
	
    //����                                                                                     
    function pay($uid , $money) {
		$uid = addslashes(trim($uid));
        $money = addslashes(trim($money));
        $paysql = "update user_info set balance = round((balance-$money),1) where id=$uid";
		$this->begintransaction();
        $rs = $this->update($paysql); 
        if ($rs) {
            $this->commit();
            return TRUE;
        } else {
            $this->rollback();
            return FALSE;
        }
    }
	
	//��ֵ
	function recharge($uid , $money) {
		$uid = addslashes(trim($uid));
        $money = addslashes(trim($money));
        $rechargesql = "update user_info set balance = round((balance+$money),1)  where id=$uid";
		$this->begintransaction();
        $rs = $this->update($rechargesql); 
        if ($rs) {
            $this->commit();
            return TRUE;
        } else {
            $this->rollback();
            return FALSE;
        }
    }
}                                                                                                                 
?>
