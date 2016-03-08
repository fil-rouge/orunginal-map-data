<?php

class Segment
{
/************************* ATTRIBUTES ************************/
	protected $id;
	protected $idSegosm;
	protected $distance;
	protected $note;
	protected $nodeA;
	protected $nodeB;
	protected $pointsGPS; //list


/************************ CONSTRUCTOR ************************/

	public function __construct($anId, $aDistance, $aNote, Node $aNodeA, 
								Node $aNodeB, $listPoints)
	{
		$this->id = $anId;
		$this->distance = $aDistance;
		$this->note = $aNote;
		$this->nodeA = $aNodeA;
		$this->nodeB = $aNodeB;
		$this->pointsGPS = $listPoints;
	}


/************************** METHODS **************************/

	public function display()
	{
		echo 'id: '.$this->id.' | distance: '.$this->distance
			 .' | note: '.$this->note.' | nodeA= ';

		$this->nodeA->display();

		echo ' | idNodeB= ';

		$this->nodeB->display();

		echo ' | pointsGPS: '.$this->pointsGPS;
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


	public function getNodeA()
	{
		return $this->nodeA;
	}

	public function setNodeA(Node $newNodeA)
	{
		$this->nodeA = $newNodeA;
	}


	public function getNodeB()
	{
		return $this->nodeB;
	}

	public function setNodeB(Node $newNodeB)
	{
		$this->nodeB = $newNodeB;
	}

	// List of GPS points
	public function getPointsGPS()
	{
		return $this->pointsGPS;
	}

	public function setPointGPS($newList)
	{
		$this->pointsGPS = $newList;
	}

}
