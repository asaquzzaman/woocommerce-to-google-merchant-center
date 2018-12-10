<template>
	<div class="wrap">
		<feed-header></feed-header>
		<form action="" method="post">
			<form-header :header="{}"></form-header>
			<form-content :content="{}"></form-content>
			<form-logic :logic="{}"></form-logic>
			<input type="submit" class="button button-primary" value="Submit">
		</form>
	</div>
</template>


<script>
	import Header from '@components/header.vue'
	import FormHeader from '@components/new-feed/form-header.vue'
	import FormContent from '@components/new-feed/form-logic.vue'
	import FormLogic from '@components/new-feed/form-content.vue'



	export default {
		components: {
			'feed-header': Header,
			'form-header': FormHeader,
			'form-content': FormContent,
			'form-logic': FormLogic
		}
	}
</script>