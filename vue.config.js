module.exports = {
    chainWebpack: (config) => {
        // Disable prefetching and preloading
        config.plugins.delete('prefetch')
        config.plugins.delete('preload')
    },
}