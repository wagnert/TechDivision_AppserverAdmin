Appserver.AppController = Ember.ObjectController.extend({

    removeVhost : function() {
        var app = this.get('model');
        app.deleteRecord();
        app.save();
    },

});
