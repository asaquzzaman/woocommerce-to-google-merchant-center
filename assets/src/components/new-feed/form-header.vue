<template>
	<div>
		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Feed name</label>
			<input type="text" class="woogool-field">
		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Enable product variations</label>
			<input type="checkbox" class="woogool-field">
		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Category maping</label>
			<select v-woogool-chosen multiple tabindex="-1">
				<option v-for="(categories, id) in categories" :value="id">{{ categories }}</option>
			</select>
		</div>

		<div v-if="catElements.length">

			<div v-for="(catElement, index) in catElements" :key="index" class="woogool-individual-field-wrap">
				<label class="woogool-label">{{ catElement.label }}</label>
				<select v-woogool-chosen-google-categories tabindex="-1">
					<option 
						v-for="(googleCategorie, lockId) in googleCategories" 
						:key="lockId" 
						:value="googleCategorie">
						{{ googleCategorie }}
					</option>
				</select>
				<span>Google category of the {{ catElement.label.toLowerCase() }} item</span>
			</div>

		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Refresh interval</label>
			<select>
				<option value="1">Daily</option>
				<option value="2">Hourly</option>
				<option value="3">Weekly</option>
				<option value="4">Monthly</option>
			</select>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			header: {
				type: [Object],
				default () {
					return {}
				}
			}
		},

		data () {
			return {
				categories: [],
				catElements: [],
				googleCategories: []
			}
		},

		created () {
			this.categories = woogool_multi_product_var.product_categories;
			this.googleCategories = woogool_multi_product_var.google_categories;
		},

		methods: {
			chosenChange (change, change_val) {

				if(typeof change_val.deselected == 'string') {
					let index = this.getIndex(this.catElements, change_val.deselected, 'id');
					this.catElements.splice( index, 1 );
				
				} else {
					var isExist = false;

					this.catElements.forEach(function(catElements) {
						if(catElements.id == change_val.selected) {
							isExist = true;
						}
					});

					if(isExist) {
						return;
					}

					this.catElements.push(
						{
							id: change_val.selected,
							label: this.categories[change_val.selected]
						}
					);
				}
			}
		}
	}
</script>