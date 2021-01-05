<template>
    <svg id="background" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000">
        <rect x="0" y="0" width="1000" height="1000" fill="#000" />
        <circle cx="246" cy="189" r="60" fill="#8cc63f"/>
        <circle  cx="865" cy="348" r="50" fill="#29abe2"/>
        <circle  cx="400" cy="290" r="40" fill="#a82a2a"/>
        <circle  cx="550" cy="392" r="12" fill="#93278f"/>
</template>

<script>
export default {
    name: "BackgroundAnimation",
    mounted() {
        console.clear();
        TweenMax.set("#demo", {xPercent:-50, yPercent:-50});
        var paths = document.querySelectorAll("path");
        var startX = 500;
        var startY = 500;
        var dur = 2;
        var tl = new TimelineMax({delay:1, repeat:-1, repeatDelay:1, yoyo:true, paused:true});
        tl.from("circle", dur, { attr:{cx:startX, cy:startY} });
        tl.from(".squares rect", dur, { attr:{x:startX, y:startY} }, 0);

        for(i=0; i<paths.length; i++) {
            var data = paths[i].getBBox();
            var nested = new TimelineMax();
            nested.from(paths[i], dur, {x:startX - data.x - (data.width/2), y:startY - data.y - (data.height/2)});
            tl.add(nested, 0);
        }

        tl.play();
    },
    
}
</script>

<style>
#background {
    width: 90%;
    height: 90%;
    position: absolute;
    left: 50%;
    top: 50%;
}
</style>