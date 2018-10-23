class Router{
    static install(Vue, options) {
        console.log(options);
        Vue.mixin({
            // Anything added to a mixin will be injected into all components.
            // In this case, the mounted() method runs when the component is added to the DOM.
        });
        Object.defineProperty(Vue.prototype, '$componentRouter', {
            get: function get () { return 'this._routerRoot._router' }
        });
        Object.defineProperty(Vue.prototype, '$componentRoute', {
            get: function get () { return this }
        });
        Vue.component('router-component-view', View)
    }
}

var View = {
    name: 'router-component-view',
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

    }
};

export default Router;