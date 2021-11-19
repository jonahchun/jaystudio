<template>
<div class="mb-5 radio-group">
    <h3 class="order-form__title">Size:</h3>
    <div class="order-form__options">
        <div v-for="size in sizes" class="form-group mb-0 mr-3">
            <input v-model="size_model"
                type="radio"
                name="size_id"
                :id="prefix + '-size-' + size.id"
                :value="size.id"
                required
            />
            <label :for="prefix + '-size-' + size.id">{{ size.title }}</label>
        </div>
        <div class="form-group form-inline mb-0 mr-3">
            <input v-model="size_model"
                type="radio"
                name="size_id"
                :id="prefix + '-size-other'"
                value=""
                required
            />
            <label class="mr-3" :for="prefix + '-size-other'">Other</label>
            <input v-show="size_model === ''"
                class="form-control-sm"
                type="text"
                name="other_size"
                required
            />
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: ['prefix', 'sizes'],
    data() {
        return {
            size_model: false,
        }
    },
}
</script>
