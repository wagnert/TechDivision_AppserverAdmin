/**
 * The route for managing apps
 *
 * @class Appserver.AppsRoute
 * @extends Ember.Route
 */
Appserver.AppsRoute = Ember.Route.extend({

    /**
     * Initialises the model
     *
     * @method model
     * @return {Object}
     */
    model: function () {
        return Appserver.App.find();
    }
});