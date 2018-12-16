<template>
	<div>
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
					<th class="first"></th>
					<th class="second">TYPE</th>
					<th class="third">IF</th>
					<th class="fourth">CONDITION</th>
					<th class="five">VALUE</th>
					<th class="six">THEN</th>
					<th class="seven">is</th>
				</tr>
			</thead>

			<tbody>
				<template v-for="(logical, key) in logic">

					<tr>
						<td class="first">
							<a href="#" @click.prevent="removeAttr(key)""><span>X</span></a>
						</td>
						
						<td class="second">
							{{ ucfirst(logical.type) }}
						</td>
						
						<td class="third">
							<select class="woogool-drop">
								<optgroup 
									v-for="(proAttrTd, prokey) in proAttrs"
									:label="proAttrTd.label">
									<option
										v-for="(attribute, attrKey) in proAttrTd.attributes"
										:value="attrKey" 
										selected="">
										{{ attribute }} 
									</option>
								</optgroup>
								
							</select>
						</td>
						
						<td class="fourth">
							<div v-if="logical.type == 'filter'">
								<select class="woogool-drop">
									<option 
										v-for="filterCondDrop in filterCondDrops"
										:value="filterCondDrop.id">

										{{ filterCondDrop.label }}
									</option>
								</select>
							</div>

							<div v-if="logical.type == 'rule' || logical.type == 'value'">
								<select class="woogool-drop">
									<option 
										v-for="ruleCondDrop in ruleCondDrops"
										:value="ruleCondDrop.id">

										{{ ruleCondDrop.label }}
									</option>
								</select>
							</div>
						</td>
						
						<td class="five">
							<input class="woogool-text" type="text">
						</td>
						
						<td class="six">
							<div v-if="logical.type == 'filter'">
								<select class="woogool-drop">
									<option value="exclude">Exclude</option>
									<option value="include">Include</option>
								</select>
							</div>

							<div v-if="logical.type == 'rule'">
								<select class="woogool-drop">
									<optgroup 
										v-for="(proAttrTd, prokey) in proAttrs"
										:label="proAttrTd.label">
										<option
											v-for="(attribute, attrKey) in proAttrTd.attributes"
											:value="attrKey" 
											selected="">
											{{ attribute }} 
										</option>
									</optgroup>
									
								</select>
							</div>

							<div v-if="logical.type == 'value'">THEN</div>

						</td>

						<td class="seven">
							<div v-if="logical.type == 'rule' || logical.type == 'value'">
								<input class="woogool-text" type="text">
							</div>
						</td>
					</tr>

				</template>
			</tbody>
		</table>
		
		<div>
			<a href="#" class="button button-primary" @click.prevent="changeStage('second')">{{ 'Prev' }}</a>
			<a href="#" class="button button-primary" @click.prevent="addFields('filter')">{{ '+ Filter' }}</a>
			<a href="#" class="button button-primary" @click.prevent="addFields('rule')">{{ '+ Rule' }}</a>
			<a href="#" class="button button-primary" @click.prevent="addFields('value')">{{ '+ Value' }}</a>
			<input type="submit" class="button button-primary" value="Submit">
		</div>
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
						label: 'Contains'
					},
					{
						id: 'does_not_contain',
						label: 'does not contain'
					},
					{
						id: 'is_equal_to',
						label: 'is equal to'
					},
					{
						id: 'is_not_equal_to',
						label: 'is not equal to'
					},
					{
						id: 'is_greater_than',
						label: 'is greater than'
					},
					{
						id: 'is_greater_or_equal_to',
						label: 'is greater or equal to'
					},
					{
						id: 'is_less_than',
						label: 'is less than'
					},
					{
						id: 'is_less_or_equal_to',
						label: 'is less or equal to'
					},
					{
						id: 'is_empty',
						label: 'is empty'
					},
				],

				ruleCondDrops: [
					{
						id: 'contains',
						label: 'Contains'
					},
					{
						id: 'does_not_contain',
						label: 'does not contain'
					},
					{
						id: 'is_equal_to',
						label: 'is equal to'
					},
					{
						id: 'is_not_equal_to',
						label: 'is not equal to'
					},
					{
						id: 'is_greater_than',
						label: 'is greater than'
					},
					{
						id: 'is_greater_or_equal_to',
						label: 'is greater or equal to'
					},
					{
						id: 'is_less_than',
						label: 'is less than'
					},
					{
						id: 'is_less_or_equal_to',
						label: 'is less or equal to'
					},
					{
						id: 'is_empty',
						label: 'is empty'
					},
					{
						id: 'multiply',
						label: 'multiply'
					},
					{
						id: 'divide',
						label: 'divide'
					},
					{
						id: 'plus',
						label: 'plus'
					},
					{
						id: 'minus',
						label: 'minus'
					},
					{
						id: 'replace',
						label: 'replace'
					},
				],
			}
		},

		methods: {
			addFields (type) {
				var filter = {
					type: type,
					if: '',
					condition: '',
					value: '',
					then: '',
					is: ''
				}

				this.logic.push(filter);
			},

			removeAttr (key) {
				if(!confirm('Are you sure')) {
					return;
				}
				
				this.logic.splice(key, 1);
			}
		}
	}
</script>