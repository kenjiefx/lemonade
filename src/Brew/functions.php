<?php

function data(
    string $key
    )
{
    if (isset($GLOBALS['MAPPED_BUILD_DATA'][$key])) {
        return $GLOBALS['MAPPED_BUILD_DATA'][$key];
    }
    return [];
}

function toParse(
    string $varName,
    array $parseData
    )
{
    echo "var ".ucfirst($varName)." = JSON.parse('".json_encode($parseData,JSON_UNESCAPED_UNICODE)."')";
}

function toBase64(
    string $path
    )
{
    $path = ROOT.'/theme/'.$GLOBALS['TARGET_OBJECT']['THEME'].$path;
    if (!file_exists($path)) {
        echo 'ERROR: Image Not Found: '.$path;
        return;
    }
    return 'data:image/png;base64, '.base64_encode(file_get_contents($path));
}

function isTemplate(
    string $name
    )
{
    return ($GLOBALS['TARGET_OBJECT']['TEMPLATE']===$name);
}

function content()
{
    require($GLOBALS['PATH_TO_CONTENT']);
}

function module(
    string $fileName
    )
{
    $path = ROOT.'/theme/'.$GLOBALS['TARGET_OBJECT']['THEME'].'modules/'.$fileName.'.php';
    if (!file_exists($path)) {
        echo 'ERROR: Module Not Found: '.$path;
        return;
    }
    include($path);
}
