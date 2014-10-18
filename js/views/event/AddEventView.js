/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: AddEventView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/event/AddEventTpl.tpl',
    'js/models/event/EventModel'
], function($, _, Backbone, AddEventTpl, EventModel) {

    var AddEventView = Backbone.View.extend({

        template: _.template(AddEventTpl),

        className: "page-event-cnt",

        events: {
            'click .add-btn': 'onSaveEvent'
        },


        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.render();
        },

        render: function() {

            this.$el.html(this.template());
        },

        onSaveEvent: function() {
            var eventModel = new EventModel();
            eventModel.save({
                "ngoID": KAPP.user.id,

                "eventTitle": this.$('#txt-ngo-name').val(),

                "eventDesc": this.$('#txt-input-desc').val(),

                "eventDate": "",

                "eventTime": "",

                "eventVenueDesc": "",

                "eventVenueLatitude": "",

                "eventVenueLongitude": "",

            }, {
                success: function(response) {
                    KAPP.router.navigate('profile', {
                        trigger: true
                    });
                }
            });
        }

    });

    return AddEventView;
});