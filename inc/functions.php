<?php

function escapeString($text)
{
    $escapes = array(
        "/'/u" => "/'",
    );
    return preg_replace(array_keys($escapes), array_values($escapes), $text);
}
