function ajax() {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function (){
      if (req.readyState == 4 && req.status == 200) {
        document.getElementById('chat').innerHTML = req.responseText;
      }
    }
      req.open('GET', 'chat_label.php', true);
      req.send();
  }

const chatModal = document.getElementById('chatModal');

setInterval(function(){ajax();},1000);