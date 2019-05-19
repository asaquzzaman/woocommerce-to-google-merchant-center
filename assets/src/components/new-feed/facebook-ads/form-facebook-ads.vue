<template>
	<div>
		<table class="wp-list-table woogool-map-table widefat striped posts">
			<thead>
				<tr>
					
					<th>Facebook dynamic ads attributes</th>
					<th>Product Attributes</th>
					<th></th>

				</tr>
			</thead>

			<tbody>
				<template 
					v-for="(fAttrTr, fkey) in gAttrs" 
					v-if="fAttrTr.format == 'required'">
				
					<tr :key="fkey" v-if="fAttrTr.type == 'default'">
						<td>
							<select class="map-drop-down-left" @change="setGooAttrReqVal(fAttrTr, fkey, fAttrTr.type, $event)">
								<optgroup 
									v-for="(facebookAttributeTd, key) in facebookAttributes"
									:label="facebookAttributeTd.label">
									<option
										v-for="(facebookAttrTd, optKey) in facebookAttributeTd.attributes"
										:value="facebookAttrTd.name" 
										:selected="isGoogleAttrSelected(fAttrTr, facebookAttrTd)">
										{{ facebookAttrTd.label }} {{ '('+facebookAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select class="map-drop-down" @change.self="setProAttrReqVal(fAttrTr, fkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, proMetaKey) in woogoolAttributes"
									:value="proMetaKey"
									:selected="isProductAttrSelected(fAttrTr, proMetaKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>

						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, fkey)"><span class="icon-woogool-delete"></span></a>
						</td>
					</tr>
			
					<!-- For extra map fields -->
					<tr :key="fkey" v-if="fAttrTr.type == 'mapping'">
						<td>
							<select class="map-drop-down-left" @change.self="setGooAttrReqVal(fAttrTr, fkey, fAttrTr.type, $event)">
								<option value=""></option>
								<optgroup 
									v-for="(facebookAttributeTd, key) in facebookAttributes"
									:label="facebookAttributeTd.label">
									<option 
										v-for="(facebookAttrTd, mKey) in facebookAttributeTd.attributes"
										:value="facebookAttrTd.name"
										:selected="isGoogleAttrSelected(fAttrTr, facebookAttrTd)">
										{{ facebookAttrTd.label }} {{ '('+facebookAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select class="map-drop-down" @change.self="setProAttrReqVal(fAttrTr, fkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, wpKey) in woogoolAttributes"
									:value="wpKey"
									:selected="isProductAttrSelected(fAttrTr, wpKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>

						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, fkey)"><span class="icon-woogool-delete"></span></a>
						</td>
					</tr>

					<!-- For custom fields -->
					<tr :key="fkey" v-if="fAttrTr.type == 'custom'">
						<td>
							<input class="custom-field-text" :value="fAttrTr.name" type="text" @input="setCustomText(fAttrTr, fkey, $event)">
						</td>
						<td>
							<select class="map-drop-down" @change.self="setProAttrReqVal(fAttrTr, fkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, pmKey) in woogoolAttributes"
									:value="pmKey"
									:selected="isProductAttrSelected(fAttrTr, pmKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>

						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, fkey)"><span class="icon-woogool-delete"></span></a>
						</td>
					</tr>

				</template>
				
			</tbody>

		</table>
	</div>
</template>
<style lang="less">
	.woogool-map-table {
		border: none !important;
		box-shadow: none !important;

		th {
			border-bottom: none !important;
			font-weight: 600;
			margin: 0 !important;
			padding: 12px !important;
		}
		td {
			vertical-align: middle;
		}

		.map-drop-down {
			width: 100%;
			height: 32px;
		}
		.map-drop-down-left {
			height: 32px;
		} 
		.custom-field-text {
			width: 462px;
		}
	}
</style>
<script>
	import Mixin from '@components/new-feed/mixin'

	export default {
		mixins: [Mixin],
		props: {
			extAttr: {
				type: [Object],
				default () {
					return {}
				}
			},
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
				facebookAttributes: woogool_multi_product_var.facebook_ad_attributes,
				woogoolAttributes: woogool_multi_product_var.woogool_product_attributes,
				//googleExtraAttrFields: woogool_multi_product_var.google_extra_attr_fields,
			}
		},

		created () {
			if(typeof this.facebookAttributes.remarketing_fields.attributes.identifier_exists != 'undefined') {
				delete this.facebookAttributes.remarketing_fields.attributes['identifier_exists'];
			}
			if(!this.extAttr.updateMode) {
				this.gAttrs.length = 0;
				this.setDefaultAttr();
			} 
		},

		methods: {
			setCustomText (fAttrTr, fkey, elet) {
				woogool.Vue.set(fAttrTr, 'name', elet.target.value);
			},
			setGooAttrReqVal (gooAttr, key, type, evt) {
				var self = this;
				var value = evt.target.value;
				
				jQuery.each(this.facebookAttributes, function(index, googleAttribute) {
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

				jQuery.each(this.facebookAttributes, function(index, googleAttribute) {
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
			isGoogleAttrSelected (gAttributeTr, facebookAttrTd) {
				return gAttributeTr.name == facebookAttrTd.name ? 'selected' : false;
			},

			isProductAttrSelected (gAttributeTr, wpKey) {
				return gAttributeTr.woogool_suggest == wpKey ? 'selected' : '';
			},

			removeAttr(gAttributeTr, key) {
				if(!confirm('Are you sure')) {
					return;
				}

				this.gAttrs.splice(key, 1);
			}
		}
	}
</script>







