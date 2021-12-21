<template>
    <div class="address-form">
        <div v-if="name" class="form-control-wrap full-width js-input-wrap">
            <label :for="address.type + '[address][hair_makeup_name]'" 
                class="form-control-label js-form-label active">
                {{ name }}
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_name]'"
                :name="address.type + '[address][hair_makeup_name]'"
                :value="address.hair_makeup_name"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][hair_makeup_address_line_1]'" 
                class="form-control-label js-form-label active">
                Address Line #1
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_address_line_1]'"
                :name="address.type + '[address][hair_makeup_address_line_1]'"
                :value="address.hair_makeup_address_line_1"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][hair_makeup_address_line_2]'" 
                class="form-control-label js-form-label active">
                Address Line #2
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_address_line_2]'"
                :name="address.type + '[address][hair_makeup_address_line_2]'"
                :value="address.hair_makeup_address_line_2"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][hair_makeup_city]'"
                class="form-control-label js-form-label active">
                City
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_city]'"
                :name="address.type + '[address][hair_makeup_city]'"
                :value="address.hair_makeup_city"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][hair_makeup_state]'"
                class="form-control-label js-form-label active">
                State / Province
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_state]'"
                :name="address.type + '[address][hair_makeup_state]'"
                :value="address.hair_makeup_state"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][hair_makeup_zip]'"
                class="form-control-label js-form-label active">
                ZIP / Postcode
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="address.type + '[address][hair_makeup_zip]'"
                :name="address.type + '[address][hair_makeup_zip]'"
                :value="address.hair_makeup_zip"
                required
            />
        </div>
    </div>
</template>

<script>
export default {
    props: ['address', 'name']
}
</script>
