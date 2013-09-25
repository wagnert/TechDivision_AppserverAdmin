Appserver.VhostController = Ember.ObjectController.extend({

    removeVhost : function() {
        var vhost = this.get('model');
        vhost.deleteRecord();
        vhost.save();
    },

});
