<?php
require_once 'baseConf.php';



/**
���ܣ����ݿ�Ļ���������
**/
class DBConn{
    private $CONN = "";                                 //�������ݿ����ӱ���
    /**
     * ���ܣ���ʼ�����캯�����������ݿ�
     */
    public function __construct(){
        try {                                           //�������Ӵ�����ʾ�����ļ�
            $conn = mysql_connect(DB_HOST,DB_USER,DB_PASSWD);
            //echo "www=",DB_HOST,DB_USER,DB_PASSWD,"fdsjkalfj";
        }catch (Exception $e)
        {
            $msg = $e;
            include(ERROR_FILE);
        }
        try {                                           //�������ݿ�ѡ�������ʾ�����ļ�
            mysql_select_db(DB_NAME,$conn);
            mysql_query("set names 'utf8'");
        }catch (Exception $e)
        {
            $msg = $e;
            include(ERROR_FILE);
        }
        $this->CONN = $conn;
    }
    /**
     * ���ܣ����ݿ��ѯ����
     * ������$sql SQL���
     * ���أ���Ψ�����false
     */
    public function select($sql = ""){
        if (empty($sql)) return false;                  //���SQL���Ϊ���򷵻�FALSE
        if (empty($this->CONN)) return false;           //�������Ϊ���򷵻�FALSE
        $results = NULL;
        //echo $sql;
        try{                                            //�������ݿ�ѡ�������ʾ�����ļ�
            $results = @mysql_query($sql,$this->CONN);
        }catch (Exception $e){
            $msg = $e;
            include(ERROR_FILE);
        }
        if ((!$results) or (empty($results))) {         //�����ѯ���Ϊ�����ͷŽ��������FALSE
            @mysql_free_result($results);
            return false;
        }
        $count = 0;
        $data = array();
        while ($row = @mysql_fetch_array($results)) {   //�Ѳ�ѯ��������һ����ά����
            $data[$count] = $row;
            $count++;
        }
        @mysql_free_result($results);
        return $data;
    }

    /**
     * ���ܣ����ݲ��뺯��
     * ������$sql SQL���
     * ���أ�0���²������ݵ�ID
     */
    public function insert($sql = ""){                                                                            
        if (empty($sql)) return FALSE;                      //���SQL���Ϊ���򷵻�FALSE                          
        if (empty($this->CONN)) return FALSE;               //�������Ϊ���򷵻�FALSE                             
        try{                                            //�������ݿ�ѡ�������ʾ�����ļ�                        
            $results = mysql_query($sql,$this->CONN);                                                             
        }catch(Exception $e){                                                                                     
            $msg = $e;                                                                                            
            include(ERROR_FILE);                                                                                  
        }                                                                                                         
        if (!$results)                                  //�������ʧ�ܷ���0�����򷵻ص�ǰ��������ID               
            return FALSE;                                                                                         
        else                                                                                                      
            return mysql_insert_id();                                                                             
    }                                                                                                             
                                                                                                                  
    /**                                                                                                           
     * ���ܣ����ݸ��º���                                                                                         
     * ������$sql SQL���                                                                                         
     * ���أ�TRUE OR FALSE                                                                                        
     */                                                                                                           
    public function update($sql = ""){                                                                            
        if(empty($sql)) return false;                   //���SQL���Ϊ���򷵻�FALSE                              
        if(empty($this->CONN)) return false;            //�������Ϊ���򷵻�FALSE                                 
        try{                                            //�������ݿ�ѡ�������ʾ�����ļ�                        
            $result = mysql_query($sql,$this->CONN);                                                              
        }catch(Exception $e){                                                                                     
            $msg = $e;                                                                                            
            include(ERROR_FILE);                                                                                  
                                                                                                                  
        }                                                                                                         
        return $result;                                                                                           
    }                                                                                                             
    /**                                                                                                           
     * ���ܣ�����ɾ������                                                                                         
     * ������$sql SQL���                                                                                         
     * ���أ�TRUE OR FALSE                                                                                        
     */                                                                                                           
    public function delete($sql = ""){                                                                            
        if(empty($sql)) return false;                   //���SQL���Ϊ���򷵻�FALSE                              
        if(empty($this->CONN)) return false;            //�������Ϊ���򷵻�FALSE                                 
        try{                                                                                                      
            $result = mysql_query($sql,$this->CONN);                                                              
        }catch(Exception $e){                                                                                     
            $msg = $e;                                                                                            
            include(ERROR_FILE);                                                                                  
        }                                                                                                         
        return $result;                                                                                           
    }                                                                                                             
    /**                                                                                                           
     * ���ܣ���������                                                                                             
     */                                                                                                           
    public function begintransaction()                                                                            
    {                                                                                                             
        mysql_query("SET  AUTOCOMMIT=0");               //����Ϊ���Զ��ύ����ΪMYSQLĬ������ִ��                 
        mysql_query("BEGIN");                           //��ʼ������                                            
    }                                                                                                             
    /**                                                                                                           
     * ���ܣ��ع�                                                                                                 
     */                                                                                                           
    public function rollback()                                                                                    
    {                                                                                                             
        mysql_query("ROOLBACK");                                                                                  
    }                                                                                                             
    /**                                                                                                           
     * ���ܣ��ύִ��                                                                                             
     */                                                                                                           
    public function commit()                                                                                      
    {                                                                                                             
        mysql_query("COMMIT");                                                                                    
    }                                                                                                             
                                                                                                                  
                                                                                                                  
                                                                                                                  
}                                                                                                                 
                                                                                                                  
                                                                                                                  
?>
