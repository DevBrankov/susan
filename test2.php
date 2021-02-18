<?php
include_once 'dataBase.php';

//Products that can't be fit in the warehouse
$bigProduct = array();
//Products that can be placed in column of 5
$columnOfFiveProducts = array();
//Products that can't be placed in column of 5
$otherProducts = array();
//Function to check the product size and to see could be placed in column of 5
function smallestSideInMeters($param1) {
    if(min($param1) / 1000 > 3.6){
        global $bigProduct;
        $bigProduct[] = $param1;
    }elseif(min($param1) / 1000 * 5 < 3.6){
        global $columnOfFiveProducts;
        $columnOfFiveProducts[] = $param1;
    }else{
        global $otherProducts;
        $otherProducts[] = $param1;
    }
}
//Making the distribution of the products
foreach ($products as $product) {
    smallestSideInMeters($product);
}
//Array with the product based on column
$stackItems = array();
print_r(count($columnOfFiveProducts)." products can be stacked in column of five.");
echo "<pre>";
print_r(count($bigProduct)." products cannot enter the warehouse because they don't have side smaller than 3.6m.");
echo "</pre>";
print_r(count($otherProducts)." products can't be stacked in column of five. They should be stack in column of less than five or combine with some others in a column.");

foreach ($columnOfFiveProducts as $value) {
//Picking up products that can stack on top of each other and rotating them based on the smaller side and also stacking them up
        $allSides = $value['height'] / 1000 + $value['width'] / 1000 + $value['length'] / 1000;
        $height = min($value) / 1000;
        $width = max($value) / 1000;
        $length = $allSides - ($width + $height);
        $value['height'] = $height * 5;
        $value['width'] = $width;
        $value['length'] = $allSides - ($width + $height);
//Array with the stacked products counting them as one product
        $stackItems[] = $value;
}

$stackingTheStacked = array();
$counter = count($stackItems) - 1;
//Check if some other stacks could be placed on each other based on the warehouse height to save more space
for ($i=0; $i < $counter; $i++) {
    if($stackItems[$i]['height'] + $stackItems[$i+1]['height'] < 3.6){
        $new['height'] = $stackItems[$i]['height'] + $stackItems[$i+1]['height'];
        $new['length'] = ($stackItems[$i]['length'] >  $stackItems[$i+1]['length']) ? $stackItems[$i]['length'] : $stackItems[$i+1]['length'];
        $new['width'] = ($stackItems[$i]['width'] >  $stackItems[$i+1]['width']) ? $stackItems[$i]['width'] : $stackItems[$i+1]['width'];
        $i++;
        $stackingTheStacked[] = $new;
    }else{
        $stackingTheStacked[] = $stackItems[$i];
    }
}

//Getting the products that CAN'T stacked on top of each other and rotating them based on the smaller side preparing them to be stacked on smaller pieces than 5 on column
foreach ($otherProducts as $oK => $oV) {
    $oAllSides = $oV['height'] / 1000 + $oV['width'] / 1000 + $oV['length'] / 1000;
    $oHeight = min($oV) / 1000;
    $oWidth = max($oV) / 1000;
    $oLength = $oAllSides - ($oWidth + $oHeight);
    $oV['height'] = $oHeight;
    $oV['width'] = $oWidth;
    $oV['length'] = $oLength;

}
 ?>
