App.ServicesViewController.reopen({
	actions: {
		addOption: function() {
			var option = App.ServiceOptions.create({
				service_id: this.get('model').id,
				isEdit: true
			});

			this.get('model').get('service_options').pushObject(option);
		},

		editOption: function(model) {
			model.set('isEdit', true);
		},

		saveOption: function(model) {
			model.set('isEdit', false);
			model.save();
		},

		deleteOption: function(model) {
			this.get('model').get('service_options').removeObject(model);
			model.deleteRecord();
		},

		addBillingCycle: function() {
			var cycle = App.BillingCycles.create({
				service_id: this.get('model').id,
				isEdit: true
			});

			this.get('model').get('billing_cycles').pushObject(cycle);
		},

		editCycle: function(model) {
			model.set('isEdit', true);
		},

		saveCycle: function(model) {
			model.set('isEdit', false);
			model.save();
		}
	}
});