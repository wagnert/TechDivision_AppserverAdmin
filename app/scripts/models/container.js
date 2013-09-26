Appserver.Container = DS.Model.extend({
   name: DS.attr('string'),
	threadType: DS.attr('string'),
	type: DS.attr('string'),
   apps: DS.hasMany('Appserver.App')
});

/**
Appserver.Container.FIXTURES = [
 {
   id: 1,
   threadType: '\\Test\\Test1',
   type: 'thread'
 },
 {
   id: 2,
   threadType: '\\Test\\Test2',
   type: 'thread'
 },
 {
   id: 3,
   threadType: '\\Test\\Test3',
   type: 'thread'
 }
];
*/