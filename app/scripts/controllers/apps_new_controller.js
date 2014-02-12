/**
 * A controller for managing apps
 *
 * @class Appserver.AppsController
 * @extends Ember.ArrayController
 */
Appserver.AppsNewController = Ember.ArrayController.extend({

    /**
     * Dependent controllers
     *
     * @property needs
     * @type []
     */
    needs: ['apps']
});