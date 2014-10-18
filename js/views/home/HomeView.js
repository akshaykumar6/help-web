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
    'text!js/templates/home/HomeTpl.tpl',
    'js/models/user/UserModel'
], function($, _, Backbone, HomeTpl, UserModel) {

    var HomeView = Backbone.View.extend({

        template: _.template(HomeTpl),

        className: "home-cnt row",

        events: {
            'click .signin-btn': 'onSignInClickEvent',
            'click .signup-btn': 'onSignUpClickEvent'
        },


        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.render();
        },

        render: function() {

            this.$el.html(this.template());
        },

        onSignInClickEvent: function(e) {
            e.preventDefault();

            this.userModel = new UserModel();
            var username = _.escape(this.$('#txt-signin-email').val());
            var password = _.escape(this.$('#txt-signin-password').val());
            this.userModel.login(username, password, _.bind(function(isLoggedIn) {
                if (isLoggedIn) {
                    KAPP.user = this.userModel;
                    KAPP.router.navigate('profile', {
                        'trigger': true
                    });
                } else {
                    alert('Incorrect Username or Password.');
                }
            }, this));
        },

        onSignUpClickEvent: function(e) {
            e.preventDefault();

            this.userModel = new UserModel();
            var name = _.escape(this.$('#txt-ngo-name').val());
            var username = _.escape(this.$('#txt-signup-email').val());
            var password = _.escape(this.$('#txt-signup-password').val());
            this.userModel.save({
                "userName": username,

                "password": password,

                "ngoUserName": name,
            }, {
                success: _.bind(function(response) {
                    KAPP.user = this.userModel;
                    KAPP.router.navigate('profile', {
                        'trigger': true
                    });
                }, this),
                error: function(response) {
                    alert('Failed to sign up.');
                }
            })
        }


    });

    return HomeView;
});