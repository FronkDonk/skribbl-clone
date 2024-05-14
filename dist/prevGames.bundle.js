/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./dist/prevGamesScripts.js":
/*!**********************************!*\
  !*** ./dist/prevGamesScripts.js ***!
  \**********************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.a(module, async (__webpack_handle_async_dependencies__, __webpack_async_result__) => { try {\n__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _src_js_profile_prevGames_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../src/js/profile/prevGames.js */ \"./src/js/profile/prevGames.js\");\n/* harmony import */ var _src_js_actions_getPrevGames_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../src/js/actions/getPrevGames.js */ \"./src/js/actions/getPrevGames.js\");\nvar __webpack_async_dependencies__ = __webpack_handle_async_dependencies__([_src_js_profile_prevGames_js__WEBPACK_IMPORTED_MODULE_0__]);\n_src_js_profile_prevGames_js__WEBPACK_IMPORTED_MODULE_0__ = (__webpack_async_dependencies__.then ? (await __webpack_async_dependencies__)() : __webpack_async_dependencies__)[0];\n\r\n\r\n\n__webpack_async_result__();\n} catch(e) { __webpack_async_result__(e); } });\n\n//# sourceURL=webpack://ecommerce-store/./dist/prevGamesScripts.js?");

/***/ }),

/***/ "./src/js/actions/getPrevGames.js":
/*!****************************************!*\
  !*** ./src/js/actions/getPrevGames.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   getPrevGames: () => (/* binding */ getPrevGames)\n/* harmony export */ });\nasync function getPrevGames() {\r\n  const res = await fetch(\"/api/getPrevGames\", {\r\n    method: \"GET\",\r\n  });\r\n  if (!res.ok) {\r\n    const data = await res.json();\r\n    console.log(`Error: ${data.message}`);\r\n    alert(data.message);\r\n  }\r\n  const { data } = await res.json();\r\n  return data;\r\n}\r\n\n\n//# sourceURL=webpack://ecommerce-store/./src/js/actions/getPrevGames.js?");

/***/ }),

/***/ "./src/js/profile/prevGames.js":
/*!*************************************!*\
  !*** ./src/js/profile/prevGames.js ***!
  \*************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.a(module, async (__webpack_handle_async_dependencies__, __webpack_async_result__) => { try {\n__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _actions_getPrevGames__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../actions/getPrevGames */ \"./src/js/actions/getPrevGames.js\");\n\r\n\r\nconst data = await (0,_actions_getPrevGames__WEBPACK_IMPORTED_MODULE_0__.getPrevGames)();\r\nconst table = document.getElementById(\"prevGames\");\r\nconsole.log(data);\r\ndata.map((game) => {\r\n  console.log(game.game_room.created_at);\r\n  console.log(game.game_room.num_rounds);\r\n  const date = new Date(game.game_room.created_at).toLocaleString();\r\n  const tr = `\r\n    <tr class=\"border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted\">\r\n      <td class=\"p-4 align-middle [&amp;:has([role=checkbox])]:pr-0\">Draw</td>\r\n      <td class=\"p-4 align-middle [&amp;:has([role=checkbox])]:pr-0\">${date}</td>\r\n      <td class=\"p-4 align-middle [&amp;:has([role=checkbox])]:pr-0\">1000</td>\r\n      <td class=\"p-4 align-middle [&amp;:has([role=checkbox])]:pr-0\">${\r\n        game.game_room.num_rounds\r\n      }</td>\r\n      <td class=\"p-4 align-middle [&amp;:has([role=checkbox])]:pr-0\">\r\n        <div class=\"flex items-center gap-2\">\r\n          ${game.players.map((player, i) => {\r\n            return `\r\n              <span class=\"relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full\">\r\n                <span class=\"flex text-muted h-full w-full items-center justify-center rounded-full bg-gradient-to-tr ${\r\n                  player.avatar\r\n                }\">P${i + 1}</span>\r\n              </span>\r\n              <span>${player.username}: ${player.score} points</span>\r\n            `;\r\n          })}\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  `;\r\n\r\n  table.insertAdjacentHTML(\"beforeend\", tr);\r\n});\r\n\n__webpack_async_result__();\n} catch(e) { __webpack_async_result__(e); } }, 1);\n\n//# sourceURL=webpack://ecommerce-store/./src/js/profile/prevGames.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/async module */
