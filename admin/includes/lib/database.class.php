<?php

	class Database{
			var $conn = "";
			var $db = "";
			var $result = "";
			var $length = "";
			var $lastquery = "";


	//////////////////////////////////////////////////////////////////
		public function __construct(){
			$this->conn = new mysqli(HOST,USER,PASS, DATABASE);
			if( mysqli_error($this->conn)){
				exit("Couldnt connect to MySQL");
			}
		}



	public function insert($table, $data){

		$dataarray = current($data);
		if ( is_array($dataarray) ) {

			$table = trim($table);
			$str = "(";
			$str2 = "(";	
			$a = 0;
			foreach ($data as $v) {
				
				//print_r($v);
				$a++;
				$b=0;
				if ( $a>1 ) $str2 .= ',
					(';
				foreach ($v as $key => $value) {
					$b++;
					if ($a==1) $str = $str . '`' . $key . '`' . ','; 

					if ( $b>1 ) $str2 .= ',';
					$str2 .= "'". addslashes( $value )  ."'";
				}		
				$str2 = $str2 . ")";		
			}
			$str = substr($str, 0, -1);
			//$str2 = substr($str2, 0, -1);
			$str = $str . ")";
		//	$str2 = $str2 . ")";


		} else {

			$table = trim($table);
			$str = "(";
			$str2 = "(";	
			foreach ($data as $key => $value) {
				$str = $str . '`' . $key . '`' . ','; 
				$str2 = $str2 ."'". $value  ."'". ',';
			}
			$str = substr($str, 0, -1);
			$str2 = substr($str2, 0, -1);
			$str = $str . ")";
			$str2 = $str2 . ")";

		}

		
		$query = "INSERT INTO `$table` $str VALUES $str2 ";
		
		$this->query($query);
		if( mysqli_error($this->conn)){
			die( mysqli_error($this->conn) );  
		}
		return $this->conn->affected_rows;
	}
	
	public function lastid(){
		return $this->conn->insert_id;
	}


	public function free(  ){
		//$this->result->free();
	}

	///////////////////////////////////////////////////////////////

	public function update($table, $data, $where){
		$table = trim($table);
		$str = "";
		foreach ($data as $key => $value) {
			$str = $str . '`' . $key . '`' . ' = ' . "'" . $value . "'" . ', '; 

		}

		$str = substr($str, 0, -2); //-2 because it has comma and a space

		$query = "UPDATE `$table` SET $str WHERE $where ";
		//echo $query;
		$this->query($query);
		return $this->conn->affected_rows;
	}

//////////////////////////////////////////////////////////////////

	public function query($sql){
			$this->result = $this->conn->query($sql);
			
			if (DEBUG == 1) echo $sql.'
				';
			if (DEBUG == 1) echo mysqli_error($this->conn);
			
			if ( isset($this->result->num_rows) )  return $this->length = $this->result->num_rows;

	}

//////////////////////////////////////////////////////////////////
	public function select($sel = '*' , $from, $where = '1=1', $order = ''){
		$from = trim($from);
		if ($where == '') $where = '1=1';
		if ($order != '') $order = 'ORDER BY '.$order;
		$sql = "SELECT $sel FROM $from WHERE $where ".$order;
		$this->query($sql);
		
		return $this->length;
	}
/////////////////////////////////////////////////////////////
	public function delete($from, $where){
		$from = trim($from);
		$sql = "DELETE FROM $from WHERE $where ";
		$this->query($sql);
		return $this->conn->affected_rows;
	}

/////////////////////////////////////////////////////////////
    public function escape($string)
      {
          if (is_array($string)) {
			  foreach ($string as $key => $value) :
				  $string[$key] = mysql_real_escape_string($value,$this->conn);
			  endforeach;
		  } else 
			  $string = mysql_real_escape_string($string,$this->conn);;
		  
		  return $string;
      }

      //////////////////////////////////////////////////

      public function getObjectResults(){
      		if ( $this->length > 0 )
			return $this->result->fetch_object() ;
      }

      /////////////////////////////////////////////////
}
?>