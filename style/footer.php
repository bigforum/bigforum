<?php if((GROUP == "2" OR GROUP == "3") AND ($_SERVER['PHP_SELF'] != "modcp.php" AND $_SERVER['PHP_SELF'] != "/modcp.php")) echo "<br><center>[ <a href=modcp.php>Moderator-Kontrollzentrum</a> ]</center>"; ?>
	</td>
  </tr>
</table><?
if($_SERVER['PHP_SELF'] == "modcp.php" OR $_SERVER['PHP_SELF'] == "/modcp.php")
{
  echo "</td></tr></table>";
}
?><br>
<center>&copy; by <a href="http://www.bfs.kilu.de" target="_blank">Bigforum-Team</a>
(Version: <?php echo VERSION; ?> )<br>
2008 - <?php echo date("Y", time()); ?></center>
</body>
</html>