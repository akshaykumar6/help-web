/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: HomeView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/header/HomeTpl.tpl',
], function($, _, Backbone, HomeTpl) {

    var HomeView = Backbone.View.extend({

        template: _.template(HomeTpl),

        className: "page-header-cnt",

        events: {},


        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.render();
        },

        render: function() {

            this.$el.html(this.template());
        }

    });

    return HomeView;
});