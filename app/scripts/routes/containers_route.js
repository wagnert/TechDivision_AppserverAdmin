Appserver.ContainersRoute = Ember.Route.extend({
    model: function () {
        return Appserver.Container.find();
    }
});