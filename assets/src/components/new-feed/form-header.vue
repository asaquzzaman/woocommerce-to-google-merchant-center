<template>
	<div>
		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Feed name</label>
			<input v-model="header.name" type="text" class="woogool-field">
		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Enable product variations</label>
			<input type="checkbox" v-model="header.activeVariation" class="woogool-field">
		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Feed by category</label>
			<input type="checkbox" v-model="header.feedByCatgory" class="woogool-field">
		</div>
		
		<div v-if="header.feedByCatgory" class="woogool-individual-field-wrap">
			<label class="woogool-label">Select Category</label>
			<select  v-woogool-chosen-categories multiple tabindex="-1">
				<option :selected="getSelectedCat(id)" v-for="(categorie, id) in categories" :value="id">{{ categorie }}</option>
			</select>
		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Category maping</label>
			<select v-if="header.categories" v-woogool-chosen multiple tabindex="-1">
				<option v-for="(categories, id) in categories" :value="id">{{ categories }}</option>
			</select>
		</div>

		<div v-if="header.googleCategories.length">

			<div v-for="(catElement, index) in header.googleCategories" :key="index" class="woogool-individual-field-wrap">
				<label class="woogool-label">{{ catElement.catName }}</label>
				<select :data-element_id="catElement.catId"  v-woogool-chosen-google-categories tabindex="-1">
					<option 
						v-for="(googleCategorie, lockId) in googleCategories" 
						:key="lockId"
						:value="googleCategorie">
						{{ googleCategorie }}
					</option>
				</select>
				<span>Google category of the {{ catElement.catName.toLowerCase() }} item</span>
			</div>

		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Refresh interval</label>
			<select v-model="header.refresh">
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
				googleCategories: [],
			}
		},

		created () {

			this.categories = woogool_multi_product_var.product_categories;
			this.googleCategories = woogool_multi_product_var.google_categories;
		},

		methods: {
			chosenChange (change, change_val) {

				if(typeof change_val.deselected == 'string') {
					let index = this.getIndex(this.header.googleCategories, change_val.deselected, 'id');
					this.header.googleCategories.splice( index, 1 );
				
				} else {
					var isExist = false;

					this.header.googleCategories.forEach(function(catElements) {
						if(catElements.id == change_val.selected) {
							isExist = true;
						}
					});

					if(isExist) {
						return;
					}

					this.header.googleCategories.push(
						{
							catId: change_val.selected,
							catName: this.categories[change_val.selected]
						}
					);
				}
			},

			setCategories (change, change_val) {
				if(typeof change_val.deselected == 'string') {
					let index = this.getIndex(this.header.categories, change_val.deselected, 'id');
					this.header.categories.splice( index, 1 );
				
				} else {
					var isExist = false;

					this.header.categories.forEach(function(catElements) {
						if(catElements.id == change_val.selected) {
							isExist = true;
						}
					});

					if(isExist) {
						return;
					}

					this.header.categories.push(
						{
							id: change_val.selected,
							label: this.categories[change_val.selected]
						}
					);
				}
			},

			setGoogleCategories (change, change_val) {
				var  WPCatId = jQuery(change.target).data('element_id');
				let index = this.getIndex(this.header.googleCategories, WPCatId, 'catId');
				
				if(index > -1) {
					this.header.googleCategories[index]['googleCat'] = change_val.selected;
				}
			},

			getSelectedCat (id) {
				
				let index = this.getIndex(this.header.categories, id, 'id');
				
				if(index !== false) {
					return 'selected';
				}

				return false;
			}
		}
	}
</script>