<?php

class Node
{
/************************* ATTRIBUTES ************************/
	protected $id;
	protected $idPoint;
	

/************************ CONSTRUCTOR ************************/

	public function __construct($anId, $anIdPoint)
	{
		$this->id = $anId;
		$this->idPoint = $anIdPoint;
	}


/************************** METHODS **************************/

	public function display()
	{
		echo 'ID: '.$this->id.' | IdPoint: '.$this->idPoint;
	}


// GETTERS & SETTERS //
	public function getId()
	{
		return $this->id;
	}

	public function getIdPoint()
	{
		return $this->idPoint;
	}

	public function setIdPoint($newIdPoint)
	{
		$this->idPoint = $newIdPoint;
	}

}