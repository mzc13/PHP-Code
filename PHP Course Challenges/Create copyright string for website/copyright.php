<?php
$FIRST_COPYRIGHT_YEAR = 2019;
function getCopyrightString($firstCopyrightYear){
    if (date('Y') > $firstCopyrightYear){
        return "©$firstCopyrightYear-" . date('Y');
    } else {
        return "©$firstCopyrightYear";
    }
}
echo getCopyrightString(2030);