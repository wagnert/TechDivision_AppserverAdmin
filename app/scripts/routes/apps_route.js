Appserver.AppsRoute = Ember.Route.extend({
  model: function () {
    return Appserver.App.find();
  }
});