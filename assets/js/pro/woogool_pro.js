/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 25);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  data: function data() {
    return {
      'stage': {
        step: 'first'
      },
      loopLimit: woogool_multi_product_var.request_amount,
      loopStart: 1
    };
  },

  watch: {
    stage: {
      handler: function handler(stage) {
        window.localStorage.setItem('woogoolStageStep', stage.step);
      },


      deep: true
    }
  },
  created: function created() {
    var step = localStorage.getItem('woogoolStageStep');

    if (step) {
      this.stage.step = step;
    }
  },

  methods: {
    newFeed: function newFeed(args) {
      var self = this,
          pre_define = {
        data: {
          feed_id: false,
          action: 'woogool-new-feed',
          _wpnonce: woogool_var.nonce
        },
        callback: false
      },
          args = jQuery.extend(true, pre_define, args);

      var request = {
        type: 'POST',
        url: woogool_var.ajaxurl,
        data: args.data,
        // data: {
        // 	action: 'woogool-new-feed',
        // 	_wpnonce: woogool_var.nonce,
        // 	header: this.header,
        // 	contentAttrs: this.contentAttrs
        // },
        success: function success(res) {
          if (typeof args.callback === 'function') {
            args.callback.call(self, res);
          }
        }
      };

      this.httpRequest(request);
    },
    changeStage: function changeStage(step) {
      this.stage.step = step;
    },
    setBoolen: function setBoolen(value) {
      if (value.toLowerCase() === 'true') {
        return true;
      }

      if (value.toLowerCase() === 'false') {
        return false;
      }

      return '';
    },
    createXmlFile: function createXmlFile(args) {
      var self = this;
      var request = {
        type: 'POST',
        url: woogool_var.ajaxurl,
        data: args.data,

        success: function success(res) {
          if (typeof args.callback !== 'undefined') {
            args.callback(self, res);
          }
        }
      };

      self.httpRequest(request);
    },
    generateFeedFile: function generateFeedFile(args) {
      var self = this;

      this.createXmlFile({
        data: {
          feed_id: args.data.feed_id,
          feed_title: args.data.feed_title,
          action: 'woogool-create-xml-file',
          _wpnonce: woogool_var.nonce
        },

        callback: function callback($this, res) {

          if (res.success === false) {
            return;
          }
          self.feedLoop(args);
        }
      });
    },
    feedLoop: function feedLoop(args) {
      var self = this;

      var pre_define = {
        data: {
          feed_id: false,
          action: 'woogool-generate-feed-file',
          offset: 0,
          _wpnonce: woogool_var.nonce
        },
        callback: false
      };

      args = jQuery.extend(true, pre_define, args);

      var request = {
        type: 'POST',
        url: woogool_var.ajaxurl,
        data: args.data,

        success: function success(res) {

          if (res.data.has_product) {
            args.data.offset = res.data.offset;
            self.feedLoop(args);
          }
          // if( typeof args.callback === 'function' ) {
          //     args.callback( self,  res );
          // }

          // if( 
          // 	request.data.page >= self.loopLimit
          // 	&&
          // 	res.data.fetch_all_product !== true 
          // ) {
          // 	self.loopStart = parseInt(self.loopLimit) + 1;
          // 	self.loopLimit = parseInt(self.loopLimit) + parseInt(woogool_multi_product_var.request_amount);

          // 	self.feedLoop(args);
          // }
        }
      };
      self.httpRequest(request);

      // for (var i = self.loopStart; i <= self.loopLimit; i++) {
      // 	request.data.page = i;
      // 	self.httpRequest(request);
      // }
    }
  }
};

/***/ }),
/* 2 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 3 */
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),
/* 4 */
/***/ (function(module, exports) {

var core = module.exports = { version: '2.5.7' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),
/* 5 */
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__webpack_require__(7)(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 7 */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(74)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_header_vue__ = __webpack_require__(10);
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["a"] = ({
	components: {
		'feed-header': __WEBPACK_IMPORTED_MODULE_0__components_header_vue__["a" /* default */]
	}
});

/***/ }),
/* 10 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_header_vue__ = __webpack_require__(11);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1afba5bd_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_header_vue__ = __webpack_require__(35);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_header_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1afba5bd_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_header_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1afba5bd", Component.options)
  } else {
    hotAPI.reload("data-v-1afba5bd", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 11 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
	methods: {
		getNavTabClass: function getNavTabClass(name) {
			var routeName = this.$route.name;

			if (routeName == name) {
				return 'nav-tab-active';
			}

			return '';
		}
	}
});

/***/ }),
/* 12 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_header_vue__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_new_feed_form_header_vue__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_new_feed_form_content_vue__ = __webpack_require__(41);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_new_feed_form_logic_vue__ = __webpack_require__(71);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_new_feed_mixin__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_new_feed_mixin___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__components_new_feed_mixin__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//







/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [__WEBPACK_IMPORTED_MODULE_4__components_new_feed_mixin___default.a],
	data: function data() {
		return {
			feed_id: false,
			header: {
				feedByCatgory: false,
				name: '',
				activeVariation: false,
				feedCategories: [],
				refresh: 1,
				googleCategories: [],
				categories: []
			},
			contentAttrs: [],
			logic: []
		};
	},

	components: {
		'feed-header': __WEBPACK_IMPORTED_MODULE_0__components_header_vue__["a" /* default */],
		'form-header': __WEBPACK_IMPORTED_MODULE_1__components_new_feed_form_header_vue__["a" /* default */],
		'form-content': __WEBPACK_IMPORTED_MODULE_2__components_new_feed_form_content_vue__["a" /* default */],
		'form-logic': __WEBPACK_IMPORTED_MODULE_3__components_new_feed_form_logic_vue__["a" /* default */]
	},

	created: function created() {
		this.getFeed(80);
		this.feed_id = 80;
	},

	methods: {
		submit: function submit() {
			var self = this;
			var args = {
				data: {
					feed_id: self.feed_id,
					header: self.header,
					contentAttrs: self.contentAttrs,
					logic: self.logic
				},
				callback: function callback(res) {
					self.feed_id = res.data.feed_id;
				}
			};

			self.newFeed(args);
		},
		getFeed: function getFeed(postId) {
			var self = this;
			var request = {
				type: 'POST',
				url: woogool_var.ajaxurl,
				data: {
					post_id: postId,
					action: 'woogool-get-feed',
					_wpnonce: woogool_var.nonce
				},
				success: function success(res) {
					self.setHeader(res.data);
					self.setContentAttrs(res.data);
					self.setLogic(res.data);
				}
			};

			this.httpRequest(request);
		},
		setHeader: function setHeader(feed) {
			this.header = feed.header;
			this.header.activeVariation = this.setBoolen(feed.header.activeVariation);
			this.header.feedByCatgory = this.setBoolen(feed.header.feedByCatgory);
		},
		setContentAttrs: function setContentAttrs(feed) {
			this.contentAttrs = feed.contentAttrs;
		},
		setLogic: function setLogic(feed) {
			this.logic = feed.logic;
		},
		createFeedFile: function createFeedFile(feedID, offset) {
			var self = this;
			offset = offset || 0;

			var args = {
				data: {
					feed_id: feedID,
					feed_title: self.header.name,
					offset: offset
				},
				callback: function callback($this, res) {}
			};

			this.generateFeedFile(args);
		}
	}

});

/***/ }),
/* 13 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [__WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin___default.a],
	props: {
		stage: {
			type: [Object],
			default: function _default() {
				return {};
			}
		},
		header: {
			type: [Object],
			default: function _default() {
				return {};
			}
		}
	},

	data: function data() {
		return {
			categories: [],
			googleCategories: []
		};
	},
	created: function created() {
		var self = this;

		this.googleCategories = woogool_multi_product_var.google_categories;

		jQuery.each(woogool_multi_product_var.product_categories, function (index, cat) {
			self.categories.push({
				'catId': index,
				'catName': cat
			});
		});
	},


	methods: {
		submit: function submit() {
			var args = {
				header: this.header,
				contentAttrs: this.contentAttrs,

				callback: function callback(res) {}
			};

			this.newFeed(args);
		},
		setGoogleCat: function setGoogleCat(cat, googleCat) {
			cat['googleCat'] = googleCat;
		}
	}
});

/***/ }),
/* 14 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_new_feed_mixin__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_new_feed_mixin___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_new_feed_mixin__);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [__WEBPACK_IMPORTED_MODULE_1__components_new_feed_mixin___default.a],
	props: {
		stage: {
			type: [Object],
			default: function _default() {
				return {};
			}
		},
		gAttrs: {
			type: [Array],
			default: function _default() {
				return [];
			}
		}
	},
	data: function data() {
		return {
			googleAttributes: woogool_multi_product_var.google_shopping_attributes,
			woogoolAttributes: woogool_multi_product_var.woogool_product_attributes,
			googleExtraAttrFields: woogool_multi_product_var.google_extra_attr_fields
		};
	},
	created: function created() {
		this.setDefaultAttr();
	},


	methods: {
		setCustomText: function setCustomText(gAttrTr, gkey, elet) {
			woogool.Vue.set(gAttrTr, 'name', elet.target.value);
		},
		setGooAttrReqVal: function setGooAttrReqVal(gooAttr, key, type, evt) {
			var self = this;
			var value = evt.target.value;

			jQuery.each(this.googleAttributes, function (index, googleAttribute) {
				jQuery.each(googleAttribute.attributes, function (position, attr) {

					if (attr.name == value) {
						var newAttr = __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_assign___default()({}, attr, {
							'woogool_suggest': gooAttr.woogool_suggest,
							'type': type,
							'format': 'required'
						});

						self.gAttrs.splice(key, 1, newAttr);
					}
				});
			});
		},
		setProAttrReqVal: function setProAttrReqVal(gooAttr, key, evt) {
			var self = this;
			var value = evt.target.value;
			woogool.Vue.set(gooAttr, 'woogool_suggest', value);
		},
		setDefaultAttr: function setDefaultAttr() {
			var self = this;

			jQuery.each(this.googleAttributes, function (index, googleAttribute) {
				jQuery.each(googleAttribute.attributes, function (key, attr) {
					if (attr.format == 'required') {
						if (typeof attr.type == 'undefined') {
							woogool.Vue.set(attr, 'type', 'default');
						}
						self.gAttrs.push(attr);
					}
				});
			});
		},
		isGoogleAttrSelected: function isGoogleAttrSelected(gAttributeTr, googleAttrTd) {
			return gAttributeTr.name == googleAttrTd.name ? 'selected' : false;
		},
		isProductAttrSelected: function isProductAttrSelected(gAttributeTr, wpKey) {
			return gAttributeTr.woogool_suggest == wpKey ? 'selected' : false;
		},
		removeAttr: function removeAttr(gAttributeTr, key) {
			if (!confirm('Are you sure')) {
				return;
			}

			this.gAttrs.splice(key, 1);
		},
		addMappingField: function addMappingField() {
			this.gAttrs.push({
				'type': 'mapping',
				'format': 'required'
			});
		},
		addCustomField: function addCustomField() {
			this.gAttrs.push({
				'type': 'custom',
				'format': 'required'
			});
		}
	}
});

/***/ }),
/* 15 */
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

