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
function insert(aTag, eTag) {
  var input = document.forms['feld'].elements['feld'];
  input.focus();
  if(typeof document.selection != 'undefined') {
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = aTag + insText + eTag;
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);      
    }
    range.select();
  }
  else if(typeof input.selectionStart != 'undefined')
  {
    var start = input.selectionStart;
    var end = input.selectionEnd;
    var insText = input.value.substring(start, end);
    input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
    var pos;
    if (insText.length == 0) {
      pos = start + aTag.length;
    } else {
      pos = start + aTag.length + insText.length + eTag.length;
    }
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  else
  {
    var pos;
    var re = new RegExp('^[0-9]{0,3}$');
    while(!re.test(pos)) {
      pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
    }
    if(pos > input.value.length) {
      pos = input.value.length;
    }
    var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}
