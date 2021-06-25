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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/js-cookie/src/js.cookie.js":
/*!*************************************************!*\
  !*** ./node_modules/js-cookie/src/js.cookie.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * JavaScript Cookie v2.2.1
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
	var registeredInModuleLoader;
	if (true) {
		!(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
		registeredInModuleLoader = true;
	}
	if (true) {
		module.exports = factory();
		registeredInModuleLoader = true;
	}
	if (!registeredInModuleLoader) {
		var OldCookies = window.Cookies;
		var api = window.Cookies = factory();
		api.noConflict = function () {
			window.Cookies = OldCookies;
			return api;
		};
	}
}(function () {
	function extend () {
		var i = 0;
		var result = {};
		for (; i < arguments.length; i++) {
			var attributes = arguments[ i ];
			for (var key in attributes) {
				result[key] = attributes[key];
			}
		}
		return result;
	}

	function decode (s) {
		return s.replace(/(%[0-9A-Z]{2})+/g, decodeURIComponent);
	}

	function init (converter) {
		function api() {}

		function set (key, value, attributes) {
			if (typeof document === 'undefined') {
				return;
			}

			attributes = extend({
				path: '/'
			}, api.defaults, attributes);

			if (typeof attributes.expires === 'number') {
				attributes.expires = new Date(new Date() * 1 + attributes.expires * 864e+5);
			}

			// We're using "expires" because "max-age" is not supported by IE
			attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

			try {
				var result = JSON.stringify(value);
				if (/^[\{\[]/.test(result)) {
					value = result;
				}
			} catch (e) {}

			value = converter.write ?
				converter.write(value, key) :
				encodeURIComponent(String(value))
					.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);

			key = encodeURIComponent(String(key))
				.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent)
				.replace(/[\(\)]/g, escape);

			var stringifiedAttributes = '';
			for (var attributeName in attributes) {
				if (!attributes[attributeName]) {
					continue;
				}
				stringifiedAttributes += '; ' + attributeName;
				if (attributes[attributeName] === true) {
					continue;
				}

				// Considers RFC 6265 section 5.2:
				// ...
				// 3.  If the remaining unparsed-attributes contains a %x3B (";")
				//     character:
				// Consume the characters of the unparsed-attributes up to,
				// not including, the first %x3B (";") character.
				// ...
				stringifiedAttributes += '=' + attributes[attributeName].split(';')[0];
			}

			return (document.cookie = key + '=' + value + stringifiedAttributes);
		}

		function get (key, json) {
			if (typeof document === 'undefined') {
				return;
			}

			var jar = {};
			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all.
			var cookies = document.cookie ? document.cookie.split('; ') : [];
			var i = 0;

			for (; i < cookies.length; i++) {
				var parts = cookies[i].split('=');
				var cookie = parts.slice(1).join('=');

				if (!json && cookie.charAt(0) === '"') {
					cookie = cookie.slice(1, -1);
				}

				try {
					var name = decode(parts[0]);
					cookie = (converter.read || converter)(cookie, name) ||
						decode(cookie);

					if (json) {
						try {
							cookie = JSON.parse(cookie);
						} catch (e) {}
					}

					jar[name] = cookie;

					if (key === name) {
						break;
					}
				} catch (e) {}
			}

			return key ? jar[key] : jar;
		}

		api.set = set;
		api.get = function (key) {
			return get(key, false /* read as raw */);
		};
		api.getJSON = function (key) {
			return get(key, true /* read as json */);
		};
		api.remove = function (key, attributes) {
			set(key, '', extend(attributes, {
				expires: -1
			}));
		};

		api.defaults = {};

		api.withConverter = init;

		return api;
	}

	return init(function () {});
}));


/***/ }),

