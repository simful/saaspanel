App.Router.map(function() {
	this.resource('tickets', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Tickets = Ember.Model.extend({
	id: Ember.attr(),
	user: Ember.belongsTo('App.Users', { key: 'user_id' }),
	department: Ember.belongsTo('App.Departments', { key: 'department_id' }),
	title: Ember.attr(),
	message: Ember.attr(),
	status: Ember.attr(),
	created_at: Ember.attr(),
	updated_at: Ember.attr(),
	isEdit: false
});

App.Tickets.url = '/tickets';
App.Tickets.adapter = Ember.RESTAdapter.create();

App.TicketsAddRoute = Ember.Route.extend({
	model: function() {
		return App.Tickets.create();
	}
});

App.TicketsEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Tickets.find(param.id);
	}
});

App.TicketsViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Tickets.find(param.id);
	}
});

App.TicketsFormController = Ember.ObjectController.extend({
	init: function() {
		this._super();
		this.set('user_id_array', App.Users.find());
		this.set('department_id_array', App.Departments.find());
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('tickets');
		},

		cancel: function() {
			this.transitionTo('tickets');
		}
	}
});

App.TicketsAddController = App.TicketsFormController.extend();
App.TicketsEditController = App.TicketsFormController.extend();

App.TicketsFormView = Em.View.extend({
	didInsertElement: function() {
		Ember.run.sync();
		Ember.run.scheduleOnce('afterRender', this, 'processElements');
	},

	processElements: function() {
		var model = this.get('model');

		this.$('#user_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/users',
				dataType: 'json',
				data: function (term, page) {
					return {
						term: term,
						limit: 10,
						col: 'username'
					}
				},
				results: function (data, page) {
					return { results: data }
				}
			},
			initSelection: function(element, callback) {
				if (element.val() !== "") {
					$.getJSON('/users/' + element.val(), function(data) {
						callback(data);
					});
				}
			},

			formatResult: function(obj, container, query) {
				return obj.username;
			},

			formatSelection: function(obj, container) {
				return obj.username;
			},

			id: function(obj) {
				return obj.id;
			},

			selectedDidChange : function(){
				this.$().select2('val', this.get('value').split(','));  
			}.observes('value')
		});
		this.$('#department_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/departments',
				dataType: 'json',
				data: function (term, page) {
					return {
						term: term,
						limit: 10,
						col: 'name'
					}
				},
				results: function (data, page) {
					return { results: data }
				}
			},
			initSelection: function(element, callback) {
				if (element.val() !== "") {
					$.getJSON('/departments/' + element.val(), function(data) {
						callback(data);
					});
				}
			},

			formatResult: function(obj, container, query) {
				return obj.name;
			},

			formatSelection: function(obj, container) {
				return obj.name;
			},

			id: function(obj) {
				return obj.id;
			},

			selectedDidChange : function(){
				this.$().select2('val', this.get('value').split(','));  
			}.observes('value')
		});
	},

	willDestroyElement: function() {
		$('.s2-enabled').select2('destroy');
	}
});


App.TicketsAddView = App.TicketsFormView.extend();
App.TicketsEditView = App.TicketsFormView.extend();

App.TicketsViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('tickets.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.TicketsIndexRoute = Ember.Route.extend();

App.TicketsIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/tickets?dt=1",
			"aoColumns": [
				{ "mData": 'id' },
				{
					"mData": null,
					"fnRender": function(obj) {
						return '<a href="#/tickets/view/' + obj.aData.id + '">' + obj.aData.title + '</a>';
					}
				},
				{
					"mData": "user_id",
					"fnRender": function(obj) {
						return '<a href="#/users/view/' + obj.aData.user_id + '">' + obj.aData.user + '</a>';
					}
				},
				{
					"mData": "department_id",
					"fnRender": function(obj) {
						return '<a href="#/departments/view/' + obj.aData.department_id + '">' + obj.aData.department + '</a>';
					}
				},
				{ "mData": "status" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/tickets/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.title + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/tickets/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});