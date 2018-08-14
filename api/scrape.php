<?php

    header('Content-type:application/json;charset=utf-8');

    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile( 'https://stemmen.top2000.nl/mijnlijst.html?h=f403bfefe60ac6c8b4c429da3076a0a5#!/index.html?page=1&q=&view=list&_=' . strtotime( date("Y-m-d H:i:s", time()) ) );
    $xpath = new DOMXPath($dom);

    $chosen_songs = array();

    $scraped_songs = $xpath->query('//form[contains(@class, "bl-form")]//ul[contains(@class, "yourlist")]//li');
    if($scraped_songs->length > 0){

        foreach($scraped_songs as $index => $song){
            $song_data = array( 'ID' => ($index + 1), 'artist' => false, 'title' => false, 'cover' => false );

            $song_artist = $song->getElementsByTagName('h2');
            if($song_artist->length > 0){
                $song_data['artist'] = $song_artist->item(0)->nodeValue;
            }

            $song_title = $song->getElementsByTagName('h3');
            if($song_title->length > 0){
                $song_data['title'] = $song_title->item(0)->nodeValue;
            }

            $song_cover = $song->getElementsByTagName('img');
            if($song_cover->length > 0 && strlen($song_cover->item(0)->attributes->getNamedItem('src')->nodeValue) > 0 ){
                $song_data['cover'] = 'https://stemmen.top2000.nl' . $song_cover->item(0)->attributes->getNamedItem('src')->nodeValue;
            }

            $chosen_songs[] = $song_data;
        }
    }

    echo json_encode( array(
        'status'    => ( count($chosen_songs) > 0 ? 'success' : 'error' ),
        'data'      => $chosen_songs
    ) );

    die();
 ?>