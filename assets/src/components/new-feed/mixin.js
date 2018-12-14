export default {
	data () {
		return {
			'stage': {
				step: 'first',
			}
		}
	},
	methods: {
		changeStage (step) {
			this.stage.step = step;
			console.log(this.stage.step);
		}
	}
}