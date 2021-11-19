<template>
<div>
    <form :action="form_action" method="post" id="thank-you-card-form" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="_token" :value="csrf" />

        <header class="intro-heading row">
            <div class="col-lg-9">
                <h2>Thank You Cards</h2>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li v-for="(step, index) in steps" v-if="step.visible" :key="index"
                  :class="{'steps__list-item' : true, 'is-complete' : (currentStep > index), 'is-active' : (index == currentStep) }">
                    <a @click="goToStep(index)" href="">{{ step.label }}</a>
                </li>
            </ol>
        </nav>

        <div v-show="currentStep == 0" class="order-forms">
            <div class="b-request__heading row">
                <div class="col-xl-6">
                    <h2 class="order-form__step-title">Choose Card Type</h2>
                </div>
            </div>

            <input type="text" name="type_validation" style="opacity:0;width:0px;height:0px" :value="card_layout_type" required />
            <div class="b-image-templates js-img-tpl swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="cardTypeData in card_layout_types" :key="cardTypeData.value" class="b-image-templates__slide swiper-slide">
                        <input v-model="card_layout_type" 
                            v-on:change="updateStepsVisibility"
                            type="radio"
                            name="layout_type"
                            :value="cardTypeData.value"
                            :id="cardTypeData.value + '_card_type'"
                        />
                        <label class="card__ttl b-image-templates__radio" :for="cardTypeData.value + '_card_type'">
                            <image-with-zoom
                                :image_url="cardTypeData.image"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                            <span class="b-image-templates__mask"></span>
                        </label>
                        <div class="text-center">
                            <h3 class="text-uppercase">{{ cardTypeData.label }}</h3>
                        </div>
                    </div>
                </div>
                <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
            </div>

            <div class="order-form__section">
                <h3 class="order-form__title">Message:</h3>
                <div class="order-form__options">
                    <div>
                        <input class="form-control" id="message-card__blank" type="radio" name="write_message" value="0" v-model="write_message" />
                        <label for="message-card__blank">Blank</label>
                    </div>
                    <div>
                        <input class="form-control" id="message-card__pre-writing" type="radio" name="write_message" value="1" v-model="write_message" />
                        <label for="message-card__pre-writing">Pre-Written Message</label>
                    </div>
                    <div>
                        <input class="form-control" id="message-card__writing" type="radio" name="write_message" value="2" v-model="write_message" />
                        <label for="message-card__writing">Writing</label>
                        <textarea v-show="write_message == 2" v-model="message" class="form-control" name="message" cols="30" rows="10" required></textarea>
                    </div>
                </div>
            </div>

            <div class="order-form__action">
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 1" class="order-forms">
            <div class="b-request__heading row">
                <div class="col-xl-6">
                    <h2 class="order-form__step-title">Card Information</h2>
                    <span class="b-request__ttl-note">Please refer back to your Contract for this information</span>
                </div>
            </div>

            <div class="order-form__section flex">
                <div class="order-form__section-inner mb-4 radio-group">
                    <h3 class="order-form__title">Size:</h3>
                    <div v-for="size in sizes" :key="size.id" class="order-form__options">
                        <input type="radio" name="size_id" :id="'size-' + size.id" :value="size.id" required />
                        <label :for="'size-' + size.id">{{ size.title }}</label>
                    </div>
                </div>
                <div class="order-form__section-inner mb-5 radio-group">
                    <h3 class="order-form__title">Format:</h3>
                    <div v-for="(label, value) in formats" :key="value" class="order-form__options">
                        <input v-model="format" type="radio" name="format" :id="'format-' + value" :value="value" required />
                        <label :for="'format-' + value">{{ label }}</label>
                    </div>
                </div>
                <div class="order-form__section full-width">
                    <label class="order-form__title" for="thank_you_cards_amount">Amount of Cards:</label>
                    <input class="form-control" name="cards_amount" type="number" min="25" id="thank_you_cards_amount" required />
                </div>
            </div>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 2" class="order-forms">
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

        <div v-show="currentStep == 3" class="order-forms">
            <order-form-images-step 
                name="front_side_images"
                :images_count="images_count.front"
            ></order-form-images-step>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 4" class="order-forms">
            <order-form-templates-step
                :templates="getTemplates(inside_side_type)"
                name="inside_template_id"
                title="Inside Templates"
                :orientation="format"
                v-model="images_count.inside"
                v-on:change="updateStepsVisibility"
            ></order-form-templates-step>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 5" class="order-forms">
            <order-form-images-step 
                name="inside_images"
                :images_count="images_count.inside"
            ></order-form-images-step>

            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 6" class="order-forms">
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

        <div v-show="currentStep == 7" class="order-forms">
            <order-form-images-step 
                name="back_side_images"
                :images_count="images_count.back"
            ></order-form-images-step>

            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 8" class="order-forms">
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
        'form_action', 'card_layout_types', 'folded_card_layout_type', 'sizes',
        'formats', 'templates', 'front_side_type', 'back_side_type', 'inside_side_type', 'locations'
    ],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            currentStep: 0,
            steps: [
                {label: 'Card Type', visible: true},
                {label: 'Card Information', visible: true},
                {label: 'Front Side Template', visible: true},
                {label: 'Front Side Images', visible: false},
                {label: 'Inside Template', visible: false},
                {label: 'Inside Images', visible: false},
                {label: 'Back Side Template', visible: true},
                {label: 'Back Side Images', visible: false},
                {label: 'Additional Comments', visible: true},
            ],
            write_message: 0,
            card_layout_type: '',
            format: false,
            images_count: {
                front: 0,
                back: 0,
                inside: 0,
            },
            message: '',
        }
    },
    mounted() {
        $('#thank-you-card-form').validate();
    },
    watch:{
        write_message(val) {
            switch(val) {
                case "2":
                    this.message = '';
                    break;
                case "0":
                case "1":
                    $('#message-error').hide();
                    this.message = val == 1 ? 'Pre-Written Message' : '';
                    break;
            }
        },
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
            if(!$('#thank-you-card-form').valid()) {
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
        updateStepsVisibility: function() {
            this.steps[4].visible = this.card_layout_type == this.folded_card_layout_type;
            this.steps[3].visible = this.images_count.front > 0;
            this.steps[5].visible = this.images_count.inside > 0;
            this.steps[7].visible = this.images_count.back > 0;
        },
        getTemplates: function(sideType) {
            var templates = [];
            for(var index in this.templates) {
                if(this.templates[index].side_type == sideType 
                        && this.templates[index].format == this.format 
                        && this.templates[index].layout_type == this.card_layout_type) {
                    templates.push(this.templates[index]);
                }
            }
            return templates;
        },
    },
}
</script>
