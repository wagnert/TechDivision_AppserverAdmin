Appserver.WidgetGridItemRow = Ember.View.extend({

    templateName: 'widgets/widget_grid_row',

    title: function () {
        // init default field name
        var fieldName = 'title';
        // check if field mapper was defined in parent view
        var definedFieldMapper = this.get('parentView').get('title');
        // set defined field mapper as fieldName
        if (definedFieldMapper) {
            fieldName = definedFieldMapper;
        }
        // get current model
        var model = this.get('controller').get('model');
        // return models fieldName
        return model.get(fieldName);
    }.property(),

    description: function () {
        var model = this.get('controller').get('model');
        var app = model.get('app');
        console.log(app.find());
        return 'asdf';
    }.property()

});
