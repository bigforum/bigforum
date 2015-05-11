function logout()
{
  x = confirm("Möchtest du dich wirklich ausloggen?");
  if(x == true)
  {
    window.location.href="login.php?do=logout";
  }
}

function uhrzeit(showe) {
 Heute = new Date();
 Sekunde = Heute.getSeconds();
 if (Heute.getSeconds() == 0 || showe == "jetzt") {
  Stunde  = Heute.getHours();
  Minute  = Heute.getMinutes();
  var Min = ((Minute < 10) ? "0" + Minute : Minute);

  document.getElementById("uhr").innerHTML=Stunde+":"+Min+" Uhr";
 }
}

function info()
{
  alert("Dies ist eine Information, die von einem Administrator erstellt wurde. Du kannst diese im Persönlichem Bereich unter \"Einstellungen\" ausblenden lassen.");
}