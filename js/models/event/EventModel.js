define([
    'jquery',
    'underscore',
    'backbone'
], function($, _, Backbone) {

    var EventModel = Backbone.Model.extend({

        urlRoot: 'api/public/event',

        defaults: {},

        idAttribute: "ngoEventID",

        getAllEvents: function(user_id, callback) {
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

    return EventModel;
});