/******/ 	(() => {
/******/ 		var webpackQueues = typeof Symbol === "function" ? Symbol("webpack queues") : "__webpack_queues__";
/******/ 		var webpackExports = typeof Symbol === "function" ? Symbol("webpack exports") : "__webpack_exports__";
/******/ 		var webpackError = typeof Symbol === "function" ? Symbol("webpack error") : "__webpack_error__";
/******/ 		var resolveQueue = (queue) => {
/******/ 			if(queue && queue.d < 1) {
/******/ 				queue.d = 1;
/******/ 				queue.forEach((fn) => (fn.r--));
/******/ 				queue.forEach((fn) => (fn.r-- ? fn.r++ : fn()));
/******/ 			}
/******/ 		}
/******/ 		var wrapDeps = (deps) => (deps.map((dep) => {
/******/ 			if(dep !== null && typeof dep === "object") {
/******/ 				if(dep[webpackQueues]) return dep;
/******/ 				if(dep.then) {
/******/ 					var queue = [];
/******/ 					queue.d = 0;
/******/ 					dep.then((r) => {
/******/ 						obj[webpackExports] = r;
/******/ 						resolveQueue(queue);
/******/ 					}, (e) => {
/******/ 						obj[webpackError] = e;
/******/ 						resolveQueue(queue);
/******/ 					});
/******/ 					var obj = {};
/******/ 					obj[webpackQueues] = (fn) => (fn(queue));
/******/ 					return obj;
/******/ 				}
/******/ 			}
/******/ 			var ret = {};
/******/ 			ret[webpackQueues] = x => {};
/******/ 			ret[webpackExports] = dep;
/******/ 			return ret;
/******/ 		}));
/******/ 		__webpack_require__.a = (module, body, hasAwait) => {
/******/ 			var queue;
/******/ 			hasAwait && ((queue = []).d = -1);
/******/ 			var depQueues = new Set();
/******/ 			var exports = module.exports;
/******/ 			var currentDeps;
/******/ 			var outerResolve;
/******/ 			var reject;
/******/ 			var promise = new Promise((resolve, rej) => {
/******/ 				reject = rej;
/******/ 				outerResolve = resolve;
/******/ 			});
/******/ 			promise[webpackExports] = exports;
/******/ 			promise[webpackQueues] = (fn) => (queue && fn(queue), depQueues.forEach(fn), promise["catch"](x => {}));
/******/ 			module.exports = promise;
/******/ 			body((deps) => {
/******/ 				currentDeps = wrapDeps(deps);
/******/ 				var fn;
/******/ 				var getResult = () => (currentDeps.map((d) => {
/******/ 					if(d[webpackError]) throw d[webpackError];
/******/ 					return d[webpackExports];
/******/ 				}))
/******/ 				var promise = new Promise((resolve) => {
/******/ 					fn = () => (resolve(getResult));
/******/ 					fn.r = 0;
/******/ 					var fnQueue = (q) => (q !== queue && !depQueues.has(q) && (depQueues.add(q), q && !q.d && (fn.r++, q.push(fn))));
/******/ 					currentDeps.map((dep) => (dep[webpackQueues](fnQueue)));
/******/ 				});
/******/ 				return fn.r ? promise : getResult();
/******/ 			}, (err) => ((err ? reject(promise[webpackError] = err) : outerResolve(exports)), resolveQueue(queue)));
/******/ 			queue && queue.d < 0 && (queue.d = 0);
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./dist/prevGamesScripts.js");
/******/ 	
/******/ })()
;