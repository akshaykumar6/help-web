/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: NeedView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/need/NeedTpl.tpl',
    'js/models/need/NeedModel',
    'js/views/need/AddNeedView'
], function($, _, Backbone, NeedTpl, NeedModel, AddNeedView) {

    var NeedView = Backbone.View.extend({

        template: _.template(NeedTpl),

        className: "page-need-cnt row",

        events: {
            'click .add-need-btn': 'onAddBtnClickEvent'
        },

        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.needModel = new NeedModel();
            this.needModel.getAllNeeds(KAPP.user.id, _.bind(function(model) {
                //console.log(model);
                this.render();
            }, this));
            //this.render();
        },

        render: function() {
            this.$el.html(this.template({
                "needs": this.needModel.toJSON()
            }));
        },

        onAddBtnClickEvent: function() {
            var addView = new AddNeedView();
            this.$el.html(addView.el);
            this._childViews.push(addView);
        }

    });

    return NeedView;
});