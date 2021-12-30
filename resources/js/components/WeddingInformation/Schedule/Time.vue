<template>
    <div class="form-control-wrap">
        
        <label>{{ `${fieldLabel} time` }}</label>
        <div class="datepicker-group">
            <div class="datepicker-group__inner time">
                <input
                    type="text" class="form-control"
                    placeholder="__:__"
                    @change="formatTimeValue('cake_cutting')"
                    @keyup="formatTimeInput('cake_cutting')"
                    v-model="cake_cutting_time.time"
                    :required="required"
                />
            </div>
            <div class="datepicker-group__inner select">
                <Select2 v-model="cake_cutting_time.ampm"
                    @change="formatTimeValue('cake_cutting')"
                    :settings="selectSettings"
                    :options="selectOptions"
                    :id="`${relationName}_${fieldName}_time`"
                    :required="required"
                />

                <input type="text"
                    :name="`${relationName}[${fieldName}_time]`"
                    style="opacity:0; width:0px; height: 0px;"
                    v-model="cake_cutting_time_value"
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
            cake_cutting_time: {
                time: '',
                ampm: '',
            },
            cake_cutting_time_value: '',
            selectSettings: {
                minimumResultsForSearch: Infinity,
            },
            selectOptions: [{id: 1, text: 'AM'}, {id: 2, text: 'PM'}],
        };
    },
    mounted() {
        console.log(this.relation)
        this.prepareTime('cake_cutting');
    },
    methods: {
        prepareTime: function (type) {
            let time = this[`${type}_time_value`] ? this[`${type}_time_value`] : this.relation[`${type}_time`];
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
            console.log(this.formatTimeValue(type));

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
    }
}
</script>
