String.prototype.ReslideReplaceAll = function(target, replacement) {
  return this.split(target).join(replacement);
};
function ReslideGenerateId() {
	var id = "",x;
   
    x = Math.floor((Math.random() * 1000) + 1);
	id = "slider"+x+"_container";

	return id;
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function IsVal(str) {
    try {
        str.getAttribute('value');
    } catch (e) {
        return false;
    }
    return str.value;
}
function bind(func, context) {
  return function() { // (*)
    return func.apply(context, arguments);
  };
}

function getparamsFromUrl( name, url ) {
	if (!url) url = location.href;
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( url );
	return results == null ? null : results[1];
}

/**##  DOM funtions ##**/


function _reslide(elem) {
	var elem = elem || 'div';
	if(typeof elem != "object") {
		elem = elem.toUpperCase();
		var self = document.createElement(elem);
	}
	else {
		self = (elem.length > 1)?elem[0]:elem;
		elem.nodeName.toLowerCase() == 'select'&&(self = elem);
	}
	self.addClass = function() {
		for(var  i = 0;i<arguments.length;i++)
		self.classList.add(arguments[i]);
		return self;
	
	};
	self.addAttr = function() {
		var props = arguments;
		var length = arguments.length;
		if(!arguments.length) 
			return false;
		if(length % 2 != 0) 
			props[length] = props[length-1];
		for(var  i = 0;i<props.length;i = i+2) {
			self.setAttribute(arguments[i],arguments[i+1]);
		};
		return self;
	};
	self.width = function(){
		return parseFloat(window.getComputedStyle(self).width);
	}
	self.addStyle = function(styleString) {
		if(!arguments.length) 
			return false;		
		var style = styleString;


		style = style.split(";");

		for(var i = 0;i<style.length;i++) {
			if(style[i] == "") continue;
			var styler = style[i].split(":");
			styler[0] = styler[0].ReslideReplaceAll(' ','');
			self.style[styler[0]] = styler[1];
		}
		return self;		
	};	
	self.append = function(child){
		self.appendChild(child);
		return self;
		
	};
	self.prepend = function(child){
		self.insertBefore( child, self.firstChild );
		return self;		
	};
	//self._ = function

	self.getAttr = function(attr) {
		return  self.getAttribute(attr);
	}	
	
	self.val = function() {
		//alert(IsVal(self));
		//if(IsVal(self)) 
		//	return self.getAttribute('value');
		if(arguments.length == 1) {
			self.value = arguments[0];
		}
		return self.value;
	}	
	self.parent = function() {
		//alert(IsVal(self));
		//if(IsVal(self)) 
		//	return self.getAttribute('value');
		return self.parentNode;
	}	
	
// prepend our span eleemnt to our section element
	return self;
} 
_reslide.each = function (str, callback) {
	var a = [];
	if(typeof str != 'object')
		var elms =  document.querySelectorAll(str);
	else elms = str;
	for(var i = 0;i<elms.length;i++) {
		a.push(bind(callback,elms[i]));
		a[i]();
	}
	return a;//_reslide(elms);
	//alert(str);
}
_reslide.html = function (html) {
    var itm = document.createElement("div");
	itm.innerHTML = html;

	var cln = itm.cloneNode(true).childNodes;
	return cln;
};

_reslide._ = function(str){
	var count = str.indexOf(' ');
	count ++;
	var a = [];	
	if(str[0] == "#" && !count)  {
		var elms =  document.getElementById(str.replace('#',''));
		if (elms == null) {elms = _reslide()};
		if(elms) {
			elms.on = function(prop,funtion) {
				elms.addEventListener(prop,funtion);
			}
		} 

		return _reslide(elms);

	}
	var elms =  document.querySelectorAll(str);
	if(elms.length) {
		elms.on = bind(function(prop,funtion){
						for(var i = 0; i< this.length;i++)
						this[i].addEventListener(prop,funtion);
					},
					elms
				);
	
		for(var i = 0;i<elms.length;i++) {
			a.push(_reslide(elms[i]));
		};
		a.on = elms.on;
	}
	return a;
}
_reslide.find = function(a, b){
	var maches = [];
	var query = "";
	if(typeof a != 'object')
		var a =  document.querySelectorAll(a);
	else a = a;	
	if(a.length) {
		for(var i = 0;i<a.length;i++) {
			var clas = _reslide(a[i]).getAttr('class');
			if(clas) {
				clas = clas.split(" ");
				clas = clas[0];			
				clas = "."+clas;
			}
			else clas = "";
			var id = _reslide(a[i]).getAttr('id');
			var nodename = _reslide(a[i]).nodeName.toLowerCase();
			var pclas = _reslide(a[i].parentNode).getAttr('class');
			if(pclas) {
				pclas = pclas.split(" ");
				pclas = pclas[0];			
				pclas = "."+pclas;
			}
			else pclas = "";	
			var pid = _reslide(a[i].parentNode).getAttr('id');
			var pnodename = _reslide(a[i].parentNode).nodeName.toLowerCase();
			if(pid) pid = "#"+pid; 
				else pid = "";
			if(id) id = "#"+id; 
				else id="";
			query = pnodename+pid+pclas+" > "+nodename+id+clas+" "+b;
			var d = document.querySelectorAll(query);
			if(d.length) {
				for(var i = 0;i<d.length;i++) {
					maches.push(_reslide(d[i]));
				}
			}
			//maches = maches.concat(document.querySelectorAll(query));	
		}		
	} else {
		var clas = _reslide(a).getAttr('class');
			if(clas) {
				clas = clas.split(" ");
				clas = clas[0];			
				clas = "."+clas;
			}		
		var id = _reslide(a).getAttr('id');
		var nodename = _reslide(a).nodeName.toLowerCase();
		var pclas = _reslide(a.parentNode).getAttr('class');
			if(pclas) {
				pclas = pclas.split(" ");
				pclas = pclas[0];			
				pclas = "."+pclas;
			}
			else pclas = "";			
		var pid = _reslide(a.parentNode).getAttr('id');
		var pnodename = _reslide(a.parentNode).nodeName.toLowerCase();
			if(pid) pid = "#"+pid; 
				else pid = "";
			if(id) id = "#"+id; 
				else id="";
		query = pnodename+pid+pclas+" > "+nodename+id+clas+" "+b;
	//	maches = maches.concat(document.querySelectorAll(query));
			var d = document.querySelectorAll(query);
			if(d.length) {
				for(var i = 0;i<d.length;i++) {
					maches.push(_reslide(d[i]));
				}
			}	
	}		
	return maches;
}
_reslide.parseJSON = function (obj) {
	var sliderJSON_OBJECTS = {};
	for( var key in obj) {
		sliderJSON_OBJECTS[key] = (JSON.stringify(obj[key],""));
	}
	return sliderJSON_OBJECTS;
}