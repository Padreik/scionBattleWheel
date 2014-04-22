/**************************************************
 * dom-drag.js
 * 09.25.2001
 * www.youngpup.net
 * Script featured on Dynamic Drive (http://www.dynamicdrive.com) 12.08.2005
 **************************************************
 * 10.28.2001 - fixed minor bug where events
 * sometimes fired off the handle, not the root.
 **************************************************/

var z = 100000; // zIndex so dragging is always on top

 /******************************************
  * functions for cloning
  ******************************************/
 			function findPos(obje) {
				var curleft = curtop = 0;
				if (obje.offsetParent) {
					curleft = obje.offsetLeft
					curtop = obje.offsetTop
					while (obje = obje.offsetParent) {
						curleft += obje.offsetLeft
						curtop += obje.offsetTop
					}
				}
				return [curleft,curtop];
			}
			
			function setPosition(obje, lyr, xOffset, yOffset) {
				var coors = findPos(obje);
				var x = document.getElementById(lyr);
				x.style.top = coors[1] + yOffset + 'px';
				x.style.left = coors[0] + xOffset + 'px';
			}
			
			var number = 0;
			
			function cloneIt() {
				var baby = this.cloneNode(true);
				baby.id = this.id + number;
				baby.onclick = null;
				baby.style.position = 'absolute';
				document.body.appendChild(baby);
				setPosition(this, baby.id, -30, 30);
				Drag.init(baby);
				
				for (i = 0; i < baby.childNodes.length; i++) {
					if (baby.childNodes[i].className == 'redX') {
						baby.childNodes[i].style.mouse = 'pointer';
					}
					if (baby.childNodes[i].className == 'iconInput') {
						baby.childNodes[i].id = baby.childNodes[i].id + number;
						cp_init(baby.childNodes[i].id);
					}
					if ((baby.childNodes[i].className == 'iconText') || 
					    (baby.childNodes[i].className == 'iconTextLarge'))
                    {
					   baby.childNodes[i].value = document.getElementById("defaultTextArea").value;
					}
				}
				number++; // increment counter to avoid duplicate ids
			}


