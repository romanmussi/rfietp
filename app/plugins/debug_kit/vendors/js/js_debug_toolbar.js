/**
 * Debug Toolbar Javascript.
 *
 * Creates the DEBUGKIT namespace and provides methods for extending
 * and enhancing the Html toolbar.  Includes library agnostic Event, Element,
 * Cookie and Request wrappers.
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       debug_kit
 * @subpackage    debug_kit.views.helpers
 * @since         DebugKit 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
var DEBUGKIT = function () {
	var undef;
	return {
		module : function (newmodule) {
			if (this[newmodule] === undef) {
				this[newmodule] = {};
				return this[newmodule];
			}
			return this[newmodule];
		}
	};
}() ;

DEBUGKIT.loader = function () {
	return {
		//list of methods to run on startup.
		_startup : [],

		//register a new method to be run on dom ready.
		register : function (method) {
			this._startup.push(method);
		},

		init : function () {
			for (var i = 0, callback; callback = this._startup[i]; i++) {
				callback.init();
			}
		}
	};
}();

//Util module and Element utility class.
DEBUGKIT.module('Util');
DEBUGKIT.Util.Element = {

	//test if an element is a name node.
	nodeName: function (element, name) {
		return element.nodeName && element.nodeName.toLowerCase() == name.toLowerCase();
	},

	//return a boolean if the element has the classname
	hasClass : function (element, className) {
		if (!element.className) {
			return false;
		}
		return element.className.indexOf(className) > -1;
	},

	addClass : function (element, className) {
		if (!element.className) {
			element.className = className;
			return;
		}
		element.className = element.className.replace(/^(.*)$/, '$1 ' + className);
	},

	removeClass : function (element, className) {
		if (!element.className) {
			return false;
		}
		element.className = element.className.replace(new RegExp(' ?(' + className +') ?'), '');
	},

	swapClass : function (element, removeClass, addClass) {
		if (!element.className) {
			return false;
		}
		element.className = element.className.replace(removeClass, addClass);
	},

	show : function (element) {
		element.style.display = 'block';
	},

	hide : function (element) {
		element.style.display = 'none';
	},

	//go between hide() and show() depending on element.style.display
	toggle : function (element) {
		if (element.style.display == 'none') {
			this.show(element);
			return;
		}
		this.hide(element);
	},

	_walk: function (element, walk) {
		var sibling = element[walk];
		while (true) {
			if (sibling.nodeType == 1) {
				break;
			}
			sibling = sibling[walk];
		}
		return sibling;
	},

	getNext: function (element) {
		return this._walk(element, 'nextSibling');
	},

	getPrevious: function (element) {
		return this._walk(element, 'previousSibling');
	},

	//get or set an element's height, omit value to get, add value (integer) to set.
	height: function (element, value) {
		//get value
		if (value === undefined) {
			return parseInt(this.getStyle(element, 'height'));
		}
		element.style.height = value + 'px';
	},

	//gets the style in css format for property
	getStyle: function (element, property) {
		if (element.currentStyle) {
			property = property.replace(/-[a-z]/g, function (match) {
				return match.charAt(1).toUpperCase();
			});
			return element.currentStyle[property];
		}
		if (window.getComputedStyle) {
			return document.defaultView.getComputedStyle(element, null).getPropertyValue(property);
		}
	}
};


//Event binding
DEBUGKIT.Util.Event = {
	_listeners: {},
	_eventId: 0,

	// bind an event listener of type to element, handler is your method.
	addEvent :function(element, type, handler, capture) {
		capture = (capture === undefined) ? false : capture;
		if (element.addEventListener) {
			element.addEventListener(type, handler, capture);
		} else if (element.attachEvent) {
			type = 'on' + type;
			element.attachEvent(type, handler);
		} else {
			type = 'on' + type;
			element[type] = handler;
		}
		this._listeners[++this._eventId] = {element: element, type: type, handler: handler};
	},

	// destroy an event listener. requires the exact same function as was used for attaching
	// the event.
	removeEvent: function (element, type, handler) {
		if (element.removeEventListener) {
			element.removeEventListener(type, handler, false);
		} else if (element.detachEvent) {
			type = 'on' + type;
			element.detachEvent(type, handler);
		} else {
			type = 'on' + type;
			element[type] = null;
		}
	},

	// bind an event to the DOMContentLoaded or other similar event.
	domready : function(callback) {
		if (document.addEventListener) {
			return document.addEventListener("DOMContentLoaded", callback, false);
		}

		if (document.all && !window.opera) {
			//Define a "blank" external JavaScript tag
			document.write('<script type="text/javascript" id="__domreadywatcher" defer="defer" src="javascript:void(0)"><\/script>');
			var contentloadtag = document.getElementById("__domreadywatcher");
			contentloadtag.onreadystatechange = function (){
				if (this.readyState == "complete") {
					callback();
				}
			}
			contentloadtag = null;
			return;
		}

		if (/Webkit/i.test(navigator.userAgent)){
			var _timer = setInterval(function (){
				if (/loaded|complete/.test(document.readyState)) {
					clearInterval(_timer);
					callback();
				}
			}, 10);
		}
	},

	// unload all the events attached by DebugKit. Fix any memory leaks.
	unload: function () {
		var listener;
		for (var i in this._listeners) {
			listener = this._listeners[i];
			try {
				this.removeEvent(listener.element, listener.type, listener.handler);
			} catch (e) {}
			delete this._listeners[i];
		}
		delete this._listeners;
	}
};

//Cookie utility
DEBUGKIT.Util.Cookie = function() {
	var cookieLife = 60;

//public methods
	return {
		 // Write to cookie
		 // @param [string] name Name of cookie to write.
		 // @param [mixed] value Value to write to cookie.
		write : function (name, value) {
			var date = new Date();
			date.setTime(date.getTime() + (cookieLife * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString();
			document.cookie = name + "=" + value + expires + "; path=/";
			return true;
		},

		// Read from the cookie
		// @param [string] name Name of cookie to read.
		read : function (name) {
			name = name + '=';
			var cookieJar = document.cookie.split(';');
			for (var i = 0; i < cookieJar.length; i++) {
				var chips = cookieJar[i];
				//trim leading spaces
				while (chips.charAt(0) == ' ') {
					chips = chips.substring(1, chips.length);
				}
				if (chips.indexOf(name) == 0) {
					return chips.substring(name.length, chips.length);
				}
			}
			return false;
		},
		// Delete a cookie by name.
		// @param [string] name of cookie to delete.
		del : function (name) {
			var date = new Date();
			date.setFullYear(2000,0,1);
			var expires = " ; expires=" + date.toGMTString();
			document.cookie = name + "=" + expires + "; path=/";
		}
	};
}();


// Object merge takes any number of arguments and glues them together
// @param [Object] one first object
// @return object
DEBUGKIT.Util.merge = function() {
	var out = {};
	for (var i = 0; i < arguments.length; i++) {
		var current = arguments[i];
		for (prop in current) {
			if (current[prop] !== undefined){
				out[prop] = current[prop];
			}
		}
	}
	return out;
};


// Simple wrapper for XmlHttpRequest objects.
DEBUGKIT.Util.Request = function (options) {
	var _defaults = {
		onComplete : function () {},
		onRequest : function () {},
		onFail : function () {},
		method : 'GET',
		async : true,
		headers : {
			'X-Requested-With': 'XMLHttpRequest',
			'Accept': 'text/javascript, text/html, application/xml, text/xml, */*'
		}
	};

	var self = this;
	this.options = DEBUGKIT.Util.merge(_defaults, options);
	this.options.method = this.options.method.toUpperCase();

	var ajax = this.createObj();
	this.transport = ajax;

	//event assignment
	this.onComplete = this.options.onComplete;
	this.onRequest = this.options.onRequest;
	this.onFail = this.options.onFail;

	this.send = function (url, data) {
		if (this.options.method == 'GET' && data) {
			url = url + ( (url.charAt(url.length -1) == '?') ? '&' : '?') + data; //check for ? at the end of the string
			data = null;
		}
		//open connection
		this.transport.open(this.options.method, url, this.options.async);

		//set statechange and pass the active XHR object to it.  From here it handles all status changes.
		this.transport.onreadystatechange = function () {
			self.onReadyStateChange.apply(self, arguments);
		};
		for (var key in this.options.headers) {
			this.transport.setRequestHeader(key, this.options.headers[key]);
		}
		this.onRequest();
		this.transport.send(data);
	};
};

