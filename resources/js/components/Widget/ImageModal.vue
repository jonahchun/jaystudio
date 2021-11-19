<template>
    <div v-show="opened" class="image-popup">
        <div class="image-popup-overlay" @click="close"></div>
        <div class="image-popup-wrap">
            <button class="btn-close" type="button" @click="close">Close</button>
            <img class="image-popup-image" v-if="image_url" :src="image_url" />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            opened: false,
            image_url: false,
        }
    },
    mounted() {
        this.$root.$on('openImagePopup', (image_url) => {
            this.image_url = image_url;
            this.opened = true;
        });
    },
    methods: {
        close: function(event) {
            this.opened = false;
        }
    }
}
</script>
