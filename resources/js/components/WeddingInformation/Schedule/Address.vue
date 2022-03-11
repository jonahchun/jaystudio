<template>
    <div class="address-form">
        <div v-if="name" class="form-control-wrap full-width js-input-wrap">
            <label
                :for="address.type + '[address][name]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.name
                }"
            >
                {{ name }}
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][name]'"
                :name="address.type + '[address][name]'"
                :value="address.name"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][name]'"
                :value="address.type + ' name of venue / hotel'"
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][address_line_1]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.address_line_1
                }"
            >
                Address Line #1
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][address_line_1]'"
                :name="address.type + '[address][address_line_1]'"
                :value="address.address_line_1"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][address_line_1]'"
                :value="address.type + ' address line #1'"
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][address_line_2]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.address_line_2
                }"
            >
                Address Line #2
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][address_line_2]'"
                :name="address.type + '[address][address_line_2]'"
                :value="address.address_line_2"
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][address_line_2]'"
                :value="address.type + ' address line #2'"
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][city]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.city
                }"
            >
                City
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][city]'"
                :name="address.type + '[address][city]'"
                :value="address.city"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][city]'"
                :value="address.type + ' address city'"
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][state]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.state
                }"
            >
                State / Province
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][state]'"
                :name="address.type + '[address][state]'"
                :value="address.state"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][state]'"
                :value="address.type + ' address state'"
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][zip]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.zip
                }"
            >
                ZIP / Postcode
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="address.type + '[address][zip]'"
                :name="address.type + '[address][zip]'"
                :value="address.zip"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][zip]'"
                :value="address.type + ' address zip'"
                data-type="Text value"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: ["address", "name"]
};
</script>
