<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jag
 * Date: 10/22/11
 * Time: 2:55 AM
 * To change this template use File | Settings | File Templates.
 */
 


function fibnacciSequencePrint($n, $node = 'L') {

    if ($n == 0) {
       if ($node == 'L') print "0,";
        return 0;
    }

    if ($n == 1) {
        $fibN = fibnacciSequencePrint(0, $node) + 1;
        if ($node == 'L') print "0,1,";
        return 1;

    }

    $fibN = fibnacciSequencePrint($n-1, $node)  +  fibnacciSequencePrint($n-2, 'R');
    if ($node == 'L') print "$fibN,";
    return $fibN;

}




/**
 * @param $Fib1 - Fib(n-1)
 * @param $Fib2 - Fib (n-2)
 * @param $stopValue - after exceeding exit
 * @param bool $isPrime - ensure the number is Prime
 * @param $fibCnt - Fibnacci index
 * @return Fibnacci Number
 */
function fibnacciSequence($Fib1, $Fib2, $stopValue, $isPrime = false, &$fibCnt)
{
    if ($Fib1 == 0)
    {
        $fibCnt = 1;
    }
    $FibT = $Fib1 + $Fib2;
    if ( $FibT >  $stopValue &&  (!$isPrime || isPrime($FibT) ) )
    {
        return $FibT;
    }
    else
    {
        $fibCnt++;
        $fibFinal = fibnacciSequence($FibT, $Fib1, $stopValue, $isPrime, $fibCnt);
    }
    return $fibFinal;
}

function isPrime($num)
{
    for ( $i = 2 ; $i <  floor( pow($num,0.5)+ 1) ; $i++)
    {
        if ($num % $i == 0 )
        {
            return false;
        }
    }
    return true;
}

/**
 * @param $num
 * @return bool
 */
function isGCFPrime($num)
{
    return $num==2 || isPrime($num);
}

/**
 * returns an array of gcf and the number of times that number appears.
 * @param $num
 * @return int[];
 */
function  getGCFArray($num)
{
    $gcfArray = array();
    if ( isGCFPrime($num) )
    {
        return array($num => 1);
    }
    for ($i = 2 ; $i < $num ; $i=$i+2 )
    {
        if ( $num % $i == 0)
        {
           $residue = getGCFArray($num/$i);
           $gcfArray = $residue + array($i=>1);
           break;
        }
        if ($i == 2)
        {
            $i--; //after 2 we want 3,5,7,9...
        }
    }
    return $gcfArray;

}

$isPrime = isPrime(121);
echo "\nprime121=";  var_dump($isPrime);

$isPrime = isPrime(13);
echo "\nprime13="; var_dump($isPrime);

$gcfArray26 = getGCFArray(52);
echo "\ngcf26="; var_dump($gcfArray26);


$fibCnt = 0;
$num = fibnacciSequence(0,1,5,false, $fibCnt);
print "\nGreaterthan5=$fibCnt -- $num";

$num = fibnacciSequence(0,1,5, true, $fibCnt);
print "\nGreaterthan5prime=$fibCnt -- $num";

$num = fibnacciSequence(0,1,100, true, $fibCnt);
print "\nGreaterthan100prime=$fibCnt -- $num";

$num = fibnacciSequence(0,1,217000, true, $fibCnt);
print "\nGreaterthan217000prime=$fibCnt -- $num";


$gcfArray = getGCFArray($num+1);
echo "\ngcf26="; var_dump($gcfArray);


echo "Sum of GCF=" .  array_sum(array_keys($gcfArray) );

$n =8;
echo "\nPrint Fibnacci of $n\n";
$x = fibnacciSequencePrint($n);


?>