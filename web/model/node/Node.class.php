<?php

class Node
{
/************************* ATTRIBUTES ************************/
	protected $id;
	protected $pointGPS;
	

/************************ CONSTRUCTOR ************************/

	public function __construct($anId, PointGPS $aPointGPS)
	{
		$this->id = $anId;
		$this->pointGPS = $aPointGPS;
	}


/************************** METHODS **************************/

	public function display()
	{
		echo ' id: '.$this->id.' | pointGPS : ';
		$this->pointGPS->display();
	}


// GETTERS & SETTERS //
	public function getId()
	{
		return $this->id;
	}

	public function getPoint()
	{
		return $this->pointGPS;
	}

	public function setPoint(PointGPS $newPointGPS)
	{
		$this->pointGPS = $newPointGPS;
	}

}