/***/ "./resources/js/argon.js":
/*!*******************************!*\
  !*** ./resources/js/argon.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/*!

=========================================================
* Argon Dashboard - v1.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2020 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
// CALL MODULE ARGON
var Cookies = __webpack_require__(/*! js-cookie */ "./node_modules/js-cookie/src/js.cookie.js"); //
// Layout
//


'use strict';

var Layout = function () {
  function pinSidenav() {
    $('.sidenav-toggler').addClass('active');
    $('.sidenav-toggler').data('action', 'sidenav-unpin');
    $('body').removeClass('g-sidenav-hidden').addClass('g-sidenav-show g-sidenav-pinned');
    $('body').append('<div class="backdrop d-xl-none" data-action="sidenav-unpin" data-target=' + $('#sidenav-main').data('target') + ' />'); // Store the sidenav state in a cookie session

    Cookies.set('sidenav-state', 'pinned');
  }

  function unpinSidenav() {
    $('.sidenav-toggler').removeClass('active');
    $('.sidenav-toggler').data('action', 'sidenav-pin');
    $('body').removeClass('g-sidenav-pinned').addClass('g-sidenav-hidden');
    $('body').find('.backdrop').remove(); // Store the sidenav state in a cookie session

    Cookies.set('sidenav-state', 'unpinned');
  } // Set sidenav state from cookie


  var $sidenavState = Cookies.get('sidenav-state') ? Cookies.get('sidenav-state') : 'pinned';

  if ($(window).width() > 1200) {
    if ($sidenavState == 'pinned') {
      pinSidenav();
    }

    if (Cookies.get('sidenav-state') == 'unpinned') {
      unpinSidenav();
    }

    $(window).resize(function () {
      if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
        $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
      }
    });
  }

  if ($(window).width() < 1200) {
    $('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
    $('body').removeClass('g-sidenav-show');
    $(window).resize(function () {
      if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
        $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
      }
    });
  }

  $("body").on("click", "[data-action]", function (e) {
    e.preventDefault();
    var $this = $(this);
    var action = $this.data('action');
    var target = $this.data('target'); // Manage actions

    switch (action) {
      case 'sidenav-pin':
        pinSidenav();
        break;

      case 'sidenav-unpin':
        unpinSidenav();
        break;

      case 'search-show':
        target = $this.data('target');
        $('body').removeClass('g-navbar-search-show').addClass('g-navbar-search-showing');
        setTimeout(function () {
          $('body').removeClass('g-navbar-search-showing').addClass('g-navbar-search-show');
        }, 150);
        setTimeout(function () {
          $('body').addClass('g-navbar-search-shown');
        }, 300);
        break;

      case 'search-close':
        target = $this.data('target');
        $('body').removeClass('g-navbar-search-shown');
        setTimeout(function () {
          $('body').removeClass('g-navbar-search-show').addClass('g-navbar-search-hiding');
        }, 150);
        setTimeout(function () {
          $('body').removeClass('g-navbar-search-hiding').addClass('g-navbar-search-hidden');
        }, 300);
        setTimeout(function () {
          $('body').removeClass('g-navbar-search-hidden');
        }, 500);
        break;
    }
  }); // Add sidenav modifier classes on mouse events

  $('.sidenav').on('mouseenter', function () {
    if (!$('body').hasClass('g-sidenav-pinned')) {
      $('body').removeClass('g-sidenav-hide').removeClass('g-sidenav-hidden').addClass('g-sidenav-show');
    }
  });
  $('.sidenav').on('mouseleave', function () {
    if (!$('body').hasClass('g-sidenav-pinned')) {
      $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hide');
      setTimeout(function () {
        $('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
      }, 300);
    }
  }); // Make the body full screen size if it has not enough content inside

  $(window).on('load resize', function () {
    if ($('body').height() < 800) {
      $('body').css('min-height', '100vh');
      $('#footer-main').addClass('footer-auto-bottom');
    }
  });
}(); //
// Charts
//
//
// Navbar
//


'use strict';

