class Router{
    static install(Vue, options) {
        console.log(options);
        Vue.mixin({
            // Anything added to a mixin will be injected into all components.
            // In this case, the mounted() method runs when the component is added to the DOM.
            mounted() {
                console.log('Mounted!');
            }
        });
        Object.defineProperty(Vue.prototype, '$componentRouter', {
            get: function get () { return 'this._routerRoot._router' }
        });
    }
}

export default Router;