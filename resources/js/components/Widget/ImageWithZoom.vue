<template>
    <div class="image-with-zoom">
        <img :src="image_url" :class="image_class" />
        <button type="button" @click="openPopup" class="magnifier">
            Zoom image
            <svg class="icon icon-zoom">
                <use xlink:href="#icon-zoom"></use>
            </svg>
        </button>
    </div>
</template>

<script>
export default {
    props: ['image_url', 'image_class'],
    methods: {
        openPopup: function() {
            this.$root.$emit('openImagePopup', this.image_url);
        },
    }
}
</script>
