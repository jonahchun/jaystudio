<template>
    <div class="address-form">
        <div v-if="name" class="form-control-wrap full-width js-input-wrap">
            <label
                :for="address.type + '[address][hair_makeup_name]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.hair_makeup_name
                }"
            >
                {{ name }}
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_name]'"
                :name="address.type + '[address][hair_makeup_name]'"
                v-model="address.hair_makeup_name"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][hair_makeup_name]'"
                :value="
                    getFieldInfo(
                        address.type + ' hair makeup address name',
                        'Text value'
                    )
                "
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][hair_makeup_address_line_1]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.hair_makeup_address_line_1
                }"
            >
                Address Line #1
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_address_line_1]'"
                :name="address.type + '[address][hair_makeup_address_line_1]'"
                v-model="address.hair_makeup_address_line_1"
                required
            />
            <input
                type="hidden"
                :name="
                    address.type +
                        '[field_data][address][hair_makeup_address_line_1]'
                "
                :value="
                    getFieldInfo(
                        address.type + ' hair makeup address line #1',
                        'Text value'
                    )
                "
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][hair_makeup_address_line_2]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.hair_makeup_address_line_2
                }"
            >
                Address Line #2
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_address_line_2]'"
                :name="address.type + '[address][hair_makeup_address_line_2]'"
                v-model="address.hair_makeup_address_line_2"
            />
            <input
                type="hidden"
                :name="
                    address.type +
                        '[field_data][address][hair_makeup_address_line_2]'
                "
                :value="
                    getFieldInfo(
                        address.type + ' hair makeup address line #2',
                        'Text value'
                    )
                "
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][hair_makeup_city]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.hair_makeup_city
                }"
            >
                City
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_city]'"
                :name="address.type + '[address][hair_makeup_city]'"
                v-model="address.hair_makeup_city"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][hair_makeup_city]'"
                :value="
                    getFieldInfo(
                        address.type + ' hair makeup city',
                        'Text value'
                    )
                "
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][hair_makeup_state]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.hair_makeup_state
                }"
            >
                State / Province
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="address.type + '[address][hair_makeup_state]'"
                :name="address.type + '[address][hair_makeup_state]'"
                v-model="address.hair_makeup_state"
                required
            />
            <input
                type="hidden"
                :name="
                    address.type + '[field_data][address][hair_makeup_state]'
                "
                :value="
                    getFieldInfo(
                        address.type + ' hair makeup state',
                        'Text value'
                    )
                "
                data-type="Text value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="address.type + '[address][hair_makeup_zip]'"
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.hair_makeup_zip
                }"
            >
                ZIP / Postcode
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="address.type + '[address][hair_makeup_zip]'"
                :name="address.type + '[address][hair_makeup_zip]'"
                v-model="address.hair_makeup_zip"
                required
            />
            <input
                type="hidden"
                :name="address.type + '[field_data][address][hair_makeup_zip]'"
                :value="
                    getFieldInfo(
                        address.type + ' hair makeup zip',
                        'Text value'
                    )
                "
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
