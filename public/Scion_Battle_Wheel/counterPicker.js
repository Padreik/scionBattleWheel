var class_grid = [
  ["counterPic", "counterText", "counterHandled", "counterLargeText"],	// class names
  ["Picture", "Text", "Handle Only", "More Text"]];                     // display text

var class_dom = null;
var class_caller = null;
var class_defaultclass = 'ffffff';
var class_closePID = null;
var rightclick = false; // was the right mouse button used?

function is_rclick(e){
    if (!e) var e = window.event;
	if(event.button)
   	{
		ev=event.button;
	}
	else 
	{
		ev=e.which
	}
    return (ev==2||ev==3);
}

function class_init(id) {
  var obj = document.getElementById(id);
  if (!obj) {
    alert("Class picker can't find '"+id+"'");
    return;
  }
  var theClass = obj.style.className;
  
//  obj.onclick = new Function("class_open(this)");
  obj.oncontextmenu = new Function("class_open(this); return false;");
  obj.onmouseover = class_cancelclose;
  obj.onmouseout = class_closesoon;
}

function class_open(caller) {
  // Create a table of colours.
  if (class_dom) {
    class_close();
    return;
  }
  class_caller = caller;
  class_defaultclass = document.getElementById(caller.id).parent.className;
  var posX = 0;
  var posY = caller.offsetHeight;
  while (caller) {
    posX += caller.offsetLeft;
    posY += caller.offsetTop;
    caller = caller.offsetParent;
  }
  class_dom = document.createElement("div");
  var div = document.createElement("div");
  div.setAttribute("border", "1");

  for (var y=0; y<class_grid[0].length; y++) {
    var p = document.createElement("p");
    p.innerHTML = class_grid[0][y];

    if (class_grid[0][y] == caller.parent.className) {
        p.style.backgroundColor = 'black';
        p.style.fontColor = 'white';
        p.style.borderStyle = "outset";
    }
    else {
        p.style.backgroundColor = 'white';
        p.style.fontColor = 'black';
        p.style.borderStyle = 'solid';
    }
    p.setAttribute("onClick", "this.parent.className = '" + class_grid[1][y] + "';");
    p.onmouseover = class_onmouseover;
    p.onmouseout = class_onmouseout;
    
    div.appendChild(p);
  }

  class_dom.appendChild(div);

  class_dom.style.position = "absolute";
  class_dom.style.left = "0px";
  class_dom.style.top = "0px";
  class_dom.style.visibility = "hidden";
  class_dom.style.zIndex = 999999; // on top of everything
  document.body.appendChild(class_dom);
  // Don't widen the screen.
  if (posX + class_dom.offsetWidth > document.body.offsetWidth)
    posX = document.body.offsetWidth - class_dom.offsetWidth;
  class_dom.style.left = posX+"px";
  class_dom.style.top = posY+"px";
  class_dom.style.visibility = "visible";
  
  return false;
}

function class_close() {
  // Close the table now.
  class_cancelclose();
  if (class_dom)
    document.body.removeChild(class_dom)
  class_dom = null;
  class_caller = null;
}

function class_closesoon() {
  // Close the table a split-second from now.
  class_closePID = window.setTimeout("class_close()", 250);
}

function class_cancelclose() {
  // Don't close the colour table after all.
  if (class_closePID)
    window.clearTimeout(class_closePID);
}

function class_onmouseover() {
  // Place a black border on the cell if the contents are light, a white border if the contents are dark.
  this.style.borderStyle = "solid";
  this.style.borderColor = "white";
  this.style.color = "black";
}

function class_onmouseout() {
  // Remove the border.
  if (this.label == class_defaultclass)
    this.style.borderStyle = "outset";
  else
    this.style.borderStyle = "solid";
}
