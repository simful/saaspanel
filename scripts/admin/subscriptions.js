App.Router.map(function() {
	this.resource('subscriptions', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Subscriptions = Ember.Model.extend({
	id: Ember.attr(),
	user: Ember.belongsTo('App.Users', { key: 'user_id' }),
	service: Ember.belongsTo('App.Services', { key: 'service_id' }),
	option: Ember.belongsTo('App.ServiceOptions', { key: 'option_id' }),
	billing_cycle: Ember.belongsTo('App.BillingCycles', { key: 'billing_cycle_id' }),
	expire_date: Ember.attr(),
	status: Ember.attr(),
	created_at: Ember.attr(),
	updated_at: Ember.attr(),
	isEdit: false
});

App.Subscriptions.url = '/subscriptions';
App.Subscriptions.adapter = Ember.RESTAdapter.create();

App.SubscriptionsAddRoute = Ember.Route.extend({
	model: function() {
		return App.Subscriptions.create();
	}
});

App.SubscriptionsEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Subscriptions.find(param.id);
	}
});

App.SubscriptionsViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Subscriptions.find(param.id);
	}
});

App.SubscriptionsFormController = Ember.ObjectController.extend({
	status_choices: ['Active','Stopped','Inactive','Cancelled'],
	init: function() {
		this._super();
		this.set('user_id_array', App.Users.find());
		this.set('service_id_array', App.Services.find());
		this.set('option_id_array', App.ServiceOptions.find());
		this.set('billing_cycle_id_array', App.BillingCycles.find());
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('subscriptions');
		},

		cancel: function() {
			this.transitionTo('subscriptions');
		}
	}
});

App.SubscriptionsAddController = App.SubscriptionsFormController.extend();
App.SubscriptionsEditController = App.SubscriptionsFormController.extend();

App.SubscriptionsFormView = Em.View.extend({
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
		this.$('#service_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/services',
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
					$.getJSON('/services/' + element.val(), function(data) {
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
		this.$('#option_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/service_options',
				dataType: 'json',
				data: function (term, page) {
					return {
						term: term,
						limit: 10,
						col: 'option_name'
					}
				},
				results: function (data, page) {
					return { results: data }
				}
			},
			initSelection: function(element, callback) {
				if (element.val() !== "") {
					$.getJSON('/service_options/' + element.val(), function(data) {
						callback(data);
					});
				}
			},

			formatResult: function(obj, container, query) {
				return obj.option_name;
			},

			formatSelection: function(obj, container) {
				return obj.option_name;
			},

			id: function(obj) {
				return obj.id;
			},

			selectedDidChange : function(){
				this.$().select2('val', this.get('value').split(','));  
			}.observes('value')
		});
		this.$('#billing_cycle_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/billing_cycles',
				dataType: 'json',
				data: function (term, page) {
					return {
						term: term,
						limit: 10,
						col: 'cycle'
					}
				},
				results: function (data, page) {
					return { results: data }
				}
			},
			initSelection: function(element, callback) {
				if (element.val() !== "") {
					$.getJSON('/billing_cycles/' + element.val(), function(data) {
						callback(data);
					});
				}
			},

			formatResult: function(obj, container, query) {
				return obj.cycle;
			},

			formatSelection: function(obj, container) {
				return obj.cycle;
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


App.SubscriptionsAddView = App.SubscriptionsFormView.extend();
App.SubscriptionsEditView = App.SubscriptionsFormView.extend();

App.SubscriptionsViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('subscriptions.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.SubscriptionsIndexRoute = Ember.Route.extend();

App.SubscriptionsIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/subscriptions?dt=1",
			"aoColumns": [
				{
					"mData": "user_id",
					"fnRender": function(obj) {
						return '<a href="#/users/view/' + obj.aData.user_id + '">' + obj.aData.user + '</a>';
					}
				},
				{
					"mData": "service_id",
					"fnRender": function(obj) {
						return '<a href="#/services/view/' + obj.aData.service_id + '">' + obj.aData.service + '</a>';
					}
				},
				{
					"mData": "option_id",
					"fnRender": function(obj) {
						return '<a href="#/service_options/view/' + obj.aData.option_id + '">' + obj.aData.option + '</a>';
					}
				},
				{
					"mData": "billing_cycle_id",
					"fnRender": function(obj) {
						return '<a href="#/billing_cycles/view/' + obj.aData.billing_cycle_id + '">' + obj.aData.billing_cycle + '</a>';
					}
				},
				{ "mData": "expire_date" },
				{ "mData": "status" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/subscriptions/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.id + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/subscriptions/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});