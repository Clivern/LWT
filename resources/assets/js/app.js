var lwt_app = lwt_app || {};


/**
 * Layout Configs
 */
lwt_app.layout = (function (window, document, $) {

    'use strict';

    var base = {

        el: {

        },

        init: function(){
            $('select.dropdown').dropdown();
            $(document).ajaxStart(function() {
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

})(window, document, jQuery);


/**
 * Login Action
 */
lwt_app.login = (function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form : $("form#login_form"),
            submitButt : $("form#login_form button[type='submit']"),
        },
        init: function(){
            if( base.el.form.length ){
                base.submit();
            }
        },
        submit : function(){
            base.el.form.on("submit", base.handler);
        },
        handler: function(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function(){
                $.post(base.el.form.attr('action'), base.data(), function( response, textStatus, jqXHR ){
                    if( jqXHR.status == 200 && textStatus == 'success' ) {
                        if( response.success ){
                            base.store('api_token', response.payload.api_token);
                            base.store('api_token_expire', response.payload.api_token_expire);
                            base.success(response.messages);
                        }else{
                            base.error(response.messages);
                        }
                    }
                }, 'json');
            });
        },
        data : function(){
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function(item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success : function(messages){
            location.reload();
            for(var messageObj of messages) {
                toastr.success(messageObj.message);
                break;
            }

        },
        error : function(messages){
            base.el.form.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.error(messageObj.message);
                break;
            }
        },
        store: function(key, value){
            Cookies.set(key, value);
        },
        get: function(key){
            return Cookies.get(key);
        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


/**
 * Update Profile Action
 */
lwt_app.profile = (function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form : $("form#profile_form"),
            submitButt : $("form#profile_form button[type='submit']"),
        },
        init: function(){
            if( base.el.form.length ){
                base.submit();
            }
        },
        submit : function(){
            base.el.form.on("submit", base.handler);
        },
        handler: function(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function(){
                $.ajax({
                    url: base.el.form.attr('action') + '?api_token=' + base.get('api_token'),
                    type: "PUT",
                    data: base.data(),
                    success: function(response) {
                        if( response.success ){
                            base.success(response.messages);
                        }else{
                            base.error(response.messages);
                        }
                    }
                });
            });
        },
        data : function(){
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function(item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success : function(messages){
            base.el.form.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.success(messageObj.message);
                break;
            }

        },
        error : function(messages){
            base.el.form.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.error(messageObj.message);
                break;
            }
        },
        store: function(key, value){
            Cookies.set(key, value);
        },
        get: function(key){
            return Cookies.get(key);
        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


/**
 * Add Server Action
 */
lwt_app.add_server = (function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form : $("form#server_add_form"),
            submitButt : $("form#server_add_form button[type='submit']"),
            redirectUrl: $("form#server_add_form input[name='redirect']"),
        },
        init: function(){
            if( base.el.form.length ){
                base.submit();
            }
        },
        submit : function(){
            base.el.form.on("submit", base.handler);
        },
        handler: function(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function(){
                $.ajax({
                    url: base.el.form.attr('action') + '?api_token=' + base.get('api_token'),
                    type: "POST",
                    data: base.data(),
                    success: function(response) {
                        if( response.success ){
                            base.success(response.messages);
                        }else{
                            base.error(response.messages);
                        }
                    }
                });
            });
        },
        data : function(){
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function(item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success : function(messages){
            base.el.form.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.success(messageObj.message);
                break;
            }
            if( base.el.redirectUrl.length ){
                window.location = base.el.redirectUrl.val();
            }
        },
        error : function(messages){
            base.el.form.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.error(messageObj.message);
                break;
            }
        },
        store: function(key, value){
            Cookies.set(key, value);
        },
        get: function(key){
            return Cookies.get(key);
        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


/**
 * Add Server Ram Action
 */
lwt_app.add_server_ram = (function (window, document, $) {

    'use strict';

    var base = {

        el: {
            form : $("form#server_ram_add_form"),
            submitButt : $("form#server_ram_add_form button[type='submit']"),
        },
        init: function(){
            if( base.el.form.length ){
                base.submit();
            }
        },
        submit : function(){
            base.el.form.on("submit", base.handler);
        },
        handler: function(event) {
            event.preventDefault();
            base.el.form.addClass('loading');
            Pace.track(function(){
                $.ajax({
                    url: base.el.form.attr('action') + '?api_token=' + base.get('api_token'),
                    type: "POST",
                    data: base.data(),
                    success: function(response) {
                        if( response.success ){
                            base.success(response.messages);
                        }else{
                            base.error(response.messages);
                        }
                    }
                });
            });
        },
        data : function(){
            var inputs = {};
            inputs['csrf_token'] = $('meta[name="csrf-token"]').attr('content');
            base.el.form.serializeArray().map(function(item, index) {
                inputs[item.name] = item.value;
            });
            return inputs;
        },
        success : function(messages){
            base.el.form.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.success(messageObj.message);
                break;
            }
            location.reload();
        },
        error : function(messages){
            base.el.form.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.error(messageObj.message);
                break;
            }
        },
        store: function(key, value){
            Cookies.set(key, value);
        },
        get: function(key){
            return Cookies.get(key);
        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


/**
 * Delete Server Ram
 */
lwt_app.delete_server_ram = (function (window, document, $) {

    'use strict';

    var base = {

        el: {
            deleteButt: $('a.ram_delete'),
        },
        init: function(){
            if( base.el.deleteButt.length ){
                base.submit();
            }
        },
        submit : function(){
            base.el.deleteButt.on("click", base.handler);
        },
        handler: function(event) {
            event.preventDefault();
            $('.ram_delete_modal').modal({
                closable  : false,
                onDeny    : function(){},
                onApprove : function() {

                    base.el.deleteButt.addClass('loading');
                    Pace.track(function(){
                        $.ajax({
                            url: base.el.deleteButt.attr('data-target') + '?api_token=' + base.get('api_token') + '&csrf_token=' + $('meta[name="csrf-token"]').attr('content'),
                            type: "DELETE",
                            data: base.data(),
                            success: function(response) {
                                if( response.success ){
                                    base.success(response.messages);
                                }else{
                                    base.error(response.messages);
                                }
                            }
                        });
                    });

                }
              }).modal('show');
        },
        data : function(){
            var inputs = {};
            return inputs;
        },
        success : function(messages){
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.success(messageObj.message);
                break;
            }
            location.reload();
        },
        error : function(messages){
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.error(messageObj.message);
                break;
            }
        },
        store: function(key, value){
            Cookies.set(key, value);
        },
        get: function(key){
            return Cookies.get(key);
        }
    };

   return {
        init: base.init
    };

})(window, document, jQuery);


/**
 * Delete Server Action
 */
lwt_app.delete_server = (function (window, document, $) {

    'use strict';

    var base = {

        el: {
            deleteButt: $('a.server_delete'),
        },
        init: function(){
            if( base.el.deleteButt.length ){
                base.submit();
            }
        },
        submit : function(){
            base.el.deleteButt.on("click", base.handler);
        },
        handler: function(event) {
            event.preventDefault();
            $('.server_delete_modal').modal({
                closable  : false,
                onDeny    : function(){},
                onApprove : function() {
                    base.el.deleteButt.addClass('loading');
                    Pace.track(function(){
                        $.ajax({
                            url: base.el.deleteButt.attr('data-target') + '?api_token=' + base.get('api_token') + '&csrf_token=' + $('meta[name="csrf-token"]').attr('content'),
                            type: "DELETE",
                            data: base.data(),
                            success: function(response) {
                                if( response.success ){
                                    base.success(response.messages);
                                }else{
                                    base.error(response.messages);
                                }
                            }
                        });
                    });

                }
              }).modal('show');
        },
        data : function(){
            var inputs = {};
            return inputs;
        },
        success : function(messages){
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.success(messageObj.message);
                break;
            }
            window.location = base.el.deleteButt.attr('data-redirect');
        },
        error : function(messages){
            base.el.deleteButt.removeClass('loading');
            toastr.clear();
            for(var messageObj of messages) {
                toastr.error(messageObj.message);
                break;
            }
        },
        store: function(key, value){
            Cookies.set(key, value);
        },
        get: function(key){
            return Cookies.get(key);
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
    lwt_app.add_server.init();
    lwt_app.add_server_ram.init();
    lwt_app.delete_server_ram.init();
    lwt_app.delete_server.init();
});