<?php

interface  IDatabaseFunction {
	
	public function select($order=null);
		
	public function insertValue($value);

	public function updateValue($index, $value);
	
	public function deleteById($index);

	public function search($part_of_word);
	
	public static function getList();
		
}
?>