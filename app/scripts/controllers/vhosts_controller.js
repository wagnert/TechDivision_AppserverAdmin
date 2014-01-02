/**
 * A controller for managing vhosts
 *
 * @class Appserver.VhostsController
 * @extends Ember.ArrayController
 */
Appserver.VhostsController = Ember.ArrayController.extend({

    /**
     * Defines the needed controllers as array
     *
     * @property needs
     * @type {Array}
     * @default "['apps']"
     */
    needs: ['apps'],

    /**
     * Defines the item controller
     *
     * @property itemController
     * @type {String}
     * @default "vhost"
     */
    itemController: 'vhost',

    /**
     * Defines the controllers actions
     *
     * @property actions
     * @type {Object}
     */
    actions: {

        /**
         * Creates a new vhost
         *
         * @method actions.create
         * @return {Void}
         */
        create: function () {
            var name = this.get('newName');
            if (!name.trim()) { return; }
            var model = Appserver.Vhost.createRecord({
                name: name
            });
            this.set('newName', '');
            model.save();
        }
    }
});