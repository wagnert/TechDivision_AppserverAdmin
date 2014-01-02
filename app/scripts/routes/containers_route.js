/**
 * The route for managing containers
 *
 * @class Appserver.ContainersRoute
 * @extends Ember.Route
 */
Appserver.ContainersRoute = Ember.Route.extend({

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