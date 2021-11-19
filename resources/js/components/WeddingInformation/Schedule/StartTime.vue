<template>
    <div class="form-control-wrap">
        <label>{{ `${fieldLabel} start time` }}</label>
        <div class="datepicker-group">
            <div class="datepicker-group__inner time">
                <input
                    type="text" class="form-control"
                    placeholder="__:__"
                    @change="formatTimeValue('start')"
                    @keyup="formatTimeInput('start')"
                    v-model="start_time.time"
                    :required="required"
                />
            </div>
            <div class="datepicker-group__inner select">
                <Select2 v-model="start_time.ampm"
                    @change="formatTimeValue('start')"
                    :settings="selectSettings"
                    :options="selectOptions"
                    :id="`${relationName}_${fieldName}_start_time`"
                    :required="required"
                />

                <input type="text"
                    :name="`${relationName}[${fieldName}_start_time]`"
                    style="opacity:0; width:0px; height: 0px;"
                    v-model="start_time_value"
                />
            </div>
        </div>
    </div>
</template>
<script>
import Select2 from 'v-select2-component';
import StartEndTime from './StartEndTime.vue';
export default {
    extends: StartEndTime,
    components: {
        Select2
    },
    props: ['relation', 'relationName', 'fieldName', 'fieldLabel', 'start_value'],
    data() {
        return {
            start_time: {
                time: '',
                ampm: '',
            },
            start_time_value: '',
            selectSettings: {
                minimumResultsForSearch: Infinity,
            },
            selectOptions: [{id: 1, text: 'AM'}, {id: 2, text: 'PM'}],
        };
    },
    mounted() {
        this.prepareTime('start');
    },
}
</script>
