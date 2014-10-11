/**
 *
 * @author Varuni Ganesan
 *
 * @version 1
 * @copyright KNOLSKAPE Solutions PVT LTD
 * @since 16 May, 2014
 * @package default
 **/

/**
 * Application routes are registered here
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'js/models/base/BaseModel',
    'js/views/base/BaseView'
], function($, _, Backbone, BaseModel, BaseView) {

    var AppRouter = Backbone.Router.extend({


        // TODO: make sure that *notfound is the last route
        routes: {
            '': 'initApp',
            'register': 'showRegisterScreen'
        },

        initialize: function() {

            _.bindAll(this, 'initApp','showRegisterScreen');
        },

        initApp: function () {
            console.log("app");
            var baseView = new BaseView({
                model: new BaseModel()
            });

            $('#root').html(baseView.el); 
        },

        showRegisterScreen: function () {
            console.log("register");
        }

        
    });

    return AppRouter;
});