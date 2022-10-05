function centerScreen() {
    return {
        x : window.innerWidth / 2,
        y: window.innerHeight / 2
    }
}

function count(elm) {
    return elm.length;
}

function addInstance(key, instance, label = 'instance') {
    if(!window[label]) {
        window[label] = {};
    }

    window[label][key] = instance;

    return window[label];
}

function removeInstance(key, label = 'instance') {
    if(window[label][key]) {
        delete window[label][key];
    }
    return window[label];
}

function getInstance(key, label = 'instance') {
    if(!window[label][key]) {
        return null;
    }
    return window[label][key];
}

function getInstances(label = 'instance') {
    if(!window[label]) {
        return undefined;
    }
    return window[label];
}

export {
    count,
    addInstance,
    removeInstance,
    getInstance,
    centerScreen,
    getInstances
}
