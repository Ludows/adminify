export default function Route(name, parameters = {...parameters}) {
    const RouteAbstract = require('./RouteAbstract').default;
    let routeQuerried = new RouteAbstract(name, parameters);
    // console.log(routeQuerried)
    return routeQuerried.routeObject.renderedUrl ? routeQuerried.routeObject.renderedUrl : routeQuerried.routeObject.url;
}
