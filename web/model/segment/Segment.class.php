<?php

class Segment
{
/************************* ATTRIBUTES ************************/
	protected $id;
	protected $distance;
	protected $note;
	protected $idNodeA;
	protected $idNodeB;
	protected $pointsGPS[];

/************************ CONSTRUCTOR ************************/

	public function __construct($anId, $aDistance, $aNote, $anIdNodeA, 
								$anIdNodeB, $listPoints)
	{
		$this->id = $anId;
		$this->distance = $aDistance;
		$this->note = $aNote;
		$this->idNodeA = $anIdNodeA;
		$this->idNodeB = $anIdNodeB;
		$this->pointsGPS[] = $listPoints;
	}


/************************** METHODS **************************/

	public function display()
	{
		echo 'id: '.$this->id.' | distance: '.$this->distance
			 .' | note: '.$this->note.' | idNodeA: '.$this->idNodeA
			 .' | idNodeB: '.$this->idNodeA.' | pointsGPS: '.$this->pointsGPS[];
	}


// GETTERS & SETTERS //
	public function getId()
	{
		return $this->id;
	}


	public function getDistance()
	{
		return $this->distance;
	}

	public function setDistance($newDistance)
	{
		$this->distance = $newDistance;
	}


	public function getNote()
	{
		return $this->note;
	}

	public function setNote($newNote)
	{
		$this->note = $newNote;
	}


	public function getIdNodeA()
	{
		return $this->idNodeA;
	}

	public function setIdNodeA($newIdNodeA)
	{
		$this->idNodeA = $newIdNodeA;
	}


	public function getIdNodeB()
	{
		return $this->idNodeB;
	}

	public function setIdNodeB($newIdNodeB)
	{
		$this->idNodeB = $newIdNodeB;
	}
}