// to indexed object, toObject with fallback for non-array-like ES3 strings
var IObject = __webpack_require__(17);
var defined = __webpack_require__(18);
module.exports = function (it) {
  return IObject(defined(it));
};


/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

// fallback for non-array-like ES3 and non-enumerable old V8 strings
var cof = __webpack_require__(58);
// eslint-disable-next-line no-prototype-builtins
module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
  return cof(it) == 'String' ? it.split('') : Object(it);
};


/***/ }),
/* 18 */
/***/ (function(module, exports) {

// 7.2.1 RequireObjectCoercible(argument)
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on  " + it);
  return it;
};


/***/ }),
/* 19 */
/***/ (function(module, exports) {

// 7.1.4 ToInteger
var ceil = Math.ceil;
var floor = Math.floor;
module.exports = function (it) {
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};


/***/ }),
/* 20 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [__WEBPACK_IMPORTED_MODULE_0__components_new_feed_mixin___default.a],

	props: {
		stage: {
			type: [Object],
			default: function _default() {
				return {};
			}
		},
		logic: {
			type: [Array],
			default: function _default() {
				return [];
			}
		}
	},

	data: function data() {
		return {
			proAttrs: woogool_multi_product_var.woogool_product_attribute_with_optgroups,
			filterCondDrops: [{
				id: 'contains',
				label: 'Contains',
				sign: 'contain'
			}, {
				id: 'does_not_contain',
				label: 'does not contain',
				sign: 'not_contain'
			}, {
				id: 'is_equal_to',
				label: 'is equal to',
				sign: '='
			}, {
				id: 'is_not_equal_to',
				label: 'is not equal to',
				sign: '!='
			}, {
				id: 'is_greater_than',
				label: 'is greater than',
				sign: '>'
			}, {
				id: 'is_greater_or_equal_to',
				label: 'is greater or equal to',
				sign: '>='
			}, {
				id: 'is_less_than',
				label: 'is less than',
				sign: '<'
			}, {
				id: 'is_less_or_equal_to',
				label: 'is less or equal to',
				sign: '<='
			}, {
				id: 'is_empty',
				label: 'is empty',
				sign: ''
			}],

			ruleCondDrops: [{
				id: 'contains',
				label: 'Contains',
				sign: 'contain'
			}, {
				id: 'does_not_contain',
				label: 'does not contain',
				sign: 'not_contain'
			}, {
				id: 'is_equal_to',
				label: 'is equal to',
				sign: '='
			}, {
				id: 'is_not_equal_to',
				label: 'is not equal to',
				sign: '!='
			}, {
				id: 'is_greater_than',
				label: 'is greater than',
				sign: '>'
			}, {
				id: 'is_greater_or_equal_to',
				label: 'is greater or equal to',
				sign: '>='
			}, {
				id: 'is_less_than',
				label: 'is less than',
				sign: '<'
			}, {
				id: 'is_less_or_equal_to',
				label: 'is less or equal to',
				sign: '<='
			}, {
				id: 'is_empty',
				label: 'is empty',
				sign: ''
			}, {
				id: 'multiply',
				label: 'multiply',
				sign: '*'
			}, {
				id: 'divide',
				label: 'divide',
				sign: '/'
			}, {
				id: 'plus',
				label: 'plus',
				sign: '+'
			}, {
				id: 'minus',
				label: 'minus',
				sign: '-'
			}, {
				id: 'replace',
				label: 'replace',
				sign: 'replace'
			}]
		};
	},


	methods: {
		addFields: function addFields(type) {
			var filter = {
				type: type,
				if_cond: 'id',
				condition: 'condition',
				value: '',
				then: 'exclude',
				is: ''
			};

			this.logic.push(filter);
		},
		removeAttr: function removeAttr(key) {
			if (!confirm('Are you sure')) {
				return;
			}

			this.logic.splice(key, 1);
		},
		setData: function setData(dataObje, key, evt) {
			dataObje[key] = evt.target.value;
		},
		isProductAttrSelected: function isProductAttrSelected(gAttributeTr, wpKey) {
			return gAttributeTr.woogool_suggest == wpKey ? 'selected' : false;
		}
	}
});

/***/ }),
/* 21 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
	created: function created() {
		if ('/' === this.$route.path) {
			this.$router.push({
				name: 'new_feed'
			});
		}
	},


	watch: {
		'$route': function $route() {
			if ('/' === this.$route.path) {
				this.$router.push({
					name: 'new_feed'
				});
			}
		}
	}
});

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = {
    methods: {
        httpRequest: function httpRequest(property) {

            return jQuery.ajax(property);
        },


        /**
               * Get index from array object element
               *
               * @param   itemList
               * @param   id
               *
               * @return  int
               */
        getIndex: function getIndex(itemList, id, slug) {
            var index = false;

            jQuery.each(itemList, function (key, item) {

                if (item[slug] == id) {
                    index = key;
                }
            });

            return index;
        },
        ucfirst: function ucfirst(word) {
            return word.replace(/\w/, function (c) {
                return c.toUpperCase();
            });
        }
    }
};

/***/ }),
/* 23 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_common_do_action_vue__ = __webpack_require__(86);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["a"] = ({
    components: {
        'do-action': __WEBPACK_IMPORTED_MODULE_0__components_common_do_action_vue__["a" /* default */]
    },

    created: function created() {
        this.registerModule();
    },


    // watch: {
    //     $route(to, from) {
    //         this.$store.commit('recordHistory', {
    //             to, from
    //         });
    //     }
    // },

    methods: {
        registerModule: function registerModule() {
            var self = this;

            wpspearWooGoolProModules.forEach(function (module) {
                var store = !(function webpackMissingModule() { var e = new Error("Cannot find module \"./components\""); e.code = 'MODULE_NOT_FOUND'; throw e; }());
                self.registerStore(module.name, store.default);
            });
        }
    },

    data: function data() {
        return {
            is_pro: woogool_var.is_pro
        };
    }
});

/***/ }),
/* 24 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_mixin_mixin__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_mixin_mixin___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__helpers_mixin_mixin__);




function woogoolGetComponents() {
    var components = {};

    wpspear_WooGool_Components.map(function (obj, key) {
        if (obj.property.mixins) {
            obj.property.mixins.push(__WEBPACK_IMPORTED_MODULE_0__helpers_mixin_mixin___default.a);
        } else {
            obj.property.mixins = [__WEBPACK_IMPORTED_MODULE_0__helpers_mixin_mixin___default.a];
        }

        components[obj.component] = obj.property;
    });

    return components;
}

var action = {
    props: {
        hook: {
            type: String,
            required: true
        },

        actionData: {
            type: [Object, Array, String, Number],

            default: function _default() {
                return {};
            }
        }
    },

    components: woogoolGetComponents(),

    render: function render(h) {
        this.$options.components = woogoolGetComponents();

        var components = [],
            self = this;

        wpspear_WooGool_Components.map(function (obj, key) {
            if (obj.hook == self.hook) {
                components.push(Vue.compile('<' + obj.component + ' :actionData="actionData"></' + obj.component + '>').render.call(self));
            }
        });

        return h('span', { class: 'woogool-action-wrap' }, components);
    }
};

/* harmony default export */ __webpack_exports__["a"] = (action);

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__.p = woogool_var.dir_url + 'assets/js/';

//For IE6 
__webpack_require__(26);

__webpack_require__(30);

/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// This file can be required in Browserify and Node.js for automatic polyfill
// To use it:  require('es6-promise/auto');

module.exports = __webpack_require__(27).polyfill();


