
getById = function(id) { return document.getElementById(id); }
getByName = function(id) { return document.getElementsByTagName(id); }


toast = function(message, level){
    
    // 1 = good; 2 = warning; 3 = bad; anything else = normal;
    
    var toastDiv = document.createElement('div');
    var toastP = document.createElement('p');
    
    switch(level) {
        case 1:
    toastDiv.className = "toastergood";
            break;
        case 2:
    toastDiv.className = "toasterwarn";
            break;
        case 3:
    toastDiv.className = "toasterbad";
            break;
        default:
    toastDiv.className = "toaster";
    }    
    
    toastDiv.id = Math.random();
    toastP.innerHTML = message;
    toastDiv.appendChild(toastP);
    var body = getByName('body')[0];
    body.appendChild(toastDiv);
    toastDiv.style.opacity = "0";
    window.setTimeout("getById('" + toastDiv.id + "').style.opacity = 100;", 30);
    window.setTimeout("getById('" + toastDiv.id + "').style.opacity = 0;", 4000);
    window.setTimeout("getByName('body')[0].removeChild(getById('" + toastDiv.id + "'));", 6000);
}

function sendPost(url, data, headers) {
var request = new XMLHttpRequest();
request.onreadystatechange= function () {
    if (request.readyState==4) {
        getById('add').style.disabled = false;
        toast(parseResponse(request.responseText), 1);
    }
}
request.open("POST", url, true);

request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
if(headers != undefined){
for(var i = 0; i < headers.length; i++) {
request.setRequestHeader(headers[i][0], headers[i][1]);    
}
}
var postdata = '';

for(var d = 0; d < data.length; d++) {
postdata += encodeURIComponent(data[d][0]) + "=" + encodeURIComponent(data[d][1]) + "&";    
}


request.send(postdata);
}


function add(etc){
postwith('manage.php' + etc , [['action', 'add']
                        , ['place', getById('place').value]
                        , ['address', getById('address').value]
                        , ['work', getById('work').value]]);
getById('add').style.disabled = true;
}


function parseResponse(text) {
    
    
}


function postwith (to,p) {
  var myForm = document.createElement("form");
  myForm.style.display = "none";
  myForm.method="post" ;
  myForm.action = to ;
  for (var k in p) {
    var myInput = document.createElement("input") ;
    myInput.setAttribute("name", p[k][0]);
    myInput.setAttribute("value", p[k][1]);
    myForm.appendChild(myInput) ;
  }
  document.body.appendChild(myForm) ;
  myForm.submit() ;
  document.body.removeChild(myForm) ;
}

function del(id, etc){
postwith('manage.php' + etc , [['action', 'delete']
                        , ['id', id]]);    
}