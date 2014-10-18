/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: AccountView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/account/AccountTpl.tpl',
    'js/views/account/EditAccountView'
], function($, _, Backbone, AccountTpl, EditAccountView) {

    var AccountView = Backbone.View.extend({

        template: _.template(AccountTpl),

        className: "page-account-cnt",

        events: {
            'click .edit-profile-btn': 'onEditProfileClickEvent'
        },

        initialize: function(options) {

            _.bindAll(this, 'render');
            this._childViews = [];
            this.options = options;
            if (KAPP.user) {
                KAPP.user.fetch({
                    success: _.bind(function(response) {
                        console.log(KAPP.user);
                        this.render();
                    }, this),
                    error: function(response) {
                        console.log(response);
                    }
                });
            }


        },

        render: function() {

            this.$el.html(this.template(KAPP.user.toJSON()));
        },

        onEditProfileClickEvent: function(e) {
            e.preventDefault();
            KAPP.router.navigate('profile/edit', {
                trigger: true
            });
        },

        renderEditProfileView: function() {
            if (this.editView) {
                this.editView.close();
            }
            this.editView = new EditAccountView();
            this.$el.html(this.editView.el);
            this._childViews.push(this.editView);
        }

    });

    return AccountView;
});