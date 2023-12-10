<?php

//! ---------------------> PartsFromFullName

$partsFromFullNameArray = [];
$fullNameFromPartsArray = [];
$shortNameArray = [];
$genderArray = [];
$mM_M;
$mM;
$perfectPartnerArray = [];

function getPartsFromFullName() {
    require 'example_persons_array.php';
    global $partsFromFullNameArray;
    $array = $example_persons_array;
    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        unset($array[$i]['job']);
    };
    array_values($array);
    $arrayForMerge = [];
    for ($i = 0; $i < $n; $i++) {
        $arrayForMerge[$i] = [
            'surname', 'name', 'patronomyc',
        ];
    }
    $i = 0;  
    foreach ($array as $k) {
        foreach ($k as $v) {            
            $getPartsFromFullName[$i] = explode(' ', $v);
    }
    $i++;
}
for ($i = 0; $i < $n; $i++) {
$partsFromFullNameArray[$i] = array_combine($arrayForMerge[$i], $getPartsFromFullName[$i]);
}
// var_dump($partsFromFullNameArray);
return $partsFromFullNameArray;
};

getPartsFromFullName();
//* printing name parts
// var_dump($partsFromFullNameArray);

//! ---------------------> FullNameFromParts

function getFullNameFromParts () {
    global $partsFromFullNameArray;
    global $fullNameFromPartsArray;
    $n = count($partsFromFullNameArray);
    for ($i = 0; $i < $n; $i++) {
        $fullNameFromPartsArray[$i] = ['fullname' => $partsFromFullNameArray[$i]['surname'] . ' ' . $partsFromFullNameArray[$i]['name'] .' '. $partsFromFullNameArray[$i]['patronomyc']];
    }
    // var_dump($fullNameFromPartsArray);
    return $fullNameFromPartsArray;
};

getFullNameFromParts();
//* printing full names
// var_dump($fullNameFromPartsArray);


//! --------------------> shortName

function shortName () {
    global $partsFromFullNameArray;
    global $shortNameArray;
    $n = count($partsFromFullNameArray);
    for ($i = 0; $i < $n; $i++) {
        $shortNameArray[$i] = ['shortname' => $partsFromFullNameArray[$i]['name'] . ' ' . mb_substr($partsFromFullNameArray[$i]['surname'], 0, 1) . '.'];
    };
    return $shortNameArray;

};
shortName();
//* printing short names
// var_dump($shortNameArray);

//! ----------------------> getGenderFromName

function getGenderFromName () {
    global $partsFromFullNameArray;
    global $genderArray;
    global $fullNameFromPartsArray;
    $n = count($partsFromFullNameArray);
    for ($i = 0; $i < $n; $i++) {
        $gender = 0;
        $genderArray[$i]['fullname'] = $fullNameFromPartsArray[$i]['fullname'];
        if (str_ends_with($partsFromFullNameArray[$i]['surname'], 'ва')) {
            --$gender;
        } elseif (str_ends_with($partsFromFullNameArray[$i]['surname'], 'в')) {
            ++$gender;
        };
        if (str_ends_with($partsFromFullNameArray[$i]['name'], 'а')) {
            --$gender;
        }   elseif (str_ends_with($partsFromFullNameArray[$i]['name'], 'й' || 'н')) {
            ++$gender;
        };        
        if (str_ends_with($partsFromFullNameArray[$i]['patronomyc'], 'вна')) {
            --$gender;
        }   elseif (str_ends_with($partsFromFullNameArray[$i]['patronomyc'], 'ич')) {
            ++$gender;
        };
        switch ($gender) {
            case 0: $genderArray[$i]['gender'] = 'невозможно определить';
            break;
            case ($gender > 0): $genderArray[$i]['gender'] = 'мужской пол';
            break;
            case ($gender < 0): $genderArray[$i]['gender'] = 'женский пол';
            break;
            default: 
            break;
        }
}
return $genderArray;
}

getGenderFromName();
//*printing gender affiliation
// var_dump($genderArray);

//! --------------> getGenderDescription

function getGenderDescription () {
    global $genderArray;
    global $mM_M;
    global $mM;
    $n = count($genderArray);
    $m = 0;
    $f = 0;
    $u = 0;
    for ($i = 0; $i < $n; $i++) {
        if ($genderArray[$i]['gender'] == 'мужской пол') {
            ++$m;
        }   elseif ($genderArray[$i]['gender'] == 'женский пол'){
            ++$f;
        }   else {
            ++$u;
        };
    };
    $mM = (($m / $n) * 100);
    $fF = (($f / $n) * 100);
    $uU = (($u / $n) * 100);
    // var_dump($f);
    // var_dump($mM);
    // var_dump($fF);
    // var_dump($uU);
    return array($mM, $fF, $uU);
}

list($x,$y,$z) = getGenderDescription();

//* echoing gender% results
// echo('Гендерный состав аудитории:' . "\n");
// echo('---------------------------' . "\n");
// echo('Мужчины - ' . number_format($x, 2)  . "\n");
// echo('Женщины - ' . number_format($y, 2)  . "\n");
// echo('Не удалось определить - ' . number_format($z, 2)  . "\n");


//! ---------------> getPerfectPartner

function getPerfectPartner () {
    global $perfectPartnerArray;
    global $shortNameArray;
    global $genderArray;
    $n = count($genderArray);
    $randomIndexPrimary = random_int(0, $n-1);
    // echo $shortNameArray[$randomIndexPrimary];
    for ($i = 0; $i < $n; $i++) {
        $randomIndexSecondary = random_int(0, $n-1);
        if ($genderArray[$randomIndexPrimary]['gender'] == 'мужской пол') {
            if ($genderArray[$randomIndexSecondary]['gender'] == 'женский пол') {
                echo ($shortNameArray[$randomIndexPrimary]['shortname'] . ' ' . '+' . ' ' . $shortNameArray[$randomIndexSecondary]['shortname'] . ' ' . '=' . "\n");
                echo ("\xe2\x9d\xa4" . ' ' . 'Идеально на ' . random_int(50, 100) . '.' . random_int(1, 99) . '%' . ' ' . "\xe2\x9d\xa4");
                break;
            }   else {$i--;}
        }   elseif ($genderArray[$randomIndexPrimary]['gender'] == 'женский пол') {
            if ($genderArray[$randomIndexSecondary]['gender'] == 'мужской пол') {
                echo ($shortNameArray[$randomIndexPrimary]['shortname'] . ' ' . '+' . ' ' . $shortNameArray[$randomIndexSecondary]['shortname'] . ' ' . '=' . "\n");
                echo ("\xe2\x9d\xa4" . ' ' . 'Идеально на ' . random_int(50, 99) . '.' . random_int(1, 99) . '%' . ' ' . "\xe2\x9d\xa4");
                break;
            }   else {$i--;}
        } else {
            echo ($shortNameArray[$randomIndexPrimary]['shortname'] . "\n" . 'Невозможно подобрать пару.');
            break;
        }
    }
};

//* getPerfectPartner function launch and echo within the function ---->
// getPerfectPartner();

?>