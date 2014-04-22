// Colour Picker v1.0
// Provides functionality for a dropdown palette of colours.
// Copyright (C) 2006 Neil Fraser
// http://neil.fraser.name/software/colourpicker/

// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License (www.gnu.org) for more details.


// Include at the top of your page:
//   <SCRIPT LANGUAGE='JavaScript1.3' SRC='cp.js'></SCRIPT>
// Call with:
//   <INPUT NAME="mycolour" ID="mycolour" VALUE="ff00ff">
//   <SCRIPT LANGUAGE='JavaScript1.3'><!--
//   cp_init("mycolour")
//   //--></SCRIPT>

var cp_grid = [
  ["ffffff", "cccccc", "999999", "666666", "333333", "000000"],	 // grayscale
  ["ffb6c1", "ff929a", "ff6d74", "ff494d", "ff2427", "ff0000"],	 // red
  ["e3a869", "df9b54", "da8e3f", "d6802a", "d17315", "cd6600"],	 // orange
  ["ffff99", "fff57a", "ffeb5c", "ffe03d", "ffd61f", "ffcc00"],	 // yellow
  ["7cfc00", "63e500", "4acf00", "32b800", "19a200", "008b00"],	 // green
  ["33ffff", "29ccf5", "1f99eb", "1466e0", "0a33d6", "0000cc"],  // blue
  ["ff66ff", "e052e0", "c23dc2", "a329a3", "851485", "660066"]]; // indigo / violet

var cp_dom = null;
var cp_caller = null;
var cp_defaultcolour = 'ffffff';
var cp_closePID = null;
var rightclick = false; // was the right mouse button used?

function rclick(e){
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

function cp_init(id) {
  // Hide the form element, and replace it with a colour box.
  var obj = document.getElementById(id);
  if (!obj) {
    alert("Colour picker can't find '"+id+"'");
    return;
  }
  var theColor = obj.style.backgroundColor;
  if (!cp_color2rgb(theColor)) {
    alert("Colour picker can't parse colour code (" + theColor + ") in '"+id+"'");
    return;
  }
  
//  obj.onclick = new Function("cp_open(this)");
  obj.oncontextmenu = new Function("cp_open(this); return false;");
  obj.onmouseover = cp_cancelclose;
  obj.onmouseout = cp_closesoon;

}

function cp_open(caller) {
  // Create a table of colours.
  if (cp_dom) {
    cp_close();
    return;
  }
  cp_caller = caller;
  cp_defaultcolour = document.getElementById(caller.id).style.backgroundColor;
  var posX = 0;
  var posY = caller.offsetHeight;
  while (caller) {
    posX += caller.offsetLeft;
    posY += caller.offsetTop;
    caller = caller.offsetParent;
  }
  cp_dom = document.createElement("div");
  var table = document.createElement("table");
  table.setAttribute("border", "1");
  table.style.backgroundColor = "#808080";
  table.onmouseover = cp_cancelclose;
  table.onmouseout = cp_closesoon;
  var tbody = document.createElement("tbody"); // IE 6 needs this.
  var row, cell;
  for (var y=0; y<cp_grid.length; y++) {
    row = document.createElement("tr");
    tbody.appendChild(row);
    for (var x=0; x<cp_grid[y].length; x++) {
      cell = document.createElement("td");
      row.appendChild(cell);
      cell.style.backgroundColor = "#"+cp_grid[y][x];
      cell.label = cp_grid[y][x];
      cell.style.border = "solid 2px #"+cell.label;
      cell.style.fontSize = "0.8em";
      cell.style.textAlign = "center";
      cell.style.width = "10px";
      cell.onmouseover = cp_onmouseover;
      cell.onmouseout = cp_onmouseout;
      cell.onclick = cp_onclick;
      cell.style.emptyCells = "show";
      cell.innerHTML = "&nbsp;";
      if (cp_defaultcolour.toLowerCase() == cp_grid[y][x].toLowerCase()) {
        cell.onmouseover();
        cell.onmouseout();
      }
    }
  }
  table.appendChild(tbody);
  cp_dom.appendChild(table);

  cp_dom.style.position = "absolute";
  cp_dom.style.left = "0px";
  cp_dom.style.top = "0px";
  cp_dom.style.visibility = "hidden";
  cp_dom.style.zIndex = 999999; // on top of everything
  document.body.appendChild(cp_dom);
  // Don't widen the screen.
  if (posX + cp_dom.offsetWidth > document.body.offsetWidth)
    posX = document.body.offsetWidth - cp_dom.offsetWidth;
  cp_dom.style.left = posX+"px";
  cp_dom.style.top = posY+"px";
  cp_dom.style.visibility = "visible";
  
  return false;
}

function cp_close() {
  // Close the table now.
  cp_cancelclose();
  if (cp_dom)
    document.body.removeChild(cp_dom)
  cp_dom = null;
  cp_caller = null;
}

function cp_closesoon() {
  // Close the table a split-second from now.
  cp_closePID = window.setTimeout("cp_close()", 250);
}

function cp_cancelclose() {
  // Don't close the colour table after all.
  if (cp_closePID)
    window.clearTimeout(cp_closePID);
}

function cp_onclick() {
  // Clicked on a colour.  Close the table, set the colour, fire an onchange event.
  cp_caller.style.backgroundColor = "#"+this.label;
  var input = document.getElementById(cp_caller.id)
  var rgb = cp_color2rgb(this.label);
  if (rgb[0]+rgb[1]+rgb[2] > 255*3/2)
    input.style.color = "black";
  else
    input.style.color = "white";
  cp_close();
  if (input.onchange)
    input.onchange();
}

function cp_onmouseover() {
  // Place a black border on the cell if the contents are light, a white border if the contents are dark.
  this.style.borderStyle = "solid";
  var rgb = cp_color2rgb(this.label);
  if (rgb[0]+rgb[1]+rgb[2] > 255*3/2) {
    this.style.borderColor = "black";
    this.style.color = "black";
  }
  else {
    this.style.borderColor = "white";
    this.style.color = "white"
  }
  this.innerHTML = "A";
}

function cp_onmouseout() {
  // Remove the border.
  if (this.label == cp_defaultcolour)
    this.style.borderStyle = "outset";
  else
    this.style.border = "solid 2px #"+this.label;
  this.innerHTML = "&nbsp";
}

function cp_color2rgb(col) {
  // Parse '0088ff' and return the [r, g, b] ints.
  if (col.indexOf('#') >= 0) {
    // #ffffff
    col = col.substr(1, (col.length - 1));
  }
  else if (col.indexOf('(') >= 0) {
    // rgb(255, 255, 255)
    var s = (col.indexOf('(') + 1);
    var e = (col.indexOf(')') - 1);
    col = col.substr(s, col.length - 5)
    arr = col.split(', ')
    var r = arr[0]
    var g = arr[1]
    var b = arr[2]
    return [r, g, b];
  }

  var m = col.match(/^([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])$/);
  if (m) {
    var r = parseInt(m[1], 16);
    var g = parseInt(m[2], 16);
    var b = parseInt(m[3], 16);
    return [r, g, b];
  }
  else {
    return null;
  }
}
