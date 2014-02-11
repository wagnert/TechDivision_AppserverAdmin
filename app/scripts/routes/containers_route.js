require('scripts/routes/model_route');

/**
 * The route for managing containers
 *
 * @class Appserver.ContainersRoute
 * @extends Ember.Route
 */
Appserver.ContainersRoute = Appserver.ModelRoute.extend({

    /**
     * Initialises the model
     *
     * @method model
     * @return {Object}
     */
    model: function () {
        return Appserver.Container.find();
    }
});