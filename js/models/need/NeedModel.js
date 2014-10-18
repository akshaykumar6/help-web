define([
    'jquery',
    'underscore',
    'backbone'
], function($, _, Backbone) {

    var NeedModel = Backbone.Model.extend({

        urlRoot: 'api/public/need',

        defaults: {},

        idAttribute: "ngoNeedID",

        getAllNeeds: function(user_id, callback) {
            var tempUrl = this.urlRoot;
            this.urlRoot = tempUrl + '/all/' + user_id;
            this.fetch({
                success: _.bind(function(response) {
                    callback(response);
                }, this),
                error: function(response) {

                }
            })
        }
    });

    return NeedModel;
});