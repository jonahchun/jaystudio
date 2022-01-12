<template>
<div class="schedule-availabilities-lists">
    <div v-for="(block, index) in blocks" :key="block" class="schedule-availabilities-list" style="position: relative;">
        <span style="position: absolute;top: -14px;font-weight: bold;">Option {{index}}</span>
        <div class="schedule-availabilities radio-group error-top">
            <div v-for="(label, value) in weekdays" :key="value">
                <input class="form-radio-input bordered"
                    type="radio"
                    :name="`${block}_week`"
                    :id="`${value}_${index}`"
                    :value="value"
                    v-model="schedule[`${block}_week`]"
                    required
                />
                <label :for="`${value}_${index}`">{{ label }}</label>
            </div>
        </div>
        <div class="schedule-availabilities radio-group error-top justify-content-between">
            <div v-for="(label, value) in times" :key="value">
                <input class="form-radio-input bordered"
                    type="radio"
                    :name="`${block}_time`"
                    :id="`${value}_${index}`"
                    :value="value"
                    v-model="schedule[`${block}_time`]"
                    required
                />
                <label :for="`${value}_${index}`">{{ label }}</label>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['wedding_schedule'],
    data() {
        return {
            blocks: {
                1: 'first',
                2: 'second',
                3: 'third'
            },
            weekdays: {
                monday: 'Monday',
                tuesday: 'Tuesday',
                wednesday: 'Wednesday',
                thursday: 'Thursday',
                friday: 'Friday'
            },
            times: {
                'time-10-12': '10:00 a.m. — 12:00 p.m.',
                'time-1-3': '1:00 p.m. — 3:00 p.m.',
                'time-4-7': '4:00 p.m. — 6:00 p.m.'
            },
            schedule: this.wedding_schedule,
        };
    },
}
</script>
