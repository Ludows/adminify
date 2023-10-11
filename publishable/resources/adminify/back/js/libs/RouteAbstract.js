export default class RouteAbstract {
    constructor(routeName, parameters = {...parameters}) {
        this.parameters = parameters;
        this.routeObject = this.get(routeName);
    }
    checkMissingRoute(name = null) {
        let params = this.getParameters();

        if(!window.LaravelRoutes) {
            throw new Error('window.LaravelRoutes wasn\'t generated')
        }
        if(!window.LaravelRoutes[name] && name != null) {
            throw new Error(name+ ' was not found');
        }
        if(window.LaravelRoutes[name].url.indexOf('}') > -1 && Object.keys(params).length === 0) {
            throw new Error(name+ ' has a required parameter. Please to fill the correct parameter');
        }

        return this;
    }
    hasParameters(route) {
        let ObjectLength = Object.keys(this.parameters);
        return ObjectLength.length > 0 ? true : false;
    }
    renderUrl(route, routeName) {
        let params = this.getParameters();
        let KeysParams = Object.keys(params);
        let _gets = ['?', '&'];
        if(KeysParams.length > 0) {
            for (let index = 0; index < KeysParams.length; index++) {
                const key = KeysParams[index];
                let str = `{${key}}`;
                let url = route.url;
                if(url.indexOf(str) === -1) {
                    //if not present we pass key to url as ? and &
                    let correctMatch = route.renderedUrl ? route.renderedUrl : url;
                    if(correctMatch.indexOf( _gets[0]+key ) === -1) {
                        str = _gets[0]+key+'='+params[key];
                    }
                    else if(correctMatch.indexOf( _gets[1]+key ) === -1) {
                        str = _gets[1]+key+'='+params[key];
                    }
                    route.renderedUrl = route.renderedUrl ? route.renderedUrl+str : url+str;
                    // console.log('route.renderedUrl a', route.renderedUrl)
                }
                else {
                    route.renderedUrl = url.replace(str, params[key]);
                    // console.log('route.renderedUrl b ', route.renderedUrl)
                }
            }
        }
        return route;
    }
    get(name) {
        this.checkMissingRoute(name);

        if(this.hasParameters()) {
            return this.renderUrl(window.LaravelRoutes[name], name);
        }
        else {
            if(window.LaravelRoutes[name].renderedUrl) {
                delete window.LaravelRoutes[name].renderedUrl;
                // console.log(window.LaravelRoutes[name])
            }
            return window.LaravelRoutes[name];
        }
    }
    getParameters() {
        return this.parameters;
    }
    listRoutes() {
        this.checkMissingRoute();
        return window.LaravelRoutes;
    }
}


