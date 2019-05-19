<template>
	<div>
		<table class="wp-list-table woogool-map-table widefat striped posts">
			<thead>
				<tr>
					
					<th>Bing Shopping Attributes</th>
					<th>Product Attributes</th>
					<th></th>

				</tr>
			</thead>

			<tbody>
				<template 
					v-for="(gAttrTr, gkey) in gAttrs" 
					v-if="gAttrTr.format == 'required'">
				
					<tr :key="gkey" v-if="gAttrTr.type == 'default'">
						<td>
							<select class="map-drop-down-left" @change="setGooAttrReqVal(gAttrTr, gkey, gAttrTr.type, $event)">
								<optgroup 
									v-for="(bingAttributeTd, key) in bingAttributes"
									:label="bingAttributeTd.label">
									<option
										v-for="(bingAttrTd, optKey) in bingAttributeTd.attributes"
										:value="bingAttrTd.name" 
										:selected="isBingAttrSelected(gAttrTr, bingAttrTd)">
										{{ bingAttrTd.label }} {{ '('+bingAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select class="map-drop-down" @change.self="setProAttrReqVal(gAttrTr, gkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, proMetaKey) in woogoolAttributes"
									:value="proMetaKey"
									:selected="isProductAttrSelected(gAttrTr, proMetaKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>

						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, gkey)"><span class="icon-woogool-delete"></span></a>
						</td>
					</tr>
			
					<!-- For extra map fields -->
					<tr :key="gkey" v-if="gAttrTr.type == 'mapping'">
						<td>
							<select class="map-drop-down-left" @change.self="setGooAttrReqVal(gAttrTr, gkey, gAttrTr.type, $event)">
								<option value=""></option>
								<optgroup 
									v-for="(bingAttributeTd, key) in bingAttributes"
									:label="bingAttributeTd.label">
									<option 
										v-for="(bingAttrTd, mKey) in bingAttributeTd.attributes"
										:value="bingAttrTd.name"
										:selected="isBingAttrSelected(gAttrTr, bingAttrTd)">
										{{ bingAttrTd.label }} {{ '('+bingAttrTd.feed_name+')' }}
									</option>
								</optgroup>
								
							</select>
						</td>
						<td>
							<select class="map-drop-down" @change.self="setProAttrReqVal(gAttrTr, gkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, wpKey) in woogoolAttributes"
									:value="wpKey"
									:selected="isProductAttrSelected(gAttrTr, wpKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>

						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, gkey)"><span class="icon-woogool-delete"></span></a>
						</td>
					</tr>

					<!-- For custom fields -->
					<tr :key="gkey" v-if="gAttrTr.type == 'custom'">
						<td>
							<input class="custom-field-text" :value="gAttrTr.name" type="text" @input="setCustomText(gAttrTr, gkey, $event)">
						</td>
						<td>
							<select class="map-drop-down" @change.self="setProAttrReqVal(gAttrTr, gkey, $event)">
								<option value=""></option>
								<option 
									v-for="(woogoolAttribute, pmKey) in woogoolAttributes"
									:value="pmKey"
									:selected="isProductAttrSelected(gAttrTr, pmKey)">
									{{ woogoolAttribute }}
								</option>
							</select>
						</td>

						<td>
							<a href="#" @click.prevent="removeAttr(gAttrs, gkey)"><span class="icon-woogool-delete"></span></a>
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
				bingAttributes: woogool_multi_product_var.woogool_bing_shopping_attributes,
				woogoolAttributes: woogool_multi_product_var.woogool_product_attributes,
				bingExtraAttrFields: woogool_multi_product_var.bing_extra_attr_fields,
			}
		},

		created () {
			if(!this.extAttr.updateMode) {
				this.gAttrs.length = 0;
				this.setDefaultAttr();
			}
		},

		methods: {
			setCustomText (gAttrTr, gkey, elet) {
				woogool.Vue.set(gAttrTr, 'name', elet.target.value);
			},
			setGooAttrReqVal (gooAttr, key, type, evt) {
				var self = this;
				var value = evt.target.value;
				
				jQuery.each(this.bingAttributes, function(index, bingAttribute) {
					jQuery.each(bingAttribute.attributes, function(position, attr) {
						
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

				jQuery.each(this.bingAttributes, function(index, bingAttribute) {
					jQuery.each(bingAttribute.attributes, function(key, attr) {
						if(attr.format == 'required') {
							if(typeof attr.type == 'undefined') {
								woogool.Vue.set(attr, 'type', 'default');
							}

				 			self.gAttrs.push(attr);
						}
					});
				});
			},
			isBingAttrSelected (gAttributeTr, bingAttrTd) {
				return gAttributeTr.name == bingAttrTd.name ? 'selected' : false;
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