/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(process, global) {/*!
 * @overview es6-promise - a tiny implementation of Promises/A+.
 * @copyright Copyright (c) 2014 Yehuda Katz, Tom Dale, Stefan Penner and contributors (Conversion to ES6 API by Jake Archibald)
 * @license   Licensed under MIT license
 *            See https://raw.githubusercontent.com/stefanpenner/es6-promise/master/LICENSE
 * @version   v4.2.4+314e4831
 */

(function (global, factory) {
	 true ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.ES6Promise = factory());
}(this, (function () { 'use strict';

function objectOrFunction(x) {
  var type = typeof x;
  return x !== null && (type === 'object' || type === 'function');
}

function isFunction(x) {
  return typeof x === 'function';
}



var _isArray = void 0;
if (Array.isArray) {
  _isArray = Array.isArray;
} else {
  _isArray = function (x) {
    return Object.prototype.toString.call(x) === '[object Array]';
  };
}

var isArray = _isArray;

var len = 0;
var vertxNext = void 0;
var customSchedulerFn = void 0;

var asap = function asap(callback, arg) {
  queue[len] = callback;
  queue[len + 1] = arg;
  len += 2;
  if (len === 2) {
    // If len is 2, that means that we need to schedule an async flush.
    // If additional callbacks are queued before the queue is flushed, they
    // will be processed by this flush that we are scheduling.
    if (customSchedulerFn) {
      customSchedulerFn(flush);
    } else {
      scheduleFlush();
    }
  }
};

function setScheduler(scheduleFn) {
  customSchedulerFn = scheduleFn;
}

function setAsap(asapFn) {
  asap = asapFn;
}

var browserWindow = typeof window !== 'undefined' ? window : undefined;
var browserGlobal = browserWindow || {};
var BrowserMutationObserver = browserGlobal.MutationObserver || browserGlobal.WebKitMutationObserver;
var isNode = typeof self === 'undefined' && typeof process !== 'undefined' && {}.toString.call(process) === '[object process]';

// test for web worker but not in IE10
var isWorker = typeof Uint8ClampedArray !== 'undefined' && typeof importScripts !== 'undefined' && typeof MessageChannel !== 'undefined';

// node
function useNextTick() {
  // node version 0.10.x displays a deprecation warning when nextTick is used recursively
  // see https://github.com/cujojs/when/issues/410 for details
  return function () {
    return process.nextTick(flush);
  };
}

// vertx
function useVertxTimer() {
  if (typeof vertxNext !== 'undefined') {
    return function () {
      vertxNext(flush);
    };
  }

  return useSetTimeout();
}

function useMutationObserver() {
  var iterations = 0;
  var observer = new BrowserMutationObserver(flush);
  var node = document.createTextNode('');
  observer.observe(node, { characterData: true });

  return function () {
    node.data = iterations = ++iterations % 2;
  };
}

// web worker
function useMessageChannel() {
  var channel = new MessageChannel();
  channel.port1.onmessage = flush;
  return function () {
    return channel.port2.postMessage(0);
  };
}

function useSetTimeout() {
  // Store setTimeout reference so es6-promise will be unaffected by
  // other code modifying setTimeout (like sinon.useFakeTimers())
  var globalSetTimeout = setTimeout;
  return function () {
    return globalSetTimeout(flush, 1);
  };
}

var queue = new Array(1000);
function flush() {
  for (var i = 0; i < len; i += 2) {
    var callback = queue[i];
    var arg = queue[i + 1];

    callback(arg);

    queue[i] = undefined;
    queue[i + 1] = undefined;
  }

  len = 0;
}

function attemptVertx() {
  try {
    var vertx = Function('return this')().require('vertx');
    vertxNext = vertx.runOnLoop || vertx.runOnContext;
    return useVertxTimer();
  } catch (e) {
    return useSetTimeout();
  }
}

var scheduleFlush = void 0;
// Decide what async method to use to triggering processing of queued callbacks:
if (isNode) {
  scheduleFlush = useNextTick();
} else if (BrowserMutationObserver) {
  scheduleFlush = useMutationObserver();
} else if (isWorker) {
  scheduleFlush = useMessageChannel();
} else if (browserWindow === undefined && "function" === 'function') {
  scheduleFlush = attemptVertx();
} else {
  scheduleFlush = useSetTimeout();
}

function then(onFulfillment, onRejection) {
  var parent = this;

  var child = new this.constructor(noop);

  if (child[PROMISE_ID] === undefined) {
    makePromise(child);
  }

  var _state = parent._state;


  if (_state) {
    var callback = arguments[_state - 1];
    asap(function () {
      return invokeCallback(_state, child, callback, parent._result);
    });
  } else {
    subscribe(parent, child, onFulfillment, onRejection);
  }

  return child;
}

/**
  `Promise.resolve` returns a promise that will become resolved with the
  passed `value`. It is shorthand for the following:

  ```javascript
  let promise = new Promise(function(resolve, reject){
    resolve(1);
  });

  promise.then(function(value){
    // value === 1
  });
  ```

  Instead of writing the above, your code now simply becomes the following:

  ```javascript
  let promise = Promise.resolve(1);

  promise.then(function(value){
    // value === 1
  });
  ```

  @method resolve
  @static
  @param {Any} value value that the returned promise will be resolved with
  Useful for tooling.
  @return {Promise} a promise that will become fulfilled with the given
  `value`
*/
function resolve$1(object) {
  /*jshint validthis:true */
  var Constructor = this;

  if (object && typeof object === 'object' && object.constructor === Constructor) {
    return object;
  }

  var promise = new Constructor(noop);
  resolve(promise, object);
  return promise;
}

var PROMISE_ID = Math.random().toString(36).substring(2);

function noop() {}

var PENDING = void 0;
var FULFILLED = 1;
var REJECTED = 2;

var TRY_CATCH_ERROR = { error: null };

function selfFulfillment() {
  return new TypeError("You cannot resolve a promise with itself");
}

function cannotReturnOwn() {
  return new TypeError('A promises callback cannot return that same promise.');
}

function getThen(promise) {
  try {
    return promise.then;
  } catch (error) {
    TRY_CATCH_ERROR.error = error;
    return TRY_CATCH_ERROR;
  }
}

function tryThen(then$$1, value, fulfillmentHandler, rejectionHandler) {
  try {
    then$$1.call(value, fulfillmentHandler, rejectionHandler);
  } catch (e) {
    return e;
  }
}

function handleForeignThenable(promise, thenable, then$$1) {
  asap(function (promise) {
    var sealed = false;
    var error = tryThen(then$$1, thenable, function (value) {
      if (sealed) {
        return;
      }
      sealed = true;
      if (thenable !== value) {
        resolve(promise, value);
      } else {
        fulfill(promise, value);
      }
    }, function (reason) {
      if (sealed) {
        return;
      }
      sealed = true;

      reject(promise, reason);
    }, 'Settle: ' + (promise._label || ' unknown promise'));

    if (!sealed && error) {
      sealed = true;
      reject(promise, error);
    }
  }, promise);
}

function handleOwnThenable(promise, thenable) {
  if (thenable._state === FULFILLED) {
    fulfill(promise, thenable._result);
  } else if (thenable._state === REJECTED) {
    reject(promise, thenable._result);
  } else {
    subscribe(thenable, undefined, function (value) {
      return resolve(promise, value);
    }, function (reason) {
      return reject(promise, reason);
    });
  }
}

function handleMaybeThenable(promise, maybeThenable, then$$1) {
  if (maybeThenable.constructor === promise.constructor && then$$1 === then && maybeThenable.constructor.resolve === resolve$1) {
    handleOwnThenable(promise, maybeThenable);
  } else {
    if (then$$1 === TRY_CATCH_ERROR) {
      reject(promise, TRY_CATCH_ERROR.error);
      TRY_CATCH_ERROR.error = null;
    } else if (then$$1 === undefined) {
      fulfill(promise, maybeThenable);
    } else if (isFunction(then$$1)) {
      handleForeignThenable(promise, maybeThenable, then$$1);
    } else {
      fulfill(promise, maybeThenable);
    }
  }
}

function resolve(promise, value) {
  if (promise === value) {
    reject(promise, selfFulfillment());
  } else if (objectOrFunction(value)) {
    handleMaybeThenable(promise, value, getThen(value));
  } else {
    fulfill(promise, value);
  }
}

function publishRejection(promise) {
  if (promise._onerror) {
    promise._onerror(promise._result);
  }

  publish(promise);
}

function fulfill(promise, value) {
  if (promise._state !== PENDING) {
    return;
  }

  promise._result = value;
  promise._state = FULFILLED;

  if (promise._subscribers.length !== 0) {
    asap(publish, promise);
  }
}

function reject(promise, reason) {
  if (promise._state !== PENDING) {
    return;
  }
  promise._state = REJECTED;
  promise._result = reason;

  asap(publishRejection, promise);
}

function subscribe(parent, child, onFulfillment, onRejection) {
  var _subscribers = parent._subscribers;
  var length = _subscribers.length;


  parent._onerror = null;

  _subscribers[length] = child;
  _subscribers[length + FULFILLED] = onFulfillment;
  _subscribers[length + REJECTED] = onRejection;

  if (length === 0 && parent._state) {
    asap(publish, parent);
  }
}

function publish(promise) {
  var subscribers = promise._subscribers;
  var settled = promise._state;

  if (subscribers.length === 0) {
    return;
  }

  var child = void 0,
      callback = void 0,
      detail = promise._result;

  for (var i = 0; i < subscribers.length; i += 3) {
    child = subscribers[i];
    callback = subscribers[i + settled];

    if (child) {
      invokeCallback(settled, child, callback, detail);
    } else {
      callback(detail);
    }
  }

  promise._subscribers.length = 0;
}

function tryCatch(callback, detail) {
  try {
    return callback(detail);
  } catch (e) {
    TRY_CATCH_ERROR.error = e;
    return TRY_CATCH_ERROR;
  }
}

function invokeCallback(settled, promise, callback, detail) {
  var hasCallback = isFunction(callback),
      value = void 0,
      error = void 0,
      succeeded = void 0,
      failed = void 0;

  if (hasCallback) {
    value = tryCatch(callback, detail);

    if (value === TRY_CATCH_ERROR) {
      failed = true;
      error = value.error;
      value.error = null;
    } else {
      succeeded = true;
    }

    if (promise === value) {
      reject(promise, cannotReturnOwn());
      return;
    }
  } else {
    value = detail;
    succeeded = true;
  }

  if (promise._state !== PENDING) {
    // noop
  } else if (hasCallback && succeeded) {
    resolve(promise, value);
  } else if (failed) {
    reject(promise, error);
  } else if (settled === FULFILLED) {
    fulfill(promise, value);
  } else if (settled === REJECTED) {
    reject(promise, value);
  }
}

function initializePromise(promise, resolver) {
  try {
    resolver(function resolvePromise(value) {
      resolve(promise, value);
    }, function rejectPromise(reason) {
      reject(promise, reason);
    });
  } catch (e) {
    reject(promise, e);
  }
}

var id = 0;
function nextId() {
  return id++;
}

function makePromise(promise) {
  promise[PROMISE_ID] = id++;
  promise._state = undefined;
  promise._result = undefined;
  promise._subscribers = [];
}

function validationError() {
  return new Error('Array Methods must be provided an Array');
}

var Enumerator = function () {
  function Enumerator(Constructor, input) {
    this._instanceConstructor = Constructor;
    this.promise = new Constructor(noop);

    if (!this.promise[PROMISE_ID]) {
      makePromise(this.promise);
    }

    if (isArray(input)) {
      this.length = input.length;
      this._remaining = input.length;

      this._result = new Array(this.length);

      if (this.length === 0) {
        fulfill(this.promise, this._result);
      } else {
        this.length = this.length || 0;
        this._enumerate(input);
        if (this._remaining === 0) {
          fulfill(this.promise, this._result);
        }
      }
    } else {
      reject(this.promise, validationError());
    }
  }

  Enumerator.prototype._enumerate = function _enumerate(input) {
    for (var i = 0; this._state === PENDING && i < input.length; i++) {
      this._eachEntry(input[i], i);
    }
  };

  Enumerator.prototype._eachEntry = function _eachEntry(entry, i) {
    var c = this._instanceConstructor;
    var resolve$$1 = c.resolve;


    if (resolve$$1 === resolve$1) {
      var _then = getThen(entry);

      if (_then === then && entry._state !== PENDING) {
        this._settledAt(entry._state, i, entry._result);
      } else if (typeof _then !== 'function') {
        this._remaining--;
        this._result[i] = entry;
      } else if (c === Promise$1) {
        var promise = new c(noop);
        handleMaybeThenable(promise, entry, _then);
        this._willSettleAt(promise, i);
      } else {
        this._willSettleAt(new c(function (resolve$$1) {
          return resolve$$1(entry);
        }), i);
      }
    } else {
      this._willSettleAt(resolve$$1(entry), i);
    }
  };

  Enumerator.prototype._settledAt = function _settledAt(state, i, value) {
    var promise = this.promise;


    if (promise._state === PENDING) {
      this._remaining--;

      if (state === REJECTED) {
        reject(promise, value);
      } else {
        this._result[i] = value;
      }
    }

    if (this._remaining === 0) {
      fulfill(promise, this._result);
    }
  };

  Enumerator.prototype._willSettleAt = function _willSettleAt(promise, i) {
    var enumerator = this;

    subscribe(promise, undefined, function (value) {
      return enumerator._settledAt(FULFILLED, i, value);
    }, function (reason) {
      return enumerator._settledAt(REJECTED, i, reason);
    });
  };

  return Enumerator;
}();

/**
  `Promise.all` accepts an array of promises, and returns a new promise which
  is fulfilled with an array of fulfillment values for the passed promises, or
  rejected with the reason of the first passed promise to be rejected. It casts all
  elements of the passed iterable to promises as it runs this algorithm.

  Example:

  ```javascript
  let promise1 = resolve(1);
  let promise2 = resolve(2);
  let promise3 = resolve(3);
  let promises = [ promise1, promise2, promise3 ];

  Promise.all(promises).then(function(array){
    // The array here would be [ 1, 2, 3 ];
  });
  ```

  If any of the `promises` given to `all` are rejected, the first promise
  that is rejected will be given as an argument to the returned promises's
  rejection handler. For example:

  Example:

  ```javascript
  let promise1 = resolve(1);
  let promise2 = reject(new Error("2"));
  let promise3 = reject(new Error("3"));
  let promises = [ promise1, promise2, promise3 ];

  Promise.all(promises).then(function(array){
    // Code here never runs because there are rejected promises!
  }, function(error) {
    // error.message === "2"
  });
  ```

  @method all
  @static
  @param {Array} entries array of promises
  @param {String} label optional string for labeling the promise.
  Useful for tooling.
  @return {Promise} promise that is fulfilled when all `promises` have been
  fulfilled, or rejected if any of them become rejected.
  @static
*/
function all(entries) {
  return new Enumerator(this, entries).promise;
}

/**
  `Promise.race` returns a new promise which is settled in the same way as the
  first passed promise to settle.

  Example:

  ```javascript
  let promise1 = new Promise(function(resolve, reject){
    setTimeout(function(){
      resolve('promise 1');
    }, 200);
  });

  let promise2 = new Promise(function(resolve, reject){
    setTimeout(function(){
      resolve('promise 2');
    }, 100);
  });

  Promise.race([promise1, promise2]).then(function(result){
    // result === 'promise 2' because it was resolved before promise1
    // was resolved.
  });
  ```

  `Promise.race` is deterministic in that only the state of the first
  settled promise matters. For example, even if other promises given to the
  `promises` array argument are resolved, but the first settled promise has
  become rejected before the other promises became fulfilled, the returned
  promise will become rejected:

  ```javascript
  let promise1 = new Promise(function(resolve, reject){
    setTimeout(function(){
      resolve('promise 1');
    }, 200);
  });

  let promise2 = new Promise(function(resolve, reject){
    setTimeout(function(){
      reject(new Error('promise 2'));
    }, 100);
  });

  Promise.race([promise1, promise2]).then(function(result){
    // Code here never runs
  }, function(reason){
    // reason.message === 'promise 2' because promise 2 became rejected before
    // promise 1 became fulfilled
  });
  ```

  An example real-world use case is implementing timeouts:

  ```javascript
  Promise.race([ajax('foo.json'), timeout(5000)])
  ```

  @method race
  @static
  @param {Array} promises array of promises to observe
  Useful for tooling.
  @return {Promise} a promise which settles in the same way as the first passed
  promise to settle.
*/
function race(entries) {
  /*jshint validthis:true */
  var Constructor = this;

  if (!isArray(entries)) {
    return new Constructor(function (_, reject) {
      return reject(new TypeError('You must pass an array to race.'));
    });
  } else {
    return new Constructor(function (resolve, reject) {
      var length = entries.length;
      for (var i = 0; i < length; i++) {
        Constructor.resolve(entries[i]).then(resolve, reject);
      }
    });
  }
}

/**
  `Promise.reject` returns a promise rejected with the passed `reason`.
  It is shorthand for the following:

  ```javascript
  let promise = new Promise(function(resolve, reject){
    reject(new Error('WHOOPS'));
  });

  promise.then(function(value){
    // Code here doesn't run because the promise is rejected!
  }, function(reason){
    // reason.message === 'WHOOPS'
  });
  ```

  Instead of writing the above, your code now simply becomes the following:

  ```javascript
  let promise = Promise.reject(new Error('WHOOPS'));

  promise.then(function(value){
    // Code here doesn't run because the promise is rejected!
  }, function(reason){
    // reason.message === 'WHOOPS'
  });
  ```

  @method reject
  @static
  @param {Any} reason value that the returned promise will be rejected with.
  Useful for tooling.
  @return {Promise} a promise rejected with the given `reason`.
*/
function reject$1(reason) {
  /*jshint validthis:true */
  var Constructor = this;
  var promise = new Constructor(noop);
  reject(promise, reason);
  return promise;
}

function needsResolver() {
  throw new TypeError('You must pass a resolver function as the first argument to the promise constructor');
}

function needsNew() {
  throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
}

/**
  Promise objects represent the eventual result of an asynchronous operation. The
  primary way of interacting with a promise is through its `then` method, which
  registers callbacks to receive either a promise's eventual value or the reason
  why the promise cannot be fulfilled.

  Terminology
  -----------

  - `promise` is an object or function with a `then` method whose behavior conforms to this specification.
  - `thenable` is an object or function that defines a `then` method.
  - `value` is any legal JavaScript value (including undefined, a thenable, or a promise).
  - `exception` is a value that is thrown using the throw statement.
  - `reason` is a value that indicates why a promise was rejected.
  - `settled` the final resting state of a promise, fulfilled or rejected.

  A promise can be in one of three states: pending, fulfilled, or rejected.

  Promises that are fulfilled have a fulfillment value and are in the fulfilled
  state.  Promises that are rejected have a rejection reason and are in the
  rejected state.  A fulfillment value is never a thenable.

  Promises can also be said to *resolve* a value.  If this value is also a
  promise, then the original promise's settled state will match the value's
  settled state.  So a promise that *resolves* a promise that rejects will
  itself reject, and a promise that *resolves* a promise that fulfills will
  itself fulfill.


  Basic Usage:
  ------------

  ```js
  let promise = new Promise(function(resolve, reject) {
    // on success
    resolve(value);

    // on failure
    reject(reason);
  });

  promise.then(function(value) {
    // on fulfillment
  }, function(reason) {
    // on rejection
  });
  ```

  Advanced Usage:
  ---------------

  Promises shine when abstracting away asynchronous interactions such as
  `XMLHttpRequest`s.

  ```js
  function getJSON(url) {
    return new Promise(function(resolve, reject){
      let xhr = new XMLHttpRequest();

      xhr.open('GET', url);
      xhr.onreadystatechange = handler;
      xhr.responseType = 'json';
      xhr.setRequestHeader('Accept', 'application/json');
      xhr.send();

      function handler() {
        if (this.readyState === this.DONE) {
          if (this.status === 200) {
            resolve(this.response);
          } else {
            reject(new Error('getJSON: `' + url + '` failed with status: [' + this.status + ']'));
          }
        }
      };
    });
  }

  getJSON('/posts.json').then(function(json) {
    // on fulfillment
  }, function(reason) {
    // on rejection
  });
  ```

  Unlike callbacks, promises are great composable primitives.

  ```js
  Promise.all([
    getJSON('/posts'),
    getJSON('/comments')
  ]).then(function(values){
    values[0] // => postsJSON
    values[1] // => commentsJSON

    return values;
  });
  ```

  @class Promise
  @param {Function} resolver
  Useful for tooling.
  @constructor
*/

var Promise$1 = function () {
  function Promise(resolver) {
    this[PROMISE_ID] = nextId();
    this._result = this._state = undefined;
    this._subscribers = [];

    if (noop !== resolver) {
      typeof resolver !== 'function' && needsResolver();
      this instanceof Promise ? initializePromise(this, resolver) : needsNew();
    }
  }

  /**
  The primary way of interacting with a promise is through its `then` method,
  which registers callbacks to receive either a promise's eventual value or the
  reason why the promise cannot be fulfilled.
   ```js
  findUser().then(function(user){
    // user is available
  }, function(reason){
    // user is unavailable, and you are given the reason why
  });
  ```
   Chaining
  --------
   The return value of `then` is itself a promise.  This second, 'downstream'
  promise is resolved with the return value of the first promise's fulfillment
  or rejection handler, or rejected if the handler throws an exception.
   ```js
  findUser().then(function (user) {
    return user.name;
  }, function (reason) {
    return 'default name';
  }).then(function (userName) {
    // If `findUser` fulfilled, `userName` will be the user's name, otherwise it
    // will be `'default name'`
  });
   findUser().then(function (user) {
    throw new Error('Found user, but still unhappy');
  }, function (reason) {
    throw new Error('`findUser` rejected and we're unhappy');
  }).then(function (value) {
    // never reached
  }, function (reason) {
    // if `findUser` fulfilled, `reason` will be 'Found user, but still unhappy'.
    // If `findUser` rejected, `reason` will be '`findUser` rejected and we're unhappy'.
  });
  ```
  If the downstream promise does not specify a rejection handler, rejection reasons will be propagated further downstream.
   ```js
  findUser().then(function (user) {
    throw new PedagogicalException('Upstream error');
  }).then(function (value) {
    // never reached
  }).then(function (value) {
    // never reached
  }, function (reason) {
    // The `PedgagocialException` is propagated all the way down to here
  });
  ```
   Assimilation
  ------------
   Sometimes the value you want to propagate to a downstream promise can only be
  retrieved asynchronously. This can be achieved by returning a promise in the
  fulfillment or rejection handler. The downstream promise will then be pending
  until the returned promise is settled. This is called *assimilation*.
   ```js
  findUser().then(function (user) {
    return findCommentsByAuthor(user);
  }).then(function (comments) {
    // The user's comments are now available
  });
  ```
   If the assimliated promise rejects, then the downstream promise will also reject.
   ```js
  findUser().then(function (user) {
    return findCommentsByAuthor(user);
  }).then(function (comments) {
    // If `findCommentsByAuthor` fulfills, we'll have the value here
  }, function (reason) {
    // If `findCommentsByAuthor` rejects, we'll have the reason here
  });
  ```
   Simple Example
  --------------
   Synchronous Example
   ```javascript
  let result;
   try {
    result = findResult();
    // success
  } catch(reason) {
    // failure
  }
  ```
   Errback Example
   ```js
  findResult(function(result, err){
    if (err) {
      // failure
    } else {
      // success
    }
  });
  ```
   Promise Example;
   ```javascript
  findResult().then(function(result){
    // success
  }, function(reason){
    // failure
  });
  ```
   Advanced Example
  --------------
   Synchronous Example
   ```javascript
  let author, books;
   try {
    author = findAuthor();
    books  = findBooksByAuthor(author);
    // success
  } catch(reason) {
    // failure
  }
  ```
   Errback Example
   ```js
   function foundBooks(books) {
   }
   function failure(reason) {
   }
   findAuthor(function(author, err){
    if (err) {
      failure(err);
      // failure
    } else {
      try {
        findBoooksByAuthor(author, function(books, err) {
          if (err) {
            failure(err);
          } else {
            try {
              foundBooks(books);
            } catch(reason) {
              failure(reason);
            }
          }
        });
      } catch(error) {
        failure(err);
      }
      // success
    }
  });
  ```
   Promise Example;
   ```javascript
  findAuthor().
    then(findBooksByAuthor).
    then(function(books){
      // found books
  }).catch(function(reason){
    // something went wrong
  });
  ```
   @method then
  @param {Function} onFulfilled
  @param {Function} onRejected
  Useful for tooling.
  @return {Promise}
  */

  /**
  `catch` is simply sugar for `then(undefined, onRejection)` which makes it the same
  as the catch block of a try/catch statement.
  ```js
  function findAuthor(){
  throw new Error('couldn't find that author');
  }
  // synchronous
  try {
  findAuthor();
  } catch(reason) {
  // something went wrong
  }
  // async with promises
  findAuthor().catch(function(reason){
  // something went wrong
  });
  ```
  @method catch
  @param {Function} onRejection
  Useful for tooling.
  @return {Promise}
  */


  Promise.prototype.catch = function _catch(onRejection) {
    return this.then(null, onRejection);
  };

  /**
    `finally` will be invoked regardless of the promise's fate just as native
    try/catch/finally behaves
  
    Synchronous example:
  
    ```js
    findAuthor() {
      if (Math.random() > 0.5) {
        throw new Error();
      }
      return new Author();
    }
  
    try {
      return findAuthor(); // succeed or fail
    } catch(error) {
      return findOtherAuther();
    } finally {
      // always runs
      // doesn't affect the return value
    }
    ```
  
    Asynchronous example:
  
    ```js
    findAuthor().catch(function(reason){
      return findOtherAuther();
    }).finally(function(){
      // author was either found, or not
    });
    ```
  
    @method finally
    @param {Function} callback
    @return {Promise}
  */


  Promise.prototype.finally = function _finally(callback) {
    var promise = this;
    var constructor = promise.constructor;

    return promise.then(function (value) {
      return constructor.resolve(callback()).then(function () {
        return value;
      });
    }, function (reason) {
      return constructor.resolve(callback()).then(function () {
        throw reason;
      });
    });
  };

  return Promise;
}();

Promise$1.prototype.then = then;
Promise$1.all = all;
Promise$1.race = race;
Promise$1.resolve = resolve$1;
Promise$1.reject = reject$1;
Promise$1._setScheduler = setScheduler;
Promise$1._setAsap = setAsap;
Promise$1._asap = asap;

/*global self*/
function polyfill() {
  var local = void 0;

  if (typeof global !== 'undefined') {
    local = global;
  } else if (typeof self !== 'undefined') {
    local = self;
  } else {
    try {
      local = Function('return this')();
    } catch (e) {
      throw new Error('polyfill failed because global object is unavailable in this environment');
    }
  }

  var P = local.Promise;

  if (P) {
    var promiseToString = null;
    try {
      promiseToString = Object.prototype.toString.call(P.resolve());
    } catch (e) {
      // silently ignored
    }

    if (promiseToString === '[object Promise]' && !P.cast) {
      return;
    }
  }

  local.Promise = Promise$1;
}

// Strange compat..
Promise$1.polyfill = polyfill;
Promise$1.Promise = Promise$1;

return Promise$1;

})));



