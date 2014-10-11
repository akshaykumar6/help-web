define([
    'jquery',
    'underscore',
    'backbone'
], function($, _, Backbone) {

    var CaseModel = Backbone.Model.extend({

        urlRoot: '',

        defaults: {
        }
    });

    return CaseModel;
});