var Drag = {

	obj : null,

	init : function(o, oRoot, minX, maxX, minY, maxY, bSwapHorzRef, bSwapVertRef, fXMapper, fYMapper)
	{
		o.style.cursor = 'move';
		o.onmousedown	= Drag.start;

		o.hmode			= bSwapHorzRef ? false : true ;
		o.vmode			= bSwapVertRef ? false : true ;

		o.root = oRoot && oRoot != null ? oRoot : o ;

		if (o.hmode  && isNaN(parseInt(o.root.style.left  ))) o.root.style.left   = "0px";
		if (o.vmode  && isNaN(parseInt(o.root.style.top   ))) o.root.style.top    = "0px";
		if (!o.hmode && isNaN(parseInt(o.root.style.right ))) o.root.style.right  = "0px";
		if (!o.vmode && isNaN(parseInt(o.root.style.bottom))) o.root.style.bottom = "0px";

		o.minX	= typeof minX != 'undefined' ? minX : null;
		o.minY	= typeof minY != 'undefined' ? minY : null;
		o.maxX	= typeof maxX != 'undefined' ? maxX : null;
		o.maxY	= typeof maxY != 'undefined' ? maxY : null;

		o.xMapper = fXMapper ? fXMapper : null;
		o.yMapper = fYMapper ? fYMapper : null;

		o.root.onDragStart	= new Function();
		o.root.onDragEnd	= new Function();
		o.root.onDrag		= new Function();
		
		//var e = window.event;
		//Drag.start(e);

	},

	start : function(e)
	{
		var o = Drag.obj = this;
		
		e = Drag.fixE(e);
		targ = Drag.getTarget(e)
		
		if (!((targ.type == 'text') ||
		      (targ.type == 'textarea'))) { // only drag if they're not trying to type in info
			var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
			var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
			o.root.onDragStart(x, y);
		
			o.root.style.zIndex = z++; // always on top
			o.root.style.opacity = '.30'; // opacity for w3c browsers
			o.root.style.filter = 'alpha(opacity=30)'; // opacity for IE
			o.root.style.mozOpacity = "0.3"; // opacity for older mozilla browsers
		
			o.lastMouseX	= e.clientX;
			o.lastMouseY	= e.clientY;

			if (o.hmode) {
				if (o.minX != null)	o.minMouseX	= e.clientX - x + o.minX;
				if (o.maxX != null)	o.maxMouseX	= o.minMouseX + o.maxX - o.minX;
			} else {
				if (o.minX != null) o.maxMouseX = -o.minX + e.clientX + x;
				if (o.maxX != null) o.minMouseX = -o.maxX + e.clientX + x;
			}

			if (o.vmode) {
				if (o.minY != null)	o.minMouseY	= e.clientY - y + o.minY;
				if (o.maxY != null)	o.maxMouseY	= o.minMouseY + o.maxY - o.minY;
			} else {
				if (o.minY != null) o.maxMouseY = -o.minY + e.clientY + y;
				if (o.maxY != null) o.minMouseY = -o.maxY + e.clientY + y;
			}

			document.onmousemove	= Drag.drag;
			document.onmouseup		= Drag.end;
			return false;
		}
	},

	drag : function(e)
	{
		e = Drag.fixE(e);
		var o = Drag.obj;

		var ey	= e.clientY;
		var ex	= e.clientX;
		var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
		var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
		var nx, ny;

		if (o.minX != null) ex = o.hmode ? Math.max(ex, o.minMouseX) : Math.min(ex, o.maxMouseX);
		if (o.maxX != null) ex = o.hmode ? Math.min(ex, o.maxMouseX) : Math.max(ex, o.minMouseX);
		if (o.minY != null) ey = o.vmode ? Math.max(ey, o.minMouseY) : Math.min(ey, o.maxMouseY);
		if (o.maxY != null) ey = o.vmode ? Math.min(ey, o.maxMouseY) : Math.max(ey, o.minMouseY);

		nx = x + ((ex - o.lastMouseX) * (o.hmode ? 1 : -1));
		ny = y + ((ey - o.lastMouseY) * (o.vmode ? 1 : -1));

		if (o.xMapper)		nx = o.xMapper(y)
		else if (o.yMapper)	ny = o.yMapper(x)

		Drag.obj.root.style[o.hmode ? "left" : "right"] = nx + "px";
		Drag.obj.root.style[o.vmode ? "top" : "bottom"] = ny + "px";
		Drag.obj.lastMouseX	= ex;
		Drag.obj.lastMouseY	= ey;

		Drag.obj.root.onDrag(nx, ny);
		return false;
	},

	end : function()
	{
		document.onmousemove = null;
		document.onmouseup   = null;
		
		// leave it partially transparent when dropped
		Drag.obj.root.style.opacity = '1.0'; // opacity for w3c browsers
		Drag.obj.root.style.filter = 'alpha(opacity=100)'; // opacity for IE
		Drag.obj.root.style.mozOpacity = "1.0"; // opacity for older mozilla browsers

		Drag.obj.root.onDragEnd(	parseInt(Drag.obj.root.style[Drag.obj.hmode ? "left" : "right"]), 
									parseInt(Drag.obj.root.style[Drag.obj.vmode ? "top" : "bottom"]));
		Drag.obj = null;
	},

	fixE : function(e)
	{
		if (typeof e == 'undefined') e = window.event;
		if (typeof e.layerX == 'undefined') e.layerX = e.offsetX;
		if (typeof e.layerY == 'undefined') e.layerY = e.offsetY;
		return e;
	},
	
	getTarget : function(e)
	{
		var targ;
		if (!e) var e = window.event;
		if (e.target) 
			targ = e.target;
		else if (e.srcElement) 
			targ = e.srcElement;
		if (targ.nodeType == 3) // defeat Safari bug
			targ = targ.parentNode;
		return targ;
	}

};