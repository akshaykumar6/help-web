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

        routes: {
            '': 'showHomeScreen',
            'profile': 'showAccountsProfileScreen',
            'profile/edit': 'showEditProfileScreen',
            'profile/event': 'showEventScreen',
            'profile/event/edit': 'showEditEventScreen',
            'profile/need': 'showNeedScreen',
            'profile/need/edit': 'showEditNeedScreen'
        },

        initialize: function() {

            _.bindAll(this, 'showHomeScreen', 'showProfileScreen');
            this.baseView = new BaseView({
                model: new BaseModel()
            });

            $('#root').html(this.baseView.el);

        },

        showHomeScreen: function() {
            this.baseView.renderHomeScreen();
        },

        showProfileScreen: function() {
            this.baseView.renderProfileScreen();
        },

        showAccountsProfileScreen: function() {
            this.showProfileScreen();
            this.baseView.profileView.renderAccountsScreen();
        },

        showEditProfileScreen: function() {
            this.showProfileScreen();
            this.baseView.profileView.screenView.renderEditProfileView();
        },

        showEventScreen: function() {
            console.log(KAPP.user);
            this.showProfileScreen();
            this.baseView.profileView.renderEventsScreen();
        },

        showEditEventScreen: function() {
            // this.baseView.profileView.screenView.
        },

        showNeedScreen: function() {
            console.log(KAPP.user);
            this.showProfileScreen();
            this.baseView.profileView.renderNeedsScreen();
        },

        showEditNeedScreen: function() {
            // this.baseView.profileView.screenView.
        }


    });

    return AppRouter;
});