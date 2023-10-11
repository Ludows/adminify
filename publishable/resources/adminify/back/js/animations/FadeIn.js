import gsap from "gsap"
function fire(toElement, config, extraDatas) {
    console.log(toElement, config)

    gsap.to(toElement, config);
}

let config = {
    duration: .2,
    opacity: 1,
    x : '0',
    ease : 'power2.in'
}

export default {
    fire,
    config 
}