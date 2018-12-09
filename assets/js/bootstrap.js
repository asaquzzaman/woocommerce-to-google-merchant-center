window.woogool = {};
const woogoolMixin = {};
const woogoolProMixin = {};
const woogoolProComment = {};
const wooGoolRouters = [];
const wpspear_WooGool_Components = [];
const wpspearWooGoolChildrenRouter = {};
const wpspearWooGoolModules = [];
const wpspearWooGoolProModules = [];
const wpspearWooGoolProAddonModules = [];
const woogoolFilters = {};


function wpspearWooGoolRegisterChildrenRoute (parentRouteName, routes) {
    
	routes.forEach(function(route) {
		if (wpspearWooGoolChildrenRouter.hasOwnProperty(parentRouteName)  ) {
			wpspearWooGoolChildrenRouter[parentRouteName].push(route);
		} else {
			wpspearWooGoolChildrenRouter[parentRouteName] = [route];
		}
	});
};

function wpspearWooGoolGetRegisterChildrenRoute(parentRouteName, prevRoute) {
	var prevRoute = prevRoute || [];

	if (wpspearWooGoolChildrenRouter.hasOwnProperty(parentRouteName)  ) {
		return prevRoute.concat(wpspearWooGoolChildrenRouter[parentRouteName]);
	}
	
	return prevRoute;
}

function wpspearWooGoolRegisterModule(module, path) {
	wpspearWooGoolModules.push(
		{
			'name': module,
			'path': path
		}
	);
}

function wpspearWooGoolProRegisterModule(module, path) {
	wpspearWooGoolProModules.push(
		{
			'name': module,
			'path': path
		}
	);
}

function wpspearWooGoolProAddonRegisterModule(module, path) {
	wpspearWooGoolProAddonModules.push(
		{
			'name': module,
			'path': path
		}
	);
}

/**
 * Add a new Filter callback to Hooks.filters
 *
 * @param tag The tag specified by apply_filters()
 * @param callback The callback function to call when apply_filters() is called
 * @param priority Priority of filter to apply. Default: 10 (like WordPress)
 */
function woogool_add_filter( tag, callback, priority ) {
    let ref = [];

    if( typeof priority === "undefined" ) {
        priority = 10;
    }

    if (jQuery.isArray(callback)) {
        ref = [ callback[0].$options.name, callback[1]];
        callback = callback[0][callback[1]];
    }

    // If the tag doesn't exist, create it.
    woogoolFilters[tag] = woogoolFilters[ tag ] || [];
    woogoolFilters[tag].push( { priority: priority, callback: callback, ref: ref } );
}

/**
 * Calls filters that are stored in Hooks.filters for a specific tag or return
 * original value if no filters exist.
 *
 * @param tag A registered tag in Hook.filters
 * @options Optional JavaScript object to pass to the callbacks
 */
function woogool_apply_filters ( tag, value, options ) {

    var filters = [];

    if( typeof woogoolFilters[tag] !== "undefined" && woogoolFilters[tag].length > 0 ) {

        woogoolFilters[tag].forEach( function( hook ) {

            filters[hook.priority] = filters[hook.priority] || [];
            filters[hook.priority].push( hook.callback );
        } );

        filters.forEach( function( hooks ) {

            hooks.forEach( function( callback ) {
                value = callback( value, options );
            } );

        } );
    }

    return value;
}

/**
 * Remove a Filter callback from Hooks.filters
 *
 * Must be the exact same callback signature.
 * Warning: Anonymous functions can not be removed.
 * @param tag The tag specified by apply_filters()
 * @param callback The callback function to remove
 */
function woogool_remove_filter( tag, callback ) {
    if(typeof woogoolFilters[ tag ] === 'undefined' ) {
        return;
    }
    woogoolFilters[ tag ].forEach( function( filter, i ) {        
        if( ! jQuery.isArray(callback) && filter.callback.name === callback ) {
            woogoolFilters[ tag ].splice(i, 1);
        } else if ( jQuery.isArray(callback) && filter.ref.length ) {
            if ( filter.ref[0] === callback[0].$options.name && filter.ref[1] === callback[1] ) {
                woogoolFilters[ tag ].splice(i, 1);
            }
        }
    } );
}

function woogoolGetIndex( itemList, id, slug) {
    var index = false;

    jQuery.each(itemList, function(key, item) {

        if (item[slug] == id) {
            index = key;
        }
    });

    return index;
}
function woogoolUserCan(cap, project, user) {
    user    = user || WooGool_Vars.current_user;

    if ( woogoolHasManageCapability() ) {
        return true;
    }

    if ( ! woogoolIsUserInProject(project, user) ) {
        return false;
    }

    if( woogoolIsManager(project, user) ) {
        return true;
    }

    var role = woogoolGetRole(project, user);

    if ( !role ) {
        return false;
    }

    var role_caps = woogoolGetRoleCaps( project, role );

    if ( !Object.keys(role_caps).length  ) {
        return true;
    }

    if ( 
        role_caps.hasOwnProperty(cap) 
        &&
        (
            role_caps[cap] === true
            ||
            role_caps[cap] === 'true'
        )
    ) {
        return true;
    }

    return false;

}

function woogoolGetRoleCaps (project, role) {
    var default_project = {
        capabilities: {}
    },
    project = jQuery.extend(true, default_project, project );
    
    if( project.capabilities.hasOwnProperty(role) ) {
        return project.capabilities[role];
    } else {
        return [];
    }
}

function woogoolGetRole (project, user) {
    user    = user || WooGool_Vars.current_user;

    var default_project = {
        assignees: {
            data: []
        }
    },
    project = jQuery.extend(true, default_project, project );

    var index = woogoolGetIndex( project.assignees.data, user.ID, 'id' );

    if ( index === false ) {
        return false;
    }

    var project_user = project.assignees.data[index];
    
    return project_user.roles.data.length ? project_user.roles.data[0].slug : false;
}

function woogoolIsUserInProject (project, user) {
    var user    = user || WooGool_Vars.current_user;
    var user_id = user.ID;
    var default_project = {
        assignees: {
            data: []
        }
    },
    project = jQuery.extend(true, default_project, project );
    
    var index = woogoolGetIndex(project.assignees.data, user_id, 'id');

    if ( index === false ) {
        return false;
    }

    return true;
}
function woogoolIsManager (project, user) {
    user    = user || WooGool_Vars.current_user;

    if (woogoolHasManageCapability()){
        return true;
    }
    if ( !project ){
        return false;
    }
    var default_project = {
        assignees: {
            data: []
        }
    },
    project = jQuery.extend(true, default_project, project );

    var index = woogoolGetIndex( project.assignees.data, user.ID, 'id' );
    ( project.assignees.data, user.ID, 'id' );

    if ( index === false ) {
        return false;
    }

    var project_user = project.assignees.data[index];
    var role_index   = woogoolGetIndex( project_user.roles.data, 'manager', 'slug' );

    if ( role_index !== false ) {
        return true;
    }

    return false;
}

function woogoolHasManageCapability () {
    if ( WooGool_Vars.manage_capability === '1' ){
        return true;
    }
    return false;
}
function woogoolHasCreateCapability () {
    if ( WooGool_Vars.manage_capability === '1' ){
        return true;
    }
    if ( WooGool_Vars.create_capability === '1' ){
        return true;
    }
    return false; 
}
