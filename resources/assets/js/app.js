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


jQuery(document).ready(function($){
    lwt_app.layout.init();
});