require('scripts/routes/model_route');

/**
 * The route for managing apps
 *
 * @class Appserver.AppsRoute
 * @extends Ember.Route
 */
Appserver.AppsRoute = Appserver.ModelRoute.extend({

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