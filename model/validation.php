<?php

function validName($name)
{
    return !empty($name);
}


function validFlavors($Midterms)
{
    return !is_null($Midterms);
}