App.Router.map(function() {
	this.resource('services', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Services = Ember.Model.extend({
	id: Ember.attr(),
	name: Ember.attr(),
	description: Ember.attr(),
	service_options: Ember.hasMany('App.ServiceOptions', { key: 'service_options', embedded: false }),
	billing_cycles: Ember.hasMany('App.BillingCycles', { key: 'billing_cycles', embedded: false }),
	isEdit: false
});

App.Services.url = '/services';
App.Services.adapter = Ember.RESTAdapter.create();

App.ServicesAddRoute = Ember.Route.extend({
	model: function() {
		return App.Services.create();
	}
});

App.ServicesEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Services.find(param.id);
	}
});

App.ServicesViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Services.find(param.id);
	}
});

App.ServicesFormController = Ember.ObjectController.extend({
	init: function() {
		this._super();
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('services');
		},

		cancel: function() {
			this.transitionTo('services');
		}
	}
});

App.ServicesAddController = App.ServicesFormController.extend();
App.ServicesEditController = App.ServicesFormController.extend();

App.ServicesFormView = Em.View.extend({
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


App.ServicesAddView = App.ServicesFormView.extend();
App.ServicesEditView = App.ServicesFormView.extend();

App.ServicesViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('services.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.ServicesIndexRoute = Ember.Route.extend();

App.ServicesIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/services?dt=1",
			"aoColumns": [
				{
					"mData": null,
					"fnRender": function(obj) {
						return '<a href="#/services/view/' + obj.aData.id + '">' + obj.aData.name + '</a>';
					}
				},
				{ "mData": "description" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/services/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.name + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/services/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});