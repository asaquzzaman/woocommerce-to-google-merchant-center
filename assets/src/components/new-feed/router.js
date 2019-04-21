import NewFeed from './new-feed.vue'
import GoogleShopping from './google-shopping/new-feed.vue'
import FacebookAds from './facebook-ads/new-feed.vue'
import BingShopping from './bing-shopping/new-feed.vue'
import GoogleShoppingPromotion from './google-shopping-promotion/new-feed.vue'
import GoogleLocal from './google-local/new-feed.vue'
import GoogleDRM from './google-drm/new-feed.vue'
import GoogleInventory from './google-inventory/new-feed.vue'

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

                {
                    path: 'google-shopping-promotion', 
                    component: GoogleShoppingPromotion,
                    name: 'google_shopping_promotion',

                    children:[
                        {
                            path: ':feed_id/edit', 
                            component: GoogleShoppingPromotion,
                            name: 'edit_google_shopping_promotion',
                        }
                    ]
                },

                 {
                    path: 'google-local', 
                    component: GoogleLocal,
                    name: 'google_local',

                    children:[
                        {
                            path: ':feed_id/edit', 
                            component: GoogleLocal,
                            name: 'edit_google_local',
                        }
                    ]
                },
                {
                    path: 'google-inventory', 
                    component: GoogleInventory,
                    name: 'google_inventory',

                    children:[
                        {
                            path: ':feed_id/edit', 
                            component: GoogleInventory,
                            name: 'edit_google_inventory',
                        }
                    ]
                },
                {
                    path: 'google-drm', 
                    component: GoogleDRM,
                    name: 'google_drm',

                    children:[
                        {
                            path: ':feed_id/edit', 
                            component: GoogleDRM,
                            name: 'edit_google_drm',
                        }
                    ]
                },
            ]

        }
        
    ]
);
