<template>
    <div class="modal fade contact-popup" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog contact-popup__inner" role="document">
            <div class="contact-popup__content">
                <button @click="resetValidation" type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                <h2 class="contact-popup__title" id="contactModalLabel">Add Contact</h2>

                <div class="contact-popup__form-wrap">
                    <form :action="urls.save" enctype="multipart/form-data" method="post" id="customer-contact-edit" class="contact-popup__form">
                        <input type="hidden" name="_token" :value="csrf" />
                        <input type="hidden" name="id" v-model="contact.id" />
                        <div class="form-control-wrap contact-popup__input-wrap js-input-wrap">
                            <label class="form-control-label solid-bg js-form-label" for="contact-first-name">First name</label>
                            <input type="text"
                                   name="first_name"
                                   v-model="contact.first_name"
                                   id="contact-first-name"
                                   class="form-control-bordered js-form-input"
                                   autocomplete="off"
                                   required="required"/>
                        </div>
                        <div class="form-control-wrap contact-popup__input-wrap js-input-wrap">
                            <label class="form-control-label solid-bg js-form-label" for="contact-last-name">Last name</label>
                            <input type="text"
                                   name="last_name"
                                   v-model="contact.last_name"
                                   id="contact-last-name"
                                   class="form-control-bordered js-form-input"
                                   autocomplete="off"
                                   required="required"/>
                        </div>
                        <div class="form-control-wrap contact-popup__input-wrap js-input-wrap">
                            <label class="form-control-label solid-bg js-form-label" for="contact-email">Email</label>
                            <input type="email"
                                   name="email"
                                   id="contact-email"
                                   v-model="contact.email"
                                   class="form-control-bordered js-form-input"
                                   autocomplete="off"
                                   required="required"/>
                        </div>
                        <div class="form-control-wrap contact-popup__input-wrap js-input-wrap">
                            <label class="form-control-label solid-bg js-form-label" for="contact-telephone">Phone Number</label>
                            <input type="tel"
                                   name="telephone"
                                   v-model="contact.telephone"
                                   id="contact-telephone"
                                   class="form-control-bordered js-form-input"
                                   autocomplete="new-password"
                                   required="required"/>
                        </div>
                        <div class="form-control-wrap file-upload contact-popup__input-wrap full-width js-input-wrap">
                            <div v-if="contact.photo" class="input-group-append">
                                <img :src="contact.photo_url" />
                            </div>
                            <input type="hidden"
                                   name="photo"
                                   v-model="contact.photo" />
                            <input type="file"
                                   name="photo[file]"
                                   class="form-control-bordered js-form-input"
                                   id="contact-photo" />
                            <label class="form-control-label solid-bg js-form-label" for="contact-photo">Choose photo...</label>
                        </div>
                        <div class="form-control-wrap form-select-wrap bordered form-select-wrap contact-popup__input-wrap">
                            <label class="col-form-label" for="contact-role">Role</label>
                            <Select2 v-model="selectedRoleValue"
                                    :settings="selectSettings"
                                    :options="selectRoleOptions"
                                    required
                                    name="role_id"
                                    id="contact-role"

                            />
                        </div>
                        <div class="form-control-wrap form-select-wrap bordered form-select-wrap contact-popup__input-wrap">
                            <label class="col-form-label" for="contact-receive-reminders">Should contact receive reminders?</label>
                            <Select2 v-model="selectedReminderValue"
                                     :settings="selectSettings"
                                     :options="selectReminderOptions"
                                     name="receive_emails"
                                     id="contact-receive-reminders"
                                     placeholder=""
                                     required
                            />
                        </div>
                    </form>
                </div>
                <div class="contact-popup__actions">
                    <button @click="resetValidation" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button @click="save" type="button" class="btn btn-primary">Save</button>
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
    props: [
        'currentContact',
        'urls',
        'roles',
    ],
    data() {
        var selectRoleOptions = [];
        for(var key in this.roles) {
            selectRoleOptions.push({
                id: key,
                text: this.roles[key]
            });
        }
        return {
            contact : this.currentContact,
            role: null,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            selectSettings: {
                minimumResultsForSearch: Infinity,
            },
            selectReminderOptions: [{id: 0, text: 'No'}, {id: 1, text: 'Yes'}],
            selectedReminderValue: this.getDefaultReminderSelectedValue(),
            selectRoleOptions: selectRoleOptions,
            selectedRoleValue: this.getDefaultRoleSelectedValue(),
        };
    },
    mounted() {
        this.form = $('#customer-contact-edit');
        this.formValidator = this.form.validate();
    },
    watch: {
        'currentContact': function() {
            this.contact = this.currentContact;
            this.role = this.contact.role ? this.contact.role.id : null;
            this.selectedReminderValue = this.getDefaultReminderSelectedValue();
            this.selectedRoleValue = this.getDefaultRoleSelectedValue();
        }
    },
    methods: {
        save: function() {
            this.form.submit();
        },
        resetValidation: function() {
            this.formValidator.resetForm();
        },
        getDefaultRoleSelectedValue: function() {
            return (typeof this.contact != 'undefined' && this.contact.role) ? this.contact.role.id : '';
        },
        getDefaultReminderSelectedValue: function(){
            if(typeof this.contact == 'undefined' || typeof this.contact.receive_emails == 'undefined') {
                return '';
            } else {
                return this.contact.receive_emails;
            }
        },
    },
}
</script>
