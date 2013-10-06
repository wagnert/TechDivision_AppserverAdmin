Appserver.VhostsRoute = Ember.Route.extend({

    model: function () {
        return Appserver.Vhost.find();
    }

});