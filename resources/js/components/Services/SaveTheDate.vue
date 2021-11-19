<template>
<div>
    <form :action="form_action" method="post" id="save-the-date-card-form" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="_token" :value="csrf" />

        <header class="intro-heading row">
            <div class="col-lg-9">
                <h2>Save the Date Card</h2>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li v-for="(step, index) in steps" v-if="step.visible" 
                    :key="index"
                    :class="{'steps__list-item' : true, 'is-complete' : (currentStep > index), 'is-active' : (index == currentStep) }"
                >
                    <a @click="goToStep(index)" href="">{{ step.label }}</a>
                </li>
            </ol>
        </nav>

        <div v-show="currentStep == 0" class="order-forms">
            <div class="order-form__section full-width">
                    <h2 class="order-form__step-title">Card Information</h2>
                    <span class="b-request__ttl-note">Please refer back to your Contract for this information</span>
            </div>
            <div class="order-form__section flex">
                <div class="order-form__section-inner mb-4 mr-2 radio-group">
                    <h3 class="order-form__title">Size:</h3>
                    <div v-for="size in sizes" :key="size.id" class="order-form__options">
                        <input type="radio" name="size_id" :id="'size-' + size.id" :value="size.id" required />
                        <label :for="'size-' + size.id">{{ size.title }}</label>
                    </div>
                </div>
                <div class="order-form__section-inner mb-5 mr-5 radio-group">
                    <h3 class="order-form__title">Format:</h3>
                    <div v-for="(label, value) in formats" :key="value" class="order-form__options">
                        <input v-model="format" type="radio" name="format" :id="'format-' + value" :value="value" required />
                        <label :for="'format-' + value">{{ label }}</label>
                    </div>
                </div>
                <div class="order-form__section-inner mb-5 radio-group">
                    <h3 class="order-form__title">Magnet:</h3>
                    <div class="order-form__options">
                        <input v-model="magnet" type="radio" name="is_magnet" id="magnet_no" value="0" />
                        <label for="magnet_no">No</label>
                    </div>
                    <div class="order-form__options">
                        <input v-model="magnet" type="radio" name="is_magnet" id="magnet_yes" value="1" />
                        <label for="magnet_yes">Yes</label>
                    </div>
                </div>
                <div class="order-form__section full-width">
                    <label for="amount-of-cards" class="order-form__title">Amount of Cards:</label>
                    <input id="amount-of-cards" class="form-control" name="cards_amount" type="number" min="25" required />
                </div>
                <div class="order-form__section full-width">
                    <label for="ts-of-the-reception" class="order-form__title">Town & State of the Reception:</label>
                    <input id="ts-of-the-reception" class="form-control" name="reception_address" type="text" required />
                </div>
            </div>

            <div class="order-form__action">
                <button class="btn-primary" v-on:click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 1" class="order-forms">
            <order-form-templates-step
                :templates="getTemplates(front_side_type)"
                name="front_side_template_id"
                title="Front Side Templates"
                :orientation="format"
                v-model="images_count.front"
                v-on:change="updateStepsVisibility"
            ></order-form-templates-step>

            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 2" class="order-forms">
            <order-form-images-step 
                name="front_side_images"
                :images_count="images_count.front"
            ></order-form-images-step>

            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 3" class="order-forms">
            <order-form-templates-step
                :templates="getTemplates(back_side_type)"
                name="back_side_template_id"
                title="Back Side Templates"
                :orientation="format"
                v-model="images_count.back"
                v-on:change="updateStepsVisibility"
            ></order-form-templates-step>

            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div  v-show="currentStep == 4" class="order-forms">
            <order-form-images-step 
                name="back_side_images"
                :images_count="images_count.back"
            ></order-form-images-step>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 5" class="order-forms">
            <h2 class="mb-4 mr-3 mb-0">Delivery Location</h2>
            <div class="row mb-4">
                <div v-for="location in locations" :key="location.id" class="col-md-6 col-xl-4">
                    <div class="form-group radio-group delivery-location">
                        <input type="radio" name="delivery_location_id" :id="'location-' + location.id" :value="location.id" required />
                        <label class="card__ttl" :for="'location-' + location.id">{{ location.title }}</label>
                    </div>
                    <p class="pl-4 mb-1">{{ location.address }}</p>
                    <p class="pl-4 mb-1">{{ location.telephone }}</p>
                    <p class="pl-4 mb-4">{{ location.working_hours }}</p>
                </div>
            </div>

            <order-form-comment-step></order-form-comment-step>

            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
</template>
<script>
export default {
    props: [
        'form_action', 'sizes', 'formats', 'templates', 'front_side_type', 'back_side_type', 'locations'
    ],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            currentStep: 0,
            steps: [
                {label: 'Card Information', visible: true},
                {label: 'Front Side Template', visible: true},
                {label: 'Front Side Images', visible: false},
                {label: 'Back Side Template', visible: true},
                {label: 'Back Side Images', visible: false},
                {label: 'Additional Comments', visible: true},
            ],
            format: false,
            images_count: {
                front: 0,
                back: 0,
            },
            magnet: 0,
        }
    },
    mounted() {
        $('#save-the-date-card-form').validate();
    },
    watch:{
        magnet(val) {
            this.steps[3].visible = val == 0;
        }
    },
    methods: {
        back() {
            this.currentStep--;
            this.currentStep = Math.max(this.currentStep, 0);
            if(!this.steps[this.currentStep].visible) {
                this.back();
            }
        },
        next: function() {
            if(!$('#save-the-date-card-form').valid()) {
                return false;
            }

            this.currentStep++;
            if(this.currentStep > this.steps.length - 1) {
                return false;
            }
            if(!this.steps[this.currentStep].visible) {
                this.next();
            }
        },
        goToStep: function(index) {
            if(index < this.currentStep) {
                this.currentStep = index;
            }
        },
        getTemplates: function(sideType) {
            var templates = [];
            for(var index in this.templates) {
                if(this.templates[index].side_type == sideType && this.templates[index].format == this.format) {
                    templates.push(this.templates[index]);
                }
            }
            return templates;
        },
        updateStepsVisibility: function() {
            this.steps[2].visible = this.images_count.front > 0;
            this.steps[4].visible = this.images_count.back > 0;
        },
    },
}
</script>
