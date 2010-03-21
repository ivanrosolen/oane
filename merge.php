<?php
date_default_timezone_set( 'America/Sao_Paulo' );
function parseData($data)
{
	$data = explode(',', $data);
	$data = trim($data[1]);
	$data = explode(' ', $data);
	$hora = explode(':', $data[3]);
	
	$data[0] = $data[0]{0} == 0 ? $data[0]{1} : $data[0];
	
	$timestamp = mktime($hora[0] - 3, $hora[1], $hora[2], getMonthNumber($data[1]), $data[0], $data[2]);
	echo gmdate('d/m/Y H:i:s', $timestamp);
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

$twitter = file_get_contents("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20twitter.search%20where%20q%20%3D%20'transito%20sp'%20limit%2010&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=");
$meme = file_get_contents("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20meme.search%20where%20query%20%3D'transito%20sp'%20limit%2010&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=");

$twitter = json_decode($twitter);
$meme = json_decode($meme);

$twitterResult = $twitter->query->results->results;
$memeResult = $meme->query->results->post;

/*
$d = new DateTime( 'Sat, 20 Mar 2010 19:29:12 +0000' );
$d->setTimezone( new DateTimeZone( 'America/Sao_Paulo' ) );
$d->format( 'd/m/Y H:m:s' );
*/

for ($i = 0; $i < 10; $i++) {
    
	echo '<hr />';
	echo 'data: ' . date('d/m/Y H:i:s', strtotime($twitterResult[$i]->created_at)) . '<br />';
	echo 'texto: ' . $twitterResult[$i]->text . '<br />';
	echo 'link:  http://twitter.com/' . $twitterResult[$i]->from_user . '/status/' . $twitterResult[$i]->id;
	echo '<hr />';
	echo 'data: ' . date('d/m/Y H:i:s', $memeResult[$i]->timestamp/1000 ) . '<br />';
	echo 'texto: ' . $memeResult[$i]->content . '<br />';
	echo 'link: ' . $memeResult[$i]->url;
}
