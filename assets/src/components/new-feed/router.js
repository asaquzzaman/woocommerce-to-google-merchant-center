import NewFeed from './new-feed'

wpspearWooGoolRegisterChildrenRoute('woogool_root', 
    [   
        {
            path: 'new-feed', 
            component: NewFeed,
            name: 'new_feed',
            
            children: [
            	{
            		path: ':feed_id/edit', 
		            component: NewFeed,
		            name: 'edit_feed',
            	}
            ]

        }
        
    ]
);
