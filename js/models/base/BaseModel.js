define([
    'jquery',
    'underscore',
    'backbone'
], function($, _, Backbone) {

    var BaseModel = Backbone.Model.extend({

        urlRoot: '',

        defaults: {}
    });

    return BaseModel;
});