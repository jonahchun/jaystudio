<template>
    <div class="address-form mt-3">
        <div class="form-control-wrap full-width js-input-wrap">
            <label
                :for="
                    this.relationName +
                        '[portrait_session_location][' +
                        index +
                        '][name_of_ceremony_portrait]'
                "
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.name_of_ceremony_portrait
                }"
            >
                Name of Portrait Session Location
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="off"
                :id="
                    this.relationName +
                        '[portrait_session_location][' +
                        index +
                        '][name_of_ceremony_portrait]'
                "
                :name="
                    this.relationName +
                        '[portrait_session_location][' +
                        index +
                        '][name_of_ceremony_portrait]'
                "
                v-model="address.name_of_ceremony_portrait"
            />
            <input
                type="hidden"
                :name="
                    this.relationName +
                        '[field_data][portrait_session_location][' +
                        index +
                        '][name_of_ceremony_portrait]'
                "
                :value="
                    getFieldInfo(
                        field_name +
                            ' | ' +
                            'Name of Portrait Session Location',
                        'Text Value'
                    )
                "
                data-type="Text Value"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][address_line_1]'
                "
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.address.address_line_1
                }"
            >
                Address Line #1
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][address_line_1]'
                "
                :name="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][address_line_1]'
                "
                v-model="address.address.address_line_1"
                :required="isRequired()"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][address_line_2]'
                "
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.address.address_line_2
                }"
            >
                Address Line #2
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][address_line_2]'
                "
                :name="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][address_line_2]'
                "
                v-model="address.address.address_line_2"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][city]'
                "
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.address.city
                }"
            >
                City
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][city]'
                "
                :name="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][city]'
                "
                v-model="address.address.city"
                :required="isRequired()"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][state]'
                "
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.address.state
                }"
            >
                State / Province
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][state]'
                "
                :name="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][state]'
                "
                v-model="address.address.state"
                :required="isRequired()"
            />
        </div>
        <div class="form-control-wrap js-input-wrap">
            <label
                :for="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][zip]'
                "
                :class="{
                    'form-control-label js-form-label': true,
                    active: address.address.zip
                }"
            >
                ZIP / Postcode
            </label>
            <input
                class="form-control js-form-input"
                type="text"
                autocomplete="new-password"
                :id="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][zip]'
                "
                :name="
                    this.relationName +
                        '[portrait_session_location][' +
                        this.index +
                        '][address][zip]'
                "
                v-model="address.address.zip"
                :required="isRequired()"
            />
        </div>
        <input
            type="hidden"
            :name="
                this.relationName +
                    '[field_data][portrait_session_location][' +
                    this.index +
                    '][address]'
            "
            :value="getFieldInfo(field_name + ' | ' + 'Address', 'Text Value')"
            data-type="Text Value"
        />
        <div class="form-control-wrap js-input-wrap"></div>
        <div class="form-control-wrap full-width ">
            <wedding-schedule-form-start-end-time
                :fieldName="
                    'portrait_session_location][' +
                        this.index +
                        ']' +
                        '[' +
                        this.fieldName
                "
                :fieldLabel="this.fieldLabel"
                :relationName="this.relationName"
                :start_value="address.portrait_start_time"
                :end_value="address.portrait_end_time"
                :time_options="time_options"
                :relation="relation"
            ></wedding-schedule-form-start-end-time>
            <input
                type="hidden"
                :name="
                    this.relationName +
                        '[field_data][portrait_session_location][' +
                        this.index +
                        '][portrait_start_time]'
                "
                :value="
                    getFieldInfo(
                        field_name + ' | ' + 'Portrait session start time',
                        'Selection'
                    )
                "
                data-type="Selection"
            />
            <input
                type="hidden"
                :name="
                    this.relationName +
                        '[field_data][portrait_session_location][' +
                        this.index +
                        '][portrait_end_time]'
                "
                :value="
                    getFieldInfo(
                        field_name + ' | ' + 'Portrait session end time',
                        'Selection'
                    )
                "
                data-type="Selection"
            />
        </div>
        <button
            type="button"
            class="btn-remove"
            title="Remove Location"
            v-on:click.prevent="removeItem()"
        >
            <svg class="icon icon-trash">
                <use xlink:href="#icon-trash"></use>
            </svg>
        </button>
        <input
            type="hidden"
            :name="
                this.relationName +
                    '[portrait_session_location][' +
                    this.index +
                    '][portrait_session_id]'
            "
            :value="this.address.portrait_session_id"
            data-type="Text Value"
        />
    </div>
</template>

<script>
export default {
    props: [
        "address",
        "index",
        "removeItem",
        "relation",
        "relationName",
        "fieldName",
        "fieldLabel",
        "portraitSessionLocation",
        "time_options",
        "field_name"
    ],
    methods: {
        isRequired: function() {
            return (
                typeof this.address.name_of_ceremony_portrait != "undefined" &&
                this.address.name_of_ceremony_portrait.length > 0
            );
        },
        getFieldInfo(fieldVal, fieldType) {
            var fieldInfo = [];
            fieldInfo["val"] = fieldVal;
            fieldInfo["type"] = fieldType;

            return JSON.stringify(Object.assign({}, fieldInfo));
        }
    },
    mounted() {
        $.validator.addMethod(
            "greater-than-start-time",
            function(value, element) {
                var id = $(element)
                    .attr("id")
                    .replace("end", "start");
                var startTime = 0;
                var endTime = 0;
                $("#" + id)
                    .val()
                    .split(":")
                    .forEach((data, index) => {
                        startTime += data * (index == 0 ? 60 : 1);
                    });
                $(element)
                    .val()
                    .split(":")
                    .forEach((data, index) => {
                        endTime += data * (index == 0 ? 60 : 1);
                    });
                return (startTime == 0 && endTime == 0) || endTime > startTime;
            },
            "End time should be greater than start time"
        );
    }
};
</script>
