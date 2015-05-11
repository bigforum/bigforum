<?php if((GROUP == "2" OR GROUP == "3") AND ($_SERVER['PHP_SELF'] != "modcp.php" AND $_SERVER['PHP_SELF'] != "/modcp.php")) echo "<br><center>[ <a href=modcp.php>Moderator-Kontrollzentrum</a> ]</center>"; ?>
	</td>
  </tr>
</table><?
if($_SERVER['PHP_SELF'] == "modcp.php" OR $_SERVER['PHP_SELF'] == "/modcp.php")
{
  echo "</td></tr></table>";
}
?>
<br>Es ist jetzt  <span id="uhr"><?php echo date("H:i", time()); ?></span>.<br>
<center>&copy; by <a href="http://www.potterfans.npage.de">Potterfans</a><br>
Version <strong> <?php echo VERSION; ?> </strong> </center>
</body>
</html>