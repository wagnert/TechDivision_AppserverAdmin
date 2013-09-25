Appserver.Vhost = DS.Model.extend({
	name: DS.attr('string'),
	appBase: DS.attr('string'),
   aliases: DS.hasMany('Appserver.Vhostalias')
});

Appserver.Vhost.FIXTURES = [
 {
   id: 1,
   name: 'appserver.io',
   appBase: 'site',
   aliases: [1, 2]
 },
 {
   id: 2,
   name: 'neos.appserver.io',
   appBase: 'neos',
 },
 {
   id: 3,
   name: 'admin.appserver.io',
   appBase: 'admin',
 }
];