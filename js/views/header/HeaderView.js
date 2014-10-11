/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: HeaderView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/header/HeaderTpl.tpl',
], function($, _, Backbone, HeaderTpl) {

    var HeaderView = Backbone.View.extend({

        template: _.template(HeaderTpl),

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

    return HeaderView;
});