var Navbar = function () {
  // Variables
  var $nav = $('.navbar-nav, .navbar-nav .nav');
  var $collapse = $('.navbar .collapse');
  var $dropdown = $('.navbar .dropdown'); // Methods

  function accordion($this) {
    $this.closest($nav).find($collapse).not($this).collapse('hide');
  }

  function closeDropdown($this) {
    var $dropdownMenu = $this.find('.dropdown-menu');
    $dropdownMenu.addClass('close');
    setTimeout(function () {
      $dropdownMenu.removeClass('close');
    }, 200);
  } // Events


  $collapse.on({
    'show.bs.collapse': function showBsCollapse() {
      accordion($(this));
    }
  });
  $dropdown.on({
    'hide.bs.dropdown': function hideBsDropdown() {
      closeDropdown($(this));
    }
  });
}(); //
// Navbar collapse
//


var NavbarCollapse = function () {
  // Variables
  var $nav = $('.navbar-nav'),
      $collapse = $('.navbar .navbar-custom-collapse'); // Methods

  function hideNavbarCollapse($this) {
    $this.addClass('collapsing-out');
  }

  function hiddenNavbarCollapse($this) {
    $this.removeClass('collapsing-out');
  } // Events


  if ($collapse.length) {
    $collapse.on({
      'hide.bs.collapse': function hideBsCollapse() {
        hideNavbarCollapse($collapse);
      }
    });
    $collapse.on({
      'hidden.bs.collapse': function hiddenBsCollapse() {
        hiddenNavbarCollapse($collapse);
      }
    });
  }

  var navbar_menu_visible = 0;
  $(".sidenav-toggler").click(function () {
    if (navbar_menu_visible == 1) {
      $('body').removeClass('nav-open');
      navbar_menu_visible = 0;
      $('.bodyClick').remove();
    } else {
      var div = '<div class="bodyClick"></div>';
      $(div).appendTo('body').click(function () {
        $('body').removeClass('nav-open');
        navbar_menu_visible = 0;
        $('.bodyClick').remove();
      });
      $('body').addClass('nav-open');
      navbar_menu_visible = 1;
    }
  });
}(); //
// Popover
//


'use strict';

var Popover = function () {
  // Variables
  var $popover = $('[data-toggle="popover"]'),
      $popoverClass = ''; // Methods

  function init($this) {
    if ($this.data('color')) {
      $popoverClass = 'popover-' + $this.data('color');
    }

    var options = {
      trigger: 'focus',
      template: '<div class="popover ' + $popoverClass + '" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
    };
    $this.popover(options);
  } // Events


  if ($popover.length) {
    $popover.each(function () {
      init($(this));
    });
  }
}(); //
// Scroll to (anchor links)
//


'use strict';

var ScrollTo = function () {
  //
  // Variables
  //
  var $scrollTo = $('.scroll-me, [data-scroll-to], .toc-entry a'); //
  // Methods
  //

  function scrollTo($this) {
    var $el = $this.attr('href');
    var offset = $this.data('scroll-to-offset') ? $this.data('scroll-to-offset') : 0;
    var options = {
      scrollTop: $($el).offset().top - offset
    }; // Animate scroll to the selected section

    $('html, body').stop(true, true).animate(options, 600);
    event.preventDefault();
  } //
  // Events
  //


  if ($scrollTo.length) {
    $scrollTo.on('click', function (event) {
      scrollTo($(this));
    });
  }
}(); //
// Tooltip
//


'use strict';

var Tooltip = function () {
  // Variables
  var $tooltip = $('[data-toggle="tooltip"]'); // Methods

  function init() {
    $tooltip.tooltip();
  } // Events


  if ($tooltip.length) {
    init();
  }
}(); //
// Form control
//


'use strict';

var FormControl = function () {
  // Variables
  var $input = $('.form-control'); // Methods

  function init($this) {
    $this.on('focus blur', function (e) {
      $(this).parents('.form-group').toggleClass('focused', e.type === 'focus');
    }).trigger('blur');
  } // Events


  if ($input.length) {
    init($input);
  }
}(); //
// Bootstrap Datepicker
//


