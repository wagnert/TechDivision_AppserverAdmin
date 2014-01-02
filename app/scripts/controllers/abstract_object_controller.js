/**
 * An abstract controller implementation
 *
 * @class Appserver.AbstractController
 * @extends Ember.ObjectController
 */
Appserver.AbstractController = Ember.ObjectController.extend({

    isEditing: false,

    actions: {
        edit: function () {
            this.set('isEditing', true);
        },

        acceptChanges: function () {
            this.set('isEditing', false);
            this.get('model').save();
        },
        remove: function () {
            var model = this.get('model');
            model.deleteRecord();
            model.save();
        }
    }

});
