<?php

class PointGPS
{
/************************* ATTRIBUTES ************************/
	protected $idosm;
	protected $lat;
	protected $lon;

/************************ CONSTRUCTOR ************************/

	public function __construct($anIdosm, $aLat, $aLon)
	{
		$this->idosm = $anIdosm;
		$this->lat = $aLat;
		$this->lon = $aLon;
	}


/************************** METHODS **************************/

	public function display()
	{
		echo ' idosm: '.$this->idosm.' | lat: '.$this->lat.
		' | lon: '.$this->lon;
	}


// GETTERS & SETTERS //
	public function getIdosm()
	{
		return $this->idosm;
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