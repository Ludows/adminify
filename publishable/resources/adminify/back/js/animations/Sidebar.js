import gsap from "gsap"
function fire(toElement, config, extraDatas) {

    if(extraDatas.isExpanded === false && extraDatas.isToggled === false) {
        return false;
    }

    console.log('pass', {
        toElement, config, extraDatas
    })

    gsap.to(toElement, {
        ...config,
        width: extraDatas.isExpanded ? '350px' : '100px',
    })
    // gsap.to(toElement, config);
}

let config = {
    duration: .4,
    ease : 'power2.in'
}

export default {
    fire,
    config 
}