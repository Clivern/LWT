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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
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
/******/ 	__webpack_require__.p = "/build/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./resources/assets/js/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/app.js":
/***/ (function(module, exports) {

var lwt_app = lwt_app || {};

/**
 * Layout Configs
 */
lwt_app.layout = function (window, document, $) {

    'use strict';

    var base = {

        el: {},

        init: function init() {
            $('select.dropdown').dropdown();
            $(document).ajaxStart(function () {
                Pace.restart();
            });
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "10000",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        }
    };

    return {
        init: base.init
    };
}(window, document, jQuery);

/**
 * Login Action
 */
lwt_app.login = function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form: $("form#login_form"),
            submitButt: $("form#login_form button[type='submit']")
        },
        init: function init() {
            if (base.el.form.length) {
                base.submit();
            }
        },
        submit: function submit() {
            base.el.form.on("submit", base.handler);
        },
        handler: function handler(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function () {
                $.post(base.el.form.attr('action'), base.data(), function (response, textStatus, jqXHR) {
                    if (jqXHR.status == 200 && textStatus == 'success') {
                        if (response.success) {
                            base.store('api_token', response.payload.api_token);
                            base.store('api_token_expire', response.payload.api_token_expire);
                            base.success(response.messages);
                        } else {
                            base.error(response.messages);
                        }
                    }
                }, 'json');
            });
        },
        data: function data() {
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function (item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success: function success(messages) {
            location.reload();
            var _iteratorNormalCompletion = true;
            var _didIteratorError = false;
            var _iteratorError = undefined;

            try {
                for (var _iterator = messages[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                    var messageObj = _step.value;

                    toastr.success(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError = true;
                _iteratorError = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion && _iterator.return) {
                        _iterator.return();
                    }
                } finally {
                    if (_didIteratorError) {
                        throw _iteratorError;
                    }
                }
            }
        },
        error: function error(messages) {
            base.el.form.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion2 = true;
            var _didIteratorError2 = false;
            var _iteratorError2 = undefined;

            try {
                for (var _iterator2 = messages[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
                    var messageObj = _step2.value;

                    toastr.error(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError2 = true;
                _iteratorError2 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion2 && _iterator2.return) {
                        _iterator2.return();
                    }
                } finally {
                    if (_didIteratorError2) {
                        throw _iteratorError2;
                    }
                }
            }
        },
        store: function store(key, value) {
            Cookies.set(key, value);
        },
        get: function get(key) {
            return Cookies.get(key);
        }
    };

    return {
        init: base.init
    };
}(window, document, jQuery);

/**
 * Update Profile Action
 */
lwt_app.profile = function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form: $("form#profile_form"),
            submitButt: $("form#profile_form button[type='submit']")
        },
        init: function init() {
            if (base.el.form.length) {
                base.submit();
            }
        },
        submit: function submit() {
            base.el.form.on("submit", base.handler);
        },
        handler: function handler(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function () {
                $.ajax({
                    url: base.el.form.attr('action') + '?api_token=' + base.get('api_token'),
                    type: "PUT",
                    data: base.data(),
                    success: function success(response) {
                        if (response.success) {
                            base.success(response.messages);
                        } else {
                            base.error(response.messages);
                        }
                    }
                });
            });
        },
        data: function data() {
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function (item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success: function success(messages) {
            base.el.form.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion3 = true;
            var _didIteratorError3 = false;
            var _iteratorError3 = undefined;

            try {
                for (var _iterator3 = messages[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                    var messageObj = _step3.value;

                    toastr.success(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError3 = true;
                _iteratorError3 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion3 && _iterator3.return) {
                        _iterator3.return();
                    }
                } finally {
                    if (_didIteratorError3) {
                        throw _iteratorError3;
                    }
                }
            }
        },
        error: function error(messages) {
            base.el.form.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion4 = true;
            var _didIteratorError4 = false;
            var _iteratorError4 = undefined;

            try {
                for (var _iterator4 = messages[Symbol.iterator](), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
                    var messageObj = _step4.value;

                    toastr.error(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError4 = true;
                _iteratorError4 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion4 && _iterator4.return) {
                        _iterator4.return();
                    }
                } finally {
                    if (_didIteratorError4) {
                        throw _iteratorError4;
                    }
                }
            }
        },
        store: function store(key, value) {
            Cookies.set(key, value);
        },
        get: function get(key) {
            return Cookies.get(key);
        }
    };

    return {
        init: base.init
    };
}(window, document, jQuery);

/**
 * Add Server Action
 */
lwt_app.add_server = function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form: $("form#server_add_form"),
            submitButt: $("form#server_add_form button[type='submit']"),
            redirectUrl: $("form#server_add_form input[name='redirect']")
        },
        init: function init() {
            if (base.el.form.length) {
                base.submit();
            }
        },
        submit: function submit() {
            base.el.form.on("submit", base.handler);
        },
        handler: function handler(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function () {
                $.ajax({
                    url: base.el.form.attr('action') + '?api_token=' + base.get('api_token'),
                    type: "POST",
                    data: base.data(),
                    success: function success(response) {
                        if (response.success) {
                            base.success(response.messages);
                        } else {
                            base.error(response.messages);
                        }
                    }
                });
            });
        },
        data: function data() {
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function (item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success: function success(messages) {
            base.el.form.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion5 = true;
            var _didIteratorError5 = false;
            var _iteratorError5 = undefined;

            try {
                for (var _iterator5 = messages[Symbol.iterator](), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {
                    var messageObj = _step5.value;

                    toastr.success(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError5 = true;
                _iteratorError5 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion5 && _iterator5.return) {
                        _iterator5.return();
                    }
                } finally {
                    if (_didIteratorError5) {
                        throw _iteratorError5;
                    }
                }
            }

            if (base.el.redirectUrl.length) {
                window.location = base.el.redirectUrl.val();
            }
        },
        error: function error(messages) {
            base.el.form.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion6 = true;
            var _didIteratorError6 = false;
            var _iteratorError6 = undefined;

            try {
                for (var _iterator6 = messages[Symbol.iterator](), _step6; !(_iteratorNormalCompletion6 = (_step6 = _iterator6.next()).done); _iteratorNormalCompletion6 = true) {
                    var messageObj = _step6.value;

                    toastr.error(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError6 = true;
                _iteratorError6 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion6 && _iterator6.return) {
                        _iterator6.return();
                    }
                } finally {
                    if (_didIteratorError6) {
                        throw _iteratorError6;
                    }
                }
            }
        },
        store: function store(key, value) {
            Cookies.set(key, value);
        },
        get: function get(key) {
            return Cookies.get(key);
        }
    };

    return {
        init: base.init
    };
}(window, document, jQuery);

/**
 * Add Server Ram Action
 */
lwt_app.add_server_ram = function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form: $("form#server_ram_add_form"),
            submitButt: $("form#server_ram_add_form button[type='submit']")
        },
        init: function init() {
            if (base.el.form.length) {
                base.submit();
            }
        },
        submit: function submit() {
            base.el.form.on("submit", base.handler);
        },
        handler: function handler(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function () {
                $.ajax({
                    url: base.el.form.attr('action') + '?api_token=' + base.get('api_token'),
                    type: "POST",
                    data: base.data(),
                    success: function success(response) {
                        if (response.success) {
                            base.success(response.messages);
                        } else {
                            base.error(response.messages);
                        }
                    }
                });
            });
        },
        data: function data() {
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function (item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success: function success(messages) {
            base.el.form.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion7 = true;
            var _didIteratorError7 = false;
            var _iteratorError7 = undefined;

            try {
                for (var _iterator7 = messages[Symbol.iterator](), _step7; !(_iteratorNormalCompletion7 = (_step7 = _iterator7.next()).done); _iteratorNormalCompletion7 = true) {
                    var messageObj = _step7.value;

                    toastr.success(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError7 = true;
                _iteratorError7 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion7 && _iterator7.return) {
                        _iterator7.return();
                    }
                } finally {
                    if (_didIteratorError7) {
                        throw _iteratorError7;
                    }
                }
            }

            location.reload();
        },
        error: function error(messages) {
            base.el.form.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion8 = true;
            var _didIteratorError8 = false;
            var _iteratorError8 = undefined;

            try {
                for (var _iterator8 = messages[Symbol.iterator](), _step8; !(_iteratorNormalCompletion8 = (_step8 = _iterator8.next()).done); _iteratorNormalCompletion8 = true) {
                    var messageObj = _step8.value;

                    toastr.error(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError8 = true;
                _iteratorError8 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion8 && _iterator8.return) {
                        _iterator8.return();
                    }
                } finally {
                    if (_didIteratorError8) {
                        throw _iteratorError8;
                    }
                }
            }
        },
        store: function store(key, value) {
            Cookies.set(key, value);
        },
        get: function get(key) {
            return Cookies.get(key);
        }
    };

    return {
        init: base.init
    };
}(window, document, jQuery);

