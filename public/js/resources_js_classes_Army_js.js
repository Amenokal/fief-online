"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_classes_Army_js"],{

/***/ "./resources/js/classes/Army.js":
/*!**************************************!*\
  !*** ./resources/js/classes/Army.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ArmyManager": () => (/* binding */ ArmyManager)
/* harmony export */ });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var ArmyManager = /*#__PURE__*/function () {
  function ArmyManager() {
    _classCallCheck(this, ArmyManager);
  }

  _createClass(ArmyManager, null, [{
    key: "movingArmy",
    value: function movingArmy() {
      return document.querySelectorAll('.moving-army>.army-forces>.sergeant-container>*, .moving-army>.army-forces>.knight-container>*, .moving-army>.lord-forces>*');
    }
  }]);

  return ArmyManager;
}();

/***/ })

}]);