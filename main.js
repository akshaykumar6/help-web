/**
 * @author: Akshay Sharma <sharmakumar3092@gmail.com>
 *
 * @since: 11 Oct, 2014
 * @file: main.js
 *
 **/

/**
 * FILE DESCRIPTION
 *
 * Main.js is the first point of contact after require.js is downloaded
 * There are many plugins included in this file. Please find their description below
 * (TODO: update this section if you use any other plugins)
 *
 * jquery                   : cross browser javascript library to simplify client-side scripting
 * underscore               : utility functions library
 * backbone                 : MV* framework for javascript
 * bootstrap                : CSS framework
 * text                     : A RequireJS/AMD loader plugin for loading text resources
 
 *
 * How to remove a plugin?
 *  --  remove an unwanted plugin by commenting corresponding row (in 'paths' or 'shim' under require.config)
 *
 **/

require.config({
    'paths': {
        'jquery': 'com/ext/jquery/jquery-2.1.1.min',
        'underscore': 'com/ext/underscore/underscore-min',
        'backbone': 'com/ext/backbone/backbone-min',
        'bootstrap': 'com/ext/bootstrap/js/bootstrap.min',
        'text': 'com/ext/require/text',
        'nprogress': 'com/ext/nprogress/nprogress'
    },
    'shim': {
        'underscore': {
            exports: '_'
        },

        'backbone': {
            deps: ['jquery', 'underscore'],
            exports: 'Backbone'
        },

        'bootstrap': {
            deps: ['jquery'],
            exports: 'bootstrap'
        },

        'jquery': {
            exports: 'jquery'
        },

        'nprogress': {
            exports: 'nprogress'
        }
    }
});

require([
    'jquery',
    'underscore',
    'backbone',
    'bootstrap',
    'js/routers/AppRouter',
    'nprogress'
], function($, _, Backbone, Bootstrap, AppRouter, NProgress) {

    $(document).ready(function() {
        APP = {};
        APP.router = new AppRouter();
        Backbone.history.start();
    });

    Backbone.View.prototype._childViews = [];
    Backbone.View.prototype.close = function() {
        this.remove();
        this.unbind();
        if (this._childViews) {
            _.each(this._childViews, function(childView) {
                if (childView.close) {
                    childView.close();
                }
            });
        }
    };


});