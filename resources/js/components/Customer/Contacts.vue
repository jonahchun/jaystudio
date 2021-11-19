<template>
<div>
    <section class="wedding">
        <header class="intro-heading row">
            <div class="col-lg-8">
                <h2>{{ this.content.title }}</h2>
                <p>{{ this.content.description }}</p>
            </div>

            <div class="col-lg-4">
                <button class="btn-add" type="button" data-toggle="modal" data-target="#contact-modal" @click="addNewContact">
                    <svg class="icon icon-plus"><use xlink:href="#icon-plus"></use></svg>
                    Add Contact
                </button>
                <customer-contact-form :urls="this.urls" :roles="this.roles" :currentContact="currentContact" />
            </div>
        </header>
    </section>

    <section class="contacts">
        <customer-contact-list :initial_contacts="this.initial_contacts" :urls="this.urls" @currentContact="updateCurrentContact" />
    </section>
</div>
</template>

<script>
import axios from "axios";
    
export default {
    props: {
        initial_contacts: Object,
        urls: Object,
        content: Object,
        roles: Object,
    },
    data() {
        return {
            contacts: this.contacts,
            currentContact: {}
        };
    },
    beforeMount() {
        this.contacts = this.initial_contacts;
    },
    methods: {
        updateCurrentContact: function(contact) {
            this.$set(this, 'currentContact', contact);
            // this.currentContact = contact;
        },
        addNewContact: function() {
            this.currentContact = {};
        },
    }
}
</script>