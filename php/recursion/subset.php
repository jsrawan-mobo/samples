<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jag
 * Date: 10/22/11
 * Time: 2:55 AM
 * To change this template use File | Settings | File Templates.
 */
 


/**
 *
 * subset arrays
 */

$seq = array ( 3, 4, 9, 14, 15, 19, 28, 37, 47, 50, 54, 56, 59, 61, 70, 73, 78, 81, 92, 95, 97, 99 );


//Should be
//$seq = array ( 1,2,3,4,5, 45,46,47,48,49, 50);

//Should be  6
//$seq = array ( 3, 4, 6 ,7, 10, 40, 50);

//Should be 5
//$seq = array ( 3, 4, 9, 14, 15, 19, 28, 37);

// should be 4
//$seq = array(1, 2, 3, 4, 6);

// Should be 0
//$seq = array(1, 1);


/**
 * Uses POE to get rid overflowing numbers relative to the one that we are searching.
 * Each pass aims to do a single burst through the array
 * We assume the array is sorted.  With this property we can assure no subsets are possible
 * After an overflow.
 *
 * So we only match the largest element in the array;
 */
function findAllSumsOld($subSetArray, $expectedSum)
{

    $foundArray = array();


    /**
     * We take each number and find the subsets possible with that number
     * k = is the main number
     *
     */
    for ($i = count($subSetArray) - 1  ; $i > 0 ; $i--)
    {
        $currentArray = array();
        $mainNum = $subSetArray[$i];
        $currentSum = $mainNum;
        $currentArray[$i] =  $mainNum;
        for ($j = $i - 1 ; $j >= 0 ; $j--)
        {

            $item = $subSetArray[$j];
            $newSum = $currentSum + $item;
            if ( $newSum > $expectedSum )
            {
                continue;
            }
            else if ( $newSum == $expectedSum )
            {
                $currentArray[$j] = $item;
                $foundArray = array_merge($foundArray, array(array_values($currentArray)));
                //pop the highest number, and start again
                $keys = array_keys($currentArray);
                $j = $keys[1]; //we want the first j key and subtract 1 from it.  The very first key is the mainNum.
                $currentArray = array();
                $currentSum = $mainNum;
                $currentArray[$i] =  $mainNum;


                continue;

            }
            else
            {
                $currentArray[$j] = $item;
                $currentSum = $newSum;
            }

        }
    }
    return $foundArray;
}


/**
 * To get all combinations, we simple recurse through each combination
 * that starts with the integer given.  If at any time
 * @param $subSetArray
 * @param $expectedSum
 * @return int[]
 *
 */
function findAllSums($subSetArray, $expectedSum)
{


    $foundArray = array();

    $lastI = count($subSetArray) - 1;

    /**
     * else permutations through leftover data.
     */
    for ($i = $lastI  ; $i >= 0 ; $i--)
    {
        if ($expectedSum  == $subSetArray[$i] )
        {
             $foundArray[] =  array($subSetArray[$i]) ;
             continue;
        }
        $currentArrays = findAllSums( array_slice($subSetArray, 0, $i), $expectedSum - $subSetArray[$i] );
        if ( count($currentArrays) > 0 )
        {
            foreach ($currentArrays as $partialArray)
            {
                $foundArray[] = array_merge($partialArray, array($subSetArray[$i] ) );
            }
        }
    }
    return $foundArray;
}

var_dump($seq);

$len = count($seq);

$setFound = array();
for ($i = 1 ; $i < $len ; $i++)
{
    $currentArray = array();
    $currentArray = findAllSums( array_slice($seq,0,$i) , $seq[$i] );
    $setFound = array_merge($setFound, $currentArray);
}

echo "set found";
var_dump($setFound);


?>