define([
    'jquery',
    'underscore',
    'backbone'
], function($, _, Backbone) {

    var UserModel = Backbone.Model.extend({

        urlRoot: 'api/public/user',

        idAttribute: 'ngoUserID',

        defaults: {},

        login: function(username, password, callback) {
            var tempUrl = this.urlRoot;
            this.urlRoot = tempUrl + '/login';
            this.save({
                'ngoUserName': username,
                'password': password
            }, {
                success: _.bind(function(response) {
                    this.urlRoot = tempUrl;
                    callback(parseInt(response.get('success')));
                }, this),
                error: _.bind(function(response) {
                    this.urlRoot = tempUrl;
                    callback(parseInt(response.get('success')));
                }, this)
            });
        }
    });

    return UserModel;
});