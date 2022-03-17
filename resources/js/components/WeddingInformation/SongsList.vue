<template>
    <div class="song-list__item-inner">
        <div class="form-control-wrap song-list__item-title">
            <input
                class="form-control"
                type="text"
                :name="this.relationName + '[' + index + '][song_name]'"
                v-model="song.song_name"
            />
        </div>
        <div class="song-list__item-type form-select-wrap">
            <Select2
                v-model="song.type"
                :settings="selectSettings"
                :options="selectOptions"
                :name="this.relationName + '[' + index + '][type]'"
            />
        </div>
        <input
            type="hidden"
            :name="
                'field_data' + '[' + this.relationName + ']' + '[songs_list]'
            "
            :value="getFieldInfo('Songs List', 'Text Value & Selection')"
        />
        <div class="song-list__item-action">
            <button
                type="button"
                class="btn-remove"
                title="Remove Item"
                v-on:click.prevent="removeSong()"
            >
                <svg class="icon icon-trash">
                    <use xlink:href="#icon-trash"></use>
                </svg>
            </button>
        </div>
    </div>
</template>
<script>
import Select2 from "v-select2-component";
export default {
    components: {
        Select2
    },
    props: ["index", "song", "removeSong", "relationName"],
    data() {
        return {
            selectSettings: {
                minimumResultsForSearch: Infinity
            },
            selectOptions: [
                { id: 1, text: "Highlight Reel" },
                { id: 2, text: "Full Video" }
            ]
        };
    },
    methods: {
        getFieldInfo(fieldVal, fieldType) {
            var fieldInfo = [];
            fieldInfo["val"] = fieldVal;
            fieldInfo["type"] = fieldType;

            return JSON.stringify(Object.assign({}, fieldInfo));
        }
    }
};
</script>
