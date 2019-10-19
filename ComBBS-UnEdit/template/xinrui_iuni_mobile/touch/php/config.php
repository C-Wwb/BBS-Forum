<?php
if ( !defined( "IN_DISCUZ" ) )
{
		exit( "Access Denied" );
}
/////////////  ²ÎÊýÉèÖÃ  //////////
$ceo_piclistopen = 1;


$useragent = $_SERVER['HTTP_USER_AGENT'];
preg_match( "/UCWEB/", $useragent, $match );
if ( $match && ( strpos( $useragent, "iPh" ) || strpos( $useragent, "wds" ) ) )
{
		header( "location:forum.php?mobile=1" );
}

$php_uri = substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],'/')+1);
$php_self = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
$php_indexurl = strrpos($php_uri, $indexurl);


?>


