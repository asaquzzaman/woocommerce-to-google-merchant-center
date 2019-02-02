<template>
	<div>
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
					
					<th class="second">TYPE</th>
					<th class="third">IF</th>
					<th class="fourth">CONDITION</th>
					<th class="five">VALUE</th>
					<th class="six">THEN</th>
					<th class="seven">is</th>
					<th class="first"></th>
				</tr>
			</thead>

			<tbody>
				<template v-for="(logical, key) in logic">

					<tr>
						
						<td class="second">
							{{ ucfirst(logical.type) }}
						</td>
						
						<td class="third">
							<select @change="setData(logical, 'if_cond', $event)" class="woogool-drop">
								<optgroup 
									v-for="(proAttrTd, prokey) in proAttrs"
									:label="proAttrTd.label">
									<option
										v-for="(attribute, attrKey) in proAttrTd.attributes"
										:value="attrKey" 
										:selected="logical.if == attrKey ? 'selected' : ''">
										{{ attribute }} 
									</option>
								</optgroup>
								
							</select>
						</td>
						
						<td class="fourth">
							<div v-if="logical.type == 'filter'">
								<select @change="setData(logical, 'condition', $event)" class="woogool-drop">
									<option 
										v-for="filterCondDrop in filterCondDrops"
										:value="filterCondDrop.id"
										:selected="logical.condition == filterCondDrop.id ? 'selected' : ''">

										{{ filterCondDrop.label }}
									</option>
								</select>
							</div>

							<div v-if="logical.type == 'rule' || logical.type == 'value'">
								<select @change="setData(logical, 'condition', $event)" class="woogool-drop">
									<option 
										v-for="ruleCondDrop in ruleCondDrops"
										:value="ruleCondDrop.id"
										:selected="logical.condition == ruleCondDrop.id ? 'selected' : ''">

										{{ ruleCondDrop.label }}
									</option>
								</select>
							</div>
						</td>
						
						<td class="five">
							<input :placeholder="logical.condition=='contains' || logical.condition=='does_not_contain'? 'val_1|val_2|val_3' : ''" 
								:value="logical.value" 
								@input="setData(logical, 'value', $event)" 
								class="woogool-text" type="text">
								
							<div v-if="logical.condition=='contains' || logical.condition=='does_not_contain'">Value seperated by |</div>
						</td>
						
						<td class="six">
							<div v-if="logical.type == 'filter'">
								<select @change="setData(logical, 'then', $event)" class="woogool-drop">
									<option :selected="logical.then == 'exclude' ? 'selected' : ''" value="exclude">
										Exclude
									</option>
									<option :selected="logical.then == 'include' ? 'selected' : ''" value="include">
										Include
									</option>
								</select>
							</div>

							<div v-if="logical.type == 'rule'">
								<select @change="setData(logical, 'then', $event)" class="woogool-drop">
									<optgroup 
										v-for="(proAttrTd, prokey) in proAttrs"
										:label="proAttrTd.label">
										<option
											v-for="(attribute, attrKey) in proAttrTd.attributes"
											:value="attrKey" 
											:selected="logical.then == attrKey ? 'selected' : ''">
											{{ attribute }} 
										</option>
									</optgroup>
									
								</select>
							</div>

							<div v-if="logical.type == 'value'">THEN</div>

						</td>

						<td class="seven">
							<div v-if="logical.type == 'rule' || logical.type == 'value'">
								<input :value="logical.is" @input="setData(logical, 'is', $event)" class="woogool-text" type="text">
							</div>
						</td>

						<td class="first">
							<a href="#" @click.prevent="removeAttr(key)"><span class="icon-woogool-delete"></span></a>
						</td>
					</tr>

				</template>
			</tbody>
		</table>
	</div>
</template>

<style lang="less">

	.wp-list-table {
		.first {
			width: 1em;
		}
		.second {
			width: 3em;
		}

		.woogool-drop, .woogool-text {
			width: 150px;
		}
	}
</style>

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
			logic: {
				type: [Array],
				default () {
					return []
				}
			}
		},

		data () {
			return {
				proAttrs: woogool_multi_product_var.woogool_product_attribute_with_optgroups,
				filterCondDrops: [
					{
						id: 'contains',
						label: 'Contains',
						sign: 'contain'
					},
					{
						id: 'does_not_contain',
						label: 'does not contain',
						sign: 'not_contain'
					},
					{
						id: 'is_equal_to',
						label: 'is equal to',
						sign: '='
					},
					{
						id: 'is_not_equal_to',
						label: 'is not equal to',
						sign: '!='
					},
					{
						id: 'is_greater_than',
						label: 'is greater than',
						sign: '>'
					},
					{
						id: 'is_greater_or_equal_to',
						label: 'is greater or equal to',
						sign: '>='
					},
					{
						id: 'is_less_than',
						label: 'is less than',
						sign: '<'
					},
					{
						id: 'is_less_or_equal_to',
						label: 'is less or equal to',
						sign: '<='
					},
					{
						id: 'is_empty',
						label: 'is empty',
						sign: ''
					},
				],

				ruleCondDrops: [
					{
						id: 'contains',
						label: 'Contains',
						sign: 'contain'
					},
					{
						id: 'does_not_contain',
						label: 'does not contain',
						sign: 'not_contain'
					},
					{
						id: 'is_equal_to',
						label: 'is equal to',
						sign: '='
					},
					{
						id: 'is_not_equal_to',
						label: 'is not equal to',
						sign: '!='
					},
					{
						id: 'is_greater_than',
						label: 'is greater than',
						sign: '>'
					},
					{
						id: 'is_greater_or_equal_to',
						label: 'is greater or equal to',
						sign: '>='
					},
					{
						id: 'is_less_than',
						label: 'is less than',
						sign: '<'
					},
					{
						id: 'is_less_or_equal_to',
						label: 'is less or equal to',
						sign: '<='
					},
					{
						id: 'is_empty',
						label: 'is empty',
						sign: ''
					},
					{
						id: 'multiply',
						label: 'multiply',
						sign: '*'
					},
					{
						id: 'divide',
						label: 'divide',
						sign: '/'
					},
					{
						id: 'plus',
						label: 'plus',
						sign: '+'
					},
					{
						id: 'minus',
						label: 'minus',
						sign: '-'
					},
					{
						id: 'replace',
						label: 'replace',
						sign: 'replace'
					},
				],
			}
		},

		methods: {

			removeAttr (key) {
				if(!confirm('Are you sure')) {
					return;
				}
				
				this.logic.splice(key, 1);
			},

			setData (dataObje, key, evt) {
				dataObje[key] = evt.target.value;
			},

			isProductAttrSelected (gAttributeTr, wpKey) {
				return gAttributeTr.woogool_suggest == wpKey ? 'selected' : false;
			},
		}
	}
</script>