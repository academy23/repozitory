<?php
	class Database {
	
		public function getConnector() {
			require("config.php");
			$connection = mysql_connect($host,$user,$pwd);
			mysql_select_db($dbName,$connection);
			mysql_set_charset( 'utf8' );
			return $connection;
		}
		
		public function getConnectorByPar($host, $user, $pass) {
			return mysql_connect($host,$user,$pass);		
		}
		
		public function selectDatabase($database) {
			mysql_select_db($database);
		}	
		
		
		public function getQueryResult($connection ,$sqlQuery) {
			return mysql_query($sqlQuery);
		}

		public function closeConnection($result, $connection) {
			mysql_free_result($result);
			mysql_close($connection);
		}
	}
	
	
?>