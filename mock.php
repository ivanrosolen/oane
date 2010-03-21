<?php

date_default_timezone_set( 'America/Sao_Paulo' )    ;

/*echo $unixtime = strtotime( 'Sat, 20 Mar 2010 19:29:12 +0000' );
echo '<br />';
echo date( 'd/m/Y H:m:s', $unixtime );
*/

$d = new DateTime( 'Sat, 20 Mar 2010 19:29:12 +0000' );
$d->setTimezone( new DateTimeZone( 'America/Sao_Paulo' ) );
echo $d->format( 'd/m/Y H:m:s' );
?>