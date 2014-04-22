// this class requires the inclusion of the cjl_cookie.js in the tools folder
var count = 0;
// converts a cookie string to an object, call getCookie to retrieve the string from the client
function cookieToCounter(name) 
{
    cookie = new CJL_CookieUtil(name, 525600, "/"); // cookie to build from

    this.nam = cookie.getSubValue('name');
    this.id = cookie.getSubValue('id');
    this.className = cookie.getSubValue('cssClass');
    this.x = cookie.getSubValue('x');
    this.y = cookie.getSubValue('y');
    this.imageSource = cookie.getSubValue('imageSource');
    this.text = cookie.getSubValue('text');

    if (this.text == undefined) // clear the text field if the value is undefined
      this.text = '';

    this.color = cookie.getSubValue('color');
    this.par = cookie.getSubValue('parent');
    this.locked = cookie.getSubValue('locked');

/*    alert('name:        ' + this.nam + '\n' +
          'id:          ' + this.id + '\n' +
          'cssClass:    ' + this.cssClass + '\n' +
          'x:           ' + this.x + '\n' +
          'y:           ' + this.y + '\n' +
          'imageSource: ' + this.imageSource + '\n' +
          'text:        ' + this.text + '\n' +
          'color:       ' + this.color + '\n' + 
          'parent:      ' + this.par + '\n' + 
          'locked:      ' + this.locked);*/
}

// convert to string
function serializeCounter(c) 
{
    var string = "no name";
    if (!c.name)
    {
        return string;
    }
    
    string = "";

    string += c.name + "_SEP_";
    string += c.id + "_SEP_";
    string += c.cssClass + "_SEP_";
    string += c.x + "_SEP_";
    string += c.y + "_SEP_";
    string += c.imageSource + "_SEP_";
    string += c.text + "_SEP_";
    string += c.color + "_SEP_";
    string += c.par + "_SEP_";
    string += c.locked + "_SEP_";
    return string;
}

function Counter(obj) {
    this.id = obj.id; // id
    this.cssClass = obj.className; // class
    if (obj.par)
        this.parent = obj.par; // parent
    else if (obj.parentNode)
        this.parent = obj.parentNode.id; // parent
    else
        this.parent = 'bod';
    
    if (obj.x) {
        this.x = obj.x;
        this.y = obj.y;
    }
    else {
        arr = findPos(obj); // gets position, function is defined in dom-drag.js
        this.x = arr[0];
        this.y = arr[1];
    }

    this.cookie = new CJL_CookieUtil("counter_" + this.id, 525600, "/");

    if (obj.childNodes) {
        for (var i = 0; i < obj.childNodes.length; i++) { // save child data
            switch (obj.childNodes[i].className) {
            case('iconImg'):
              this.imageSource = obj.childNodes[i].src;
              break;
            case('iconText'):
              this.text = obj.childNodes[i].value;
              break;
            case('iconInput'):
              this.name = obj.childNodes[i].value;
              this.color = obj.childNodes[i].style.backgroundColor;
              break;
            case('locked'):
              this.locked = true;
              break;
            case('unlocked'):
              this.locked = false;
              break;
            default:
              break;
            }
        }
    }
    else {
        this.imageSource = obj.imageSource;
        this.text = obj.text;
        this.name = obj.nam;
        this.color = obj.color;
        this.locked = obj.locked;
    }
    
    // converts the object to a cookie string, call storeCookie to set the cookie on the client
    this.toCookie = function toCookie() { 
        for(sProperty in this) {
            if (typeof this[sProperty] == 'boolean') {
                if (this[sProperty])
                    this.cookie.setSubValue(sProperty, 'true');
                else
                    this.cookie.setSubValue(sProperty, 'false');
            }
            if ((typeof this[sProperty] == 'string') || 
                (typeof this[sProperty] == 'number'))
                this.cookie.setSubValue(sProperty, this[sProperty]);
        }
    }

    this.popMsg = function popMsg() {
        var outMsg = '';
        for(sProperty in this) {
            if ((typeof this[sProperty] == 'boolean') ||
                (typeof this[sProperty] == 'string') || 
                (typeof this[sProperty] == 'number')) {
                if (this[sProperty]) {
                    outMsg += sProperty + ': ' + this[sProperty] + '\n';
                }
            }
        }
    }
    
    // converts object to html
    this.toDom = function toDom() {
//  <div class="counterPic" id="counter1">
        var counter = document.createElement('div');
        counter.className = this.cssClass;
        counter.setAttribute('id', this.id);

        counter.style.position = 'absolute';
        counter.style.top = this.y + 'px';
        counter.style.left = this.x + 'px';

//      <img src="icons\The Dodekatheon\Hephaestus.jpg" class="iconImg" />
        var img = document.createElement('img');
        img.setAttribute('src', this.imageSource);
        img.className = 'iconImg';
        img.setAttribute('id', 'iconImg' + this.id);
        counter.appendChild(img);

//        <div class="handle"></div>
        var div = document.createElement('div');
        div.className = 'handle';
        div.setAttribute('id', 'handle' + this.id);
        counter.appendChild(div);

//        <textarea value="" class="iconText"></textarea>
        var txt = document.createElement('textArea');
        txt.setAttribute('value', this.text); // for IE
        txt.defaultValue = this.text; // for mozilla
        txt.className = 'iconText';
        counter.appendChild(txt);

//        <input name="nameBox" type="text" value="name1" class="iconInput" style="background-color: #ffe03d;" id="iconText1">
        var nm = document.createElement('input');
        nm.setAttribute('name', 'name' + count);
        nm.setAttribute('type', 'text');
        nm.setAttribute('value', this.name);
        nm.className = 'iconInput';
        nm.style.backgroundColor = this.color;
        
        var rgb = cp_color2rgb(this.color);
        if (rgb[0]+rgb[1]+rgb[2] > 255*3/2)
          nm.style.color = "black";
        else
          nm.style.color = "white";

        nm.setAttribute('id', 'iconText' + count++);
        counter.appendChild(nm);

//        <img src="redX.bmp" class="redX" onclick="return false;" />
        var image = document.createElement('img');
        image.setAttribute('src', 'redX.bmp');
        image.className = 'redX';
        image.setAttribute('onClick', 'this.parentNode.parentNode.removeChild(this.parentNode);');
        image.style.mouse = 'pointer';
        counter.appendChild(image);

//        <img src="locked.bmp" class="locked" onclick="toggleLockStatus(this);" />
        if (this.locked)
            var str = 'locked';
        else
            var str = 'unlocked';
        
        var image = document.createElement('img');
        image.setAttribute('src', str + '.bmp');
        image.className = str;
        image.setAttribute('onClick', 'toggleLockStatus(this);');
        image.style.mouse = 'pointer';
        counter.appendChild(image);

//      </div> <!-- counterPic -->
        document.getElementById(this.parent).appendChild(counter);
        Drag.init(counter); // set up drag and drop
        cp_init(nm.id);     // allow right click to change name box's color
        //todo: class_init(img.id);     // allow right click on pic to change counter's class
        //todo: class_init(div.id);     // allow right click on handle to change counter's class
    }
  
    // deletes cookie
    this.deleteCookie = function deleteCookie() {
        this.cookie.expire();
    }
}