/**
 * Delete Server Ram
 */
lwt_app.delete_server_ram = function (window, document, $) {

    'use strict';

    var base = {

        el: {
            deleteButt: $('a.ram_delete')
        },
        init: function init() {
            if (base.el.deleteButt.length) {
                base.submit();
            }
        },
        submit: function submit() {
            base.el.deleteButt.on("click", base.handler);
        },
        handler: function handler(event) {
            event.preventDefault();
            $('.ram_delete_modal').modal({
                closable: false,
                onDeny: function onDeny() {},
                onApprove: function onApprove() {

                    base.el.deleteButt.addClass('loading');
                    Pace.track(function () {
                        $.ajax({
                            url: base.el.deleteButt.attr('data-target') + '?api_token=' + base.get('api_token') + '&csrf_token=' + $('meta[name="csrf-token"]').attr('content'),
                            type: "DELETE",
                            data: base.data(),
                            success: function success(response) {
                                if (response.success) {
                                    base.success(response.messages);
                                } else {
                                    base.error(response.messages);
                                }
                            }
                        });
                    });
                }
            }).modal('show');
        },
        data: function data() {
            var inputs = {};
            return inputs;
        },
        success: function success(messages) {
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion9 = true;
            var _didIteratorError9 = false;
            var _iteratorError9 = undefined;

            try {
                for (var _iterator9 = messages[Symbol.iterator](), _step9; !(_iteratorNormalCompletion9 = (_step9 = _iterator9.next()).done); _iteratorNormalCompletion9 = true) {
                    var messageObj = _step9.value;

                    toastr.success(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError9 = true;
                _iteratorError9 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion9 && _iterator9.return) {
                        _iterator9.return();
                    }
                } finally {
                    if (_didIteratorError9) {
                        throw _iteratorError9;
                    }
                }
            }

            location.reload();
        },
        error: function error(messages) {
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion10 = true;
            var _didIteratorError10 = false;
            var _iteratorError10 = undefined;

            try {
                for (var _iterator10 = messages[Symbol.iterator](), _step10; !(_iteratorNormalCompletion10 = (_step10 = _iterator10.next()).done); _iteratorNormalCompletion10 = true) {
                    var messageObj = _step10.value;

                    toastr.error(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError10 = true;
                _iteratorError10 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion10 && _iterator10.return) {
                        _iterator10.return();
                    }
                } finally {
                    if (_didIteratorError10) {
                        throw _iteratorError10;
                    }
                }
            }
        },
        store: function store(key, value) {
            Cookies.set(key, value);
        },
        get: function get(key) {
            return Cookies.get(key);
        }
    };

    return {
        init: base.init
    };
}(window, document, jQuery);

