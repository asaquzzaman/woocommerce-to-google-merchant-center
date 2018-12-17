<template>
	<div>
		<table class="wp-list-table widefat striped posts">
			<thead>
				<tr>
					<th></th>
					<th>Google Shopping Attributes</th>
					<th>Product Attributes</th>

				</tr>
			</thead>

			<tbody>
				<template 
					v-for="(gAttrTr, gkey) in gAttrs" 
					v-if="gAttrTr.format == 'required'">
				
					<tr :key="gkey" v-if="gAttrTr.type == 'default'">
						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, gkey)"><span>X</span></a>
						</td>
						<td>
							<select @change="setGooAttrReqVal(gAttrTr, gkey, gAttrTr.type, $event)">
								<optgroup 
									v-for="(googleAttributeTd, key) in googleAttributes"
									:label="googleAttributeTd.label">
									<option
										v-for="(googleAttrTd, optKey) in googleAttributeTd.attributes"
										:value="googleAttrTd.name" 
										:selected="isGoogleAttrSelected(gAttrTr, googleAttrTd)">
										{{ googleAttrTd.label }} {{ '('+googleAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select @change.self="setProAttrReqVal(gAttrTr, gkey, $event)">
								<option 
									v-for="(woogoolAttribute, proMetaKey) in woogoolAttributes"
									:value="proMetaKey"
									:selected="isProductAttrSelected(gAttrTr, proMetaKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>
					</tr>
			
					<!-- For extra map fields -->
					<tr :key="gkey" v-if="gAttrTr.type == 'mapping'">
						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, gkey)"><span>X</span></a>
						</td>
						<td>
							<select @change.self="setGooAttrReqVal(gAttrTr, gkey, gAttrTr.type, $event)">
								<option value=""></option>
								<optgroup 
									v-for="(googleAttributeTd, key) in googleAttributes"
									:label="googleAttributeTd.label">
									<option 
										v-for="(googleAttrTd, mKey) in googleAttributeTd.attributes"
										:value="googleAttrTd.name"
										:selected="isGoogleAttrSelected(gAttrTr, googleAttrTd)">
										{{ googleAttrTd.label }} {{ '('+googleAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select @change.self="setProAttrReqVal(gAttrTr, gkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, wpKey) in woogoolAttributes"
									:value="wpKey"
									:selected="isProductAttrSelected(gAttrTr, wpKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>
					</tr>

					<!-- For custom fields -->
					<tr :key="gkey" v-if="gAttrTr.type == 'custom'">
						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, gkey)"><span>X</span></a>
						</td>
						<td>
							<input :value="gAttrTr.name" type="text" @input="setCustomText(gAttrTr, gkey, $event)">
						</td>
						<td>
							<select @change.self="setProAttrReqVal(gAttrTr, gkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, pmKey) in woogoolAttributes"
									:value="pmKey"
									:selected="isProductAttrSelected(gAttrTr, pmKey)">
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
			gAttrs: {
				type: [Array],
				default () {
					return []
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

		created () {
			this.setDefaultAttr();
		},

		methods: {
			setCustomText (gAttrTr, gkey, elet) {
				woogool.Vue.set(gAttrTr, 'name', elet.target.value);
			},
			setGooAttrReqVal (gooAttr, key, type, evt) {
				var self = this;
				var value = evt.target.value;
				
				jQuery.each(this.googleAttributes, function(index, googleAttribute) {
					jQuery.each(googleAttribute.attributes, function(position, attr) {
						
						if(attr.name == value) {
							let newAttr = Object.assign({}, attr, 
								{
									'woogool_suggest': gooAttr.woogool_suggest, 
									'type': type, 
									'format': 'required'
								}
							);
							
				 			self.gAttrs.splice(key, 1, newAttr);
						} 
					});
				});
			},
			setProAttrReqVal (gooAttr, key, evt) {
				var self = this;
				var value = evt.target.value;
				woogool.Vue.set( gooAttr, 'woogool_suggest', value );
			},
			setDefaultAttr () {
				var self = this;

				jQuery.each(this.googleAttributes, function(index, googleAttribute) {
					jQuery.each(googleAttribute.attributes, function(key, attr) {
						if(attr.format == 'required') {
							if(typeof attr.type == 'undefined') {
								woogool.Vue.set(attr, 'type', 'default');
							}
				 			self.gAttrs.push(attr);
						}
					});
				});
			},
			isGoogleAttrSelected (gAttributeTr, googleAttrTd) {
				return gAttributeTr.name == googleAttrTd.name ? 'selected' : false;
			},

			isProductAttrSelected (gAttributeTr, wpKey) {
				return gAttributeTr.woogool_suggest == wpKey ? 'selected' : false;
			},

			removeAttr(gAttributeTr, key) {
				if(!confirm('Are you sure')) {
					return;
				}

				this.gAttrs.splice(key, 1);
			},

			addMappingField () {
				this.gAttrs.push({
					'type': 'mapping',
					'format': 'required'
				});
			},

			addCustomField () {
				this.gAttrs.push({
					'type': 'custom',
					'format': 'required'
				});
			}
		}
	}
</script>







