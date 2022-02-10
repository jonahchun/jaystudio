<template>
    <form :action="urls.save" method="post" id="wedding-schedule-form" enctype="multipart/form-data" autocomplete="off" :class="{'readonly': readonly}">
        <input type="hidden" name="_token" :value="csrf" />
        <input type="hidden" name="current_step" :value="current_step" />

        <header class="intro-heading row">
            <div class="col-9">
                <h2>Wedding Schedule</h2>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li v-for="(step, index) in steps" :key="index" :class="{'steps__list-item' : true, 'is-complete' : (current_step > index && !readonly), 'is-active' : (index == current_step) }">
                    <a @click="goToStep(index)" href="">{{ step }}</a>
                </li>
            </ol>
        </nav>
        <div v-if="current_step < 2 || !current_step" class="schedule-forms">
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" v-if="current_step != 0" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
            <div class="schedule-form__section full-width">
                <h3 class="schedule-form__title">General Details:</h3>
                <div class="form-select-wrap">
                    <Select2 v-model="getCurrentRelation().preparation_id"
                            :settings="settingSelectSettings"
                            :options="preparation_settings_select"
                            :name="getCurrentRelationName() + '[preparation_id]'"
                            :id="getCurrentRelationName() + '_preparation_location_name'"
                            placeholder="Name of setting"
                            required
                    />
                </div>
            </div>
            <div v-if="newlywed_types[0] == 'bride' && current_step == 0 || newlywed_types[1] == 'bride' && current_step == 1" class="schedule-form__section full-width">
                <h3 class="schedule-form__title">Hair/Makeup - Same Location:</h3>
                <div class="schedule-form__options">
                    <div class="form-group">
                        <input type="radio"
                               :name="getCurrentRelationName() + '[hair_makeup]'"
                               v-model="getCurrentRelation().hair_makeup"
                               value="1"
                               id="hairmakeup-yes" v-on:change="onChangeValue($event)" required/><br>
                        <label for="hairmakeup-yes">Yes</label>
                    </div>
                    <div class="form-group">
                        <input type="radio"
                               :name="getCurrentRelationName() + '[hair_makeup]'"
                               v-model="getCurrentRelation().hair_makeup"
                               value="0"
                               id="hairmakeup-no" v-on:change="onChangeValue($event)" required/>
                        <label for="hairmakeup-no">No</label>
                    </div>
                </div>
            </div>
            <div class="schedule-form__section">
                <h3 class="schedule-form__title">Preparation Address:</h3>
                <wedding-schedule-form-address
                    :address="getRelationAddress()"
                    name="Name of Venue / Hotel (if applicable)"
                ></wedding-schedule-form-address>

                <h3 class="schedule-form__title" v-if="getCurrentRelation().hair_makeup == 0">Hair/Makeup Address:</h3>
                <wedding-schedule-form-hair-makeup-address
                    :address="getRelationAddress()"
                    name="Name of Venue / Hotel (if applicable)" 
                 v-if="getCurrentRelation().hair_makeup == 0"></wedding-schedule-form-hair-makeup-address>
            </div>
            <div class="schedule-form__section">
                <h3 class="schedule-form__title">Preparation Schedule & Contact:</h3>
                Starting time of our Team will be determined during your phone meeting with our scheduling coordinator.
                <div class="mt-3"></div>
                <div class="datepicker-form">
                    <!-- - Preparation -->
                    <wedding-schedule-form-start-time
                        :relation="getCurrentRelation()"
                        :relationName="getCurrentRelationName()"
                        :fieldName="`preparation`"
                        :fieldLabel="`Hair & make up`"
                        :time_options="time_options"
                    ></wedding-schedule-form-start-time>

                    <!-- Transportation -->
                    <wedding-schedule-form-start-time
                        :relation="getCurrentRelation()"
                        :relationName="getCurrentRelationName()"
                        :fieldName="`transportation`"
                        :fieldLabel="`Transportation`"
                        :time_options="time_options"
                    ></wedding-schedule-form-start-time>
                    <div class="form-control-wrap">
                        <label :for="getCurrentRelationName() + '_contact_name'" 
                            :class="{'form-control-label js-form-label': true, 'active': getCurrentRelation().contact_name}"
                        >
                            Full Name
                        </label>
                        <input class="form-control js-form-input"
                            type="text"
                            autocomplete="off"
                            :id="getCurrentRelationName() + '_contact_name'"
                            :name="getCurrentRelationName() + '[contact_name]'"
                            :value="getCurrentRelation().contact_name"
                            :required="!getCurrentRelation().contact_id"
                        />
                    </div>
                    <div class="form-control-wrap">
                        <label :for="getCurrentRelationName() + '_contact_phone'" 
                            :class="{'form-control-label js-form-label': true, 'active': getCurrentRelation().contact_phone}"
                        >
                            Phone
                        </label>
                        <input class="form-control js-form-input"
                            type="text"
                            autocomplete="off"
                            :id="getCurrentRelationName() + '_contact_phone'"
                            :name="getCurrentRelationName() + '[contact_phone]'"
                            :value="getCurrentRelation().contact_phone"
                            :required="!getCurrentRelation().contact_id"
                        />
                    </div>
                </div>
                <p>Or select from contacts list</p>
                <div class="form-select-wrap">
                    <Select2 v-model="getCurrentRelation().contact_id"
                        :settings="contactsSelectSettings"
                        :options="contacts_settings_select"
                        :name="getCurrentRelationName() + '[contact_id]'"
                        :id="getCurrentRelationName() + '_contact_id'"
                        placeholder="Emergency contact"
                    />
                </div>
            </div>
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" v-if="current_step != 0" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
        </div>

        <div v-if="current_step == 2" class="schedule-forms">
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
            <div class="schedule-form__section">
                <div class="schedule-form__section-inner">
                    <div class="form-control-wrap">
                        <label class="schedule-form__title" :for="getCurrentRelationName() + '[name_of_ceremony]'">Name of Ceremony Location:</label>
                        <input class="form-control" type="text"
                               :id="getCurrentRelationName() + '[name_of_ceremony]'"
                               :name="getCurrentRelationName() + '[name_of_ceremony]'"
                               :value="getCurrentRelation().name_of_ceremony ? getCurrentRelation().name_of_ceremony : getCurrentRelation().address.name"
                               required />
                    </div>
                </div>
                <div class="schedule-form__section-inner">
                    <h3 class="schedule-form__title">Ceremony Address:</h3>
                    <wedding-schedule-form-address
                        :address="getRelationAddress()"
                    ></wedding-schedule-form-address>
                </div>
                <div class="schedule-form__section-inner">
                    <!-- - Ceremony -->
                    <h3 class="schedule-form__title">Ceremony Schedule:</h3>
                    <div class="datepicker-form ceremony-schedule start-end">
                        <!-- Invitation -->
                        <wedding-schedule-form-start-time
                            :relation="getCurrentRelation()"
                            :relationName="getCurrentRelationName()"
                            fieldName="invitation"
                            fieldLabel="Invitation"
                            :required="true"
                            :time_options="time_options"
                        ></wedding-schedule-form-start-time>

                        <wedding-schedule-form-start-end-time
                            :relation="getCurrentRelation()"
                            :relationName="getCurrentRelationName()"
                            fieldName="ceremony"
                            fieldLabel="Ceremony"
                            :required="true"
                            :time_options="time_options"
                        ></wedding-schedule-form-start-end-time>
                    </div>
                </div>
            </div>
            <div class="schedule-form__section options">
                <div class="schedule-form__section-inner radio-group">
                    <h3 class="schedule-form__title">Ceremony Setting:</h3>
                    <div v-for="setting in this.ceremony_settings" :key="setting.identifier">
                        <input type="radio"
                            :name="getCurrentRelationName() + '[settings]'"
                            v-model="getCurrentRelation().settings"
                            @change="ceremony_settings_other = false"
                            :value="setting.identifier"
                            :id="`setting_` + setting.identifier"
                        />
                        <label :for="`setting_` + setting.identifier">{{ setting.title }}</label>
                    </div>
                    <div class="form-control-wrap other">
                        <input type="radio" id="setting-other"
                               :checked="ceremony_settings_other"
                               @change="ceremony_settings_other = true; getCurrentRelation().settings = ''"
                               :name="getCurrentRelationName() + '[settings]'"
                        />
                        <label for="setting-other">Other:</label>
                        <input class="form-control-sm" type="text"
                            :name="getCurrentRelationName() + '[settings]'"
                            v-model="getCurrentRelation().settings"
                            :disabled="!ceremony_settings_other"
                            v-show="ceremony_settings_other"
                        />
                    </div>
                </div>
                <div class="schedule-form__section-inner radio-group">
                    <h3 class="schedule-form__title">Ceremony Traditions:</h3>
                    <div v-for="tradition in this.ceremony_traditions" :key="tradition.identifier">
                        <input type="checkbox"
                            :name="getCurrentRelationName() + '[ceremony_traditions][]'"
                            v-model="ceremony_tradition[tradition.identifier]"
                            :value="tradition.identifier"
                            :id="`tradition_` + tradition.identifier"
                        />
                        <label :for="`tradition_` + tradition.identifier">{{ tradition.title }}</label>
                    </div>
                    <div class="form-control-wrap other">
                        <input type="checkbox" id="tradition_other" v-model="ceremony_traditions_other">
                        <label for="tradition_other">Other:</label>
                        <input class="form-control-sm" type="text"
                            :name="getCurrentRelationName() + '[ceremony_traditions][]'"
                            v-model="ceremony_tradition.other"
                            :disabled="!ceremony_traditions_other"
                            v-show="ceremony_traditions_other"
                        />
                    </div>
                    <input type="hidden" v-if="showEmptyTraditionsInput()" :name="getCurrentRelationName() + '[ceremony_traditions]'" value="" />
                </div>
                <div class="schedule-form__section-inner radio-group">
                    <h3 class="schedule-form__title">Details:</h3>
                    <div v-for="detail in this.ceremony_details" :key="detail.identifier">
                        <input type="checkbox"
                            :name="getCurrentRelationName() + '[details][' + detail.identifier + ']'"
                            v-model="getCurrentRelation().details[detail.identifier]"
                            :value="detail.identifier"
                            :id="`detail_` + detail.identifier"
                        />
                        <label :for="`detail_` + detail.identifier">{{ detail.title }}</label>
                    </div>
                    <div class="form-control-wrap other">
                        <input type="checkbox" id="details-other"
                               :checked="ceremony_details_other"
                               @change="ceremony_details_other = !ceremony_details_other"
                               :name="getCurrentRelationName() + '[details][other]'"
                        />
                        <label for="details-other">Other:</label>
                        <input class="form-control-sm" type="text"
                            :name="getCurrentRelationName() + '[details][other]'"
                            v-model="getCurrentRelation().details.other"
                            :disabled="!ceremony_details_other"
                            v-show="ceremony_details_other"
                        />
                    </div>
                </div>
            </div>
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
        </div>

        <div v-if="current_step == 3" class="schedule-forms">
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
            <div class="schedule-form__section">
                <div class="schedule-form__section-inner">
                    <label class="schedule-form__title" for="getCurrentRelationName() + '[name_of_reception]'">Name of Reception Location:</label>
                    <input class="form-control" type="text"
                        id="getCurrentRelationName() + '[name_of_reception]'"
                        :name="getCurrentRelationName() + '[name_of_reception]'"
                        :value="getCurrentRelation().name_of_reception ? getCurrentRelation().name_of_reception : getCurrentRelation().address.name"
                        required
                    />
                </div>
                <div class="schedule-form__section-inner">
                    <label class="schedule-form__title" for="getCurrentRelationName() + '[insurance_certificate]'" style="margin-bottom:0px;">Certificate of Insurance:</label>
                    <div class="form-group">
                        <input type="radio"
                                :name="getCurrentRelationName() + '[insurance_certificate]'"
                                value="1"
                                id="insurance_certificate_y"
                                :checked="getCurrentRelation().insurance_certificate == 1"
                                v-model="getCurrentRelation().insurance_certificate"
                                required
                            /><br>
                        <label for="insurance_certificate_y">Yes </label> (Please email us at <a href="mailto:support@jaylimstudio.com" style="font-weight:bold;color:rgba(57, 57, 57, 0.5);">support@jaylimstudio.com</a> if you need a Certificate of Insurance) **
                    </div>
                    <div class="form-group">
                        <input type="radio"
                                :name="getCurrentRelationName() + '[insurance_certificate]'"
                                value="0"
                                id="insurance_certificate_n"
                                :checked="getCurrentRelation().insurance_certificate == 0"
                                v-model="getCurrentRelation().insurance_certificate"
                                required
                            />
                        <label for="insurance_certificate_n">No</label>
                    </div>
                    <a :href="download_urls.download" style="color:#fb434c;" v-if="is_download_file == 1">Download Insurance Certificate</a>
                </div>
                <div class="schedule-form__section-inner">
                    <h3 class="schedule-form__title">Reception Address:</h3>
                    <wedding-schedule-form-address
                        :address="getRelationAddress()"
                    ></wedding-schedule-form-address>
                </div>

                <div class="schedule-form__section-inner">
                    <h3 class="schedule-form__title">Venue Information:</h3>
                    <div class="address-form">
                        <div class="form-control-wrap js-input-wrap">
                            <label :for="getCurrentRelationName() + '[venue_coordinator_name]'" :class="{'form-control-label js-form-label': true, 'active': getCurrentRelation().venue_coordinator_name}">
                                Venue Coordinator Name
                            </label>
                            <input class="form-control js-form-input"
                                type="text"
                                :name="getCurrentRelationName() + '[venue_coordinator_name]'"
                                :value="getCurrentRelation().venue_coordinator_name"
                                required
                            />
                        </div>
                        <div class="form-control-wrap js-input-wrap">
                            <label :for="getCurrentRelationName() + '[venue_coordinator_email]'" :class="{'form-control-label js-form-label': true, 'active': getCurrentRelation().venue_coordinator_email}">
                                Venue Coordinator Email
                            </label>
                            <input class="form-control js-form-input"
                                type="text"
                                :name="getCurrentRelationName() + '[venue_coordinator_email]'"
                                :value="getCurrentRelation().venue_coordinator_email"
                                required
                            />
                        </div>
                        <div class="form-control-wrap js-input-wrap">
                            <label :for="getCurrentRelationName() + '[venue_coordinator_phone]'" :class="{'form-control-label js-form-label': true, 'active': getCurrentRelation().venue_coordinator_phone}">
                                Venue Coordinator Phone
                            </label>
                            <input class="form-control js-form-input"
                                type="text"
                                :name="getCurrentRelationName() + '[venue_coordinator_phone]'"
                                :value="getCurrentRelation().venue_coordinator_phone"
                                required
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="schedule-form__section flex">
                <h3 class="schedule-form__title">Reception Schedule:</h3>
                <div class="datepicker-form start-end">
                    <!-- Cocktail Start & End Time -->
                    <wedding-schedule-form-start-end-time
                        :relation="getCurrentRelation()"
                        :relationName="getCurrentRelationName()"
                        :fieldName="`cocktails`"
                        :fieldLabel="`Cocktails`"
                        :time_options="time_options"
                    ></wedding-schedule-form-start-end-time>

                    <!-- Reception Start & End Time -->
                    <wedding-schedule-form-start-end-time
                        :relation="getCurrentRelation()"
                        :relationName="getCurrentRelationName()"
                        :fieldName="`reception`"
                        :fieldLabel="`Reception`"
                        :required="true"
                        :time_options="time_options"
                    ></wedding-schedule-form-start-end-time>

                     <wedding-schedule-form-time
                        :relation="getCurrentRelation()"
                        :relationName="getCurrentRelationName()"
                        :fieldName="`cake_cutting`"
                        :fieldLabel="`Cake cutting`"
                        :time_options="time_options"
                    ></wedding-schedule-form-time> 

                    <!-- Viennese -->
                    <!--<wedding-schedule-form-start-end-time
                        :relation="getCurrentRelation()"
                        :relationName="getCurrentRelationName()"
                        :fieldName="`viennese`"
                        :fieldLabel="`Viennese`"
                    ></wedding-schedule-form-start-end-time>-->
                </div>

                <!-- Party Start & End Time -->
                <!--<wedding-schedule-form-start-time
                    :relation="getCurrentRelation()"
                    :relationName="getCurrentRelationName()"
                    :fieldName="`afterparty`"
                    :fieldLabel="`Afterparty`"
                ></wedding-schedule-form-start-time>-->

                <!--<div class="form-control-wrap js-input-wrap">
                    <label :for="getCurrentRelationName() + '[number_of_toasts]'">
                        # of Speeches/Toasts
                    </label>
                    <input class="form-control" type="number" min="0" oninput="validity.valid||(value='');"
                           :id="getCurrentRelationName() + '[number_of_toasts]'"
                           :name="getCurrentRelationName() + '[number_of_toasts]'"
                           :value="getCurrentRelation().number_of_toasts"
                    >
                </div>-->
                <div class="form-control-wrap js-input-wrap full-width">
                    <label :class="{'form-control-label js-form-label': true, 'active': getCurrentRelation().toast_givers}"
                        :for="getCurrentRelationName() + '[toast_givers]'"
                    >
                        Who Will Give Speech/Toast
                    </label>
                    <input class="form-control js-form-input" type="text"
                           :id="getCurrentRelationName() + '[toast_givers]'"
                           :name="getCurrentRelationName() + '[toast_givers]'"
                           :value="getCurrentRelation().toast_givers"
                    >
                </div>
            </div>
            <div class="details-forms">
                <p class="details-forms__comment-description">Please submit your reception timeline provided by the venue or DJ.</p>
                <file-uploader name="reception[timeline_file]" :value="getCurrentRelation().timeline_file"></file-uploader>
            </div>
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
        </div>

        <div v-if="current_step == 4" class="schedule-forms">
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
            <div class="schedule-form__section full-width radio-group">
                <h3>When is your portrait session (including bride & groom, bridal party, family & etc.) ?</h3>
                <div class="schedule-form__options" style="padding-top:10px;">
                    <div class="form-group">
                        <input type="checkbox"
                            :name="getCurrentRelationName() + '[when][]'"
                            value="1"
                            id="beforeceremony"
                            :checked="getCurrentRelation().when == 1"
                            v-model="getCurrentRelation().when"
                            required
                        />
                        <label for="beforeceremony">Before Ceremony</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"
                            :name="getCurrentRelationName() + '[when][]'"
                            value="2"
                            id="afterceremony"
                            :checked="getCurrentRelation().when == 2"
                            v-model="getCurrentRelation().when"
                            required
                        />
                        <label for="afterceremony">After Ceremony</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"
                            :name="getCurrentRelationName() + '[when][]'"
                            value="3"
                            id="notsure"
                            :checked="getCurrentRelation().when == 3"
                            v-model="getCurrentRelation().when"
                            required
                        />
                        <label for="notsure">Not Sure</label>
                    </div>
                </div>
            </div>
            <div class="schedule-form__section full-width flex">
                <h3 class="schedule-form__title">Enter one or more portrait session locations:</h3>
                <div class="schedule-form__section-inner" v-for="(address, index) in this.schedule.portrait_session.portrait_session_locations" :key="index">
                    <b v-html="'Location ' + (index+1)" class="schedule-form__title"></b>
                    <br>
                    <repeater-address
                        :relationName="getCurrentRelationName()"
                        :fieldName="`portrait`"
                        :fieldLabel="`Portrait session`"
                        :address="address"
                        :index="index"
                        :removeItem="removeItem.bind(this, index)"
                        :time_options="time_options"
                    ></repeater-address>
                </div>
                <div class="schedule-form__action-add">
                    <button type="button" @click='addItems' class="btn-add">
                        <svg class="icon icon-plus"><use xlink:href="#icon-plus"></use></svg>
                        Add Location
                    </button>
                    <p class="btn-note">Please click "Next" if you are unsure</p>
                </div>
            </div>
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Next</button>
            </div>
        </div>

        <div v-if="current_step == 5" class="schedule-forms">
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Submit</button>
            </div>
            <p class="h3 mb-4">Now that you filled all information, please share with us your availabilities to connect to our scheduling coordinator to confirm your wedding details: (This meeting will take about 10-15 minutes)</p>
            <wedding-schedule-availabilities :wedding_schedule="schedule"></wedding-schedule-availabilities>
            <div class="details-forms">
                <div class="details-forms__comment">
                    <label class="details-forms__comment-label" for="comment">Comments:</label>
                    <p class="details-forms__comment-description">Feel free to list any specific wedding day details you’d like for our Team to know ahead of time. Also, please make sure to let us know of any chances that may occur prior to, or on the day of your special day.</p>
                    <textarea :name="'comment'"
                              :value="comment"
                              id="comment"
                              cols="30"
                              rows="10"
                              class="form-control">
                    </textarea>
                </div>
                <p class="details-forms__comment-description">Please attach files if you would like to share planner timeline, notes, etc.</p>
                <file-uploader name="file" :value="schedule.file"></file-uploader>
            </div>
            <div class="schedule-form__action mb-4" v-if="!readonly">
                <button class="btn-primary" @click="back" type="button" style="width:59px;">Back</button>
                <button class="btn-primary" @click="submit" type="submit" style="width:59px;">Submit</button>
            </div>
        </div>
    </form>
