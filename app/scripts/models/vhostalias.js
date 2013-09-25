Appserver.Vhostalias = DS.Model.extend({
	name: DS.attr('string'),
	vhost: DS.belongsTo('Appserver.Vhost')
});

Appserver.Vhostalias.FIXTURES = [
 {
   id: 1,
   name: 'www.appserver.io',
   vhost: 1
 },
 {
   id: 2,
   name: 'site.appserver.io',
   vhost: 1
 }
];