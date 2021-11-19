<template>
<div>
    <div class="info-column__item space-between">
        <h3 class="info-column__title wide">Additional Comments</h3>
        
        <button class="btn-default--alt" @click="show_form = true" v-show="!comment && !show_form && can_edit">Add</button>
        <button class="btn-default--alt" @click="update" v-show="show_form && can_edit">Update</button>

        <textarea v-model="comment" v-show="show_form" rows="4"></textarea>
        <p v-show="!show_form" class="info-column__value wide additional">{{ comment }}</p>
    </div>
</div>
</template>
<script>
import axios from "axios";
export default {
    props: ['comment_value', 'url', 'can_edit'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            comment: this.comment_value,
            show_form: false,
        };
    },
    methods: {
        update: function() {
            let currentObj = this;
            axios.post(this.url, {
                _token: this.csrf,
                comment: this.comment,
            })
            .then(function (response) {
                currentObj.show_form = false;
                currentObj.comment = response.data.comment;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    },
}
</script>
