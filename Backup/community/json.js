var txt = '';
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function(){
  if(xmlhttp.status == 200 && xmlhttp.readyState == 4){
    txt = xmlhttp.responseText;
  }
};
xmlhttp.open("GET","./content/test.json",false);
xmlhttp.send();
console.log(txt)
var json = JSON.parse(txt);
alert(json.src);

if (json.type == "img") {
	var contenttype = "img"
} else {
	var contenttype = "iframe"
}

var options = ' src = "';
var options = options.concat(json.src);
var options = options.concat('"');
var content = document.createElement(contenttype,[options]);

document.body.appendChild(content)
