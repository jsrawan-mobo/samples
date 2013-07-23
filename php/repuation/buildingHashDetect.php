<?php


/**
 * @param int[]
 */
global $skylineLookup = array();


function buildHash($xL, $xR, $h2)
{
    for($x=$xL ; $x<= $xR ; $x++)
    {
        //@TODo need to checkup.
        $skylineLookup[$x] = $h2;

    }
}


/**
 * @param $x
 * @param $y
 * @return bool
 */
function lookupHash($x,$y)
{
    if ( isset($skylineLookup[$x]) && $skylineLookup[$x] < $y )
    {
        return true;
    }
}


$buildings = array( 'x1'=>1, 'xR'=>10, 'h'=>10 );

/**
 * 1. Build the Hash
 *
 */
for ($i = 0 ; $i < count($buildings) ; $i++)
{
    buildHash($buildings['x1'], $buildHash['xR'], $buildHash['h'] );

}


/**
 * 2. Lookup the Hash
 *
 */

$points = array($x=>1, $y=>1);

 lookupHash($points[$x], )



?>
