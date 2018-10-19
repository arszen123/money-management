export default {
    name: 'ComponentRouterView',
    functional: true,
    props: {
        name: {
            type: String,
            default: 'default'
        }
    },
    render (_, { props, children, parent, data }) {
        console.log({ props, children, parent, data });
        // used by devtools to display a router-view badge
        data.routerView = true
        // directly use parent context's createElement() function
        // so that components rendered by router-view can resolve named slots
        const h = parent.$createElement
        const name = props.name
        const route = parent.$componentRouter
        let current = parent.$componentRouter.get()
        const routeName = current.split('.')[0];
        current = current.split('.')[1];
        // if (!(name === routeName || typeof parent.$componentRouter.currents[name] !== 'undefined')) { return;}
        current = typeof parent.$componentRouter.currents[name] !== 'undefined' ? typeof parent.$componentRouter.currents[name] : current;
        parent.$componentRouter.currents[name] = current;
        // determine current view depth, also check to see if the tree
        // has been toggled inactive but kept-alive.
        let depth = 0
        let inactive = false
        let component = null
        for (let i in parent.$componentRoute) {
            if (parent.$componentRoute[i].name === current) {
                component = parent.$componentRoute[i].component;
                break;
            }
        }

        data.registerRouteInstance = (vm, val) => {
            // val could be undefined for unregistration
            console.log('called');
        }

        ;(data.hook || (data.hook = {})).prepatch = (_, vnode) => {
            console.log('called2')
        }

        return h(component, data, children)
    }
}

function resolveProps (route, config) {
    switch (typeof config) {
        case 'undefined':
            return
        case 'object':
            return config
        case 'function':
            return config(route)
        case 'boolean':
            return config ? route.params : undefined
        default:
            if (process.env.NODE_ENV !== 'production') {
                warn(
                    false,
                    `props in "${route.path}" is a ${typeof config}, ` +
                    `expecting an object, function or boolean.`
                )
            }
    }
}