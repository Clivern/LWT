var lwt_app = lwt_app || {};


lwt_app.layout = (function (window, document, $) {

    var base = {

        el: {

        },

        init: function(){
            $('select.dropdown').dropdown();
        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


lwt_app.login = (function (window, document, $) {

    var base = {

        el: {

        },

        init: function(){

        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


lwt_app.profile = (function (window, document, $) {

    var base = {

        el: {

        },

        init: function(){

        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


lwt_app.server = (function (window, document, $) {

    var base = {

        el: {

        },

        init: function(){

        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


jQuery(document).ready(function($){
    lwt_app.layout.init();
    lwt_app.login.init();
    lwt_app.profile.init();
    lwt_app.server.init();
});