/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/army.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "drawAll": () => (/* binding */ drawAll)
/* harmony export */ });
// CUSTOM CANVAS BANNERS !!!
function drawAll(power) {
  document.querySelectorAll('.lord-banner').forEach(function (el) {
    draw(el, power);
  });
}

function get(what) {
  return window.getComputedStyle(document.documentElement, null).getPropertyValue('--' + what);
}

function draw(target) {
  var power = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
  var elm = document.querySelector('.game-view').className.split(' ')[1].split('-')[0];
  var baseColor = get(elm);
  var strongColor = get(elm + '-strong');
  var txtColor = get(elm + '-txt');
  var cvs = target;
  var ctx = cvs.getContext('2d'); // MANCHE

  ctx.fillStyle = 'rgb(58, 28, 0)';
  ctx.fillRect(cvs.width / 2 - 4, 0, 8, cvs.height);
  ctx.fillRect(cvs.width / 15, cvs.height / 14.5, cvs.width * .87, cvs.height / 20); // ATTACHES

  ctx.strokeStyle = 'black';
  ctx.beginPath();
  ctx.moveTo(cvs.width / 2, cvs.height / 40);
  ctx.lineTo(cvs.height / 10, cvs.width / 9);
  ctx.closePath();
  ctx.stroke();
  ctx.strokeStyle = 'black';
  ctx.beginPath();
  ctx.moveTo(cvs.width / 2, cvs.height / 40);
  ctx.lineTo(cvs.width * .85, cvs.width / 9);
  ctx.closePath();
  ctx.stroke(); // BORDER

  ctx.fillStyle = strongColor;
  ctx.beginPath();
  ctx.moveTo(cvs.width / 10, cvs.width / 10);
  ctx.lineTo(cvs.width / 10, cvs.height / 1.4);
  ctx.lineTo(cvs.width / 2, cvs.height / 1.13);
  ctx.lineTo(cvs.width * (9 / 10), cvs.height / 1.4);
  ctx.lineTo(cvs.width * (9 / 10), cvs.width / 10);
  ctx.closePath();
  ctx.fill(); // BASE

  ctx.fillStyle = baseColor;
  ctx.beginPath();
  ctx.moveTo(cvs.width / 5, cvs.width / 5);
  ctx.lineTo(cvs.width / 5, cvs.height / 1.48);
  ctx.lineTo(cvs.width / 2, cvs.height / 1.23);
  ctx.lineTo(cvs.width * (4 / 5), cvs.height / 1.48);
  ctx.lineTo(cvs.width * (4 / 5), cvs.width / 5);
  ctx.closePath();
  ctx.fill(); // 2ND COLOR

  ctx.fillStyle = txtColor;
  ctx.beginPath();
  ctx.moveTo(cvs.width / 5, cvs.width / 5);
  ctx.lineTo(cvs.width / 5, cvs.height / 1.48);
  ctx.lineTo(cvs.width / 2, cvs.height / 1.23);
  ctx.lineTo(cvs.width / 2, cvs.height / 1.48);
  ctx.lineTo(cvs.width / 2, cvs.width / 5);
  ctx.closePath();
  ctx.fill(); // CHEVRONS

  ctx.fillStyle = strongColor;

  for (var i = 0; i < power; i++) {
    ctx.beginPath();
    ctx.moveTo(cvs.width / 5, cvs.height / 6 + 70 * i - 15);
    ctx.lineTo(cvs.width / 5, cvs.height / 6 + 40 + 70 * i - 15);
    ctx.lineTo(cvs.width / 2, cvs.height / 3.3 + 40 + 70 * i - 15);
    ctx.lineTo(cvs.width * .8, cvs.height / 6 + 40 + 70 * i - 15);
    ctx.lineTo(cvs.width * .8, cvs.height / 6 + 70 * i - 15);
    ctx.lineTo(cvs.width / 2, cvs.height / 3.3 + 70 * i - 15);
    ctx.closePath();
    ctx.fill();
  } // ARMOIRIES
  // var img = new Image;
  // img.src = "/fief/storage/app/public/banners/blue.png";
  // img.width = '20%';
  // img.height = '20%';
  // img.onload = ()=>{
  //     ctx.drawImage(img, 75, 75, 100, 100);
  // }

}
/******/ })()
;