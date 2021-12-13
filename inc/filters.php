<?php

function filter_underscoreFilename($str)
{
    return $str = str_replace(' ', '_', strtolower(trim($str)));
}

function filter_acronymizer(string $str, int $maxlen = 4)
{
    global $config;
    //normalize
    $str = strtoupper($str);

    //remove boring stuff 
    $str = str_replace('PLUGIN','',$str);
    $str = str_replace($config['plugin']['prefix'],'',$str);

    //already enough?
    if(strlen($str) <= $maxlen)
    {
        return $str;
    }

    $words = explode(" ", $str);
    $acronym = "";

    foreach ($words as $word) {
        if(strlen($word) > 0)
        {
            $acronym .= $word[0];
        }
    }

    //already enough?

    if(strlen($acronym) <= $maxlen)
    {
        return $acronym;
    }

    $acronym = "";

    foreach ($words as $word) {
        if(strlen($word) > 2)
        {
            $acronym .= $word[0];
        }
    }

    //finally enough?
    if(strlen($acronym) <= $maxlen)
    {
        return $acronym;
    }

    // no more ideas.. just cut it:
    return substr($acronym,0,$maxlen);
}