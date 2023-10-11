import gsap from "gsap"
function fire(toElement, config, extraData={}) {
    console.log(toElement, config)
    gsap.to(toElement, config);
}

let config = {
    duration: .2,
    opacity: 0,
    x : '-=360',
    ease : 'power2.out'
}

export default {
    fire,
    config 
}