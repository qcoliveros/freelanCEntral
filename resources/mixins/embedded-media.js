export default {
    methods: {
        modifyEmbeddedVideo(content) {
            content = content.replace('oembed', 'iframe')
            content = content.replace('url', 'src')
            content = content.replace('watch?v=', 'embed/')
            content = content.replace('oembed', 'iframe')
            return content
        },
    },
};
