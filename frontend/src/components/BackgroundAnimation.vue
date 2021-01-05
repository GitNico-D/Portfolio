<template>
    <svg id="background" xmlns="http://www.w3.org/2000/svg">
        <circle cx="246" cy="189" r="60" fill="#8cc63f"/>
        <circle cx="865" cy="348" r="50" fill="#29abe2"/>
        <circle cx="400" cy="290" r="40" fill="#a82a2a"/>
        <circle cx="550" cy="392" r="12" fill="#93278f"/>
    </svg>
</template>

<script>
import { gsap } from 'gsap';
// var tl = new TimelineMax({delay:1, repeat:-1, repeatDelay:1, yoyo:true, paused:true});

export default {
    name: "BackgroundAnimation",
    mounted() {
        gsap.from("#background", {
            duration: 2,
            scale: 0.5, 
            opacity: 0, 
            delay: 0.5, 
            stagger: 0.2,
            ease: "elastic", 
            force3D: true
        });
    },
    
}
</script>

<style>
#background {
    width: 100vh;
    height: 100vh;
}
</style>