DEBUGKIT.Util.Request.prototype.onReadyStateChange = function (){
	if (this.transport.readyState !== 4) {
		return;
	}
	if (this.transport.status == 200 || this.transport.status > 300 && this.transport.status < 400 ) {
		this.response = {
			xml: this.transport.responseXML,
			text: this.transport.responseText
		};

		if (typeof this.onComplete == 'function') {
			this.onComplete.apply(this, [this, this.response]);
		} else {
			return this.response;
		}
	} else if (this.transport.status > 400) {
		if (typeof this.onFail == 'function') {
			this.onFail.apply(this, []);
		} else {
			console.error('request failed');
		}
	}
};

// Creates cross-broswer XHR object used for requests
DEBUGKIT.Util.Request.prototype.createObj = function(){
	var request = null;
	try {
		request = new XMLHttpRequest();
	} catch (MS) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (old_MS) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(failure) {
				request = null;
			}
		}
	}
	return request;
};


//Basic toolbar module.
DEBUGKIT.toolbar = function () {
	//shortcuts
	var Request = DEBUGKIT.Request,
		Element = DEBUGKIT.Util.Element,
		Cookie = DEBUGKIT.Util.Cookie,
		Event = DEBUGKIT.Util.Event,
		toolbarHidden = false;


	// Add neat array functionality.
	// Events are bound to depth-0 UL elements.
	// Use event delegation to find original target.
	function _delegateNeatArray (event) {
		var clickedEl = event.target;
		while (!Element.nodeName(clickedEl, 'LI')) {
			clickedEl = clickedEl.parentNode;
		}
		var subUl = clickedEl.lastChild;
		if (!Element.nodeName(subUl, 'ul')) {
			return;
		}
		var hide = Boolean(subUl.style.display === 'block');
		if (hide) {
			Element.hide(subUl);
			Element.swapClass(clickedEl, 'expanded', 'collapsed');
		} else {
			Element.show(subUl);
			Element.swapClass(clickedEl, 'collapsed', 'expanded');
		}
		if (event.stopPropagation !== undefined) {
			event.stopPropagation();
		}
	}

	return {
		elements : {},
		panels : {},

		init : function () {
			var i, element, lists, index;
			this.elements.toolbar = document.getElementById('debug-kit-toolbar');

			if (this.elements.toolbar === undefined) {
				throw('Toolbar not found, make sure you loaded it.');
			}

			for (i in this.elements.toolbar.childNodes) {
				element = this.elements.toolbar.childNodes[i];
				if (element.nodeName && element.id === 'panel-tabs') {
					this.elements.panel = element;
					break;
				}
			}

			for (i in this.elements.panel.childNodes) {
				element = this.elements.panel.childNodes[i];
				if (Element.hasClass(element, 'panel-tab')) {
					this.addPanel(element);
				}
			}
			if (document.getElementsByClassName) {
				lists = this.elements.toolbar.getElementsByClassName('depth-0');
			} else {
				lists = this.elements.toolbar.getElementsByTagName('ul');
			}
			this.makeNeatArray(lists);
			this.deactivatePanel(true);
		},

		// Add a panel to the toolbar
		addPanel : function (tab) {
			if (!Element.nodeName(tab, 'li')) {
				throw ('Toolbar not found, make sure you loaded it.');
			}
			var panel = {
				id : false,
				element : tab,
				button : undefined,
				content : undefined,
				active : false
			};
			for (var i in tab.childNodes) {
				var element = tab.childNodes[i];
				if (Element.nodeName(element, 'A')) {
					panel.id = element.hash.replace(/^#/, '');
					panel.button = element;
				} else if (Element.nodeName(element, 'DIV')) {
					panel.content = element;
				}
			}
			if (!panel.id || !panel.content) {
				return false;
			}
			this.makePanelDraggable(panel);

			var self = this;
			Event.addEvent(panel.button, 'click', function(event) {
				event = event || window.event;
				event.preventDefault();
				return self.togglePanel(panel.id);
			});
			this.panels[panel.id] = panel;
			return panel.id;
		},

		// find the handle element and make the panel drag resizable.
		makePanelDraggable: function (panel) {

			//create a variable in the enclosing scope, for scope tricks.
			var currentElement = null;

			// Use the elements startHeight stored Event.pageY and current Event.pageY to
			// resize the panel
			var mouseMoveHandler = function (event) {
				event.preventDefault();
				var newHeight = currentElement._startHeight + (event.pageY - currentElement._startY);
				Element.height(Element.getPrevious(currentElement), newHeight);
			}

			// handle the mouseup event, remove the other listeners so the panel
			// doesn't continue to resize
			var mouseUpHandler = function (event) {
				currentElement = null;
				Event.removeEvent(document, 'mousemove', mouseMoveHandler);
				Event.removeEvent(document, 'mouseup', mouseUpHandler);
			}

			for (var i in panel.content.childNodes) {
				var element = panel.content.childNodes[i];
				if (Element.nodeName(element, 'DIV') && Element.hasClass(element, 'panel-resize-handle')) {

					Event.addEvent(element, 'mousedown', function (event) {
						event.preventDefault();
						currentElement = this;
						this._startY = event.pageY;
						this._startHeight = parseInt(Element.height(Element.getPrevious(currentElement)));

						// attach to document so mouse doesn't have to stay precisely on the 'handle'
						Event.addEvent(document, 'mousemove', mouseMoveHandler);
						Event.addEvent(document, 'mouseup', mouseUpHandler);
					});
				}
			}
		},

		// Toggle a panel
		togglePanel : function (id) {
			if (this.panels[id] && this.panels[id].active) {
				this.deactivatePanel(true);
			} else {
				this.deactivatePanel(true);
				this.activatePanel(id);
			}
		},

		// Make a panel active.
		activatePanel : function (id, unique) {
			if (this.panels[id] !== undefined && !this.panels[id].active) {
				var panel = this.panels[id];
				if (panel.content !== undefined) {
					Element.show(panel.content);
				}
				Element.addClass(panel.button, 'active');
				panel.active = true;
				return true;
			}
			return false;
		},

		// Deactivate a panel.  use true to hide all panels.
		deactivatePanel : function (id) {
			if (id === true) {
				for (var i in this.panels) {
					this.deactivatePanel(i);
				}
				return true;
			}
			if (this.panels[id] !== undefined) {
				var panel = this.panels[id];
				if (panel.content !== undefined) {
					Element.hide(panel.content);
				}
				Element.removeClass(panel.button, 'active');
				panel.active = false;
				return true;
			}
			return false;
		},

		// Bind events for all the collapsible arrays.
		makeNeatArray : function (lists) {
			for (var i = 0, element; element = lists[i]; i++) {
				if (Element.hasClass(element, 'neat-array') && element.className.match(/depth-0/)) {
					var childLists = element.getElementsByTagName('UL');
					for (var j = 0, childEl; childEl = childLists[j]; j++) {
						Element.hide(childEl);
						Element.addClass(childEl.parentNode, 'expandable collapsed');
					}
					Event.addEvent(element, 'click', _delegateNeatArray);
				}
			}
		}
	};
}();
DEBUGKIT.loader.register(DEBUGKIT.toolbar);

//Add events + behaviors for toolbar collapser.
DEBUGKIT.toolbarToggle = function () {
	var toolbar = DEBUGKIT.toolbar,
		Cookie = DEBUGKIT.Util.Cookie,
		Event = DEBUGKIT.Util.Event,
		toolbarHidden = false;

	return {
		init : function () {
			var button = document.getElementById('hide-toolbar'),
				self = this;

			Event.addEvent(button, 'click', function (event) {
				event = event || window.event
				event.preventDefault();
				self.toggleToolbar();
			});

			var toolbarState = Cookie.read('toolbarDisplay');
			if (toolbarState != 'block') {
				toolbarHidden = false;
				this.toggleToolbar();
			}
		},

		toggleToolbar : function () {
			var display = toolbarHidden ? 'block' : 'none';
			for (var i in toolbar.panels) {
				var panel = toolbar.panels[i];
				panel.element.style.display = display;
				Cookie.write('toolbarDisplay', display);
			}
			toolbarHidden = !toolbarHidden;
			return false;
		}
	};
}();
DEBUGKIT.loader.register(DEBUGKIT.toolbarToggle);


DEBUGKIT.Util.Event.domready(function () {
	DEBUGKIT.loader.init();
	DEBUGKIT.Util.Event.addEvent(window, 'unload', DEBUGKIT.Util.Event.unload);
});