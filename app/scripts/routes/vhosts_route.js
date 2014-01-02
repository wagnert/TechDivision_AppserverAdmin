/**
 * The route for managing vhosts
 *
 * @class Appserver.VhostsRoute
 * @extends Ember.Route
 */
Appserver.VhostsRoute = Ember.Route.extend({

    /**
     * Initialises the model
     *
     * @method model
     * @return {Object}
     */
    model: function () {
        return Appserver.Vhost.find();
    }

});