import SavingForm from './components/SavingForm'

class ComponentRouter{
    constructor({routes}) {
        this._routes = routes
        console.log(routes);
    }

    static install(Vue, options) {
        console.log(this);

        let isDef = function (v) { return v !== undefined; };

        // let registerInstance = function (vm, callVal) {
        //     let i = vm.$options._parentVnode;
        //     if (isDef(i) && isDef(i = i.data) && isDef(i = i.registerRouteInstance)) {
        //         i(vm, callVal);
        //     }
        // };

        Vue.mixin({
            // Anything added to a mixin will be injected into all components.
            // In this case, the mounted() method runs when the component is added to the DOM.
            beforeCreate: function beforeCreate () {
                if (isDef(this.$options.componentRouter)) {
                    this._routerRoot = this;
                    this._router = this.$options.componentRouter;
                    // this._router.init(this);
                    Vue.util.defineReactive(this, '_componentRouter', this._router);
                } else {
                    this._routerRoot = (this.$parent && this.$parent._routerRoot) || this;
                }
                // registerInstance(this, this);
            },
            destroyed: function destroyed () {
                // registerInstance(this);
            }
        });
        Object.defineProperty(Vue.prototype, '$componentRouter', {
            get: function get () { return this.$options.componentRouter }
        });
        Vue.util.defineReactive(this, '_componentRoute', 'asd')
        Object.defineProperty(Vue.prototype, '$componentRoute', {
            get: function get () { return this.$options.componentRoute }
        });
        Vue.component('component-route-view', View);
    }
}

var View = {
    name: 'component-route-view',
    functional: true,
    props: {
        name: {
            type: String,
            default: 'default'
        }
    },
    render: function render (_, ref) {
        var props = ref.props;
        var children = ref.children;
        var parent = ref.parent;
        var data = ref.data;

        data.routerView = true;

        // directly use parent context's createElement() function
        // so that components rendered by router-view can resolve named slots
        var h = parent.$createElement;
        var name = props.name;
        var route = parent.$componentRoute;
        var cache = parent._routerViewCache || (parent._routerViewCache = {});
        console.log(route);

        return h(SavingForm, data, children)
    },
    watch: {
        window
    }
}

export default ComponentRouter;