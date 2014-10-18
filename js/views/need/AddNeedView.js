/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: AddNeedView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'text!js/templates/need/AddNeedTpl.tpl',
    'js/models/need/NeedModel'
], function($, _, Backbone, AddNeedTpl, NeedModel) {

    var AddNeedView = Backbone.View.extend({

        template: _.template(AddNeedTpl),

        className: "page-need-cnt",

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
            var needModel = new NeedModel();
            needModel.save({
                "ngoID": KAPP.user.id,

                "needTitle": this.$('#txt-ngo-name').val(),

                "needDesc": this.$('#txt-input-desc').val()

            }, {
                success: function(response) {
                    KAPP.router.navigate('profile', {
                        trigger: true
                    });
                }
            });
        }

    });

    return AddNeedView;
});