App.Router.map(function() {
	this.resource('users', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Users = Ember.Model.extend({
	id: Ember.attr(),
	username: Ember.attr(),
	email: Ember.attr(),
	password: Ember.attr(),
	confirmation_code: Ember.attr(),
	confirmed: Ember.attr(),
	role: Ember.attr(),
	created_at: Ember.attr(),
	updated_at: Ember.attr(),
	isEdit: false
});

App.Users.url = '/users';
App.Users.adapter = Ember.RESTAdapter.create();

App.UsersAddRoute = Ember.Route.extend({
	model: function() {
		return App.Users.create();
	}
});

App.UsersEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Users.find(param.id);
	}
});

App.UsersViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Users.find(param.id);
	}
});

App.UsersFormController = Ember.ObjectController.extend({
	role_choices: ['Admin','Client'],
	init: function() {
		this._super();
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('users');
		},

		cancel: function() {
			this.transitionTo('users');
		}
	}
});

App.UsersAddController = App.UsersFormController.extend();
App.UsersEditController = App.UsersFormController.extend();

App.UsersFormView = Em.View.extend({
	didInsertElement: function() {
		Ember.run.sync();
		Ember.run.scheduleOnce('afterRender', this, 'processElements');
	},

	processElements: function() {
		var model = this.get('model');
		this.$('.type-date').datetimepicker({
			pickTime: false
		});

	},

	willDestroyElement: function() {
		$('.s2-enabled').select2('destroy');
	}
});


App.UsersAddView = App.UsersFormView.extend();
App.UsersEditView = App.UsersFormView.extend();

App.UsersViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('users.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.UsersIndexRoute = Ember.Route.extend();

App.UsersIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/users?dt=1",
			"aoColumns": [
				{
					"mData": null,
					"fnRender": function(obj) {
						return '<a href="#/users/view/' + obj.aData.id + '">' + obj.aData.username + '</a>';
					}
				},
				{ "mData": "email" },
				{ "mData": "confirmed" },
				{ "mData": "role" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/users/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.username + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/users/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});