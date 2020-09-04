<?php

function convert_file_json_to_array($path)
{
    $str = file_get_contents($path);
    return json_decode($str, true);
}

function path_data($fileName)
{
    return app_path("Datas/{$fileName}");
}
