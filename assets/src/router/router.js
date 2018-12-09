import FeedLists from '@components/feed-lists/router';
import NewFeed from '@components/new-feed/router';

import Empty from '@components/root/init.vue';

wooGoolRouters.push({
	path: '/', 
    component:  Empty,
    name: 'woogool_root',

	children: wpspearWooGoolGetRegisterChildrenRoute('woogool_root')
});

var router = new woogool.VueRouter({
	routes: wooGoolRouters,
});




export default router;

