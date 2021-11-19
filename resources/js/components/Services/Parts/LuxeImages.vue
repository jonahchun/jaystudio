<template>
<div class="swiper-container js-img-tpl">
    <div class="mb-4 swiper-wrapper">
        <div class="b-image-templates__slide" v-for="image in images">
            <image-with-zoom
                :image_url="image.image_url"
                image_class="b-image-templates__slide swiper-slide"
            ></image-with-zoom>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: ['images'],
}
</script>
