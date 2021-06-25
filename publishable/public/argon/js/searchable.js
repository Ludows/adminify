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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/searchable.js":
/*!************************************!*\
  !*** ./resources/js/searchable.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(document).ready(function ($) {
  var modale = $('#globalSearch');
  var appendSearchable = $('#appendSearchable');

  if (modale.length > 0) {
    var generateHtml = function generateHtml(data, labels) {
      var k = Object.keys(data);
      var st = "<div class=\"list-group list-group-flush\">";

      if (k.length > 0) {
        console.log(data);
        $.each(k, function (i, localKey) {
          st += "".concat(data[localKey].length, " entit\xE9 trouv\xE9e").concat(data[localKey].length > 1 ? 's' : '', " pour ").concat(localKey, "<br>");
          $.each(data[localKey], function (i, item) {
            st += "<a href=\"".concat(item.url, "\" class=\"list-group-item list-group-item-action\">\n                                ").concat(item[labels[localKey]], "\n                              </a>");
          });
        });
      }

      st += "</div>";
      return st;
    };

    var input = modale.find('#js-search-entity');
    var handler = $('.js-search-btn');
    console.log(handler, input);
    handler.on('click', function (e) {
      e.preventDefault();
      modale.modal('show');
    });
    input.on('keyup', function (e) {
      console.log('change');

      if (input.val().length > 2) {
        console.log(Route('searchable'), input.val());
        $.ajax({
          'method': 'POST',
          'url': Route('searchable'),
          'dataType': 'json',
          'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          'data': {
            'query': input.val()
          }
        }).done(function (data) {
          appendSearchable.html('');

          if (Object.keys(data.response).length > 0) {
            var $html = generateHtml(data.response, data.labels);
            appendSearchable.append($html);
          }
        }).fail(function (err) {
          console.log(err);
        });
      }

      if (input.val().length < 3) {
        appendSearchable.html('');
      }
    });
    modale.on('hide.bs.modal', function () {
      input.val('');
    });
  }
});

/***/ }),

/***/ 3:
/*!******************************************!*\
  !*** multi ./resources/js/searchable.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/Ludow/Documents/projets-externes/pixelizer/resources/js/searchable.js */"./resources/js/searchable.js");


/***/ })

/******/ });