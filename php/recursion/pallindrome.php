<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jag
 * Date: 10/22/11
 * Time: 2:08 AM
 * To change this template use File | Settings | File Templates.
 */

$text="FourscoreandsevenyearsagoourfaathersbroughtforthonthiscontainentanewnationconceivedinzLibertyanddedicatedtothepropositionthatallmenarecreatedequalNowweareengagedinagreahtcivilwartestingwhetherthatnaptionoranynartionsoconceivedandsodedicatedcanlongendureWeareqmetonagreatbattlefiemldoftzhatwarWehavecometodedicpateaportionofthatfieldasafinalrestingplaceforthosewhoheregavetheirlivesthatthatnationmightliveItisaltogetherfangandproperthatweshoulddothisButinalargersensewecannotdedicatewecannotconsecratewecannothallowthisgroundThebravelmenlivinganddeadwhostruggledherehaveconsecrateditfaraboveourpoorponwertoaddordetractTgheworldadswfilllittlenotlenorlongrememberwhatwesayherebutitcanneverforgetwhattheydidhereItisforusthelivingrathertobededicatedheretotheulnfinishedworkwhichtheywhofoughtherehavethusfarsonoblyadvancedItisratherforustobeherededicatedtothegreattdafskremainingbeforeusthatfromthesehonoreddeadwetakeincreaseddevotiontothatcauseforwhichtheygavethelastpfullmeasureofdevotionthatweherehighlyresolvethatthesedeadshallnothavediedinvainthatthisnationunsderGodshallhaveanewbirthoffreedomandthatgovernmentofthepeoplebythepeopleforthepeopleshallnotperishfromtheearth";

//test odd palindrome = 13
//$text="xyxyxyxyxyabcdefgfedcbaxyxyxyxyxy";

//test even palindrome = 34
//$text="xyxyxyxyxyxabcdeffedcbaxyxyxyxyxyx";

//test no palindrome
//$text="abcdefghijklmnopqrs";


/**
 * Algorithm: For each letter just iterate through and and loop to the right and left of the letter. If the same its an odd pallindrome
 * For even palindrome, you need to take the character to try
 * We could combine the two functions obviously...
 */
function findOddPalindrome($i, $text)
{
    $length = strlen($text);
    $i;
    $j=0;
    do
    {
        echo "j=" . $text[$i+$j];
        $low = $i-$j-1;
        $high = $i+$j+1;
        if ( $text[$high] == $text[$low] )
        {
        }
        else
        {
            break;
        }
        $j++;
    } while ($low > 0 && $high < $length);
    return array('size'=>$j*2+1, 'string'=>substr($text, $i-$j, $j*2+1)  );
}

function findEvenPalindrome($i, $text)
{
    $length = strlen($text);
    $i;
    $j=0;
    do
    {
        echo "j=" . $text[$i-$j];
        $low = $i-$j;
        $high = $i+$j+1;
        if ( $text[$high] == $text[$low] )
        {
        }
        else
        {
            break;
        }
        $j++;
    } while ($low > 0 && $high < $length);
    return array('size'=>$j*2, 'string'=>substr($text, $i-$j+1, $j*2) );

}


/*
 * Main
 *
 */
$length = strlen($text);
$maxSize = array('size'=>0, 'string'=>"");
for ($i = 0 ; $i < $length ; $i++)
{
    $letter = $text[$i];

    $matchLengthOdd = findOddPalindrome($i, $text);
    if ( $matchLengthOdd['size'] > $maxSize['size'])
    {
        $maxSize = $matchLengthOdd;
    }
    $i += floor($matchLengthOdd['size']/2); //speed up

    $matchLengthEven = findEvenPalindrome($i, $text);
    if ( $matchLengthEven['size'] > $maxSize['size'])
    {
        $maxSize = $matchLengthEven;
    }

    $i += floor($matchLengthEven['size']/2); //speed up
    echo "i=$i";
    echo "maxSize=$maxSize\n";
}

var_dump($maxSize)

?>
