<template>
<div>
    <div class="info-column__upload">
        <p class="info-column__upload-value">
            Image #{{ image_number }}:
            <span v-show="!show_form">{{ image_initial_value ? image_initial_value : 'None Selected' }}</span>
            <input v-show="show_form" type="text" v-model="image_value" />
        </p>
        <button class="btn-default--alt" @click="show_form = true" v-show="!show_form && can_edit">
            {{ !image_initial_value ? 'Add' : 'Edit' }}
        </button>
        <button class="btn-default--alt" @click="update" v-show="show_form && can_edit">Update</button>
    </div>
</div>
</template>
<script>
import axios from "axios";
export default {
    props: ['image_number', 'image_val', 'url', 'name_prefix', 'can_edit'],
    data() {
        console.log(this.can_edit);
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            show_form: false,
            image_value: '',
            image_initial_value: this.image_val
        };
    },
    methods: {
        update: function() {
            let currentObj = this;
            let postData = {
                _token: this.csrf,
            };
            postData[this.name_prefix] = {};
            postData[this.name_prefix][this.image_number] = this.image_value;
            axios.post(this.url, postData)
                .then(function (response) {
                    currentObj.show_form = false;
                    currentObj.image_initial_value = response.data[currentObj.name_prefix][currentObj.image_number];
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
}
</script>