'use strict';

var Datepicker = function () {
  // Variables
  var $datepicker = $('.datepicker'); // Methods

  function init($this) {
    var options = {
      disableTouchKeyboard: true,
      autoclose: false
    };
    $this.datepicker(options);
  } // Events


  if ($datepicker.length) {
    $datepicker.each(function () {
      init($(this));
    });
  }
}(); //
// Form control
//


'use strict';

var noUiSlider = function () {
  // Variables
  // var $sliderContainer = $('.input-slider-container'),
  // 		$slider = $('.input-slider'),
  // 		$sliderId = $slider.attr('id'),
  // 		$sliderMinValue = $slider.data('range-value-min');
  // 		$sliderMaxValue = $slider.data('range-value-max');;
  // // Methods
  //
  // function init($this) {
  // 	$this.on('focus blur', function(e) {
  //       $this.parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
  //   }).trigger('blur');
  // }
  //
  //
  // // Events
  //
  // if ($input.length) {
  // 	init($input);
  // }
  if ($(".input-slider-container")[0]) {
    $('.input-slider-container').each(function () {
      var slider = $(this).find('.input-slider');
      var sliderId = slider.attr('id');
      var minValue = slider.data('range-value-min');
      var maxValue = slider.data('range-value-max');
      var sliderValue = $(this).find('.range-slider-value');
      var sliderValueId = sliderValue.attr('id');
      var startValue = sliderValue.data('range-value-low');
      var c = document.getElementById(sliderId),
          d = document.getElementById(sliderValueId);
      noUiSlider.create(c, {
        start: [parseInt(startValue)],
        connect: [true, false],
        //step: 1000,
        range: {
          'min': [parseInt(minValue)],
          'max': [parseInt(maxValue)]
        }
      });
      c.noUiSlider.on('update', function (a, b) {
        d.textContent = a[b];
      });
    });
  }

  if ($("#input-slider-range")[0]) {
    var c = document.getElementById("input-slider-range"),
        d = document.getElementById("input-slider-range-value-low"),
        e = document.getElementById("input-slider-range-value-high"),
        f = [d, e];
    noUiSlider.create(c, {
      start: [parseInt(d.getAttribute('data-range-value-low')), parseInt(e.getAttribute('data-range-value-high'))],
      connect: !0,
      range: {
        min: parseInt(c.getAttribute('data-range-value-min')),
        max: parseInt(c.getAttribute('data-range-value-max'))
      }
    }), c.noUiSlider.on("update", function (a, b) {
      f[b].textContent = a[b];
    });
  }
}(); //
// Scrollbar
//


'use strict';

var Scrollbar = function () {
  // Variables
  var $scrollbar = $('.scrollbar-inner'); // Methods

  function init() {
    $scrollbar.scrollbar().scrollLock();
  } // Events


  if ($scrollbar.length) {
    init();
  }
}();

/***/ }),

/***/ "./resources/sass/argon.scss":
/*!***********************************!*\
  !*** ./resources/sass/argon.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/extensions.scss":
/*!****************************************!*\
  !*** ./resources/sass/extensions.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**************************************************************************************************!*\
  !*** multi ./resources/js/argon.js ./resources/sass/argon.scss ./resources/sass/extensions.scss ***!
  \**************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/Ludow/Documents/projets-externes/pixelizer/resources/js/argon.js */"./resources/js/argon.js");
__webpack_require__(/*! /Users/Ludow/Documents/projets-externes/pixelizer/resources/sass/argon.scss */"./resources/sass/argon.scss");
module.exports = __webpack_require__(/*! /Users/Ludow/Documents/projets-externes/pixelizer/resources/sass/extensions.scss */"./resources/sass/extensions.scss");


/***/ })

/******/ });