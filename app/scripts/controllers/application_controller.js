Appserver.ApplicationController = Ember.Controller.extend({
    message: function () {
        return Appserver.Message.find();
    }.property('message')
});