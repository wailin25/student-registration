<?php

function getDatePart($date, $part) {
    $dateObj = new DateTime($date);
    switch ($part) {
        case 'd': return $dateObj->format('d');
        case 'm': return $dateObj->format('m');
        case 'Y': return $dateObj->format('Y');
        default: return '';
    }
}

function convertMyanmarToNumber($myanmar) {
    $digits = ['၀'=>0, '၁'=>1, '၂'=>2, '၃'=>3, '၄'=>4, '၅'=>5, '၆'=>6, '၇'=>7, '၈'=>8, '၉'=>9];
    $number = '';
    foreach (mb_str_split($myanmar) as $char) {
        if (isset($digits[$char])) {
            $number .= $digits[$char];
        }
    }
    return $number;
}

function convertNumberToMyanmar($number) {
    $digits = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
    $myanmar = '';
    foreach (str_split((string)$number) as $digit) {
        if (is_numeric($digit)) {
            $myanmar .= $digits[$digit];
        }
    }
    return $myanmar;
}
?>