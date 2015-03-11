/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: SidebarView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/sidebar/SidebarTpl.tpl',
], function($, _, Backbone, SidebarTpl) {

    var SidebarView = Backbone.View.extend({

        template: _.template(SidebarTpl),

        className: "page-sidebar-cnt",

        events: {
            "click .profile-item": "onProfileClickEvent",
            "click .events-item": "onEventClickEvent",
            "click .needs-item": "onNeedClickEvent",
            "click .sidebar-list-item": "onSideItemClickEvent"
        },

        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.render();
        },

        render: function() {

            this.$el.html(this.template());
        },

        onSideItemClickEvent: function(e) {
            e.preventDefault();
            this.$('.sidebar-list li').removeClass('active');
            $(e.target).addClass('active');
        },

        onProfileClickEvent: function(e) {
            e.preventDefault();
            KAPP.router.navigate('profile', {
                trigger: true
            });

        },
        onEventClickEvent: function(e) {
            e.preventDefault();
            KAPP.router.navigate('profile/event', {
                trigger: true
            });

        },
        onNeedClickEvent: function(e) {
            e.preventDefault();
            KAPP.router.navigate('profile/need', {
                trigger: true
            });

        },



    });

    return SidebarView;
});