//# sourceMappingURL=es6-promise.map

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(28), __webpack_require__(29)))

/***/ }),
/* 28 */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),
/* 29 */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(31);

var _router = __webpack_require__(32);

var _router2 = _interopRequireDefault(_router);

var _store = __webpack_require__(79);

var _store2 = _interopRequireDefault(_store);

__webpack_require__(80);

var _mixin = __webpack_require__(22);

var _mixin2 = _interopRequireDefault(_mixin);

var _App = __webpack_require__(81);

var _App2 = _interopRequireDefault(_App);

__webpack_require__(89);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

window.woogoolBus = new woogool.Vue();

/**
 * Project template render
 */
var Woogool_Vue = {
  el: '#wpspear-woogool',
  store: _store2.default,
  router: _router2.default,
  render: function render(t) {
    return t(_App2.default);
  }
};

woogool.Vue.mixin(_mixin2.default);

new woogool.Vue(Woogool_Vue);

/***/ }),
/* 31 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _router = __webpack_require__(33);

var _router2 = _interopRequireDefault(_router);

var _router3 = __webpack_require__(37);

var _router4 = _interopRequireDefault(_router3);

var _init = __webpack_require__(77);

var _init2 = _interopRequireDefault(_init);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

wooGoolRouters.push({
	path: '/',
	component: _init2.default,
	name: 'woogool_root',

	children: wpspearWooGoolGetRegisterChildrenRoute('woogool_root')
});

var router = new woogool.VueRouter({
	routes: wooGoolRouters
});

exports.default = router;

/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _feedLists = __webpack_require__(34);

var _feedLists2 = _interopRequireDefault(_feedLists);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

wpspearWooGoolRegisterChildrenRoute('woogool_root', [{
    path: 'feed-lists',
    component: _feedLists2.default,
    name: 'feed_lists'

}]);

/***/ }),
/* 34 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_feed_lists_vue__ = __webpack_require__(9);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3e0c5eaf_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_feed_lists_vue__ = __webpack_require__(36);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_feed_lists_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3e0c5eaf_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_feed_lists_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/feed-lists/feed-lists.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3e0c5eaf", Component.options)
  } else {
    hotAPI.reload("data-v-3e0c5eaf", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 35 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "h2",
      { staticClass: "nav-tab-wrapper" },
      [
        _c(
          "router-link",
          {
            class: "nav-tab " + _vm.getNavTabClass("new_feed"),
            attrs: { to: { name: "new_feed" } }
          },
          [_vm._v("New Feed")]
        ),
        _vm._v(" "),
        _c(
          "router-link",
          {
            class: "nav-tab " + _vm.getNavTabClass("feed_lists"),
            attrs: { to: { name: "feed_lists" } }
          },
          [_vm._v("Feed Lists")]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1afba5bd", esExports)
  }
}

/***/ }),
/* 36 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [_c("feed-header")], 1)
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-3e0c5eaf", esExports)
  }
}

/***/ }),
/* 37 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _newFeed = __webpack_require__(38);

var _newFeed2 = _interopRequireDefault(_newFeed);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

wpspearWooGoolRegisterChildrenRoute('woogool_root', [{
    path: 'new-feed',
    component: _newFeed2.default,
    name: 'new_feed'

}]);

/***/ }),
/* 38 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_new_feed_vue__ = __webpack_require__(12);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5be1668f_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_new_feed_vue__ = __webpack_require__(76);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_new_feed_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5be1668f_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_new_feed_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/new-feed/new-feed.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5be1668f", Component.options)
  } else {
    hotAPI.reload("data-v-5be1668f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 39 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_header_vue__ = __webpack_require__(13);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0c604002_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_header_vue__ = __webpack_require__(40);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_header_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0c604002_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_header_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/new-feed/form-header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0c604002", Component.options)
  } else {
    hotAPI.reload("data-v-0c604002", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 40 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "woogool-individual-field-wrap" }, [
        _c("label", { staticClass: "woogool-label" }, [_vm._v("Feed name")]),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.header.name,
              expression: "header.name"
            }
          ],
          staticClass: "woogool-field",
          attrs: { type: "text" },
          domProps: { value: _vm.header.name },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.$set(_vm.header, "name", $event.target.value)
            }
          }
        })
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "woogool-individual-field-wrap" }, [
        _c("label", { staticClass: "woogool-label" }, [
          _vm._v("Enable product variations")
        ]),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.header.activeVariation,
              expression: "header.activeVariation"
            }
          ],
          staticClass: "woogool-field",
          attrs: { type: "checkbox" },
          domProps: {
            checked: Array.isArray(_vm.header.activeVariation)
              ? _vm._i(_vm.header.activeVariation, null) > -1
              : _vm.header.activeVariation
          },
          on: {
            change: function($event) {
              var $$a = _vm.header.activeVariation,
                $$el = $event.target,
                $$c = $$el.checked ? true : false
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v)
                if ($$el.checked) {
                  $$i < 0 &&
                    _vm.$set(_vm.header, "activeVariation", $$a.concat([$$v]))
                } else {
                  $$i > -1 &&
                    _vm.$set(
                      _vm.header,
                      "activeVariation",
                      $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                    )
                }
              } else {
                _vm.$set(_vm.header, "activeVariation", $$c)
              }
            }
          }
        })
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "woogool-individual-field-wrap" }, [
        _c("label", { staticClass: "woogool-label" }, [
          _vm._v("Feed by category")
        ]),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.header.feedByCatgory,
              expression: "header.feedByCatgory"
            }
          ],
          staticClass: "woogool-field",
          attrs: { type: "checkbox" },
          domProps: {
            checked: Array.isArray(_vm.header.feedByCatgory)
              ? _vm._i(_vm.header.feedByCatgory, null) > -1
              : _vm.header.feedByCatgory
          },
          on: {
            change: function($event) {
              var $$a = _vm.header.feedByCatgory,
                $$el = $event.target,
                $$c = $$el.checked ? true : false
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v)
                if ($$el.checked) {
                  $$i < 0 &&
                    _vm.$set(_vm.header, "feedByCatgory", $$a.concat([$$v]))
                } else {
                  $$i > -1 &&
                    _vm.$set(
                      _vm.header,
                      "feedByCatgory",
                      $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                    )
                }
              } else {
                _vm.$set(_vm.header, "feedByCatgory", $$c)
              }
            }
          }
        })
      ]),
      _vm._v(" "),
      _vm.header.feedByCatgory
        ? _c(
            "div",
            [
              _c("label", [_vm._v("Feed by category")]),
              _vm._v(" "),
              _c("vue-woogool-multiselect", {
                attrs: {
                  options: _vm.categories,
                  multiple: true,
                  "close-on-select": true,
                  "clear-on-select": true,
                  "show-labels": true,
                  searchable: true,
                  placeholder: "Select Category",
                  "select-label": "",
                  "selected-label": "selected",
                  "deselect-label": "",
                  label: "catName",
                  "track-by": "catId",
                  "allow-empty": true
                },
                model: {
                  value: _vm.header.categories,
                  callback: function($$v) {
                    _vm.$set(_vm.header, "categories", $$v)
                  },
                  expression: "header.categories"
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        [
          _c("label", [_vm._v("Category Maping")]),
          _vm._v(" "),
          _c("vue-woogool-multiselect", {
            attrs: {
              options: _vm.categories,
              multiple: true,
              "close-on-select": true,
              "clear-on-select": true,
              "show-labels": true,
              searchable: true,
              placeholder: "Category maping",
              "select-label": "",
              "selected-label": "selected",
              "deselect-label": "",
              label: "catName",
              "track-by": "catId",
              "allow-empty": true
            },
            model: {
              value: _vm.header.googleCategories,
              callback: function($$v) {
                _vm.$set(_vm.header, "googleCategories", $$v)
              },
              expression: "header.googleCategories"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _vm._l(_vm.header.googleCategories, function(catElement, index) {
        return _c(
          "div",
          { key: index, staticClass: "woogool-individual-field-wrap" },
          [
            _c("label", { staticClass: "woogool-label" }, [
              _vm._v(_vm._s(catElement.catName))
            ]),
            _vm._v(" "),
            _c("vue-woogool-multiselect", {
              attrs: {
                options: _vm.googleCategories,
                multiple: false,
                "close-on-select": true,
                "clear-on-select": true,
                "show-labels": true,
                searchable: true,
                placeholder: "Category maping",
                "select-label": "",
                "selected-label": "selected",
                "deselect-label": "",
                label: "",
                "track-by": "id",
                "allow-empty": true
              },
              on: {
                input: function($event) {
                  _vm.setGoogleCat(catElement, $event)
                }
              },
              model: {
                value: catElement.googleCat,
                callback: function($$v) {
                  _vm.$set(catElement, "googleCat", $$v)
                },
                expression: "catElement.googleCat"
              }
            }),
            _vm._v(" "),
            _c("span", [
              _vm._v(
                "Google category for the " +
                  _vm._s(catElement.catName.toLowerCase()) +
                  " item"
              )
            ])
          ],
          1
        )
      }),
      _vm._v(" "),
      _c("div", { staticClass: "woogool-individual-field-wrap" }, [
        _c("label", { staticClass: "woogool-label" }, [
          _vm._v("Refresh interval")
        ]),
        _vm._v(" "),
        _c(
          "select",
          {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.header.refresh,
                expression: "header.refresh"
              }
            ],
            on: {
              change: function($event) {
                var $$selectedVal = Array.prototype.filter
                  .call($event.target.options, function(o) {
                    return o.selected
                  })
                  .map(function(o) {
                    var val = "_value" in o ? o._value : o.value
                    return val
                  })
                _vm.$set(
                  _vm.header,
                  "refresh",
                  $event.target.multiple ? $$selectedVal : $$selectedVal[0]
                )
              }
            }
          },
          [
            _c("option", { attrs: { value: "1" } }, [_vm._v("Daily")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "2" } }, [_vm._v("Hourly")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "3" } }, [_vm._v("Weekly")]),
            _vm._v(" "),
            _c("option", { attrs: { value: "4" } }, [_vm._v("Monthly")])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", [
        _c(
          "a",
          {
            staticClass: "button button-primary",
            attrs: { href: "#" },
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.changeStage("second")
              }
            }
          },
          [_vm._v(_vm._s("Next"))]
        )
      ])
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0c604002", esExports)
  }
}

/***/ }),
/* 41 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_content_vue__ = __webpack_require__(14);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_248174d4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_content_vue__ = __webpack_require__(70);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_content_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_248174d4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_content_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/new-feed/form-content.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-248174d4", Component.options)
  } else {
    hotAPI.reload("data-v-248174d4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(43), __esModule: true };

/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(44);
module.exports = __webpack_require__(4).Object.assign;


/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.3.1 Object.assign(target, source)
var $export = __webpack_require__(45);

$export($export.S + $export.F, 'Object', { assign: __webpack_require__(55) });


/***/ }),
/* 45 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(3);
var core = __webpack_require__(4);
var ctx = __webpack_require__(46);
var hide = __webpack_require__(48);
var has = __webpack_require__(15);
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var IS_WRAP = type & $export.W;
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE];
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE];
  var key, own, out;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    if (own && has(exports, key)) continue;
    // export native or passed
    out = own ? target[key] : source[key];
    // prevent global pollution for namespaces
    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
    // bind timers to global for call from export context
    : IS_BIND && own ? ctx(out, global)
    // wrap global constructors for prevent change them in library
    : IS_WRAP && target[key] == out ? (function (C) {
      var F = function (a, b, c) {
        if (this instanceof C) {
          switch (arguments.length) {
            case 0: return new C();
            case 1: return new C(a);
            case 2: return new C(a, b);
          } return new C(a, b, c);
        } return C.apply(this, arguments);
      };
      F[PROTOTYPE] = C[PROTOTYPE];
      return F;
    // make static versions for prototype methods
    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
    if (IS_PROTO) {
      (exports.virtual || (exports.virtual = {}))[key] = out;
      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
      if (type & $export.R && expProto && !expProto[key]) hide(expProto, key, out);
    }
  }
};
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

// optional / simple context binding
var aFunction = __webpack_require__(47);
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),
/* 47 */
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__(49);
var createDesc = __webpack_require__(54);
module.exports = __webpack_require__(6) ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__(50);
var IE8_DOM_DEFINE = __webpack_require__(51);
var toPrimitive = __webpack_require__(53);
var dP = Object.defineProperty;

