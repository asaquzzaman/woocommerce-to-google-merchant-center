<template>
	<div>
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
					<th></th>
					<th>Google Shopping Attributes</th>
					<th>Product Attributes</th>

				</tr>
			</thead>

			<tbody>
				<template v-for="(gAttribute, key) in googleAttributes">
					<tr 
						v-for="(gAttributeTr, gkey) in gAttribute.attributes"
						v-if="gAttributeTr.format == 'required'">
						<td>
							<a href="#" @click.prevent="removeAttr(gAttributeTr)"><span>X</span></a>
						</td>
						<td>
							<select>
								<optgroup 
									v-for="(googleAttributeTd, key) in googleAttributes"
									:label="googleAttributeTd.label">
									<option 
										v-for="(googleAttrTd, key) in googleAttributeTd.attributes"
										:selected="isGoogleAttrSelected(gAttributeTr, googleAttrTd)">
										{{ googleAttrTd.label }} {{ '('+googleAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select>
								<option 
									v-for="(woogoolAttribute, wpKey) in woogoolAttributes"
									:selected="isProductAttrSelected(gAttributeTr, wpKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>
					</tr>
				</template>
				<!-- For extra map fields -->
				<template 
					v-for="(extraAF, attrKey) in googleExtraAttrFields" 
					v-if="extraAF.format == 'required'">

					<tr v-if="extraAF.type == 'mapping'">
						<td>
							<a href="#" @click.prevent="removeAttr(extraAF)"><span>X</span></a>
						</td>
						<td>
							<select>
								<option value=""></option>
								<optgroup 
									v-for="(googleAttributeTd, key) in googleAttributes"
									:label="googleAttributeTd.label">
									<option 
										v-for="(googleAttrTd, key) in googleAttributeTd.attributes"
										:selected="isGoogleAttrSelected(extraAF, googleAttrTd)">
										{{ googleAttrTd.label }} {{ '('+googleAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select>
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, wpKey) in woogoolAttributes"
									:selected="''">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>
					</tr>

					<!-- For custom fields -->
					<tr v-if="extraAF.type == 'custom'">
						<td>
							<a href="#" @click.prevent="removeAttr(extraAF)"><span>X</span></a>
						</td>
						<td>
							<input type="text">
						</td>
						<td>
							<select>
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, wpKey) in woogoolAttributes"
									:selected="''">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>
					</tr>

				</template>
				
			</tbody>

		</table>
		<div>
			<a href="#" class="button button-primary" @click.prevent="changeStage('first')">{{ 'Prev' }}</a>
			<a href="#" class="button button-primary" @click.prevent="addCustomField('first')">{{ 'Add custom field' }}</a>
			<a href="#" class="button button-primary" @click.prevent="addMappingField()">{{ 'Add mapping field' }}</a>
			<a href="#" class="button button-primary" @click.prevent="changeStage('third')">{{ 'Next' }}</a>
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
			content: {
				type: [Object],
				default () {
					return {}
				}
			}
		},
		data () {
			return {
				googleAttributes: woogool_multi_product_var.google_shopping_attributes,
				woogoolAttributes: woogool_multi_product_var.woogool_product_attributes,
				googleExtraAttrFields: woogool_multi_product_var.google_extra_attr_fields,
			}
		},

		methods: {
			isGoogleAttrSelected (gAttributeTr, googleAttrTd) {
				return gAttributeTr.name == googleAttrTd.name ? 'selected' : false;
			},

			isProductAttrSelected (gAttributeTr, wpKey) {
				return gAttributeTr.woogool_suggest == wpKey ? 'selected' : false;
			},

			removeAttr(gAttributeTr) {
				if(!confirm('Are you sure')) {
					return;
				}

				gAttributeTr.format = 'optional';
			},

			addMappingField () {
				this.googleExtraAttrFields.push({
					'type': 'mapping',
					'format': 'required'
				});
			},

			addCustomField () {
				this.googleExtraAttrFields.push({
					'type': 'custom',
					'format': 'required'
				});
			}
		}
	}
</script>







