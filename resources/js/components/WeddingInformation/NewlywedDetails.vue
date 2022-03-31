<template>
    <form
        :action="urls.save"
        id="newlywed-details-form"
        method="post"
        enctype="multipart/form-data"
        autocomplete="off"
        :class="{ readonly: readonly }"
    >
        <input type="hidden" name="_token" :value="csrf" />
        <input type="hidden" name="current_step" :value="current_step" />
        <input
            type="hidden"
            name="is_final_step"
            :value="is_final_step"
            id="is_final_step"
        />
        <input type="hidden" name="button_type" id="btn_type" />
        <input type="hidden" name="go_step" id="go_step" />
        <input type="hidden" name="go_prev_step" id="go_prev_step" />
        <header class="intro-heading row">
            <div class="col-9">
                <h2>{{ content.title }}</h2>
                <p>{{ content.description }}</p>
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
                    <a @click="event => goToStep(event, index)" href="">{{
                        step
                    }}</a>
                </li>
            </ol>
        </nav>

        <div v-if="current_step < 3" class="details-forms">
            <div class="row mb-4" v-if="!readonly">
                <div class="col-12 text-right">
                    <button
                        class="btn-primary"
                        v-if="current_step != 0"
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
            <div class="details-forms__columns">
                <div class="details-forms__column">
                    <div
                        class="form-group"
                        v-for="question in getStepQuestionRow(1)"
                        :key="question.id"
                    >
                        <label
                            class="details-form__label"
                            :for="'question_' + question.id"
                            >{{
                                question.number + ". " + question.question
                            }}</label
                        >
                        <textarea
                            :name="'question_answers[' + question.id + ']'"
                            :id="'question_' + question.id"
                            v-model="question_answers[question.id]"
                            cols="30"
                            rows="10"
                            class="form-control"
                        ></textarea>
                    </div>
                </div>

                <div class="details-forms__column">
                    <div
                        class="form-group"
                        v-for="question in getStepQuestionRow(2)"
                        :key="question.id"
                    >
                        <label
                            class="details-form__label"
                            :for="'question_' + question.id"
                            >{{
                                question.number + ". " + question.question
                            }}</label
                        >
                        <textarea
                            :name="'question_answers[' + question.id + ']'"
                            :id="'question_' + question.id"
                            v-model="question_answers[question.id]"
                            cols="30"
                            rows="10"
                            class="form-control"
                        ></textarea>
                    </div>
                </div>
            </div>

            <div class="row" v-if="!readonly">
                <div class="col-12 text-right">
                    <button
                        class="btn-primary"
                        v-if="current_step != 0"
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
        </div>

        <div v-if="current_step == 3" class="details-forms">
            <div class="row mb-4" v-if="!readonly">
                <div class="col-12 text-right">
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
            <div class="details-forms__comment">
                <label class="details-forms__comment-label" for="comment"
                    >Comments:</label
                >
                <textarea
                    name="comment"
                    id="comment"
                    cols="30"
                    rows="10"
                    class="form-control"
                    v-model="comment"
                ></textarea>
            </div>

            <file-uploader
                name="file"
                :value="newlywed_detail.file"
                id="file_upload"
            ></file-uploader>

            <div class="row" v-if="!readonly">
                <div class="col-12 text-right">
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
        </div>
        <input
            type="hidden"
            name="form_fields"
            :value="form_fields"
            id="form_fields"
        />
        <input
            type="hidden"
            name="form_field_type"
            :value="form_field_type"
            id="form_field_type"
        />
    </form>
</template>

<script>
export default {
    props: [
        "newlywed_detail",
        "questions",
        "urls",
        "content",
        "steps",
        "readonly"
    ],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            current_step: !this.readonly
                ? this.newlywed_detail.current_step
                : 0,
            is_final_step: 0,
            form_fields: "",
            form_field_type: "",
            question_answers: JSON.parse(this.newlywed_detail.question_answers),
            comment: this.newlywed_detail.comment,
            file: this.newlywed_detail.file ? this.newlywed_detail.file : ""
        };
    },
    mounted() {
        this.form = $("#newlywed-details-form");
        this.formValidator = this.form.validate();
    },
    methods: {
        getFieldData() {
            var form_que = [];
            var form_field_type = [];

            if (this.questions[this.current_step]) {
                for (
                    var j = 0;
                    j < this.questions[this.current_step].length;
                    j++
                ) {
                    form_que.push(
                        this.questions[this.current_step][j].question
                    );

                    if (this.current_step != 3) {
                        var myEle = document.getElementById(
                            "question_" +
                                this.questions[this.current_step][j].id
                        );
                        if (myEle) {
                            form_field_type.push(myEle.tagName);
                        }
                    }
                }
            }
            this.form_field_type = JSON.stringify(
                Object.assign({}, form_field_type)
            );
            this.form_fields = JSON.stringify(Object.assign({}, form_que));
        },
        back() {
            this.getFieldData();
            $("#btn_type").val("back");
            this.form.validate();
            if (!this.form.valid()) {
                event.preventDefault();
            }
            return false;
        },
        getStepQuestionRow: function(rowNumber) {
            var questions = this.questions[this.current_step];
            if (typeof questions == "undefined") {
                questions = [];
            }
            return rowNumber == 1
                ? questions.slice(0, Math.round(questions.length / 2))
                : questions.slice(Math.round(questions.length / 2));
        },
        goToStep: function(event, step) {
            document.getElementById("go_prev_step").value = this.current_step;
            if (step >= this.current_step && !this.readonly) {
                return false;
            } else {
                this.getFieldData();
                $("#form_fields").val(this.form_fields);
                $("#form_field_type").val(this.form_field_type);
                $("#btn_type").val("gotostep");
                $("#go_step").val(step);
                this.form.validate();
                if (!this.form.valid()) {
                    event.preventDefault();
                } else {
                    $("#newlywed-details-form").submit();
                }
            }
        },
        submit: function(event) {
            this.getFieldData();
            if (!this.form.valid()) {
                event.preventDefault();
            } else {
                var submitBtn = document.getElementsByClassName(
                    "submit-btn"
                )[0];
                if (typeof submitBtn !== "undefined") {
                    if (submitBtn.type == "submit") {
                        this.is_final_step = 1;
                        document.getElementById(
                            "is_final_step"
                        ).value = this.is_final_step;
                    }
                }
            }
            return false;
        }
    }
};
</script>
