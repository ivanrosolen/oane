<?php
session_start();

date_default_timezone_set( 'America/Sao_Paulo' );
   
function orderByDate ($a, $b) {
    if ( $a->data == $b->data ) {
        return 0;
    } else {
        return ( $a->data > $b->data ? -1 : 1 );
    }
}

$result = array( 'refresh' => 0, 'new' => 0, 'results' => '' );

if ( !isset($_POST['search']) || empty($_POST['search']) ) {
    $result = json_encode($result);
} else {
    
    $search = strtolower($_POST['search']);
    
    if ( in_array( $search, array('sp','rj','bh')) ) {
        $search = urlencode('transito'.$_POST['search']);
    } else {
        $search = urlencode($_POST['search']);
    }
    
    $twitter = file_get_contents("https://query.yahooapis.com/v1/public/yql?q=select%20created_at%2C%20text%20from%20twitter.search%20where%20q%20%3D%20'{$search}'and%20rpp%20%3D%2030&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys");
    $meme    = file_get_contents("https://query.yahooapis.com/v1/public/yql?q=select%20timestamp%2C%20content%20from%20meme.search%20(30)%20where%20query%20%3D'{$search}'&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys");
    
    $twitter = json_decode($twitter);
    $meme    = json_decode($meme);
    
    $twitterResult = $twitter->query->results->results;
    $memeResult    = $meme->query->results->post;
    
    $dados = array();
    
    foreach ( $twitterResult as $key => $value) {
        $t = new StdClass();
        $t->data  = strtotime($value->created_at);
        $t->texto = $value->text;
        $t->image = '_images/twitter.png';
        array_push( $dados, $t );
    }
    
    foreach ( $memeResult as $key => $value) {
        $m = new StdClass();
        $m->data  = $value->timestamp/1000;
        $m->texto = $value->content;
        $m->image = '_imagens/meme.gif';
        array_push( $dados, $m );
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
        $result = json_encode($result);
    } else {
        
        if ( $serializedArray == $_SESSION['lastResult'] ) {
            $result['refresh'] = 0;
            $result['new']     = 0;
            $result['results'] = $tmpArray;
            $result = json_encode($result);
        } else {
            $countTmp = count($tmpArray);
            $bar = unserialize($_SESSION['lastResult']);
            $total = 0;
            for ($i = 0; $i < $countTmp; $i++) {
                if ($tmpArray[$i]->texto != $bar[$i]->texto) {
                    $total++;
                }
            }
            
            $_SESSION['lastResult'] = $serializedArray;

            $result['refresh'] = 1;
            $result['new']     = $total;
            $result['results'] = $tmpArray;
            $result = json_encode($result);
        }
    }
}

echo $result;
