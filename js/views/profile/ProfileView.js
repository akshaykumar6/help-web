/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: ProfileView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/profile/ProfileTpl.tpl',
    'js/views/sidebar/SidebarView',
    'js/views/account/AccountView',
    'js/models/event/EventModel',
    'js/views/event/EventView',
    'js/models/need/NeedModel',
    'js/views/need/NeedView',
    'js/models/user/UserModel'
], function($, _, Backbone, ProfileTpl, SidebarView, AccountView, EventModel, EventView,
    NeedModel, NeedView, UserModel) {

    var ProfileView = Backbone.View.extend({

        template: _.template(ProfileTpl),

        className: "page-profile-cnt row",

        events: {},


        initialize: function(options) {

            _.bindAll(this, 'render', 'renderAccountsScreen', 'renderEventsScreen', 'renderNeedsScreen');
            this._childViews = [];
            this.options = options;
            this.render();

        },

        render: function() {

            this.$el.html(this.template());
            if (!this.sidebarView) {
                this.sidebarView = new SidebarView();
                this.$('.sidebar-cnt').html(this.sidebarView.el);
                this._childViews.push(this.sidebarView);
            }

        },

        renderAccountsScreen: function() {
            if (this.screenView) {
                this.screenView.close();
            }
            this.screenView = new AccountView();
            this.$('.screen-cnt').html(this.screenView.el);
            this._childViews.push(this.screenView);
            $('.profile-item').addClass('active');
        },

        renderEventsScreen: function() {
            if (this.screenView) {
                this.screenView.close();
            }
            this.screenView = new EventView({
                model: new EventModel()
            });
            this.$('.screen-cnt').html(this.screenView.el);
            this._childViews.push(this.screenView);
            $('.sidebar-list li').removeClass('active');
            $('.events-item').addClass('active');
        },

        renderNeedsScreen: function() {
            if (this.screenView) {
                this.screenView.close();
            }
            this.screenView = new NeedView({
                model: new NeedModel()
            });
            this.$('.screen-cnt').html(this.screenView.el);
            this._childViews.push(this.screenView);
            $('.sidebar-list li').removeClass('active');
            $('.needs-item').addClass('active');
        }


    });

    return ProfileView;
});