import RouteAbstract from './RouteAbstract';
export default function Route(name, parameters = {...parameters}) {
    let routeQuerried = new RouteAbstract(name, parameters);
    // console.log(routeQuerried)
    return routeQuerried.routeObject.renderedUrl ? routeQuerried.routeObject.renderedUrl : routeQuerried.routeObject.url;
}
