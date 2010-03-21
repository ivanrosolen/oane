<?php
session_start();

date_default_timezone_set( 'America/Sao_Paulo' );
    
function getPhoto($guid) {
    $info = json_decode(file_get_contents("http://query.yahooapis.com/v1/public/yql?q=SELECT%20avatar_url%20FROM%20meme.info%20WHERE%20owner_guid%3D%27{$guid}%27&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback="));
    return $info->query->results->meme->avatar_url;
}

function orderByDate ($a, $b) {
    if ( $a->data == $b->data ) {
        return 0;
    } else {
        return ( $a->data > $b->data ? -1 : 1 );
    }
}

$result = array( 'refresh' => 0, 'new' => 0, 'results' => '' );

preg_replace( '/[ˆa-zA-Z0-9]/', '', $_POST['search'] );

if ( empty($_POST['search']) ) {
    $result = json_encode($result);
} else {
    
    $search = urlencode($_POST['search']);
    
    $twitter = file_get_contents("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20twitter.search%20where%20q%20%3D%20'{$search}'and%20rpp%20%3D%2030&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=");
    $meme    = file_get_contents("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20meme.search%20(30)%20where%20query%20%3D'{$search}'&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys");
    
    $twitter = json_decode($twitter);
    $meme    = json_decode($meme);
    
    $twitterResult = $twitter->query->results->results;
    $memeResult    = $meme->query->results->post;
    
    $dados = array();
    
    foreach ( $twitterResult as $key => $value) {
        
        if ( isset($twitterResult[$key]) ) {
            $t = new StdClass();
            $t->data = strtotime($twitterResult[$key]->created_at);
            $t->texto = htmlentities(utf8_decode($twitterResult[$key]->text), ENT_QUOTES);
            $t->url = 'http://twitter.com/' . $twitterResult[$key]->from_user . '/status/' . $twitterResult[$key]->id;
            $t->image = $twitterResult[$key]->profile_image_url;
            
            array_push( $dados, $t );
        }
        
        if ( isset($memeResult[$key]) ) {
            $m = new StdClass();
            $m->data = $memeResult[$key]->timestamp/1000;
            $m->texto = htmlentities(utf8_decode($memeResult[$key]->content), ENT_QUOTES);
            $m->url = $memeResult[$key]->url;
            $m->image = getPhoto($memeResult[$key]->guid);
            
            array_push( $dados, $m );
        }
    }
    usort( $dados, 'orderByDate' );
    
    $i = 0;
    $tmpArray = array();
    foreach ( $dados as $obj ) {
        if ( $i++ > 30) break;
        $obj->data = date( 'd/m/Y H:i:s', $obj->data );
        array_push( $tmpArray, $obj );
    }
    
    $serializedArray = serialize($tmpArray);
    
    if ( !isset( $_SESSION['lastResult']) ) {
        $_SESSION['lastResult'] = $serializedArray;
        $result['refresh'] = 1;
        $result['new']     = count($tmpArray);
        $result['results'] = $tmpArray;
        $result = json_encode($tmpArray);
    } else {
        
        if ( $serializedArray == $_SESSION['lastResult'] ) {
           $result = json_encode($result);
        } else {
            $result['refresh'] = 1;
            $result['new']     = ;
            $result['results'] = $tmpArray;
            $result = json_encode($tmpArray);
        }
    }
}

echo $result;