</template>
<script>
    import RepeatAddress from "./RepeatAddress";
    import Select2 from 'v-select2-component';

    export default {
        components: {RepeatAddress, Select2},
        props: [
            'wedding_schedule',
            'urls',
            'steps',
            'relations',
            'ceremony_settings',
            'preparation_settings',
            'ceremony_details',
            'ceremony_traditions',
            'contacts',
            'newlywed_types',
            'readonly',
            'download_urls',
            'is_download_file',
            'time_options'
        ],
        data() {
            var schedule = this.wedding_schedule;

            if(!schedule.ceremony) {
                schedule.ceremony = {};
            }

            if(!schedule.preparation) {
                schedule.preparation = {};
            }

            var ceremony_traditions = schedule.ceremony.ceremony_traditions;
            schedule.ceremony.ceremony_traditions = {};
            if(ceremony_traditions &&  Array.isArray(ceremony_traditions)) {
                ceremony_traditions.forEach(value => {
                    let other = true;
                    this.ceremony_traditions.forEach(data => {
                        if(value == data.identifier) {
                            other = false;
                        }
                    });
                    if(!other) {
                        schedule.ceremony.ceremony_traditions[value] = true;
                    } else {
                        schedule.ceremony.ceremony_traditions.other = value;
                    }
                });
            }

            var ceremony_settings_other = schedule.ceremony.settings ? true : false;
            for(var index in this.ceremony_settings) {
                if(schedule.ceremony.settings && this.ceremony_settings[index].title == schedule.ceremony.settings) {
                    ceremony_settings_other = false;
                    schedule.ceremony.settings = this.ceremony_settings[index].identifier;
                }
            }

            var preparation_settings_other = schedule.preparation.settings ? true : false;
            var preparation_settings_select = [];
            for(var index in this.preparation_settings) {
                preparation_settings_select.push({
                    id: this.preparation_settings[index].id,
                    text: this.preparation_settings[index].title,
                });
                if(schedule.preparation.settings && this.preparation_settings[index].identifier == schedule.preparation.settings) {
                    ceremony_settings_other = false;
                }
            }

            var ceremony_details_other = (typeof schedule.ceremony.details.other != 'undefined') ? true : false;

            var contacts_settings_select = [];
            for(var index in this.contacts) {
                contacts_settings_select.push({
                    id: this.contacts[index].id,
                    text: this.contacts[index].first_name + ' ' + this.contacts[index].last_name + 
                        (this.contacts[index].role_id ? ' (' + this.contacts[index].role.title + ')' : ''),
                });
            }

            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                current_step: !this.readonly ? this.wedding_schedule.current_step : 0,
                first_week: this.wedding_schedule.first_week,
                first_time: this.wedding_schedule.first_time,
                second_week: this.wedding_schedule.second_week,
                second_time: this.wedding_schedule.second_time,
                third_week: this.wedding_schedule.third_week,
                third_time: this.wedding_schedule.third_time,
                comment: this.wedding_schedule.comment,
                schedule: schedule,
                ceremony_traditions_other: !!schedule.ceremony.ceremony_traditions['other'],
                ceremony_tradition: schedule.ceremony.ceremony_traditions,
                preparation_settings_other: preparation_settings_other,
                ceremony_details_other: ceremony_details_other,
                ceremony_settings_other: ceremony_settings_other,
                contactsSelectSettings: {
                    minimumResultsForSearch: Infinity,
                    placeholder: 'Emergency Contact'
                },
                settingSelectSettings: {
                    minimumResultsForSearch: Infinity,
                    placeholder: 'Name of Setting'
                },
                preparation_settings_select: preparation_settings_select,
                contacts_settings_select: contacts_settings_select,
            };
        },
        mounted() {
            this.schedule.portrait_session.when = JSON.parse(this.schedule.portrait_session.when)
            
            this.form = $('#wedding-schedule-form');
            this.formValidator = this.form.validate();
            if(!this.schedule.portrait_session.portrait_session_locations.length) {
                this.addItems();
            }
        },
        methods: {
            back() {
                this.current_step--;
                this.current_step = Math.max(this.current_step, 0);
            },
            portraitSessionLocation() {
                return this.schedule.portrait_session.portrait_session_locations;
            },
            addItems() {
                this.schedule.portrait_session.portrait_session_locations.push({portrait_start_time:"00.00",portrait_end_time:"00.00",address:{address_line_1: "", address_line_2: "", country: "", state: "", city: "", zip: ""}});
            },
            removeItem(index) {
                this.schedule.portrait_session.portrait_session_locations.splice(index,1);
            },

            getCurrentRelation: function() {
                if(!this.schedule[this.getCurrentRelationName(this.current_step)]) {
                    this.schedule[this.getCurrentRelationName(this.current_step)] = {};
                }
                let currentRelation = this.schedule[this.getCurrentRelationName(this.current_step)];
                if(!currentRelation.address || !currentRelation.address.address_line_1) {
                    currentRelation.address = this.schedule.first_newlywed_preparation.address;
                }
                return currentRelation;
            },
            getCurrentRelationName: function() {
                return this.relations[this.current_step];
            },
            goToStep: function(step) {
                if(step >= this.current_step && !this.readonly) {
                    return false;
                }
                this.current_step = step;
            },
            submit: function(event) {
                this.form.validate();
                if(!this.form.valid()) {
                    event.preventDefault();
                }
                return false;
            },
            showEmptyTraditionsInput: function() {
                if(this.ceremony_traditions_other) {
                    return false;
                }
                let show = true;
                this.ceremony_traditions.forEach(data => {
                    if(this.ceremony_tradition[data.identifier]) {
                        show = false;
                    }
                });
                return show;
            },
            getRelationAddress: function() {
                let address = this.getCurrentRelation().address;
                if(!address) {
                    address = {};
                }
                address.type = this.getCurrentRelationName();
                console.log(address);
                return address;
            },
            onChangeValue:function($event){
                let currentRelation = this.schedule[this.getCurrentRelationName(this.current_step)];
                if(currentRelation.hair_makeup == "1"){
                    currentRelation.address.hair_makeup_name = null;
                    currentRelation.address.hair_makeup_state = null;
                    currentRelation.address.hair_makeup_zip = null;
                    currentRelation.address.hair_makeup_city = null;
                    currentRelation.address.hair_makeup_address_line_2 = null;
                    currentRelation.address.hair_makeup_address_line_1 = null;
                }
            }
        },
    }
</script>
