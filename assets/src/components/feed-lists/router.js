import FeedLists from './feed-lists'

wpspearWooGoolRegisterChildrenRoute('woogool_root', 
    [   
        {
            path: 'feed-lists', 
            component: FeedLists,
            name: 'feed_lists',

        }
        
    ]
);
