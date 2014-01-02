/**
 * A controller for managing containers
 *
 * @class Appserver.ContainersController
 * @extends Ember.ArrayController
 */
Appserver.ContainersController = Ember.ArrayController.extend({

    /**
     * Defines the item controller
     *
     * @property itemController
     * @type {String}
     * @default "container"
     */
    itemController: 'container',

    /**
     * Defines the controllers actions
     *
     * @property actions
     * @type {Object}
     */
    actions: {

        /**
         * Creates a new app
         *
         * @method actions.create
         * @return {Void}
         */
        create: function () {
            var name = this.get('newName');
            if (!name.trim()) { return; }
            var model = Appserver.Container.createRecord({
                name: name
            });
            this.set('newName', '');
            model.save();
        }
    }
});