<?php

class PointGPS
{
/************************* ATTRIBUTES ************************/
	protected $id;
	protected $lat;
	protected $lon;

/************************ CONSTRUCTOR ************************/

	public function __construct($anId, $aLat, $aLon)
	{
		$this->id = $anId;
		$this->lat = $aLat;
		$this->lon = $aLon;
	}


/************************** METHODS **************************/

	public function display()
	{
		echo 'ID: '.$this->id.' | Lat: '.$this->lat.
		' | Lon: '.$this->lon;
	}


// GETTERS & SETTERS //
	public function getId()
	{
		return $this->id;
	}

	public function getLat()
	{
		return $this->lat;
	}

	public function getLon()
	{
		return $this->lon;
	}

	public function setLat($newLat)
	{
		$this->lat = $newLat;
	}

	public function setLon($newLon)
	{
		$this->lon = $newLon;
	}
}