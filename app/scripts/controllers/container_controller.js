Appserver.ContainerController = Ember.ObjectController.extend({

    removeVhost: function () {
        var container = this.get('model');
        container.deleteRecord();
        container.save();
    },

});
