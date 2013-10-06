Appserver.VhostController = Ember.ObjectController.extend({

    removeVhost: function () {
        var vhost = this.get('model');
        vhost.deleteRecord();
        vhost.save();
    },

    widgetTitle: function () {
        return this.get('content').get('name');
    }.property(),

    widgetDescription: function () {
        return this.get('content').get('app.name');
    }.property()

});
