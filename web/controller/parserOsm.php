<?php
// Initialize the XML parser
$parser=xml_parser_create();

$countWay=0;
$countNode=0;
$countNd=0;
$count=0;

/*********** STORE SEGMENT INFORMATION ***************/
$tmpNodeA=null;
$tmpNodeB=null;
$tmpSegPoints=null;

//  Boolean to know if the parser should parse the tag or not
$parserOn=true;

// Function to use at the start of an element
function start($parser,$element_name,$element_attrs) {
  //echo $element_name;
  // global $count;
  // $count=$count+1;
  switch($element_name) {
    case "NODE":
      //global $countNode;
      //$countNode++;
      //insert_pointgps($element_attrs['ID'],$element_attrs['LAT'],
      //                $element_attrs['LON']);
    break;
    case "WAY":
      if (parserOn)
      {
        $segments = get_segment_by_idosm($element_attrs['ID']);
        if (count($segments)!=0)
        {
          // Segment already in database -> don't parse the 
          // following NDs
          global $parserOn;
          $parserOn = false;
        }
      }
      // global $countWay;
      // $countWay++;
      break;
    case "ND":
      if (parserOn)
      {
      }
      //echo "way/node: ";
      // global $countNd;
      // $countNd++;
      break;
  }
}

// Function to use at the end of an element
function stop($parser,$element_name) {
  //echo "<br>";
  switch($element_name) {
    case "WAY":
      // Reactivate parser
      global $parserOn;
      $parserOn = true;

      // Initiate variables
      global $tmpNodeA;
      global $tmpNodeB;
      global $tmpSegPoints;
      $tmpNodeA=null;
      $tmpNodeB=null;
      $tmpSegPoints=null;

      break;
  }
}

// Function to use when finding character data
function char($parser,$data) {
  echo $data;
}

// Specify element handler
xml_set_element_handler($parser,"start","stop");

// Specify data handler
xml_set_character_data_handler($parser,"char");

// Open XML file
$fp=fopen("dirname(__DIR__).'/../../files/osm/villeurbanneTout.osm","r");

// Read data
while ($data=fread($fp,4096)) {
  xml_parse($parser,$data,feof($fp)) or
  die (sprintf("XML Error: %s at line %d",
  xml_error_string(xml_get_error_code($parser)),
  xml_get_current_line_number($parser)));
}

// echo "count=". $GLOBALS['count']."<br>";
// echo "countNode=". $GLOBALS['countNode']."<br>";
// echo "countWay=". $GLOBALS['countWay']."<br>";
// echo "countNd=". $GLOBALS['countNd']."<br>";

// Free the XML parser
xml_parser_free($parser);