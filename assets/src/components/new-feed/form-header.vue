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

		<div v-if="header.feedByCatgory">
			<label>Feed by category</label>
			<vue-woogool-multiselect 
                v-model="header.categories" 
				:options="categories" 
                :multiple="true"
                :close-on-select="true"
                :clear-on-select="true"
                :show-labels="true"
                :searchable="true"
                placeholder="Select Category"
                select-label=""
                selected-label="selected"
                deselect-label=""
                label="catName"
                track-by="catId"
                :allow-empty="true">
					
			</vue-woogool-multiselect>
		</div>

		<div>
			<label>Category Maping</label>
			<vue-woogool-multiselect 
                v-model="header.googleCategories" 
				:options="categories" 
                :multiple="true"
                :close-on-select="true"
                :clear-on-select="true"
                :show-labels="true"
                :searchable="true"
                placeholder="Category maping"
                select-label=""
                selected-label="selected"
                deselect-label=""
                label="catName"
                track-by="catId"
                :allow-empty="true">
					
			</vue-woogool-multiselect>
		</div>

		<div v-for="(catElement, index) in header.googleCategories" :key="index" class="woogool-individual-field-wrap">
			<label class="woogool-label">{{ catElement.catName }}</label>
			<vue-woogool-multiselect
				v-model="catElement.googleCat"
				:options="googleCategories" 
                :multiple="false"
                :close-on-select="true"
                :clear-on-select="true"
                :show-labels="true"
                :searchable="true"
                @input="setGoogleCat(catElement, $event)"
                placeholder="Category maping"
                select-label=""
                selected-label="selected"
                deselect-label=""
                label=""
                track-by="id"
                :allow-empty="true">
					
			</vue-woogool-multiselect>
			<span>Google category for the {{ catElement.catName.toLowerCase() }} item</span>
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

		<div>
			<a href="#" class="button button-primary" @click.prevent="changeStage('second')">{{ 'Next' }}</a>
		</div>
	</div>
</template>

<script>
	import Mixin from '@components/new-feed/mixin'

	export default {
		mixins: [Mixin],
		props: {
			stage: {
				type: [Object],
				default () {
					return {}
				}
			},
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
				googleCategories: [],
			}
		},


		created () {
			var self = this;
			
			this.googleCategories = woogool_multi_product_var.google_categories;


			jQuery.each(woogool_multi_product_var.product_categories, function(index, cat) {
				self.categories.push({
					'catId': index,
					'catName': cat
				});
			});
		},

		methods: {
			setGoogleCat (cat, googleCat) {
				cat['googleCat'] = googleCat;
			},
	
		}
	}
</script>