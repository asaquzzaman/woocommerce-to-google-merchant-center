export default new woogool.Vuex.Store({
    state: {
    	header: {
    		feedByCatgory: false,
			name: '',
			activeVariation: false,
			feedCategories: [],
			refresh: 1,
			googleCategories: [],
			categories: [],
			country: {},
			channel: {
				label: 'Google Shopping',
				id: 'google_shopping'
			},
    	},

    	channels: []
    },

    mutations: {
        setHeaderInStore (state, data) {
        	state.header = data.header;
        	state.channels = data.channels;
        }
    }

});
