
var ownerId = 0;

/*
function CounterFromFields(name, id, class, x, y, image, text, color, parent, locked)
{
alert('in');
    this.nam = name;
    this.id = id;
    this.className = class;
    this.x = x;
    this.y = y;
    this.imageSource = image;
    this.text = text;
    this.color = color;
    this.par = parent;
    this.locked = locked;
}
*/
function toggleLockStatus(obj) {
    if (obj.className == 'locked') {
        obj.className = 'unlocked'
        obj.src = 'unlocked.bmp';
    }
    else {
        obj.className = 'locked'
        obj.src = 'locked.bmp';
    }
}


function loadSession(id)
{
    if ("" != id)
    {
        window.location="" + "?id=" + id;
    }
}

function saveSession(id)
{
    if ((null == id) || ("" == id))
    {
        name = prompt("Please enter a name for the session.",""); 
    }

    allOfIt = "";
    foundOne = false;
    for (var i = 0; i < document.body.childNodes.length; i++) { 
        // save child data
        if(/counter/i.test(document.body.childNodes[i].className)) {
            foundOne = true;
            eval("temp = new Counter(document.body.childNodes['" + i + "'])");
            allOfIt += "__NEW__" + serializeCounter(temp);
        }
    }
    
    if (foundOne)
    {
        params = "";
        if (name)
        {
            params = "name=" + name;
        }
        else
        {
            params = "id=" + id;
        }
        params += "&counters="+allOfIt;
        params += "&ownerId="+ownerId;
        params += "&wheel="+document.getElementById("wheelImg").src;
        xmlhttpPost("save.php", params);
    }  
}

function xmlhttpPost(strURL, strDATA) {
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            displayResult(self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(strDATA);
}

function displayResult(str){
    document.getElementById("result").innerHTML = str;
}

function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}


var counter_array = new Array();
