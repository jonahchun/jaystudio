<template>
    <div class="address-form">
        <div v-if="name" class="form-control-wrap full-width js-input-wrap">
            <label :for="address.type + '[address][name]'" 
                :class="{'form-control-label js-form-label': true, 'active': address.name}"
            >
                {{ name }}
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][name]'"
                :name="address.type + '[address][name]'"
                :value="address.name"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][address_line_1]'" 
                :class="{'form-control-label js-form-label': true, 'active': address.address_line_1}"
            >
                Address Line #1
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][address_line_1]'"
                :name="address.type + '[address][address_line_1]'"
                :value="address.address_line_1"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][address_line_2]'" 
                :class="{'form-control-label js-form-label': true, 'active': address.address_line_2}"
            >
                Address Line #2
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][address_line_2]'"
                :name="address.type + '[address][address_line_2]'"
                :value="address.address_line_2"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][city]'"
                :class="{'form-control-label js-form-label': true, 'active': address.city}"
            >
                City
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][city]'"
                :name="address.type + '[address][city]'"
                :value="address.city"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][state]'"
                :class="{'form-control-label js-form-label': true, 'active': address.state}"
            >
                State / Province
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][state]'"
                :name="address.type + '[address][state]'"
                :value="address.state"
                required
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label :for="address.type + '[address][zip]'"
                :class="{'form-control-label js-form-label': true, 'active': address.zip}"
            >
                ZIP / Postcode
            </label>
            <input class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="address.type + '[address][zip]'"
                :name="address.type + '[address][zip]'"
                :value="address.zip"
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
