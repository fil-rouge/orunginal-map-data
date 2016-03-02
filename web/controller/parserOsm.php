<?php
// Initialize the XML parser
$parser=xml_parser_create();

$countWay=0;
$countNode=0;
$countNd=0;
$count=0;

/*********** STORE SEGMENT INFORMATION ***************/
$anIdsegosm=0;
$aDistance=0;
$aNote=0;
$tmpSegPoints=null;
$nbPoint=0;

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
      global $parserOn;
      if (parserOn)
      {
        $segments = get_segment_by_idosm($element_attrs['ID']);

        if (count($segments)!=0)
        {
          // Segment already in database -> don't parse the 
          // following NDs
          $parserOn = false;
          echo "PARSER OFF !!<br/>";
        }
        else
        {
          global $anIdsegosm;
          global $aDistance;
          global $aNote;

          $anIdsegosm=$element_attrs['ID'];
          $aDistance=0;
          $aNote=0;
        }
      }
      // global $countWay;
      // $countWay++;
      break;
    case "ND":
      if (parserOn)
      {
        global $tmpSegPoints;
        global $nbPoint;

        //  Check if first GPS point of the segment
        if($nbPoint==0)
        {
          $tmpSegPoints[$nbPoint] = $element_attrs['ID'];
          $nbPoint = $nbPoint+1;
          break;
        }
        else
        {
          //  Check if current point is already part of a segment in DB
          $points = get_point_by_id_from_s2p($element_attrs['ID']);

          if (count($points)!=0)
          {
            // Already part of a segment
            if ($points['isnode']==true)
            {
              // We found node B for the current segment !!
              $tmpSegPoints[$nbPoint] = $element_attrs['ID'];
              $nbPoint = $nbPoint+1;

              global $anIdsegosm;
              global $aDistance;
              global $aNote;

              //  INSERT NEW SEGMENT TO DB
              try {

              }
              catch(Exception $e)
              {
                  die('Erreur : '.$e->getMessage());
              }
              $idSeg = insert_segment_into_segments($anIdsegosm, $aDistance, 
                                                    $aNote, $tmpSegPoints[0], 
                                                    $tmpSegPoints[$nbPoint-1]);

              insert_segment_into_s2p($idSeg['id'], $tmpSegPoints);

              //  RESET LIST STRUCTURE
              $tmpSegPoints[0] = null;
              $tmpSegPoints[0] = $element_attrs['ID'];
              $nbPoint = 1;
              $aDistance=0;
              $aNote=0;
            }
            else
            {
              // less easy TODO
            }
          }
          else
          {
            //  Add to segment list
            $tmpSegPoints[$nbPoint] = $element_attrs['ID'];
            $nbPoint = $nbPoint+1;
          }
        }
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
      global $nbPoint;
      global $tmpSegPoints;
      $tmpSegPoints=null;
      $nbPoint=0;
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