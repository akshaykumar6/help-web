/**
 * @author: Varuni Ganesan
 *
 * @since: 19 May, 2014
 * @file: BaseView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'nprogress',
    'text!js/templates/base/BaseTpl.tpl',
    'js/views/header/HeaderView',
    'js/views/home/HomeView',
    'js/views/profile/ProfileView'
], function($, _, Backbone, NProgress, BaseTpl, HeaderView, HomeView, ProfileView) {

    var BaseView = Backbone.View.extend({

        template: _.template(BaseTpl),

        id: "wrapper",

        initialize: function(options) {

            _.bindAll(this, 'close',
                'render');
            NProgress.start();
            this._childViews = [];
            this.options = options;
            this.render();
        },

        close: function() {

            this.remove();
            this.unbind();

            // remove all the child views
            _.each(this._childViews, function(childView) {
                if (childView.close) {
                    childView.close();
                }
            });
        },

        render: function() {

            this.$el.html(this.template());

            this.headerView = new HeaderView({
                userModel: this.options.userModel
            });
            this.$('.main-header').html(this.headerView.el);
            this._childViews.push(this.headerView);

        },

        renderHomeScreen: function() {
            if (this.homeView) {
                this.homeView.close();
            }
            this.homeView = new HomeView();
            this.$('.wrapper').html(this.homeView.el);
            this._childViews.push(this.homeView);
            NProgress.done();
        },

        renderProfileScreen: function() {
            if (!this.profileView) {
                this.profileView = new ProfileView();
                this.$('.wrapper').html(this.profileView.el);
                this._childViews.push(this.profileView);
                NProgress.done();
            }

        }

    });

    return BaseView;
});