exports.f = __webpack_require__(6) ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(5);
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = !__webpack_require__(6) && !__webpack_require__(7)(function () {
  return Object.defineProperty(__webpack_require__(52)('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 52 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(5);
var document = __webpack_require__(3).document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __webpack_require__(5);
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),
/* 54 */
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// 19.1.2.1 Object.assign(target, source, ...)
var getKeys = __webpack_require__(56);
var gOPS = __webpack_require__(67);
var pIE = __webpack_require__(68);
var toObject = __webpack_require__(69);
var IObject = __webpack_require__(17);
var $assign = Object.assign;

// should work with symbols and should have deterministic property order (V8 bug)
module.exports = !$assign || __webpack_require__(7)(function () {
  var A = {};
  var B = {};
  // eslint-disable-next-line no-undef
  var S = Symbol();
  var K = 'abcdefghijklmnopqrst';
  A[S] = 7;
  K.split('').forEach(function (k) { B[k] = k; });
  return $assign({}, A)[S] != 7 || Object.keys($assign({}, B)).join('') != K;
}) ? function assign(target, source) { // eslint-disable-line no-unused-vars
  var T = toObject(target);
  var aLen = arguments.length;
  var index = 1;
  var getSymbols = gOPS.f;
  var isEnum = pIE.f;
  while (aLen > index) {
    var S = IObject(arguments[index++]);
    var keys = getSymbols ? getKeys(S).concat(getSymbols(S)) : getKeys(S);
    var length = keys.length;
    var j = 0;
    var key;
    while (length > j) if (isEnum.call(S, key = keys[j++])) T[key] = S[key];
  } return T;
} : $assign;


/***/ }),
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.14 / 15.2.3.14 Object.keys(O)
var $keys = __webpack_require__(57);
var enumBugKeys = __webpack_require__(66);

module.exports = Object.keys || function keys(O) {
  return $keys(O, enumBugKeys);
};


/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__(15);
var toIObject = __webpack_require__(16);
var arrayIndexOf = __webpack_require__(59)(false);
var IE_PROTO = __webpack_require__(62)('IE_PROTO');

module.exports = function (object, names) {
  var O = toIObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~arrayIndexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),
/* 58 */
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

// false -> Array#indexOf
// true  -> Array#includes
var toIObject = __webpack_require__(16);
var toLength = __webpack_require__(60);
var toAbsoluteIndex = __webpack_require__(61);
module.exports = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) if (IS_INCLUDES || index in O) {
      if (O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};


/***/ }),
/* 60 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.15 ToLength
var toInteger = __webpack_require__(19);
var min = Math.min;
module.exports = function (it) {
  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};


/***/ }),
/* 61 */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(19);
var max = Math.max;
var min = Math.min;
module.exports = function (index, length) {
  index = toInteger(index);
  return index < 0 ? max(index + length, 0) : min(index, length);
};


