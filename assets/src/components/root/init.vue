<template>
	<router-view></router-view>
</template>

<script>

	export default {
		created () {
			if ( '/' === this.$route.path ) {
				this.$router.push(
					{
						name: 'new_feed'
					}
				);
			}
		},

		watch: {
			'$route' () {
				if ( '/' === this.$route.path ) {
					this.$router.push(
						{
							name: 'new_feed'
						}
					);
				}
			}
		}
	}
</script>