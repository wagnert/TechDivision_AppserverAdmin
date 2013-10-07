Appserver.ContainersController = Ember.ArrayController.extend({
    itemController: 'container',

    actions: {
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