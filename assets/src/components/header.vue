<template>
	<div>
		<h2 class="nav-tab-wrapper">
            <router-link :class="'nav-tab ' + getNavTabClass('new_feed')" :to="{name: 'new_feed'}">New Feed</router-link>
            <router-link :class="'nav-tab ' + getNavTabClass('feed_lists')" :to="{name: 'feed_lists'}">Feed Lists</router-link>
        </h2>
	</div>
</template>


<script>
	export default {
		methods: {
			getNavTabClass (name) {
				var routeName = this.$route.name;

				if( routeName == name ) {
					return 'nav-tab-active';
				}

				return '';
 			}
		}
	}
</script>