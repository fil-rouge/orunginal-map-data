<?php
echo "dbserializer; ";




reset_osm_file();
print_osm_nodes(2500);
//print_osm_ways(5500);
end_osm_file();

/**
*	Reset & print header to osm file
*/
function reset_osm_file()
{
	$fileOsm=dirname(__DIR__).'/../files/osm/database.osm';

	reset_write_to_file($fileOsm, "<?xml version='1.0' encoding='UTF-8'?>");
	append_to_file($fileOsm, "<osm version='0.6' generator='Osmosis 0.43.1'>");
}

/**
*	Print last tag to osm file
*/
function end_osm_file()
{
	$fileOsm=dirname(__DIR__).'/../files/osm/database.osm';

	append_to_file($fileOsm, "</osm>");
}

/**
*	Print intersections to osm file
*/
function print_osm_nodes($limit)
{
	$fileOsm=dirname(__DIR__).'/../files/osm/database.osm';

	$nodes = get_intersections($limit);

	foreach ($nodes as $node) 
	{
		//var_dump($node['idosm']);
		$line = "<node id='".$node['idosm']."' lat='".$node['lat']."' lon='".$node['lon']."'/>";
		append_to_file($fileOsm, $line);
	}
}

/**
*	Print ways to osm file
*/
function print_osm_ways($limit)
{
	$segments = get_segment($limit);

	foreach ($segments as $segment) 
	{
		print_osm_way($segment['id']);
	}
}

/**
*	Print one way to osm file
*/
function print_osm_way($idsegment)
{
	$fileOsm=dirname(__DIR__).'/../files/osm/database.osm';

	$nds = get_NDs_by_id($idsegment);

	$line = "<way id='".$idsegment."'>";
	append_to_file($fileOsm, $line);

	foreach ($nds as $node) 
	{
		$line = "<nd ref='".$node['idpointgps']."'/>";
		append_to_file($fileOsm, $line);
	}

	append_to_file($fileOsm, "</way>");
}

