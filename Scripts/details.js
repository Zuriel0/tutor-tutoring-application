function cardDetails() {
  var req = new XMLHttpRequest();
  req.onreadystatechange = function (){
    if (req.readyState == 4 && req.status == 200) {
      document.getElementById('details').innerHTML = req.responseText;
    }
  }
    req.open('GET', './../include/details.php', true);
    req.send();
}
setInterval(function(){cardDetails();},1000);