/**
 * Delete Server Action
 */
lwt_app.delete_server = function (window, document, $) {

    'use strict';

    var base = {

        el: {
            deleteButt: $('a.server_delete')
        },
        init: function init() {
            if (base.el.deleteButt.length) {
                base.submit();
            }
        },
        submit: function submit() {
            base.el.deleteButt.on("click", base.handler);
        },
        handler: function handler(event) {
            event.preventDefault();
            $('.server_delete_modal').modal({
                closable: false,
                onDeny: function onDeny() {},
                onApprove: function onApprove() {
                    base.el.deleteButt.addClass('loading');
                    Pace.track(function () {
                        $.ajax({
                            url: base.el.deleteButt.attr('data-target') + '?api_token=' + base.get('api_token') + '&csrf_token=' + $('meta[name="csrf-token"]').attr('content'),
                            type: "DELETE",
                            data: base.data(),
                            success: function success(response) {
                                if (response.success) {
                                    base.success(response.messages);
                                } else {
                                    base.error(response.messages);
                                }
                            }
                        });
                    });
                }
            }).modal('show');
        },
        data: function data() {
            var inputs = {};
            return inputs;
        },
        success: function success(messages) {
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion11 = true;
            var _didIteratorError11 = false;
            var _iteratorError11 = undefined;

            try {
                for (var _iterator11 = messages[Symbol.iterator](), _step11; !(_iteratorNormalCompletion11 = (_step11 = _iterator11.next()).done); _iteratorNormalCompletion11 = true) {
                    var messageObj = _step11.value;

                    toastr.success(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError11 = true;
                _iteratorError11 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion11 && _iterator11.return) {
                        _iterator11.return();
                    }
                } finally {
                    if (_didIteratorError11) {
                        throw _iteratorError11;
                    }
                }
            }

            window.location = base.el.deleteButt.attr('data-redirect');
        },
        error: function error(messages) {
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            var _iteratorNormalCompletion12 = true;
            var _didIteratorError12 = false;
            var _iteratorError12 = undefined;

            try {
                for (var _iterator12 = messages[Symbol.iterator](), _step12; !(_iteratorNormalCompletion12 = (_step12 = _iterator12.next()).done); _iteratorNormalCompletion12 = true) {
                    var messageObj = _step12.value;

                    toastr.error(messageObj.message);
                    break;
                }
            } catch (err) {
                _didIteratorError12 = true;
                _iteratorError12 = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion12 && _iterator12.return) {
                        _iterator12.return();
                    }
                } finally {
                    if (_didIteratorError12) {
                        throw _iteratorError12;
                    }
                }
            }
        },
        store: function store(key, value) {
            Cookies.set(key, value);
        },
        get: function get(key) {
            return Cookies.get(key);
        }
    };

    return {
        init: base.init
    };
}(window, document, jQuery);

jQuery(document).ready(function ($) {
    lwt_app.layout.init();
    lwt_app.login.init();
    lwt_app.profile.init();
    lwt_app.add_server.init();
    lwt_app.add_server_ram.init();
    lwt_app.delete_server_ram.init();
    lwt_app.delete_server.init();
});

/***/ })

/******/ });