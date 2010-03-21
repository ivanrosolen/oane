<?php
date_default_timezone_set( 'America/Sao_Paulo' );

function getPhoto($guid)
{
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

/*
 * select * from twitter.search where q = 'transito sp' limit 10
 * created_at
 * text
 * from_user
 * id
 * 
 * select * from meme.search where query ='transito sp' limit 10
 * timestamp
 * content
 * url
 */

$twitter = file_get_contents("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20twitter.search%20where%20q%20%3D%20'transito%20sp'and%20rpp%20%3D%2030&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=");
$meme = file_get_contents("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20meme.search%20where%20query%20%3D'transito%20sp'%20limit%2030&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=");

$twitter = json_decode($twitter);
$meme = json_decode($meme);

$twitterResult = $twitter->query->results->results;
$memeResult = $meme->query->results->post;


$dados = array();
foreach ( $twitterResult as $key => $value) {
	
	if ( isset($twitterResult[$key]) ) {
		$t = new StdClass();
		$t->data = strtotime($twitterResult[$key]->created_at);
		$t->texto = utf8_decode($twitterResult[$key]->text);
		$t->url = 'http://twitter.com/' . $twitterResult[$key]->from_user . '/status/' . $twitterResult[$key]->id;
		$t->image = $twitterResult[$key]->profile_image_url;
		
		$dados[] = $t;
	}
	
	if ( isset($memeResult[$key]) ) {
		$m = new StdClass();
		$m->data = $memeResult[$key]->timestamp/1000;
		$m->texto = utf8_decode($memeResult[$key]->content);
		$m->url = $memeResult[$key]->url;
		$m->image = getPhoto($memeResult[$key]->guid);
		
		$dados[] = $m;
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
print_r( $tmpArray );
/*
$d = new DateTime( 'Sat, 20 Mar 2010 19:29:12 +0000' );
$d->setTimezone( new DateTimeZone( 'America/Sao_Paulo' ) );
$d->format( 'd/m/Y H:m:s' );
*/

//for ($i = 0; $i < 10; $i++) {
//    
//	echo '<hr />';
//	echo 'data: ' . date('d/m/Y H:i:s', strtotime($twitterResult[$i]->created_at)) . '<br />';
//	echo 'texto: ' . utf8_decode($twitterResult[$i]->text) . '<br />';
//	echo 'link:  http://twitter.com/' . $twitterResult[$i]->from_user . '/status/' . $twitterResult[$i]->id;
//	echo '<hr />';
//	echo 'data: ' . date('d/m/Y H:i:s', $memeResult[$i]->timestamp/1000 ) . '<br />';
//	echo 'texto: ' . utf8_decode($memeResult[$i]->content) . '<br />';
//	echo 'link: ' . $memeResult[$i]->url;
//}
