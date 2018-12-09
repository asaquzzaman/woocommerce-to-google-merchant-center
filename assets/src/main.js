
import '@helpers/less/woogool-style.less'
import router from '@router/router'
import store from '@store/store'
import '@directives/directive'
import Mixin from '@helpers/mixin/mixin'
import Woogool from './App.vue'
import '@helpers/common-components'

window.woogoolBus = new woogool.Vue();

/**
 * Project template render
 */
var Woogool_Vue = {
    el: '#wpspear-woogool',
    store,
    router,
    render: t => t(Woogool),
}

woogool.Vue.mixin(Mixin);

new woogool.Vue(Woogool_Vue); 
	





