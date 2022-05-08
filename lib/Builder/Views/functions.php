<?php

function contentFor(
    array $data
){
    if ($data['viewType']==='PREVIEW') {
        echo '<section class="Preview outer-wrapper --type-is-'.$data['previewType'].'">';
            echo '<div class="inner-wrapper">';
            $path = __DIR__.$data['contentFor'];
            if (file_exists($path)) {
                require($path);
            }
            echo '</div>';
        echo '</section>';
    }
}

function module(
    string $name
    )
{
    $path = __DIR__."/modules/{$name}.php";
    if (!file_exists($path)) {
        echo '<!-- Build Error::Module not found @ '.$path.' -->';
        return;
    }
    require($path);
}

function dumpStaticObjects(
    array $data
    )
{
    echo '<script type="text/javascript">';
    if ($data['viewType']==='PREVIEW') {
        if (isset($_GET['project'])) {
            $projectDataPath = $data['projectRoot'].'/test/data/project/'.$_GET['project'].'.json';
            if (!file_exists($projectDataPath)) {
                echo 'var ProjectData = {}';
            } else {
                $json = json_encode(json_decode(file_get_contents($projectDataPath),TRUE),JSON_UNESCAPED_UNICODE);
                echo "var ProjectData = JSON.parse('".$json."')";
            }
        }
        else {
            echo 'var ProjectData = {}';
        }
    }
    echo '</script>';
}
