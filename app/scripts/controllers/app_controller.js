Appserver.AppController = Ember.ObjectController.extend({

    removeApp: function () {
        var app = this.get('model');
        app.deleteRecord();
        app.save();
    },

    url: function () {
        return "http://localhost:8586/" + this.get('name');
    }.property()

});
