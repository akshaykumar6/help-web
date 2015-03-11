/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: EditEventViewView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'chosen',
    'text!js/templates/need/EditEventTpl.tpl',
], function($, _, Backbone, Chosen, EditEventViewTpl) {

    var EditEventView = Backbone.View.extend({

        template: _.template(EditEventViewTpl),

        className: "page-edit-cnt",

        events: {},


        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.render();
        },

        render: function() {

            this.$el.html(this.template());
            this.$('.chosen-select').chosen();
            //this.$('#txt-input-category').chosen();
        }

    });

    return EditEventView;
});