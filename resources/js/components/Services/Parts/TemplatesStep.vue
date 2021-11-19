<template>
<div>
    <header class="mb-4 d-flex align-items-center flex-wrap">
        <h2 class="order-form__step-title">{{ title }}</h2>
    </header>
    <input type="text" :name="name + '_validation'" style="opacity:0;width:0px;height:0px" :value="template_id" required />
    <div class="b-image-templates js-img-tpl swiper-container">
        <div class="swiper-wrapper">
            <div v-for="template in templates" :class="{'b-image-templates__slide swiper-slide': true, 'vertical': orientation == 2}">
                <input 
                    type="radio"
                    v-model="template_id"
                    :name="name"
                    :id="'template-' + template.id"
                    :value="template.id"
                    @change="$emit('change', template.images_count)"
                />
                <label :for="'template-' + template.id" class="b-image-templates__radio">
                    <image-with-zoom
                        :image_url="template.image_url"
                        image_class="b-image-templates__img"
                    ></image-with-zoom>
                    <span class="b-image-templates__mask"></span>
                </label>
            </div>
        </div>
        <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
    </div>
</div>
</template>
<script>
export default {
    props: ['templates', 'name', 'title', 'checked', 'orientation'],
    model: {
        prop: 'checked',
        event: 'change'
    },
    data() {
        return {
            template_id: '',
        }
    }
}
</script>
