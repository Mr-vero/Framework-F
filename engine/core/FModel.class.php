<?php
/*
*  Author :  Irvan
*  Version : 0.0.1
*  Last Modified: September 17, 2016
*  Path : framework/core/Model.class.php
*/
// Base Model Class
class Model{
    protected $db; //database connection object
    protected $table; //table name
    protected $fields = array();  //fields list
    public function __construct($table){
        $dbconfig['host'] = $GLOBALS['config']['host'];
        $dbconfig['user'] = $GLOBALS['config']['user'];
        $dbconfig['password'] = $GLOBALS['config']['password'];
        $dbconfig['dbname'] = $GLOBALS['config']['dbname'];
        $dbconfig['port'] = $GLOBALS['config']['port'];
        $dbconfig['charset'] = $GLOBALS['config']['charset'];

        $this->db = new Mysql($dbconfig);

        $this->table = $GLOBALS['config']['prefix'] . $table;
        $this->getFields();
    }
    /*
     * Get the list of table fields
     *
     */
    private function getFields(){
        $sql = "DESC ". $this->table;
        $result = $this->db->getAll($sql);
        foreach ($result as $v) {
            $this->fields[] = $v['Field'];
            if ($v['Key'] == 'PRI') {
                // If there is PK, save it in $pk
                $pk = $v['Field'];
            }
        }
        // If there is PK, add it into fields list
        if (isset($pk)) {
            $this->fields['pk'] = $pk;
        }
    }
    /*
     * Insert records
     * @access public
     * @param $list array associative array
     * @return mixed If succeed return inserted record id, else return false
     */
    public function insert($list){
        $field_list = '';  //field list string
        $value_list = '';  //value list string
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields)) {
                $field_list .= "`".$k."`" . ',';
                $value_list .= "'".$v."'" . ',';
            }
        }
        // Trim the comma on the right
        $field_list = rtrim($field_list,',');
        $value_list = rtrim($value_list,',');
        // Construct sql statement
        $sql = "INSERT INTO `{$this->table}` ({$field_list}) VALUES ($value_list)";
        if ($this->db->query($sql)) {
            // Insert succeed, return the last record’s id
            return $this->db->getInsertId();
            //return true;
        } else {
            // Insert fail, return false
            return false;
        }
    }

    /*
     * Update records
     * @access public
     * @param $list array associative array needs to be updated
     * @return mixed If succeed return the count of affected rows, else return false
     */

    public function update($list){

        $uplist = ''; //update fields

        $where = 0;   //update condition, default is 0

        foreach ($list as $k => $v) {

            if (in_array($k, $this->fields)) {

                if ($k == $this->fields['pk']) {

                    // If it’s PK, construct where condition

                    $where = "`$k`=$v";

                } else {

                    // If not PK, construct update list

                    $uplist .= "`$k`='$v'".",";
                }
            }
        }
        // Trim comma on the right of update list
        $uplist = rtrim($uplist,',');
        // Construct SQL statement
        $sql = "UPDATE `{$this->table}` SET {$uplist} WHERE {$where}";

        if ($this->db->query($sql)) {
            // If succeed, return the count of affected rows
            if ($rows = mysql_affected_rows()) {
                // Has count of affected rows  
                return $rows;
            } else {
                // No count of affected rows, hence no update operation
                return false;
            }    
        } else {
            // If fail, return false
            return false;
        }
    }

    /*
     * Delete records
     * @access public
     * @param $pk mixed could be an int or an array
     * @return mixed If succeed, return the count of deleted records, if fail, return false
     */
    public function delete($pk){
        $where = 0; //condition string
        //Check if $pk is a single value or array, and construct where condition accordingly
        if (is_array($pk)) {
            // array
            $where = "`{$this->fields['pk']}` in (".implode(',', $pk).")";
        } else {
            // single value
            $where = "`{$this->fields['pk']}`=$pk";
        }
        // Construct SQL statement
        $sql = "DELETE FROM `{$this->table}` WHERE $where";
        if ($this->db->query($sql)) {
            // If succeed, return the count of affected rows
            if ($rows = mysql_affected_rows()) {
                // Has count of affected rows
                return $rows;
            } else {
                // No count of affected rows, hence no delete operation
                return false;
            }        
        } else {
            // If fail, return false
            return false;
        }
    }

    /*
     * Get info based on PK
     * @param $pk int Primary Key
     * @return array an array of single record
     */
    public function selectByPk($pk){
        $sql = "select * from `{$this->table}` where `{$this->fields['pk']}`=$pk";
        return $this->db->getRow($sql);
    }

    /*
     * Get the count of all records
     *
     */
    public function total(){
        $sql = "select count(*) from {$this->table}";
        return $this->db->getOne($sql);
    }

    /*
     * Get info of pagination
     * @param $offset int offset value
     * @param $limit int number of records of each fetch
     * @param $where string where condition,default is empty
     */
    public function pageRows($offset, $limit,$where = ''){
        if (empty($where)){
            $sql = "select * from {$this->table} limit $offset, $limit";
        } else {
            $sql = "select * from {$this->table}  where $where limit $offset, $limit";
        }
        return $this->db->getAll($sql);
    }
}