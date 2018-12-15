export default {
	data () {
		return {
			'stage': {
				step: 'first',
			}
		}
	},
	watch: {
		stage: {
			handler (stage) {
				window.localStorage.setItem('woogoolStageStep', stage.step);
			},

			deep: true
		}
	},
	created () {
		var step = localStorage.getItem('woogoolStageStep');

		if(step) {
			this.stage.step = step;
		}
	},
	methods: {
		changeStage (step) {
			this.stage.step = step;
		}
	}
}