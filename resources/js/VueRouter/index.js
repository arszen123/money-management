import { install } from './install'

export default class ComponentRouter {
    static install () {};

    constructor ({routes}) {
        this._routes = routes
        this.current = window.current;
        window.current = 'default'
        window.currents = {};
        this.currents = {};
    }
    init (app) {
        // this._routes.listen(route => {
        //     app._route = route
        // })
    }


    beforeEach (fn) {
        console.log(fn)
    }

    beforeResolve (fn) {
        console.log(fn)
    }

    afterEach (fn) {
        console.log(fn)
    }

    onReady (cb, errorCb) {
        console.log(cb, errorCb)
    }


    go (name) {
        window.current = name;
        this.current = name;
    }

    get (name) {
        return window.current;
    }

    beforeEach (fn) {
        return fn;
    }
}

ComponentRouter.install = install

if (window.Vue) {
    window.Vue.use(ComponentRouter)
}