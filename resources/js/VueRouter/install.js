import View from './components/componentView'
// import Link from './components/link'

export let _Vue

export function install(Vue) {
    if (install.installed && _Vue === Vue) return
    install.installed = true

    _Vue = Vue

    const isDef = v => v !== undefined

    const registerInstance = (vm, callVal) => {
        let i = vm.$options._parentVnode
        if (isDef(i) && isDef(i = i.data) && isDef(i = i.registerRouteInstance)) {
            i(vm, callVal)
        }
    }

    Vue.mixin({
        beforeCreate() {
            if (isDef(this.$options.componentRouter)) {
                this._componentRouterRoot = this
                this._componentRouter = this.$options.componentRouter
                this._router.init(this)
                Vue.util.defineReactive(this, '_componentRoute', this._componentRouter._routes)
            } else {
                this._componentRouterRoot = (this.$parent && this.$parent._componentRouterRoot) || this
            }
            registerInstance(this, this)
        },
        destroyed() {
            registerInstance(this)
        },
        watch:{
            _componentRoute () {
                console.log('changed!')
            }
        }
    })

    Object.defineProperty(Vue.prototype, '$componentRouter', {
        get() {
            return this._componentRouterRoot._componentRouter
        }
    })

    Object.defineProperty(Vue.prototype, '$componentRoute', {
        get() {
            return this._componentRouterRoot._componentRoute
        }
    })

    Vue.component('ComponentRouterView', View)
    // Vue.component('RouterLink', Link)
    const strats = Vue.config.optionMergeStrategies
    // use the same hook merging strategy for route hooks
    strats.beforeRouteEnter = strats.beforeRouteLeave = strats.beforeRouteUpdate = strats.created
}