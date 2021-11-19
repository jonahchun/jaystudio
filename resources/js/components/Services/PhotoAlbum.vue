<template>
<div>
    <form :action="form_action" method="post" id="photo-album-order-form" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="_token" :value="csrf" />

        <header class="intro-heading row">
            <div class="col-lg-9">
                <h2>Album Order Form</h2>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li v-for="(step, index) in steps" v-if="step.visible" 
                    :key="index"
                    :class="{'steps__list-item' : true, 'is-complete' : (currentStep > index), 'is-active' : (index == currentStep) }"
                >
                    <a @click="goToStep(index)">{{ step.label }}</a>
                </li>
            </ol>
        </nav>

        <div v-show="currentStep == 0" class="order-forms">
            <div class="b-request__heading row">
                <div class="col-xl-6">
                    <h2 class="order-form__step-title">Choose Album Type</h2>
                </div>
            </div>
            <input type="text" name="type_validation" style="opacity:0;width:0px;height:0px" :value="type" required />
            <div class="b-image-templates js-img-tpl-4 swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="albumType in album_types" :key="albumType.value" class="b-image-templates__slide swiper-slide">
                        <input v-model="type"
                            v-on:change="updateStepsVisibility"
                            type="radio"
                            name="album_type"
                            :id="'album-type-' + albumType.value"
                            :value="albumType.value"
                        />
                        <label :for="'album-type-' + albumType.value" class="b-image-templates__radio">
                            <image-with-zoom
                                :image_url="albumType.image"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                            <span class="b-image-templates__mask"></span>
                        </label>
                        <div class="text-center mt-2">
                            <h3 class="text-uppercase">{{ albumType.label }}</h3>
                        </div>
                    </div>
                </div>
                <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
            </div>
            <div class="order-form__action">
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 1" class="order-forms">
            <div class="b-request__heading row">
                <div class="col-xl-6">
                    <h3 class="order-form__step-title">Album Information</h3>
                    <span class="b-request__ttl-note">Refer back to your contract for this information.</span>
                </div>
            </div>
            <div class="mb-2 radio-group">
                <h3 class="order-form__title">Select One:</h3>
                <div v-for="coreType in core_types" :key="coreType.id" class="form-group mb-0 mr-3">
                    <input v-model="core_type"
                        v-on:change="updateStepsVisibility"
                        type="radio"
                        name="core_type_id"
                        :id="'album-type-' + coreType.id"
                        :value="coreType.id"
                        required
                    />
                    <label :for="'album-type-' + coreType.id">{{ coreType.title }}</label>
                </div>
            </div>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 2" class="order-forms">
            <header class="mb-4 d-flex align-items-center flex-wrap">
                <h2 class="order-form__step-title">Album Collection</h2>
            </header>
            <input type="text" name="luxe_type_validation" style="opacity:0;width:0px;height:0px" :value="luxe_type" required />
            <div class="b-image-templates js-img-tpl-4 swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="luxeType in luxe_types" :key="luxeType.id" class="b-image-templates__slide swiper-slide">
                        <input type="radio"
                            v-model="luxe_type"
                            v-on:change="updateStepsVisibility"
                            name="luxe_type_id"
                            :id="'luxe-type-' + luxeType.id"
                            :value="luxeType.id"
                        />
                        <label :for="'luxe-type-' + luxeType.id" class="b-image-templates__radio">
                            <image-with-zoom
                                :image_url="luxeType.image_url"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                            <span class="b-image-templates__mask"></span>
                        </label>
                        <div class="text-center">
                            <h3 class="text-uppercase">{{ luxeType.title }}</h3>
                        </div>
                    </div>
                </div>
                <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
            </div>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 3" class="order-forms">
            <header class="mb-4 d-flex align-items-center">
                <h2 class="order-form__step-title">Select Embedding Option</h2>
            </header>
            <div class="mb-4">
                <order-form-luxe-type-images :images="getImages(leather_luxe_type_id)"></order-form-luxe-type-images>
            </div>
            <div class="order-form__section flex">
                <div class="order-form__section-inner large mb-4">
                    <order-form-photo-album-sizes :prefix="'leather'" :sizes="getSizes(leather_luxe_type_id)"></order-form-photo-album-sizes>
                </div>
                <div class="order-form__section-inner large mb-5 radio-group">
                    <h3 class="order-form__title">Cover Text Options:</h3>
                    <div class="order-form__options">
                        <div class="form-group mb-0">
                            <input v-model="leather_text"
                                class="form-control"
                                name="leather_text_option"
                                type="radio"
                                id="leather_text_option_none"
                                value="0"
                                required
                            />
                            <label for="leather_text_option_none">None</label>
                        </div>
                        <div class="form-group form-inline mb-0 mr-3">
                            <input v-model="leather_text"
                                class="form-control"
                                name="leather_text_option"
                                type="radio"
                                id="leather_text_option_custom"
                                value="1"
                                required
                            />
                            <label for="leather_text_option_custom" class="mr-3">Custom</label>
                            <input v-if="leather_text == 1" class="form-control-sm" type="text" name="leather_text" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 4" class="order-forms">
            <header class="mb-4 d-flex align-items-center">
                <h2 class="order-form__step-title">Choose Vintage Cover Option</h2>
            </header>
            <div class="mb-4">
                <order-form-luxe-type-images :images="getImages(vintage_luxe_type_id)"></order-form-luxe-type-images>
            </div>
            <order-form-photo-album-sizes :prefix="'vintage'" :sizes="getSizes(vintage_luxe_type_id)"></order-form-photo-album-sizes>
            
            <input type="text" name="vintage_cover_validation" style="opacity:0;width:0px;height:0px" :value="vintage_cover" required />
            <div class="b-image-templates js-img-tpl-4 swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="vintageCover in vintage_covers" :key="vintageCover.id" class="b-image-templates__slide additional-option swiper-slide">
                        <input type="radio"
                            v-model="vintage_cover"
                            name="vintage_cover_id"
                            :id="'vintage-cover-' + vintageCover.id"
                            :value="vintageCover.id"
                        />
                        <label :for="'vintage-cover-' + vintageCover.id" class="b-image-templates__radio">
                            <image-with-zoom
                                :image_url="vintageCover.thumbnail_url"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                            <span class="b-image-templates__mask"></span>
                        </label>
                    </div>
                </div>
                <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
            </div>
            <input v-if="luxe_type == vintage_luxe_type_id" type="text" name="black_matte_cover_validation" style="opacity:0;width:0px;height:0px" :value="black_matte_cover" required />
            <div v-if="luxe_type == vintage_luxe_type_id" class="b-image-templates js-img-tpl-4 swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="blackMatteCover in black_matte_covers" :key="blackMatteCover.id" class="b-image-templates__slide additional-option swiper-slide">
                        <input type="radio"
                            v-model="black_matte_cover"
                            name="black_matte_cover_id"
                            :id="'vintage-black-matte-cover-' + blackMatteCover.id"
                            :value="blackMatteCover.id"
                        />
                        <label :for="'vintage-black-matte-cover-' + blackMatteCover.id" class="b-image-templates__radio">
                            <image-with-zoom
                                :image_url="blackMatteCover.thumbnail_url"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                            <span class="b-image-templates__mask"></span>
                        </label>
                    </div>
                </div>
                <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
            </div>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 5" class="order-forms">
            <header class="mb-4">
                <h2 class="order-form__step-title">Choose Black Matte Cover Option</h2>
                <span class="b-request__ttl-note">Please select one - Style is as is and cannot be altered</span>
            </header>
            <div class="mb-4">
                <order-form-luxe-type-images :images="getImages(black_mate_luxe_type_id)"></order-form-luxe-type-images>
            </div>
            <order-form-photo-album-sizes :prefix="'black_matte'" :sizes="getSizes(black_mate_luxe_type_id)"></order-form-photo-album-sizes>
            <input v-if="luxe_type == black_mate_luxe_type_id" type="text" name="black_matte_cover_validation" style="opacity:0;width:0px;height:0px" :value="black_matte_cover" required />
            <div v-if="luxe_type == black_mate_luxe_type_id" class="b-image-templates js-img-tpl-4 swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="blackMatteCover in black_matte_covers" :key="blackMatteCover.id" class="b-image-templates__slide additional-option swiper-slide">
                        <input type="radio"
                            v-model="black_matte_cover"
                            name="black_matte_cover_id"
                            :id="'black-matte-cover-' + blackMatteCover.id"
                            :value="blackMatteCover.id"
                        />
                        <label :for="'black-matte-cover-' + blackMatteCover.id" class="b-image-templates__radio">
                            <image-with-zoom
                                :image_url="blackMatteCover.thumbnail_url"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                            <span class="b-image-templates__mask"></span>
                        </label>
                    </div>
                </div>
                <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
            </div>
            <div class="order-form__action">
                <button class="btn-primary" @click="back" type="button">Back</button>
                <button class="btn-primary" @click="next" type="button">Next</button>
            </div>
        </div>

        <div v-show="currentStep == 6" class="order-forms">
            <header class="mb-4 d-flex align-items-center">
                <h2 class="order-form__step-title">Choose Art Deco Cover Option</h2>
            </header>
            <div class="mb-4">
                <order-form-luxe-type-images :images="getImages(art_deco_luxe_type_id)"></order-form-luxe-type-images>
            </div>

            <div class="order-form__section flex full-width">
                <div class="order-form__section-inner mr-3">
                    <order-form-photo-album-sizes :prefix="'art_deco'" :sizes="getSizes(art_deco_luxe_type_id)"></order-form-photo-album-sizes>
                </div>
                <div class="order-form__section-inner">
                    <div id="color-option" class="mb-5 radio-group">
                        <h3 class="order-form__title">Color Option:</h3>
                        <div class="order-form__options">
                            <div v-for="artDecoColor in art_deco_colors" :key="artDecoColor.id" class="form-group mb-0 mr-3">
                                <input type="radio"
                                    name="art_deco_color_id"
                                    :id="'art-deco-color-' + artDecoColor.id"
                                    :value="artDecoColor.id"
                                    required
                                />
                                <label :for="'art-deco-color-' + artDecoColor.id">{{ artDecoColor.title }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 d-flex align-items-center">
                <h3 class="order-form__title">Pattern Option:</h3>
            </div>
            <input type="text" name="art_deco_pattern_validation" style="opacity:0;width:0px;height:0px" :value="art_deco_pattern" required />
            <div class="b-image-templates js-img-tpl swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="artDecoPattern in art_deco_patterns" :key="artDecoPattern.id" class="b-image-templates__slide additional-option swiper-slide">
                        <input type="radio"
                            v-model="art_deco_pattern"
                            name="art_deco_pattern_id"
                            :id="'art-deco-pattern-' + artDecoPattern.id"
                            :value="artDecoPattern.id"
                        />
                        <label :for="'art-deco-pattern-' + artDecoPattern.id" class="b-image-templates__radio">
                            <image-with-zoom
                                :image_url="artDecoPattern.thumbnail_url"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                            <span class="b-image-templates__mask"></span>
                        </label>
                    </div>
                </div>
                <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="art_deco_cover_image">Art Deco Cover Image (Image Number) :</label>
                        <p>*Not available in size 8x8*</p>
                        <input class="form-control" id="art_deco_cover_image" name="art_deco_cover_image" type="text" required />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn-primary" @click="back" type="button">Back</button>
                    <button class="btn-primary" @click="next" type="button">Next</button>
                </div>
            </div>
        </div>

        <div v-show="currentStep == 7" class="order-forms">
            <header class="mb-4 d-flex align-items-center">
                <h2 class="mr-3 mb-0">Acrylic Cover Image</h2>
            </header>

            <div class="mb-4">
                <div class="b-image-templates js-img-tpl-4 swiper-container">
                    <div class="swiper-wrapper mb-4">
                        <div v-for="(image, index) in acrylic_images" :key="index" class="b-image-templates__slide swiper-slide">
                            <image-with-zoom
                                :image_url="image.thumbnail_url"
                                image_class="b-image-templates__img"
                            ></image-with-zoom>
                        </div>
                        <div class="b-image-templates__scrollbar js-img-tpl-scrollbar swiper-scrollbar"></div>
                    </div>
                </div>
            </div>

            <p>See upper for reference: Please specify below the file name you’d like to use for your Acrylic Cover.</p>

            <order-form-photo-album-sizes :prefix="'acrylic'" :sizes="acrylic_sizes"></order-form-photo-album-sizes>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="acrylic_cover_image">Acrylic Cover Image (Image Number):</label>
                        <input class="form-control" id="acrylic_cover_image" name="acrylic_cover_image" type="text" required />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn-primary" @click="back" type="button">Back</button>
                    <button class="btn-primary" @click="next" type="button">Next</button>
                </div>
            </div>
        </div>

        <div v-show="currentStep == 8" class="order-forms">
            <h2 class="mb-4 mr-3 mb-0">Directions</h2>
            <div class="info-list" v-html="directions[0]"></div>
            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn-primary" @click="back" type="button">Back</button>
                    <button class="btn-primary" @click="next" type="button">Next</button>
                </div>
            </div>
        </div>

        <div v-show="currentStep == 9" class="order-forms">
            <div class="b-request__heading row">
                <div class="col-xl-6 d-flex">
                    <h3 class="b-request__ttl">Please list images to put in the album</h3>
                    <a class="b-request__ttl-link" href="/faq" target="_blank">
                        <svg class="icon icon-help"><use xlink:href="#icon-help"></use></svg>
                    </a>
                </div>
            </div>

            <div class="row">
                <div v-for="col in 3" :key="col" class="col-lg-6 col-xl-4">
                    <div v-for="row in getImageRowNumbers(col)" :key="row" class="form-control-wrap js-input-wrap">
                        <label :for="`image_${row}`" :class="{'form-control-label js-form-label': true, 'active' : images[row]}">
                            #{{ row }}
                        </label>
                        <input v-model="images[row]" class="form-control" :name="'images[' + row + ']'" type="text" :id="`image_${row}`" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn-primary" @click="back" type="button">Back</button>
                    <button class="btn-primary" @click="next" type="button">Next</button>
                </div>
            </div>
        </div>

        <div v-show="currentStep == 10" class="order-forms">
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
            
            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn-primary" @click="back" type="button">Back</button>
                    <button class="btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
</template>
<script>
export default {
    props: [
        'form_action', 'album_types', 'luxe_album_type', 'acrylic_album_type', 'core_types',
        'directions', 'locations', 'luxe_types', 'leather_luxe_type_id', 'vintage_luxe_type_id',
        'black_mate_luxe_type_id', 'art_deco_luxe_type_id', 'vintage_covers', 'black_matte_covers',
        'art_deco_colors', 'art_deco_patterns', 'acrylic_sizes', 'acrylic_images'
    ],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            currentStep: 0,
            steps: [
                {label: 'Album Type', visible: true},
                {label: 'Album Information', visible: true},
                {label: 'Album Collection', visible: false},
                {label: 'Genuine Leather Embedding Option', visible: false},
                {label: 'Vintage Cover Option', visible: false},
                {label: 'Black Matte Cover Option', visible: false},
                {label: 'Art Deco Cover Option', visible: false},
                {label: 'Acrylic Cover Photo', visible: false},
                {label: 'Direction', visible: true},
                {label: 'Image Selections', visible: false},
                {label: 'Delivery & Comments', visible: true},
            ],
            type: '',
            core_type: '',
            lastRenderedImageFieldNumber: '',
            luxe_type: '',
            leather_text: '',
            vintage_cover: '',
            black_matte_cover: '',
            art_deco_pattern: '',
            images: {},
        }

    },
    mounted() {
        this.form = $('#photo-album-order-form');
        this.form.validate();
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
            if(!this.form.valid()) {
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
        updateStepsVisibility: function() {
            this.steps[3].visible = this.luxe_type == this.leather_luxe_type_id;
            this.steps[4].visible = this.luxe_type == this.vintage_luxe_type_id;
            this.steps[5].visible = this.luxe_type == this.black_mate_luxe_type_id;
            this.steps[6].visible = this.luxe_type == this.art_deco_luxe_type_id;

            if(this.type == this.acrylic_album_type) {
                this.steps[7].visible = true;

                this.steps[2].visible = false;
                this.steps[3].visible = false;
                this.steps[4].visible = false;
                this.steps[5].visible = false;
                this.steps[6].visible = false;
            }

            if(this.type == this.luxe_album_type) {
                this.steps[7].visible = false;
                this.steps[2].visible = true;
            }

            if(this.core_type) {
                this.steps[9].visible = true;
            }
        },
        goToStep: function(step) {
            if(step >= this.currentStep) {
                return false;
            }
            this.currentStep = step;
        },
        getImageRowNumbers: function(columnNumber) {
            var photosCount = 0;
            for(var index in this.core_types) {
                if(this.core_types[index].id == this.core_type) {
                    photosCount = this.core_types[index].photos_count;
                }
            }

            var firstColumnSize = Math.ceil(photosCount / 3);
            var secondColumnSize = firstColumnSize;
            var thirdColumnSize = firstColumnSize;
            if(photosCount - 2 * firstColumnSize < firstColumnSize - 1) {
                secondColumnSize--;
            }

            if(photosCount - 3 * firstColumnSize < 0) {
                thirdColumnSize--;
            }

            var startNumber;
            var endNumber;
            switch(columnNumber) {
                case 1:
                    startNumber = 1;
                    endNumber = firstColumnSize;
                    break;
                case 2:
                    startNumber = firstColumnSize + 1;
                    endNumber = firstColumnSize + secondColumnSize;
                    break;
                case 3:
                    startNumber = firstColumnSize + secondColumnSize + 1;
                    endNumber = photosCount;
                    break;
            }
            var numbers = [];
            for(startNumber; startNumber <= endNumber; startNumber++) {
                numbers.push(startNumber);
            }
            return numbers;
        },
        getImages: function(luxeTypeId) {
            var luxeType = this._getLuxeType(luxeTypeId);
            return luxeType ? luxeType.images : [];
        },
        getSizes: function(luxeTypeId) {
            var luxeType = this._getLuxeType(luxeTypeId);
            return luxeType ? luxeType.sizes : [];
        },
        _getLuxeType: function(luxeTypeId) {
            for(var index in this.luxe_types) {
                if(this.luxe_types[index].id == luxeTypeId) {
                    return this.luxe_types[index];
                }
            }
            return false;
        },
    },
}
</script>
