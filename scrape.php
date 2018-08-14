<?php

    function dump($var){
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile( 'https://stemmen.top2000.nl/mijnlijst.html?h=f403bfefe60ac6c8b4c429da3076a0a5#!/index.html?page=1&q=&view=list&_=' . strtotime( date("Y-m-d H:i:s", time()) ) );
    $xpath = new DOMXPath($dom);

    $chosen_songs = array();

    $scraped_songs = $xpath->query('//form[contains(@class, "bl-form")]//ul[contains(@class, "yourlist")]//li');
    if($scraped_songs->length > 0){

        foreach($scraped_songs as $song){
            $artist = $song->getElementsByTagName('h2');

            if($artist->length > 0){
                dump($artist->item(0)->nodeValue);
            }

            $song_title = $song->getElementsByTagName('h3');

            if($song_title->length > 0){
                dump($song_title->item(0)->nodeValue);
            }

            echo '<hr>';
        }

    }
 ?>