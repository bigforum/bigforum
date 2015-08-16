<?php 

if($_GET["location"] != "")
{
  header("location: thread.php?id=$_GET[location]");
}
header("Content-type: text/xml"); 
echo '<'.'?xml version="1.0" encoding="ISO-8859-1"?'.'>'; 
include("includes/functions.php");
//connect_to_database();
config("f2name2", true, "function_define");
?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"> 

<channel>
    <title><?php echo SITENAME; ?></title> 					
    <language>de</language>				  					
    <link>http://<?php echo $_SERVER["HTTP_HOST"]; ?></link>	  						
    <description><?php echo BESCHREIBUNG; ?></description>
    <copyright>Copyright <?php date("y");  echo $_SERVER["HTTP_HOST"]; ?></copyright>		

<?php 
$query = "SELECT * FROM thema WHERE dele = '' ORDER BY id DESC LIMIT 10 ";    
$result = mysql_query($query) or die (mysql_error()); 
while ($row = mysql_fetch_array($result)){ 
  $for_dat = mysql_query("SELECT * FROM foren WHERE id LIKE '$row[where_forum]'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
  $fd = mysql_fetch_object($for_dat);
  $z = "0";
  if($fd->guest_see == "1" AND USER != "")
  {
    $z = "1";
  	$id = $row['id']; 
	$autor = $row['verfas']; 
	$title = $row['tit']; 
	$text = $row['text'];
    $text = preg_replace('/\[b\](.*?)\[\/b\]/s', '<b>$1</b>', $text);  
    $text = preg_replace('/\[k\](.*?)\[\/k\]/s', '<i>$1</i>', $text);  
    $text = preg_replace('/\[u\](.*?)\[\/u\]/s', '<u>$1</u>', $text);  
    $text = preg_replace('/\[code\](.*?)\[\/code\]/s', "<small style='display:block;'>Code:</small><table width=80% bgcolor=snow><tr><td>$1</td></tr></table>", $text);  
    $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$text);
    $text = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="http://$1" target=\"_blank\">$2</a>', $text);  
    $text = eregi_replace("\[img\]([^\[]+)\[/img\]","<img src=\"\\1\" border=0>",$text);
    $text = preg_replace("/\[color=(.*)\](.*)\[\/color\]/Usi", "<font color=\"\\1\">\\2</font>", $text); 
    $text = preg_replace("/\[size=(.*)\](.*)\[\/size\]/Usi", "<font size=\"\\1\">\\2</font>", $text); 
    $text = preg_replace("/\[zitat=(.*)\](.*)\[\/zitat\]/Usi", "<small style='display:block;'>Zitat von \\1:</small><table width=80% bgcolor=snow><tr><td>\\2</td></tr></table>", $text);
    $text = str_replace("http://http://" ,"http://", $text);	
	$pubdate = date("d.m.Y - H:i", $row['post_when']); 	
		?> 
	    <item>
		<title><?php echo $title; ?></title>
	    <link><?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?location=$id";?></link>
	   	<guid isPermaLink="false"><?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?location=$id";?></guid>
	   	<author><?php echo $autor; ?></author>
	    <pubDate><?php echo $pubdate; ?></pubDate>
	    <description><![CDATA[ <?php echo $text; ?>]]></description>
	    </item>
<?php
  }
     
      if($fd->guest_see == "2" AND (GROUP == 2 OR GROUP == 3) AND $z == 0)
      {
	    $z = 1;
	  	$id = $row['id']; 
	    $autor = $row['verfas']; 
	    $title = $row['tit']; 
	    $text = $row['text'];
        $text = preg_replace('/\[b\](.*?)\[\/b\]/s', '<b>$1</b>', $text);  
        $text = preg_replace('/\[k\](.*?)\[\/k\]/s', '<i>$1</i>', $text);  
        $text = preg_replace('/\[u\](.*?)\[\/u\]/s', '<u>$1</u>', $text);  
        $text = preg_replace('/\[code\](.*?)\[\/code\]/s', "<small style='display:block;'>Code:</small><table width=80% bgcolor=snow><tr><td>$1</td></tr></table>", $text);  
        $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$text);
        $text = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="http://$1" target=\"_blank\">$2</a>', $text);  
        $text = eregi_replace("\[img\]([^\[]+)\[/img\]","<img src=\"\\1\" border=0>",$text);
        $text = preg_replace("/\[color=(.*)\](.*)\[\/color\]/Usi", "<font color=\"\\1\">\\2</font>", $text); 
        $text = preg_replace("/\[size=(.*)\](.*)\[\/size\]/Usi", "<font size=\"\\1\">\\2</font>", $text); 
        $text = preg_replace("/\[zitat=(.*)\](.*)\[\/zitat\]/Usi", "<small style='display:block;'>Zitat von \\1:</small><table width=80% bgcolor=snow><tr><td>\\2</td></tr></table>", $text);
        $text = str_replace("http://http://" ,"http://", $text);	
	    $pubdate = date("d.m.Y - H:i", $row['post_when']);
		?> 
	    <item>
		<title><?php echo $title; ?></title>
	    <link><?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?location=$id";?></link>
	   	<guid isPermaLink="false"><?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?location=$id";?></guid>
	   	<author><?php echo $autor; ?></author>
	    <pubDate><?php echo $pubdate; ?></pubDate>
	    <description><![CDATA[ <?php echo $text; ?>]]></description>
	    </item>
<?php
	  }
	if($z == "0")
    {
    $z = "1";
  	$id = $row['id']; 
	$autor = $row['verfas']; 
	$title = $row['tit']; 
	$text = $row['text'];
    $text = preg_replace('/\[b\](.*?)\[\/b\]/s', '<b>$1</b>', $text);  
    $text = preg_replace('/\[k\](.*?)\[\/k\]/s', '<i>$1</i>', $text);  
    $text = preg_replace('/\[u\](.*?)\[\/u\]/s', '<u>$1</u>', $text);  
    $text = preg_replace('/\[code\](.*?)\[\/code\]/s', "<small style='display:block;'>Code:</small><table width=80% bgcolor=snow><tr><td>$1</td></tr></table>", $text);  
    $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$text);
    $text = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="http://$1" target=\"_blank\">$2</a>', $text);  
    $text = eregi_replace("\[img\]([^\[]+)\[/img\]","<img src=\"\\1\" border=0>",$text);
    $text = preg_replace("/\[color=(.*)\](.*)\[\/color\]/Usi", "<font color=\"\\1\">\\2</font>", $text); 
    $text = preg_replace("/\[size=(.*)\](.*)\[\/size\]/Usi", "<font size=\"\\1\">\\2</font>", $text); 
    $text = preg_replace("/\[zitat=(.*)\](.*)\[\/zitat\]/Usi", "<small style='display:block;'>Zitat von \\1:</small><table width=80% bgcolor=snow><tr><td>\\2</td></tr></table>", $text);
    $text = str_replace("http://http://" ,"http://", $text);	
	$pubdate = date("d.m.Y - H:i", $row['post_when']); 	
		?> 
	    <item>
		<title><?php echo $title; ?></title>
	    <link><?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?location=$id";?></link>
	   	<guid isPermaLink="false"><?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?location=$id";?></guid>
	   	<author><?php echo $autor; ?></author>
	    <pubDate><?php echo $pubdate; ?></pubDate>
	    <description><![CDATA[ <?php echo $text; ?>]]></description>
	    </item>
<?php
    }

}
?>

</channel>
</rss>