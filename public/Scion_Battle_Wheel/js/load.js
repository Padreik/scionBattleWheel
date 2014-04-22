window.onunload = function() {
    ck = new CJL_CookieUtil("config");  // cookie for source
    ck.setSubValue("imgSource", document.getElementById("wheelImg").src);
}

window.onload = function() {

    // build a cookie id using the ip address and time
    createCookie('ownerId' , '1394914020.3', 10000);
ownerId = 1394914020.3;

	var galleryPanels = new Array();

	var opt = 0;
	var arr = document.getElementsByTagName('div');
	
	for(var i = 0; i < arr.length; i++) {
		// find all icon divs
		if(/counter/i.test(arr[i].className)) {
			arr[i].onclick = cloneIt;
		}

		// find all gallery divs
		if ((/SlidingPanelsContent/i.test(arr[i].className)) && (arr[i].id)) {
			galleryPanels[opt++] = arr[i].id;
		}
	}
	
	galleryPanels.sort();
	opt = 0;
	
	for(var i = 0; i < galleryPanels.length; i++) {
		// add to select
		document.forms['navForm'].gallerySelect.options[opt++] = new Option(galleryPanels[i], galleryPanels[i]);
	}
	
ck = new CJL_CookieUtil("config");  // cookie for sourceif (ck.getSubValue("imgSource"))\tdocument.getElementById("wheelImg").src = ck.getSubValue("imgSource");
}