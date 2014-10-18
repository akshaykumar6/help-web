/**
 * @author: Akshay Sharma
 *
 * @since: 11 Oct, 2014
 * @file: EditAccountViewView.js
 *
 * @copyright: KNOLSKAPE Solutions Pvt Ltd
 **/

define([
    'jquery',
    'underscore',
    'backbone',
    'chosen',
    'text!js/templates/account/EditAccountTpl.tpl',
], function($, _, Backbone, Chosen, EditAccountViewTpl) {

    var EditAccountView = Backbone.View.extend({

        template: _.template(EditAccountViewTpl),

        className: "page-edit-cnt",

        events: {
            'click .edit-save-btn': 'onSaveClickEvent',
            'click .edit-cancel-btn': 'onCancelClickEvent'
        },


        initialize: function(options) {

            _.bindAll(this, 'render');

            this.options = options;
            this.render();
        },

        render: function() {

            this.$el.html(this.template(KAPP.user.toJSON()));


            $.ajax({
                type: "GET",
                url: "api/public/category",
                success: _.bind(function(response) {
                    var obj = $.parseJSON(response);
                    _.each(obj, _.bind(function(element, index) {
                        //console.log(element);
                        this.$('#txt-input-category').append('<option value="' + element.category_id + '">' + element.category_name + '</option>');
                    }, this));

                    this.$('.chosen-select').chosen();
                    //console.log($.parseJSON(response));
                }, this),
                error: function(response) {
                    console.log(response);
                }
            });
            //this.$('#txt-input-category').chosen();
        },

        onSaveClickEvent: function() {

            KAPP.user.save({
                category: this.$('#txt-input-category').val(),
                contact: _.escape(this.$('#txt-input-contact').val()),
                email: _.escape(this.$('#txt-input-email').val()),
                website: _.escape(this.$('#txt-input-website').val()),
                ngoUserName: _.escape(this.$('#txt-input-name').val()),
                userAddress: _.escape(this.$('#txt-input-address').val()),
                userCity: _.escape(this.$('#txt-input-city').val()),
                userDesc: _.escape(this.$('#txt-input-desc').val())
            }, {
                success: function(response) {

                    KAPP.router.navigate('profile', {
                        trigger: true
                    });
                },
                error: function(response) {
                    console.log(response);
                }

            });
        },

        onCancelClickEvent: function() {
            KAPP.router.navigate('profile', {
                trigger: true
            });
        },


    });

    return EditAccountView;
});