Appserver.VhostsController = Ember.ArrayController.extend({

    needs: ['apps'],

    itemController: 'vhost',

    actions: {
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