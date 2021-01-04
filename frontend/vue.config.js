module.exports = {
    css: {
        loaderOptions: {
            sass: {
                prependData: `
                    @import "@/styles/scss/global.scss";
                    @import "@/styles/scss/_variables.scss";
                    @import "@/styles/scss/_mixin.scss";
                `
            }
        }
    }
};