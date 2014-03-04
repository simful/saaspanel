App.Router.map(function() {
	this.resource('invoices', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Invoices = Ember.Model.extend({
	id: Ember.attr(),
	user: Ember.belongsTo('App.Users', { key: 'user_id' }),
	due_date: Ember.attr(),
	status: Ember.attr(),
	created_at: Ember.attr(),
	updated_at: Ember.attr(),
	isEdit: false
});

App.Invoices.url = '/invoices';
App.Invoices.adapter = Ember.RESTAdapter.create();

App.InvoicesAddRoute = Ember.Route.extend({
	model: function() {
		return App.Invoices.create();
	}
});

App.InvoicesEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Invoices.find(param.id);
	}
});

App.InvoicesViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Invoices.find(param.id);
	}
});

App.InvoicesFormController = Ember.ObjectController.extend({
	status_choices: ['Draft','Unpaid','Paid'],
	init: function() {
		this._super();
		this.set('user_id_array', App.Users.find());
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('invoices');
		},

		cancel: function() {
			this.transitionTo('invoices');
		}
	}
});

App.InvoicesAddController = App.InvoicesFormController.extend();
App.InvoicesEditController = App.InvoicesFormController.extend();

App.InvoicesFormView = Em.View.extend({
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
	},

	willDestroyElement: function() {
		$('.s2-enabled').select2('destroy');
	}
});


App.InvoicesAddView = App.InvoicesFormView.extend();
App.InvoicesEditView = App.InvoicesFormView.extend();

App.InvoicesViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('invoices.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.InvoicesIndexRoute = Ember.Route.extend();

App.InvoicesIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/invoices?dt=1",
			"aoColumns": [
				{ "mData": "id" },
				{
					"mData": "user_id",
					"fnRender": function(obj) {
						return '<a href="#/users/view/' + obj.aData.user_id + '">' + obj.aData.user + '</a>';
					}
				},
				{ "mData": "due_date" },
				{ "mData": "status" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/invoices/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.id + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/invoices/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});