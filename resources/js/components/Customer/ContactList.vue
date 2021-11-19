<template>
    <div v-if="this.contacts.data.length">
        <div v-for="contact in this.contacts.data" class="contact-item">
            <div class="contact-item__name">
                <div class="contact-item__img-wrap">
                    <img v-if="contact.photo" class="contact-item__img" :src="contact.photo_url" alt="" />
                </div>
                <span class="contact-item__name-txt">{{ contact.first_name + ' ' + contact.last_name }}</span>
            </div>

            <div class="contact-item__role">
                Role:
                <span class="contact-item__role-txt">{{ contact.role ? contact.role.title : 'N/A' }}</span>
            </div>
            
            <div class="contact-item__email">
                <a :href="getMailToLink(contact)" :title="contact.email">{{ contact.email }}</a>
            </div>

            <div class="contact-item__telephone">
                <a :href="getTelLink(contact)">{{ contact.telephone }}</a>
            </div>

            <div class="contact-item__controls">
                <a class="contact-item__control edit" @click="openEditForm(contact)" href="javascript:void(0);" aria-label="Edit item" data-toggle="modal" data-target="#contact-modal">
                    <svg class="icon icon-edit"><use xlink:href="#icon-edit"></use></svg>
                </a>
                <a class="contact-item__control delete" @click="deleteContact(contact)" href="javascript:void(0);" aria-label="Delete item">
                    <svg class="icon icon-trash"><use xlink:href="#icon-trash"></use></svg>
                </a>
            </div>
        </div>
        <pagination :paginator="this.contacts" @load="loadContacts" :entityTitle="`Contacts`" />
    </div>
    <div v-else>There are no contacts in you list</div>

</template>

<script>
import axios from "axios";
    
export default {
    props: {
        initial_contacts: Object,
        urls: Object
    },
    data() {
        return {
            contacts : this.contacts,
        };
    },
    beforeMount(){
        this.contacts = this.initial_contacts;
    },
    methods: {
        getMailToLink: function(contact) {
            return 'mailto:' + contact.email;
        },
        getTelLink: function(contact) {
            return 'tel:' + contact.telephone;
        },
        loadContacts: function(urlLink) {
            axios.get(urlLink)
                .then(response => {
                    this.contacts = response.data;
                });
        },
        openEditForm: function(contact) {
            this.$emit('currentContact', contact);
            $('.js-form-input').each(function() {
                $(this).parent().children('.js-form-label').addClass('active');
            });
        },
        deleteContact: function(contact) {
            confirmSetLocation(this.urls.delete.replace('__id__', contact.id));
        },
    }
}
</script>
