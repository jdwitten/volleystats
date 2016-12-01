<?php

class Stat
{
	
	private $stat_code;
	private $value;



	public function __construct($stat_code, $value)
	{
		$this->stat_code = $stat_code;
		$this->value = $value;

	}

	public function convertToArray()
	{
		return Array("stat_code"=>$this->stat_code, "value"=>$this->value);
	}




}

?>