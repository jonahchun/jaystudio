<template>
    <div class="datepicker-group-container">
        <div class="form-control-wrap start">
            <label>{{ `${fieldLabel} start time` }}</label>
            <div class="datepicker-group">
                <div class="datepicker-group__inner time">
                    <input
                            :name="`${relationName}_${fieldName}_start_time_input`"
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
                    />

                    <input type="text"
                           :name="`${relationName}[${fieldName}_start_time]`"
                           v-model="start_time_value"
                    />
                </div>
            </div>
        </div>
        <div class="form-control-wrap end">
            <label>{{ `${fieldLabel} end time` }}</label>
            <div class="datepicker-group">
                <div class="datepicker-group__inner time">
                    <input
                            :name="`${relationName}_${fieldName}_end_time_input`"
                            type="text" class="form-control"
                            placeholder="__:__"
                            @change="formatTimeValue('end')"
                            @keyup="formatTimeInput('end')"
                            v-model="end_time.time"
                            :required="required"
                    />
                </div>
                <div class="datepicker-group__inner select">
                    <Select2 v-model="end_time.ampm"
                             @change="formatTimeValue('end')"
                             :settings="selectSettings"
                             :options="selectOptions"
                             :id="`${relationName}_${fieldName}_end_time`"
                    />

                    <input type="text"
                           :name="`${relationName}[${fieldName}_end_time]`"
                           v-model="end_time_value"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Select2 from 'v-select2-component';

    export default {
        components: {
            Select2
        },
        props: ['relation', 'relationName', 'fieldName', 'fieldLabel', 'required', 'start_value', 'end_value'],
        data() {
            return {
                start_time: {
                    time: '',
                    ampm: '',
                },
                end_time: {
                    time: '',
                    ampm: '',
                },
                start_time_value: '',
                end_time_value: '',
                selectSettings: {
                    minimumResultsForSearch: Infinity,
                },
                selectOptions: [{id: 1, text: 'AM'}, {id: 2, text: 'PM'}],
            };
        },
        mounted() {
            $.validator.addMethod('greater-than-start-time', function (value, element) {
                var id = $(element).attr('id').replace('end', 'start');
                var startTime = 0;
                var endTime = 0;
                $('#' + id).val().split(':').forEach((data, index) => {
                    startTime += data * ((index == 0) ? 60 : 1);
                });
                $(element).val().split(':').forEach((data, index) => {
                    endTime += data * ((index == 0) ? 60 : 1);
                });
                return endTime == 0 || endTime > startTime;
            }, "End time should be greater than start time");
            this.prepareTime('start');
            this.prepareTime('end');
        },
        methods: {
            prepareTime: function (type) {
                let time = this[`${type}_value`] ? this[`${type}_value`] : this.relation[`${this.fieldName}_${type}_time`];
                if (!time) {
                    this[`${type}_time`].ampm = 1;
                    return;
                }

                time = time.split(':');
                if (time.length != 2) {
                    this[`${type}_time`].ampm = 1;
                    return;
                }

                time[0] = parseInt(time[0]);
                if (time[0] > 12) {
                    this[`${type}_time`].ampm = 2;
                    time[0] -= 12;
                } else {
                    this[`${type}_time`].ampm = 1;
                }

                this[`${type}_time`].time = time.join(':');
                this.formatTimeValue(type);
            },
            formatTimeValue: function (type) {
                let time = this[`${type}_time`].time.split(':');
                if (time.length != 2) {
                    this[`${type}_time_value`] = '';
                    return;
                }

                time[0] = parseInt(time[0]);
                time[1] = parseInt(time[1]);
                if (isNaN(time[0]) || isNaN(time[1])) {
                    this[`${type}_time_value`] = '';
                    return;
                }

                if (this[`${type}_time`].ampm == 2) {
                    time[0] += 12;
                }

                if (time[0] < 10) {
                    time[0] = '0' + time[0];
                }

                if (time[1] < 10) {
                    time[1] = '0' + time[1];
                }

                this[`${type}_time_value`] = time.join(':');
            },
            formatTimeInput: function (type) {
                let data = this[`${type}_time`].time.split(':').join('');
                let hours = data.slice(0, 2);
                let minutes = data.slice(2);

                if (hours > 12) {
                    hours = 12;
                }
                if (hours && hours < 0) {
                    hours = 0;
                }
                if (minutes > 59) {
                    minutes = 59;
                }
                if (minutes < 0) {
                    minutes = 0;
                }

                this[`${type}_time`].time = hours + (hours.length == 2 && minutes.length ? ':' + minutes : '');
            },
        },
    }
</script>
