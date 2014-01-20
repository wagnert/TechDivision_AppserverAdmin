/**
 * A controller for managing apps
 *
 * @class Appserver.AppsController
 * @extends Ember.ArrayController
 */
Appserver.AppsController = Ember.ArrayController.extend({

    /**
     * Defines the item controller
     *
     * @property itemController
     * @type {String}
     * @default "app"
     */
    itemController: 'app',



    actions: {

        openApplicationNew: function () {

            this.transitionToRoute("apps.new");
        }

    }
});