Appserver.Vhost = DS.Model.extend({
    icon: 'cloud',
    name: DS.attr('string'),
    app: DS.belongsTo('Appserver.App'),
    aliases: DS.belongsTo('Appserver.Vhostalias')
});

Appserver.Vhost.FIXTURES = [
    {
        id: 1,
        name: 'appserver.io',
        aliases: 2,
        app: 1
    },
    {
        id: 2,
        name: 'neos.appserver.io',
        app: 2
    },
    {
        id: 3,
        name: 'admin.appserver.io',
        app: 3
    }
];