Appserver.Container = DS.Model.extend({
    name: DS.attr('string'),
    threadType: DS.attr('string'),
    type: DS.attr('string'),
    apps: DS.hasMany('Appserver.App')
});


Appserver.Container.FIXTURES = [
    {
        id: 1,
        threadType: '\\TechDivision\\ServletContainer',
        type: 'thread',
        name: 'ServletContainer',
        apps: [1, 2, 3]
    },
    {
        id: 2,
        threadType: '\\TechDivision\\PersistentContainer',
        type: 'thread',
        name: 'PersistentContainer',
        apps: [1, 2, 3]
    },
    {
        id: 3,
        threadType: '\\TechDivision\\WebSocketContainer',
        type: 'thread',
        name: 'WebSocketContainer',
        apps: [1, 2, 3]
    }
];