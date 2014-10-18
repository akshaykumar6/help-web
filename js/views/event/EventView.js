/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: EventView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/event/EventTpl.tpl',
    'js/models/event/EventModel',
    'js/views/event/AddEventView'
], function($, _, Backbone, EventTpl, EventModel, AddNeedView) {

    var EventView = Backbone.View.extend({

        template: _.template(EventTpl),

        className: "page-event-cnt row",

        events: {
            'click .add-event-btn': 'onAddBtnClickEvent'
        },

        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.eventModel = new EventModel();
            this.eventModel.getAllEvents(KAPP.user.id, _.bind(function(model) {
                //console.log(model);
                this.render();
            }, this));

        },

        render: function() {

            this.$el.html(this.template({
                "events": this.eventModel.toJSON()
            }));
        },

        onAddBtnClickEvent: function() {
            var addView = new AddNeedView();
            this.$el.html(addView.el);
            this._childViews.push(addView);
        }

    });

    return EventView;
});