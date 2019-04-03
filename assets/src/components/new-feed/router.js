import NewFeed from './new-feed.vue'
import GoogleShopping from './google-shopping/new-feed.vue'
import FacebookAds from './facebook-ads/new-feed.vue'
import BingShopping from './bing-shopping/new-feed.vue'

wpspearWooGoolRegisterChildrenRoute('woogool_root', 
    [   
        {
            path: 'new-feed', 
            component: NewFeed,
            name: 'new_feed',
            
            children: [
                {
                    path: 'google-shopping', 
                    component: GoogleShopping,
                    name: 'google_shopping',

                    children:[
                        {
                            path: ':feed_id/edit', 
                            component: GoogleShopping,
                            name: 'edit_google_shopping',
                        }
                    ]
                },

                {
                    path: 'facebook-ads', 
                    component: FacebookAds,
                    name: 'facebook_ads',

                    children:[
                        {
                            path: ':feed_id/edit', 
                            component: FacebookAds,
                            name: 'edit_facebook_ads',
                        }
                    ]
                },

                {
                    path: 'bing-shopping', 
                    component: BingShopping,
                    name: 'bing_shopping',

                    children:[
                        {
                            path: ':feed_id/edit', 
                            component: BingShopping,
                            name: 'edit_bing_shopping',
                        }
                    ]
                },
            ]

        }
        
    ]
);
