<template>
<div>
    <div class="b-request__heading row">
        <div class="col-xl-6">
            <h3 class="b-request__ttl">Please specify images to put on card</h3>
            <span class="b-request__ttl-note">Edited image(s) only</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div v-for="image_index in images_count" :key="image_index" class="mb-3">
                <input class="form-control" :name="name + '[' + image_index + ']'" type="text" required />
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: ['name', 'images_count'],
}
</script>
