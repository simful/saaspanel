App.Router.map(function() {
	this.resource('billing_cycles', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.BillingCycles = Ember.Model.extend({
	id: Ember.attr(),
	service: Ember.belongsTo('App.Services', { key: 'service_id' }),
	cycle: Ember.attr(),
	discount: Ember.attr(),
	created_at: Ember.attr(),
	updated_at: Ember.attr(),
	isEdit: false
});

App.BillingCycles.url = '/billing_cycles';
App.BillingCycles.adapter = Ember.RESTAdapter.create();

App.BillingCyclesAddRoute = Ember.Route.extend({
	model: function() {
		return App.BillingCycles.create();
	}
});

App.BillingCyclesEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.BillingCycles.find(param.id);
	}
});

App.BillingCyclesViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.BillingCycles.find(param.id);
	}
});

App.BillingCyclesFormController = Ember.ObjectController.extend({
	init: function() {
		this._super();
		this.set('service_id_array', App.Services.find());
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('billing_cycles');
		},

		cancel: function() {
			this.transitionTo('billing_cycles');
		}
	}
});

App.BillingCyclesAddController = App.BillingCyclesFormController.extend();
App.BillingCyclesEditController = App.BillingCyclesFormController.extend();

App.BillingCyclesFormView = Em.View.extend({
	didInsertElement: function() {
		Ember.run.sync();
		Ember.run.scheduleOnce('afterRender', this, 'processElements');
	},

	processElements: function() {
		var model = this.get('model');

		this.$('#service_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/services',
				dataType: 'json',
				data: function (term, page) {
					return {
						term: term,
						limit: 10,
						col: 'id'
					}
				},
				results: function (data, page) {
					return { results: data }
				}
			},
			initSelection: function(element, callback) {
				if (element.val() !== "") {
					$.getJSON('/services/' + element.val(), function(data) {
						callback(data);
					});
				}
			},

			formatResult: function(obj, container, query) {
				return obj.id;
			},

			formatSelection: function(obj, container) {
				return obj.id;
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


App.BillingCyclesAddView = App.BillingCyclesFormView.extend();
App.BillingCyclesEditView = App.BillingCyclesFormView.extend();

App.BillingCyclesViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('billing_cycles.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.BillingCyclesIndexRoute = Ember.Route.extend();

App.BillingCyclesIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/billing_cycles?dt=1",
			"aoColumns": [
				{
					"mData": "service_id",
					"fnRender": function(obj) {
						return '<a href="#/services/view/' + obj.aData.service_id + '">' + obj.aData.service + '</a>';
					}
				},
				{ "mData": "cycle" },
				{ "mData": "discount" },
				{ "mData": "created_at" },
				{ "mData": "updated_at" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/billing_cycles/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.id + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/billing_cycles/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});