/***/ }),
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

var shared = __webpack_require__(63)('keys');
var uid = __webpack_require__(65);
module.exports = function (key) {
  return shared[key] || (shared[key] = uid(key));
};


/***/ }),
/* 63 */
/***/ (function(module, exports, __webpack_require__) {

var core = __webpack_require__(4);
var global = __webpack_require__(3);
var SHARED = '__core-js_shared__';
var store = global[SHARED] || (global[SHARED] = {});

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: core.version,
  mode: __webpack_require__(64) ? 'pure' : 'global',
  copyright: '© 2018 Denis Pushkarev (zloirock.ru)'
});


/***/ }),
/* 64 */
/***/ (function(module, exports) {

module.exports = true;


/***/ }),
/* 65 */
/***/ (function(module, exports) {

var id = 0;
var px = Math.random();
module.exports = function (key) {
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};


/***/ }),
/* 66 */
/***/ (function(module, exports) {

// IE 8- don't enum bug keys
module.exports = (
  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
).split(',');


/***/ }),
/* 67 */
/***/ (function(module, exports) {

exports.f = Object.getOwnPropertySymbols;


/***/ }),
/* 68 */
/***/ (function(module, exports) {

exports.f = {}.propertyIsEnumerable;


/***/ }),
/* 69 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.13 ToObject(argument)
var defined = __webpack_require__(18);
module.exports = function (it) {
  return Object(defined(it));
};


/***/ }),
/* 70 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("table", { staticClass: "wp-list-table widefat striped posts" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "tbody",
        [
          _vm._l(_vm.gAttrs, function(gAttrTr, gkey) {
            return gAttrTr.format == "required"
              ? [
                  gAttrTr.type == "default"
                    ? _c("tr", { key: gkey }, [
                        _c("td", [
                          _c(
                            "a",
                            {
                              attrs: { href: "#" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  _vm.removeAttr(_vm.gAttrs, gkey)
                                }
                              }
                            },
                            [_c("span", [_vm._v("X")])]
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _c(
                            "select",
                            {
                              on: {
                                change: function($event) {
                                  _vm.setGooAttrReqVal(
                                    gAttrTr,
                                    gkey,
                                    gAttrTr.type,
                                    $event
                                  )
                                }
                              }
                            },
                            _vm._l(_vm.googleAttributes, function(
                              googleAttributeTd,
                              key
                            ) {
                              return _c(
                                "optgroup",
                                { attrs: { label: googleAttributeTd.label } },
                                _vm._l(googleAttributeTd.attributes, function(
                                  googleAttrTd,
                                  optKey
                                ) {
                                  return _c(
                                    "option",
                                    {
                                      domProps: {
                                        value: googleAttrTd.name,
                                        selected: _vm.isGoogleAttrSelected(
                                          gAttrTr,
                                          googleAttrTd
                                        )
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n\t\t\t\t\t\t\t\t\t" +
                                          _vm._s(googleAttrTd.label) +
                                          " " +
                                          _vm._s(
                                            "(" + googleAttrTd.feed_name + ")"
                                          ) +
                                          "\n\t\t\t\t\t\t\t\t"
                                      )
                                    ]
                                  )
                                })
                              )
                            })
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _c(
                            "select",
                            {
                              on: {
                                change: function($event) {
                                  if ($event.target !== $event.currentTarget) {
                                    return null
                                  }
                                  _vm.setProAttrReqVal(gAttrTr, gkey, $event)
                                }
                              }
                            },
                            _vm._l(_vm.woogoolAttributes, function(
                              woogoolAttribute,
                              proMetaKey
                            ) {
                              return _c(
                                "option",
                                {
                                  domProps: {
                                    value: proMetaKey,
                                    selected: _vm.isProductAttrSelected(
                                      gAttrTr,
                                      proMetaKey
                                    )
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n\t\t\t\t\t\t\t\t" +
                                      _vm._s(woogoolAttribute) +
                                      "\n\t\t\t\t\t\t\t"
                                  )
                                ]
                              )
                            })
                          )
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  gAttrTr.type == "mapping"
                    ? _c("tr", { key: gkey }, [
                        _c("td", [
                          _c(
                            "a",
                            {
                              attrs: { href: "#" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  _vm.removeAttr(_vm.gAttrs, gkey)
                                }
                              }
                            },
                            [_c("span", [_vm._v("X")])]
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _c(
                            "select",
                            {
                              on: {
                                change: function($event) {
                                  if ($event.target !== $event.currentTarget) {
                                    return null
                                  }
                                  _vm.setGooAttrReqVal(
                                    gAttrTr,
                                    gkey,
                                    gAttrTr.type,
                                    $event
                                  )
                                }
                              }
                            },
                            [
                              _c("option", { attrs: { value: "" } }),
                              _vm._v(" "),
                              _vm._l(_vm.googleAttributes, function(
                                googleAttributeTd,
                                key
                              ) {
                                return _c(
                                  "optgroup",
                                  { attrs: { label: googleAttributeTd.label } },
                                  _vm._l(googleAttributeTd.attributes, function(
                                    googleAttrTd,
                                    mKey
                                  ) {
                                    return _c(
                                      "option",
                                      {
                                        domProps: {
                                          value: googleAttrTd.name,
                                          selected: _vm.isGoogleAttrSelected(
                                            gAttrTr,
                                            googleAttrTd
                                          )
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n\t\t\t\t\t\t\t\t\t" +
                                            _vm._s(googleAttrTd.label) +
                                            " " +
                                            _vm._s(
                                              "(" + googleAttrTd.feed_name + ")"
                                            ) +
                                            "\n\t\t\t\t\t\t\t\t"
                                        )
                                      ]
                                    )
                                  })
                                )
                              })
                            ],
                            2
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _c(
                            "select",
                            {
                              on: {
                                change: function($event) {
                                  if ($event.target !== $event.currentTarget) {
                                    return null
                                  }
                                  _vm.setProAttrReqVal(gAttrTr, gkey, $event)
                                }
                              }
                            },
                            [
                              _c("option", { attrs: { value: "" } }),
                              _vm._v(" "),
                              _vm._l(_vm.woogoolAttributes, function(
                                woogoolAttribute,
                                wpKey
                              ) {
                                return _c(
                                  "option",
                                  {
                                    domProps: {
                                      value: wpKey,
                                      selected: _vm.isProductAttrSelected(
                                        gAttrTr,
                                        wpKey
                                      )
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\t" +
                                        _vm._s(woogoolAttribute) +
                                        "\n\t\t\t\t\t\t\t"
                                    )
                                  ]
                                )
                              })
                            ],
                            2
                          )
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  gAttrTr.type == "custom"
                    ? _c("tr", { key: gkey }, [
                        _c("td", [
                          _c(
                            "a",
                            {
                              attrs: { href: "#" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  _vm.removeAttr(_vm.gAttrs, gkey)
                                }
                              }
                            },
                            [_c("span", [_vm._v("X")])]
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _c("input", {
                            attrs: { type: "text" },
                            domProps: { value: gAttrTr.name },
                            on: {
                              input: function($event) {
                                _vm.setCustomText(gAttrTr, gkey, $event)
                              }
                            }
                          })
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _c(
                            "select",
                            {
                              on: {
                                change: function($event) {
                                  if ($event.target !== $event.currentTarget) {
                                    return null
                                  }
                                  _vm.setProAttrReqVal(gAttrTr, gkey, $event)
                                }
                              }
                            },
                            [
                              _c("option", { attrs: { value: "" } }),
                              _vm._v(" "),
                              _vm._l(_vm.woogoolAttributes, function(
                                woogoolAttribute,
                                pmKey
                              ) {
                                return _c(
                                  "option",
                                  {
                                    domProps: {
                                      value: pmKey,
                                      selected: _vm.isProductAttrSelected(
                                        gAttrTr,
                                        pmKey
                                      )
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\t" +
                                        _vm._s(woogoolAttribute) +
                                        "\n\t\t\t\t\t\t\t"
                                    )
                                  ]
                                )
                              })
                            ],
                            2
                          )
                        ])
                      ])
                    : _vm._e()
                ]
              : _vm._e()
          })
        ],
        2
      )
    ]),
    _vm._v(" "),
    _c("div", [
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.changeStage("first")
            }
          }
        },
        [_vm._v(_vm._s("Prev"))]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.addCustomField("first")
            }
          }
        },
        [_vm._v(_vm._s("Add custom field"))]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.addMappingField()
            }
          }
        },
        [_vm._v(_vm._s("Add mapping field"))]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.changeStage("third")
            }
          }
        },
        [_vm._v(_vm._s("Next"))]
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th"),
        _vm._v(" "),
        _c("th", [_vm._v("Google Shopping Attributes")]),
        _vm._v(" "),
        _c("th", [_vm._v("Product Attributes")])
      ])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-248174d4", esExports)
  }
}

/***/ }),
/* 71 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_logic_vue__ = __webpack_require__(20);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0ee82c0e_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_logic_vue__ = __webpack_require__(75);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(72)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_logic_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0ee82c0e_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_logic_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/new-feed/form-logic.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0ee82c0e", Component.options)
  } else {
    hotAPI.reload("data-v-0ee82c0e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(73);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(8)("29c1f79a", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0ee82c0e\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/less-loader/dist/cjs.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./form-logic.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0ee82c0e\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/less-loader/dist/cjs.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./form-logic.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 73 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)(false);
// imports


// module
exports.push([module.i, "\n.wp-list-table .first {\n  width: 1em;\n}\n.wp-list-table .second {\n  width: 3em;\n}\n.wp-list-table .woogool-drop,\n.wp-list-table .woogool-text {\n  width: 150px;\n}\n", ""]);

// exports


/***/ }),
/* 74 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 75 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("table", { staticClass: "wp-list-table widefat fixed striped posts" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "tbody",
        [
          _vm._l(_vm.logic, function(logical, key) {
            return [
              _c("tr", [
                _c("td", { staticClass: "first" }, [
                  _c(
                    "a",
                    {
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.removeAttr(key)
                        }
                      }
                    },
                    [_c("span", [_vm._v("X")])]
                  )
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "second" }, [
                  _vm._v(
                    "\n\t\t\t\t\t\t" +
                      _vm._s(_vm.ucfirst(logical.type)) +
                      "\n\t\t\t\t\t"
                  )
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "third" }, [
                  _c(
                    "select",
                    {
                      staticClass: "woogool-drop",
                      on: {
                        change: function($event) {
                          _vm.setData(logical, "if_cond", $event)
                        }
                      }
                    },
                    _vm._l(_vm.proAttrs, function(proAttrTd, prokey) {
                      return _c(
                        "optgroup",
                        { attrs: { label: proAttrTd.label } },
                        _vm._l(proAttrTd.attributes, function(
                          attribute,
                          attrKey
                        ) {
                          return _c(
                            "option",
                            {
                              domProps: {
                                value: attrKey,
                                selected:
                                  logical.if == attrKey ? "selected" : ""
                              }
                            },
                            [
                              _vm._v(
                                "\n\t\t\t\t\t\t\t\t\t" +
                                  _vm._s(attribute) +
                                  " \n\t\t\t\t\t\t\t\t"
                              )
                            ]
                          )
                        })
                      )
                    })
                  )
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "fourth" }, [
                  logical.type == "filter"
                    ? _c("div", [
                        _c(
                          "select",
                          {
                            staticClass: "woogool-drop",
                            on: {
                              change: function($event) {
                                _vm.setData(logical, "condition", $event)
                              }
                            }
                          },
                          _vm._l(_vm.filterCondDrops, function(filterCondDrop) {
                            return _c(
                              "option",
                              {
                                domProps: {
                                  value: filterCondDrop.id,
                                  selected:
                                    logical.condition == filterCondDrop.id
                                      ? "selected"
                                      : ""
                                }
                              },
                              [
                                _vm._v(
                                  "\n\n\t\t\t\t\t\t\t\t\t" +
                                    _vm._s(filterCondDrop.label) +
                                    "\n\t\t\t\t\t\t\t\t"
                                )
                              ]
                            )
                          })
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  logical.type == "rule" || logical.type == "value"
                    ? _c("div", [
                        _c(
                          "select",
                          {
                            staticClass: "woogool-drop",
                            on: {
                              change: function($event) {
                                _vm.setData(logical, "condition", $event)
                              }
                            }
                          },
                          _vm._l(_vm.ruleCondDrops, function(ruleCondDrop) {
                            return _c(
                              "option",
                              {
                                domProps: {
                                  value: ruleCondDrop.id,
                                  selected:
                                    logical.condition == ruleCondDrop.id
                                      ? "selected"
                                      : ""
                                }
                              },
                              [
                                _vm._v(
                                  "\n\n\t\t\t\t\t\t\t\t\t" +
                                    _vm._s(ruleCondDrop.label) +
                                    "\n\t\t\t\t\t\t\t\t"
                                )
                              ]
                            )
                          })
                        )
                      ])
                    : _vm._e()
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "five" }, [
                  _c("input", {
                    staticClass: "woogool-text",
                    attrs: {
                      placeholder:
                        logical.condition == "contains" ||
                        logical.condition == "does_not_contain"
                          ? "val_1|val_2|val_3"
                          : "",
                      type: "text"
                    },
                    domProps: { value: logical.value },
                    on: {
                      input: function($event) {
                        _vm.setData(logical, "value", $event)
                      }
                    }
                  }),
                  _vm._v(" "),
                  logical.condition == "contains" ||
                  logical.condition == "does_not_contain"
                    ? _c("div", [_vm._v("Value seperated by |")])
                    : _vm._e()
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "six" }, [
                  logical.type == "filter"
                    ? _c("div", [
                        _c(
                          "select",
                          {
                            staticClass: "woogool-drop",
                            on: {
                              change: function($event) {
                                _vm.setData(logical, "then", $event)
                              }
                            }
                          },
                          [
                            _c(
                              "option",
                              {
                                attrs: { value: "exclude" },
                                domProps: {
                                  selected:
                                    logical.then == "exclude" ? "selected" : ""
                                }
                              },
                              [
                                _vm._v(
                                  "\n\t\t\t\t\t\t\t\t\tExclude\n\t\t\t\t\t\t\t\t"
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "option",
                              {
                                attrs: { value: "include" },
                                domProps: {
                                  selected:
                                    logical.then == "include" ? "selected" : ""
                                }
                              },
                              [
                                _vm._v(
                                  "\n\t\t\t\t\t\t\t\t\tInclude\n\t\t\t\t\t\t\t\t"
                                )
                              ]
                            )
                          ]
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  logical.type == "rule"
                    ? _c("div", [
                        _c(
                          "select",
                          {
                            staticClass: "woogool-drop",
                            on: {
                              change: function($event) {
                                _vm.setData(logical, "then", $event)
                              }
                            }
                          },
                          _vm._l(_vm.proAttrs, function(proAttrTd, prokey) {
                            return _c(
                              "optgroup",
                              { attrs: { label: proAttrTd.label } },
                              _vm._l(proAttrTd.attributes, function(
                                attribute,
                                attrKey
                              ) {
                                return _c(
                                  "option",
                                  {
                                    domProps: {
                                      value: attrKey,
                                      selected:
                                        logical.then == attrKey
                                          ? "selected"
                                          : ""
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\t\t\t" +
                                        _vm._s(attribute) +
                                        " \n\t\t\t\t\t\t\t\t\t"
                                    )
                                  ]
                                )
                              })
                            )
                          })
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  logical.type == "value"
                    ? _c("div", [_vm._v("THEN")])
                    : _vm._e()
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "seven" }, [
                  logical.type == "rule" || logical.type == "value"
                    ? _c("div", [
                        _c("input", {
                          staticClass: "woogool-text",
                          attrs: { type: "text" },
                          domProps: { value: logical.is },
                          on: {
                            input: function($event) {
                              _vm.setData(logical, "is", $event)
                            }
                          }
                        })
                      ])
                    : _vm._e()
                ])
              ])
            ]
          })
        ],
        2
      )
    ]),
    _vm._v(" "),
    _c("div", [
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.changeStage("second")
            }
          }
        },
        [_vm._v(_vm._s("Prev"))]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.addFields("filter")
            }
          }
        },
        [_vm._v(_vm._s("+ Filter"))]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.addFields("rule")
            }
          }
        },
        [_vm._v(_vm._s("+ Rule"))]
      ),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "button button-primary",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.addFields("value")
            }
          }
        },
        [_vm._v(_vm._s("+ Value"))]
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "first" }),
        _vm._v(" "),
        _c("th", { staticClass: "second" }, [_vm._v("TYPE")]),
        _vm._v(" "),
        _c("th", { staticClass: "third" }, [_vm._v("IF")]),
        _vm._v(" "),
        _c("th", { staticClass: "fourth" }, [_vm._v("CONDITION")]),
        _vm._v(" "),
        _c("th", { staticClass: "five" }, [_vm._v("VALUE")]),
        _vm._v(" "),
        _c("th", { staticClass: "six" }, [_vm._v("THEN")]),
        _vm._v(" "),
        _c("th", { staticClass: "seven" }, [_vm._v("is")])
      ])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0ee82c0e", esExports)
  }
}

/***/ }),
/* 76 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {},
    [
      _c("feed-header"),
      _vm._v(" "),
      _c(
        "form",
        {
          attrs: { action: "", method: "post" },
          on: {
            submit: function($event) {
              $event.preventDefault()
              _vm.submit()
            }
          }
        },
        [
          _c("form-header", {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.stage.step == "first",
                expression: "stage.step == 'first'"
              }
            ],
            attrs: { header: _vm.header, stage: _vm.stage }
          }),
          _vm._v(" "),
          _c("form-content", {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.stage.step == "second",
                expression: "stage.step == 'second'"
              }
            ],
            attrs: { gAttrs: _vm.contentAttrs, stage: _vm.stage }
          }),
          _vm._v(" "),
          _c("form-logic", {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.stage.step == "third",
                expression: "stage.step == 'third'"
              }
            ],
            attrs: { logic: _vm.logic, stage: _vm.stage }
          }),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass: "button button-primary",
              attrs: { href: "#" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.submit()
                }
              }
            },
            [_vm._v(_vm._s("Save"))]
          ),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass: "button button-primary",
              attrs: { href: "#" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.createFeedFile(80)
                }
              }
            },
            [_vm._v(_vm._s("Generate Feed File"))]
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5be1668f", esExports)
  }
}

/***/ }),
/* 77 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_init_vue__ = __webpack_require__(21);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4784381d_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_init_vue__ = __webpack_require__(78);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_init_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4784381d_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_init_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/root/init.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4784381d", Component.options)
  } else {
    hotAPI.reload("data-v-4784381d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 78 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("router-view")
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4784381d", esExports)
  }
}

/***/ }),
/* 79 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = new woogool.Vuex.Store({
    state: {},

    mutations: {}

});

/***/ }),
/* 80 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


woogool.Vue.directive('woogool-slide-up-down', {
	inserted: function inserted(el) {
		var node = jQuery(el);

		if (node.is(':visible')) {
			node.slideUp(400);
		} else {
			node.slideDown(400);
		}
	}
});

woogool.Vue.directive('woogool-pretty-photo', {
	inserted: function inserted(el) {
		var node = jQuery(el);

		node.prettyPhoto({
			allow_resize: true,
			social_tools: '',
			allow_expand: true,
			deeplinking: false
		});
	}
});

woogool.Vue.directive('woogool-tooltip', {
	inserted: function inserted(el) {
		jQuery(el).tipTip();
	}
});

/***/ }),
/* 81 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_App_vue__ = __webpack_require__(23);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_31ad00d8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__ = __webpack_require__(88);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(82)
  __webpack_require__(84)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_App_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_31ad00d8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/App.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-31ad00d8", Component.options)
  } else {
    hotAPI.reload("data-v-31ad00d8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(83);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(8)("f9913afa", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../node_modules/css-loader/index.js!../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31ad00d8\",\"scoped\":false,\"hasInlineConfig\":false}!../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./App.vue", function() {
     var newContent = require("!!../../node_modules/css-loader/index.js!../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31ad00d8\",\"scoped\":false,\"hasInlineConfig\":false}!../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./App.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 83 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)(false);
// imports


// module
exports.push([module.i, "\n.hrm-h1 {\n    margin: 0 !important;\n    padding: 0 !important;\n}\n", ""]);

// exports


/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(85);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(8)("1112ca3c", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../node_modules/css-loader/index.js!../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31ad00d8\",\"scoped\":false,\"hasInlineConfig\":false}!../../node_modules/vue-loader/lib/selector.js?type=styles&index=1!./App.vue", function() {
     var newContent = require("!!../../node_modules/css-loader/index.js!../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31ad00d8\",\"scoped\":false,\"hasInlineConfig\":false}!../../node_modules/vue-loader/lib/selector.js?type=styles&index=1!./App.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)(false);
// imports


// module
exports.push([module.i, "\n#nprogress .bar {\n    z-index: 99999;\n}\n\n", ""]);

// exports


/***/ }),
/* 86 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_do_action_vue__ = __webpack_require__(24);
/* unused harmony namespace reexport */
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */
var __vue_template__ = null
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_do_action_vue__["a" /* default */],
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/common/do-action.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-18ba2f78", Component.options)
  } else {
    hotAPI.reload("data-v-18ba2f78", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 87 */
/***/ (function(module, exports) {

function webpackEmptyContext(req) {
	throw new Error("Cannot find module '" + req + "'.");
}
webpackEmptyContext.keys = function() { return []; };
webpackEmptyContext.resolve = webpackEmptyContext;
module.exports = webpackEmptyContext;
webpackEmptyContext.id = 87;

/***/ }),
/* 88 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "wedevs-pm-wrap wrap pm pm-page-wrapper",
      attrs: { id: "wedevs-project-manager" }
    },
    [
      _c("h1", { staticClass: "hrm-h1" }),
      _vm._v(" "),
      _c("do-action", { attrs: { hook: "pm-before-router-view" } }),
      _vm._v(" "),
      _c("router-view"),
      _vm._v(" "),
      _c("do-action", { attrs: { hook: "addons-component" } })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-31ad00d8", esExports)
  }
}

/***/ }),
/* 89 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


woogool.Vue.component('vue-woogool-multiselect', window.VueMultiselect.default);

/***/ })
/******/ ]);