<template>
    <form
        :action="urls.save"
        id="wedding-checklist-form"
        method="post"
        enctype="multipart/form-data"
        autocomplete="off"
        :class="{ readonly: readonly }"
    >
        <input type="hidden" name="_token" :value="csrf" />
        <input type="hidden" name="current_step" :value="current_step" />
        <input type="hidden" name="is_final_step" :value="is_final_step" id="is_final_step"/>
        <input type="hidden" name="button_type" id="btn_type"/>
        <input type="hidden" name="go_step" id="go_step"/>
        <input type="hidden" name="go_prev_step" id="go_prev_step"/>

        <header class="intro-heading row">
            <div class="col-9">
                <h2>Wedding Checklist</h2>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li
                    v-for="(step, index) in steps"
                    :key="index"
                    :class="{
                        'steps__list-item': true,
                        'is-complete': current_step > index && !readonly,
                        'is-active': index == current_step
                    }"
                >
                    <a @click="(event)=>goToStep(event,index)" href="">{{ step }}</a>
                </li>
            </ol>
        </nav>

        <div v-if="current_step <= 3" class="checklist-forms">
            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    v-if="current_step != 0"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button class="btn-primary" type="submit" style="width:59px;" @click="submit">
                    Next
                </button>
            </div>
            <div class="checklist-form__options">
                <div
                    class="form-group"
                    v-for="question in getStepQuestionRow(current_step, 1)"
                    :key="question.id"
                >
                    <input
                        type="checkbox"
                        :name="
                            step_names[current_step] +
                                '[' +
                                question.id +
                                '][value]'
                        "
                        :id="step_names[current_step] + '_' + question.id"
                        v-model="
                            checklist[step_names[current_step]][question.id]
                                .value
                        "
                        value="yes"
                    />
                    <label
                        :for="step_names[current_step] + '_' + question.id"
                        >{{ question.title }}</label
                    >
                    <input
                        type="hidden"
                        :name="'field_data[' + question.id + '][value]'"
                        :value="getFieldInfo(question.title, 'Selection')"
                        data-type="Selection"
                    />
                    <small
                        v-if="question.has_details"
                        aria-describedby="textSpecific"
                        class="form-text text-muted checklist-form__note"
                        >Please be specific:</small
                    >
                    <input
                        v-if="question.has_details"
                        :name="
                            step_names[current_step] +
                                '[' +
                                question.id +
                                '][details]'
                        "
                        type="text"
                        class="form-control"
                        v-model="
                            checklist[step_names[current_step]][question.id]
                                .details
                        "
                    />
                </div>
                <div
                    class="form-group"
                    v-for="question in getStepQuestionRow(current_step, 2)"
                    :key="question.id"
                >
                    <input
                        type="checkbox"
                        :name="
                            step_names[current_step] +
                                '[' +
                                question.id +
                                '][value]'
                        "
                        :id="step_names[current_step] + '_' + question.id"
                        v-model="
                            checklist[step_names[current_step]][question.id]
                                .value
                        "
                        value="yes"
                    />
                    <label
                        :for="step_names[current_step] + '_' + question.id"
                        >{{ question.title }}</label
                    >
                    <input
                        type="hidden"
                        :name="'field_data[' + question.id + '][value]'"
                        :value="getFieldInfo(question.title, 'Selection')"
                        data-type="Selection"
                    />
                    <small
                        v-if="question.has_details"
                        aria-describedby="textSpecific"
                        class="form-text text-muted checklist-form__note"
                        >Please be specific:</small
                    >
                    <input
                        v-if="question.has_details"
                        :name="
                            step_names[current_step] +
                                '[' +
                                question.id +
                                '][details]'
                        "
                        type="text"
                        class="form-control"
                        v-model="
                            checklist[step_names[current_step]][question.id]
                                .details
                        "
                    />
                </div>
                <input
                    type="text"
                    name="validation"
                    class="one-of-answers-required"
                    style="opacity:0;width:0;height:0"
                />
            </div>
            <div class="checklist-form__comment">
                <label
                    :for="step_names[current_step] + '_comment'"
                    class="checklist-form__title"
                    >Other comments:</label
                >
                <textarea
                    :name="step_names[current_step] + '[comment]'"
                    v-model="checklist[step_names[current_step]].comment"
                    :id="step_names[current_step] + '_comment'"
                    cols="30"
                    rows="10"
                    class="form-control"
                ></textarea>
                <input
                    type="hidden"
                    name="field_data[comment]"
                    :value="getFieldInfo('Other comments', 'Text Value')"
                    data-type="Text Value"
                />
            </div>
            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    v-if="current_step != 0"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button class="btn-primary" type="submit" style="width:59px;" @click="submit">
                    Next
                </button>
            </div>
        </div>

        <div v-if="current_step == 4">
            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button class="btn-primary" type="submit" style="width:59px;" @click="submit">
                    Next
                </button>
            </div>
            <div v-html="song_list"></div>
            <div class="checklist-forms radio-group">
                <h3 class="checklist-form__title">
                    I want to have music picked by:
                </h3>
                <div class="row" style="width:100%;">
                    <div class="col-md-5">
                        <div class="form-group">
                            <input
                                type="radio"
                                v-model="music"
                                :name="'music'"
                                value="1"
                                id="jaylimstudio"
                                :checked="music == 1"
                                required
                            />
                            <label for="jaylimstudio">JAYLim Studio</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input
                                type="radio"
                                v-model="music"
                                :name="'music'"
                                value="3"
                                id="no_service"
                                :checked="music == 3"
                                required
                            />
                            <label for="no_service"
                                >No Cinematography Service</label
                            >
                        </div>
                    </div>
                </div>
                <div class="row" style="width:100%;">
                    <div class="col-md-5">
                        <div class="form-group">
                            <input
                                type="radio"
                                v-model="music"
                                :name="'music'"
                                value="2"
                                id="myself"
                                :checked="music == 2"
                                required
                            />
                            <label for="myself">Myself</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input
                                type="radio"
                                v-model="music"
                                :name="'music'"
                                value="4"
                                id="myself_jaylim"
                                :checked="music == 4"
                                required
                            />
                            <label for="myself_jaylim"
                                >Myself & the rest can be picked by JAYlim
                                Studio</label
                            >
                        </div>
                    </div>
                </div>
                <input
                    type="hidden"
                    name="field_data[music]"
                    :value="
                        getFieldInfo(
                            'I want to have music picked by',
                            'Radio button value'
                        )
                    "
                    data-type="Radio button value"
                />
            </div>

            <div v-show="music == 2 || music == 4" class="song-list">
                <h3 class="song-list__title">Songs List:</h3>
                <p class="song-list__subtitle wide">Song Name & Artist</p>
                <p class="song-list__subtitle narrow">Type</p>
                <div
                    v-for="(song, index) in this.checklist.music_songs"
                    :key="index"
                    class="song-list__item"
                >
                    <songs-list
                        :relationName="getCurrentRelationName()"
                        :index="index"
                        :song="song"
                        :removeSong="removeSong.bind(this, index)"
                    >
                    </songs-list>
                </div>
                <button type="button" @click="addSongs" class="btn-add">
                    <svg class="icon icon-plus">
                        <use xlink:href="#icon-plus"></use>
                    </svg>
                    Add Song
                </button>
            </div>
            <div class="details-forms__comment">
                <label for="comment" class="details-forms__comment-label"
                    >Comments:</label
                >
                <textarea
                    name="music_comment"
                    v-model="checklist.music_comment"
                    id="checklist.music_comment"
                    cols="30"
                    rows="10"
                    class="form-control"
                ></textarea>
                <input
                    type="hidden"
                    name="field_data[music_comment]"
                    :value="getFieldInfo('Comments', 'Text Value')"
                    data-type="Text Value"
                />
            </div>
            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button class="btn-primary" type="submit" style="width:59px;" @click="submit">
                    Next
                </button>
            </div>
        </div>

        <div v-if="current_step == 5" class="checklist-forms">
            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button
                    class="btn-primary"
                    @click="submit"
                    type="submit"
                    style="width:59px;"
                >
                    Next
                </button>
            </div>
            <div class="checklist-form__columns">
                <div class="checklist-form__column">
                    <div class="checklist-form__column-titles">
                        <span class="checklist-form__column-title"
                            >Name / Company</span
                        >
                        <span class="checklist-form__column-title"
                            >Social media handle</span
                        >
                    </div>
                    <div
                        v-for="question in getStepQuestionRow(current_step, 1)"
                        :key="question.id"
                        class="checklist-form__column-item"
                    >
                        <label
                            class="checklist-form__column-label"
                            :for="step_names[current_step] + '_' + question.id"
                            >{{ question.title }}:</label
                        >
                        <div class="checklist-form__column-input">
                            <input
                                :name="
                                    step_names[current_step] +
                                        '[' +
                                        question.id +
                                        '][company]'
                                "
                                class="form-control-sm"
                                :id="
                                    step_names[current_step] + '_' + question.id
                                "
                                type="text"
                                v-model="
                                    checklist[step_names[current_step]][
                                        question.id
                                    ].company
                                "
                                :required="question.is_required ? true : false"
                            />
                            <input
                                type="hidden"
                                :name="
                                    'field_data' +
                                        '[' +
                                        question.id +
                                        '][company]'
                                "
                                :value="
                                    getFieldInfo(
                                        question.title + ' | Name / Company',
                                        'Text Value'
                                    )
                                "
                                data-type="Text Value"
                            />
                        </div>
                        <div class="checklist-form__column-input">
                            <input
                                :name="
                                    step_names[current_step] +
                                        '[' +
                                        question.id +
                                        '][socials]'
                                "
                                type="text"
                                class="form-control-sm"
                                v-model="
                                    checklist[step_names[current_step]][
                                        question.id
                                    ].socials
                                "
                                :required="question.is_required ? true : false"
                            />
                            <input
                                type="hidden"
                                :name="
                                    'field_data' +
                                        '[' +
                                        question.id +
                                        '][socials]'
                                "
                                :value="
                                    getFieldInfo(
                                        question.title +
                                            ' | Social media handle',
                                        'Text Value'
                                    )
                                "
                                data-type="Text Value"
                            />
                        </div>
                    </div>
                </div>
                <div class="checklist-form__column">
                    <div class="checklist-form__column-titles mobile">
                        <span class="checklist-form__column-title"
                            >Name / Company</span
                        >
                        <span class="checklist-form__column-title"
                            >Social media handle</span
                        >
                    </div>
                    <div
                        v-for="question in getStepQuestionRow(current_step, 2)"
                        :key="question.id"
                        class="checklist-form__column-item"
                    >
                        <label
                            class="checklist-form__column-label"
                            :for="step_names[current_step] + '_' + question.id"
                            >{{ question.title }}:</label
                        >
                        <div class="checklist-form__column-input">
                            <input
                                :name="
                                    step_names[current_step] +
                                        '[' +
                                        question.id +
                                        '][company]'
                                "
                                class="form-control-sm"
                                :id="
                                    step_names[current_step] + '_' + question.id
                                "
                                type="text"
                                v-model="
                                    checklist[step_names[current_step]][
                                        question.id
                                    ].company
                                "
                                :required="question.is_required ? true : false"
                            />
                            <input
                                type="hidden"
                                :name="
                                    'field_data' +
                                        '[' +
                                        question.id +
                                        '][company]'
                                "
                                :value="
                                    getFieldInfo(
                                        question.title + ' | Name / Company',
                                        'Text Value'
                                    )
                                "
                                data-type="Text Value"
                            />
                        </div>
                        <div class="checklist-form__column-input">
                            <input
                                :name="
                                    step_names[current_step] +
                                        '[' +
                                        question.id +
                                        '][socials]'
                                "
                                type="text"
                                class="form-control-sm"
                                v-model="
                                    checklist[step_names[current_step]][
                                        question.id
                                    ].socials
                                "
                                :required="question.is_required ? true : false"
                            />
                            <input
                                type="hidden"
                                :name="
                                    'field_data' +
                                        '[' +
                                        question.id +
                                        '][socials]'
                                "
                                :value="
                                    getFieldInfo(
                                        question.title +
                                            ' | Social media handle',
                                        'Text Value'
                                    )
                                "
                                data-type="Text Value"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button
                    class="btn-primary"
                    @click="submit"
                    type="submit"
                    style="width:59px;"
                >
                    Next
                </button>
            </div>
        </div>

        <div v-if="current_step == 6" class="details-forms">
            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button
                    class="btn-primary submit-btn"
                    @click="submit"
                    type="submit"
                    style="width:59px;"
                >
                    Submit
                </button>
            </div>
            <div class="details-forms__comment">
                <label for="comment" class="details-forms__comment-label"
                    >Comments:</label
                >
                <span class="d-block mb-3 b-request__ttl-note"
                    >For any inspiration photos/videos, family dynamic and or
                    family shot list w/ names, etc. that our Team should be
                    aware of, please share!</span
                >
                <textarea
                    name="comment"
                    v-model="comment"
                    id="comment"
                    cols="30"
                    rows="10"
                    class="form-control"
                ></textarea>
            </div>

            <file-uploader name="file" :value="checklist.file"></file-uploader>

            <div class="checklist-form__action mb-4" v-if="!readonly">
                <button
                    class="btn-primary"
                    @click="back"
                    type="submit"
                    style="width:59px;"
                >
                    Back
                </button>
                <button
                    class="btn-primary submit-btn"
                    @click="submit"
                    type="submit"
                    style="width:59px;"
                >
                    Submit
                </button>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props: [
        "wedding_checklist",
        "preparation",
        "ceremony",
        "relations",
        "reception",
        "portrait_session",
        "vendors",
        "urls",
        "steps",
        "song_list",
        "readonly"
    ],
    data() {
        var checklist = this.wedding_checklist;
        var step_names = [
            "preparation",
            "ceremony",
            "portrait_session",
            "reception",
            false,
            "vendors"
        ];
        for (var index in step_names) {
            if (step_names[index] == false) {
                continue;
            }
            checklist[step_names[index]] = checklist[step_names[index]]
                ? JSON.parse(checklist[step_names[index]])
                : {};

            for (var i in this[step_names[index]]) {
                if (
                    typeof checklist[step_names[index]][
                        this[step_names[index]][i].id
                    ] == "undefined"
                ) {
                    checklist[step_names[index]][
                        this[step_names[index]][i].id
                    ] = {};
                }
            }
        }
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            current_step: !this.readonly
                ? this.wedding_checklist.current_step
                : 0,
            checklist: checklist,
            is_final_step: 0,
            comment: this.wedding_checklist.comment,
            step_names: step_names,
            music: this.wedding_checklist.music
        };
    },
    mounted() {
        $.validator.addMethod(
            "one-of-answers-required",
            function(value, element) {
                var valid = false;
                $('#wedding-checklist-form input[type="checkbox"]').each(
                    function() {
                        if (this.checked) {
                            valid = true;
                        }
                    }
                );
                return valid;
            },
            "You must select at least one field"
        );
        this.form = $("#wedding-checklist-form");
        this.formValidator = this.form.validate();
        this.addSongs();
    },
    methods: {
        getFieldInfo(fieldVal, fieldType) {
            var fieldInfo = [];
            fieldInfo["val"] = fieldVal;
            fieldInfo["type"] = fieldType;

            return JSON.stringify(Object.assign({}, fieldInfo));
        },
        back() {
            $('#btn_type').val('back');
            this.form.validate();
            if(!this.form.valid()) {
                event.preventDefault();
            }
            return false;
        },
        addSongs() {
            this.checklist.music_songs.push({ song_name: "", type: "" });
        },
        removeSong(index) {
            this.checklist.music_songs.splice(index, 1);
        },
        getStepQuestionRow: function(step, rowNumber) {
            var step_name = this.step_names[step];
            var questions = this[step_name];
            if (typeof questions == "undefined") {
                questions = [];
            }
            return rowNumber == 1
                ? questions.slice(0, Math.round(questions.length / 2))
                : questions.slice(Math.round(questions.length / 2));
        },
        goToStep: function(event,step) {
            document.getElementById("go_prev_step").value = this.current_step;
            if(step >= this.current_step && !this.readonly) {
                return false;
            }else{
                $('#btn_type').val('gotostep');
                $('#go_step').val(step);
                this.form.validate();
                if(!this.form.valid()) {
                    event.preventDefault();
                }else{
                    $('#wedding-checklist-form').submit();
                }
            }
        },
        getCurrentRelationName: function() {
            return this.relations[0];
        },
        getCurrentRelation: function() {
            return this.checklist[
                this.getCurrentRelationName(this.current_step)
            ]
                ? this.checklist[this.getCurrentRelationName(this.current_step)]
                : {};
        },
        submit: function(event) {

            if (!this.form.valid()) {
                event.preventDefault();
            } else {
                var submitBtn = document.getElementsByClassName(
                    "submit-btn"
                )[0];

                if (typeof submitBtn !== "undefined") {
                    if (submitBtn.type == "submit") {
                        this.is_final_step = 1;
                        document.getElementById("is_final_step").value = this.is_final_step;
                    }
                }
            }
            return false;
        }
    }
};
</script>
