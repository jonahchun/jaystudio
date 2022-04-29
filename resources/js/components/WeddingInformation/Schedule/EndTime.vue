<template>
    <div class="form-control-wrap">
        <label v-if="fieldLabel == 'Hair & make up'">{{
            `${fieldLabel} finish time`
        }}</label>
        <label v-else>{{ `${fieldLabel} finish time` }}</label>
        <div class="datepicker-group">
            <div class="datepicker-group__inner time">
                <!-- <input
                    type="text" class="form-control"
                    placeholder="__:__"
                    @change="formatTimeValue('end')"
                    @keyup="formatTimeInput('end')"
                    v-model="end_time.time"
                    :required="required"
                />-->

                <Select2
                    v-model="end_time.time"
                    @change="formatTimeValue('end')"
                    :settings="selectSettings"
                    :options="selectTimeOptions"
                    :required="required"
                />
                <label id="-error" class="error" for=""></label>
            </div>
            <div class="datepicker-group__inner select">
                <Select2
                    v-model="end_time.ampm"
                    @change="formatTimeValue('end')"
                    :settings="selectSettings"
                    :options="selectOptions"
                    :id="`${relationName}_${fieldName}_end_time`"
                    :required="required"
                />

                <input
                    type="text"
                    :name="`${relationName}[${fieldName}_end_time]`"
                    style="opacity:0; width:0px; height: 0px;"
                    v-model="end_time_value"
                />
            </div>
        </div>
    </div>
</template>
<script>
import Select2 from "v-select2-component";
import StartEndTime from "./StartEndTime.vue";
export default {
    extends: StartEndTime,
    components: {
        Select2
    },
    props: [
        "relation",
        "relationName",
        "fieldName",
        "fieldLabel",
        "end_value",
        "time_options"
    ],
    data() {
        return {
            end_time: {
                time: "",
                ampm: ""
            },
            end_time_value: "",
            selectSettings: {
                minimumResultsForSearch: Infinity
            },
            selectOptions: [{ id: 1, text: "AM" }, { id: 2, text: "PM" }],
            selectTimeOptions: []
        };
    },
    mounted() {
        this.prepareTime("end");
        var jsonObj = [];

        $.each(this.time_options, function(k, v) {
            var item = {};
            item["id"] = k;
            item["text"] = v;

            jsonObj.push(item);
        });
        this.selectTimeOptions = jsonObj;
    }
};
</script>
