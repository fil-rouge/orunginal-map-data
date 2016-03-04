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
  global $parserOn;

  switch($element_name) {
    case "NODE":
      //  Write insert into commands into insertPoints.sql file
      // insert_pointgps($element_attrs['ID'],$element_attrs['LAT'],
      //                $element_attrs['LON']);
    break;
    case "WAY":
      if ($parserOn)
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
          //  Initiate the segment structure
          global $anIdsegosm;
          global $aDistance;
          global $aNote;

          $anIdsegosm=$element_attrs['ID'];
          $aDistance=0;
          $aNote=0;
        }
      }
       
      break;
    case "ND":
      if ($parserOn)
      {
        global $tmpSegPoints;
        global $nbPoint;

        //  Check if current point is the first GPS point of the segment
        if($nbPoint==0)
        {
          $tmpSegPoints[$nbPoint] = $element_attrs['REF'];
          $nbPoint = 1;
          break;
        }
        else
        {
          //  Check if current point is already part of a segment in DB
          $points = get_point_by_id_from_s2p($element_attrs['REF']);

          if (count($points)!=0)
          {
            // Already part of a segment
            
            // We found node B for the current segment !!
            $tmpSegPoints[$nbPoint] = $element_attrs['REF'];
            $nbPoint = $nbPoint+1;

            global $anIdsegosm;
            global $aDistance;
            global $aNote;

            //  INSERT NEW SEGMENT TO DB
            try 
            {
              echo "INSERT new segment ! <br/>";
              $idSeg = insert_segment_into_segments($anIdsegosm, $aDistance, 
                                                    $aNote, $tmpSegPoints[0], 
                                                    $tmpSegPoints[$nbPoint-1]);

              insert_segment_into_s2p($idSeg[0]['id'], $tmpSegPoints);
            }
            catch(Exception $e)
            {
              echo "FAIL: INSERT SEGMENT INTO DB !<br/>";
              die('Erreur : '.$e->getMessage());
            }
            

            //  RESET LIST STRUCTURE
            $tmpSegPoints[0] = null;
            $tmpSegPoints[0] = $element_attrs['REF'];
            $nbPoint = 1;
            $aDistance=0;
            $aNote=0;

            if ($points[0]['isnode']==false)
            {
              //  FOUND NEW NODE -> Cut existing segment into 2 segments

              /******** NEW SEGMENTS STRUCTURES ********/
              $newSegment1=null;
              $nbPoint1=0;
              $newSegment2=null;
              $nbPoint2=0;

              $olds2p = delete_from_s2p_by_id($points[0]['idsegment']);
              $oldSegment = delete_from_segments_by_id($points[0]['idsegment']);

              /***********************************************/
              //        DB ready to welcome new segments
              //        Need to create the 2 segments
              /***********************************************/
              /***** FIRST SEGMENT ******/
              foreach ($olds2p as $point) 
              {
                if($point['idpointgps']==$points[0]['idpointgps'])
                {
                  //  FOUND NEW NODE
                  $newSegment1[$nbPoint1] = $point['idpointgps'];
                  $nbPoint1 = $nbPoint1 + 1;

                  // Also add to segment2

                  $newSegment2[0] = $point['idpointgps'];
                  $nbPoint2 = 1;
                  break;
                }
                else
                {
                  //  Add to segment list
                  $newSegment1[$nbPoint1] = $point['idpointgps'];
                  $nbPoint1 = $nbPoint1 + 1;
                }
              }

              /***** SECOND SEGMENT ******/
              $olds2pLength = count($olds2p);
              for ($i=$nbPoint1; $i < $olds2pLength ; $i++) 
              { 
                $newSegment2[$nbPoint2] = $olds2p[$i]['idpointgps'];
                $nbPoint2 = $nbPoint2 + 1;  
              }

              /*****************************************************/
              //            INSERT TWO NEW SEGMENT TO DB
              /*****************************************************/
              try 
              {
                // segment1
                $idSeg1 = insert_segment_into_segments($oldSegment[0]['idsegosm'], 
                                                      $oldSegment[0]['distance'], 
                                                      $oldSegment[0]['note'], 
                                                      $newSegment1[0], 
                                                      $newSegment1[$nbPoint1-1]);

                insert_segment_into_s2p($idSeg1[0]['id'], $newSegment1);

                // segment2
                $idSeg2 = insert_segment_into_segments($oldSegment[0]['idsegosm'], 
                                                      $oldSegment[0]['distance'], 
                                                      $oldSegment[0]['note'], 
                                                      $newSegment2[0], 
                                                      $newSegment2[$nbPoint2-1]);

                insert_segment_into_s2p($idSeg2[0]['id'], $newSegment2);
              }
              catch(Exception $e)
              {
                echo "FAIL: INSERT 2 NEW SEGMENTS INTO DB !<br/>";
                die('Erreur : '.$e->getMessage());
              }

            }
          }
          else
          {
            //  Not found in table s2p -> Add to segment list
            $tmpSegPoints[$nbPoint] = $element_attrs['REF'];
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
      global $nbPoint;
      if ($nbPoint>1)
      {
        global $tmpSegPoints;
        global $anIdsegosm;
        global $aDistance;
        global $aNote;

        //  INSERT NEW SEGMENT TO DB
        try 
        {
          $idSeg = insert_segment_into_segments($anIdsegosm, $aDistance, 
                                                $aNote, $tmpSegPoints[0], 
                                                $tmpSegPoints[$nbPoint-1]);
          insert_segment_into_s2p($idSeg[0]['id'], $tmpSegPoints);
        }
        catch(Exception $e)
        {
          echo "FAIL: INSERT SEGMENT INTO DB !<br/>";
          die('Erreur : '.$e->getMessage());
        }
      }

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

while ($data=fread($fp,4096) AND $countWay<2500) {
  $countWay = $countWay + 1;
  xml_parse($parser,$data,feof($fp)) or
  die (sprintf("XML Error: %s at line %d",
  xml_error_string(xml_get_error_code($parser)),
  xml_get_current_line_number($parser)));
}

// echo "count=". $GLOBALS['count']."<br>";
// echo "countNode=". $GLOBALS['countNode']."<br>";
 echo "countWay=".$countWay."<br>";
// echo "countNd=". $GLOBALS['countNd']."<br>";

// Free the XML parser
xml_parser_free($parser);