<template>
    <form :action="urls.save" id="newlywed-details-form" method="post" enctype="multipart/form-data" autocomplete="off" :class="{'readonly': readonly}">
        <input type="hidden" name="_token" :value="csrf" />
        <input type="hidden" name="current_step" :value="current_step" />
        <header class="intro-heading row">
            <div class="col-9">
                <h2>{{ content.title }}</h2>
                <p>{{ content.description }}</p>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li v-for="(step, index) in steps" :key="index" :class="{'steps__list-item' : true, 'is-complete' : (current_step > index && !readonly), 'is-active' : (index == current_step) }">
                    <a @click="goToStep(index)" href="">{{ step }}</a>
                </li>
            </ol>
        </nav>

        <div v-if="current_step < 3" class="details-forms">
            <div class="details-forms__columns">
                <div class="details-forms__column">
                    <div class="form-group" v-for="question in getStepQuestionRow(1)" :key="question.id">
                        <label class="details-form__label" :for="'question_' + question.id">{{ question.number + '. ' + question.question }}</label>
                        <textarea :name="'question_answers[' + question.id + ']'" :id="'question_' + question.id" v-model="question_answers[question.id]" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>

                <div class="details-forms__column">
                    <div class="form-group" v-for="question in getStepQuestionRow(2)" :key="question.id">
                        <label class="details-form__label" :for="'question_' + question.id">{{ question.number + '. ' + question.question }}</label>
                        <textarea :name="'question_answers[' + question.id + ']'" :id="'question_' + question.id" v-model="question_answers[question.id]" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="row" v-if="!readonly">
                <div class="col-12 text-right">
                    <button class="btn-primary" v-if="current_step != 0" @click="back" type="button">Back</button>
                    <button class="btn-primary" @click="submit" type="submit">Next</button>
                </div>
            </div>
        </div>

        <div v-if="current_step == 3" class="details-forms">
            <div class="details-forms__comment">
                <label class="details-forms__comment-label" for="comment">Comments:</label>
                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" v-model="comment"></textarea>
            </div>

            <file-uploader name="file" :value="newlywed_detail.file"></file-uploader>

            <div class="row" v-if="!readonly">
                <div class="col-12 text-right">
                    <button class="btn-primary" @click="back" type="button">Back</button>
                    <button class="btn-primary" @click="submit" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
   
export default {
    props: [
        'newlywed_detail',
        'questions',
        'urls',
        'content',
        'steps',
        'readonly'
    ],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            current_step: !this.readonly ? this.newlywed_detail.current_step : 0,
            question_answers: JSON.parse(this.newlywed_detail.question_answers),
            comment: this.newlywed_detail.comment,
            file: this.newlywed_detail.file ? this.newlywed_detail.file : '',
        };
    },
    mounted() {
        this.form = $('#newlywed-details-form');
        this.formValidator = this.form.validate();
    },
    methods: {
        back() {
            this.current_step--;
            this.current_step = Math.max(this.current_step, 0);
        },
        getStepQuestionRow: function(rowNumber) {
            var questions = this.questions[this.current_step];
            if(typeof questions == 'undefined') {
                questions = [];
            }
            return rowNumber == 1 ? questions.slice(0, Math.round(questions.length / 2)) : questions.slice(Math.round(questions.length / 2));
        },
        goToStep: function(step) {
            if(step >= this.current_step && !this.readonly) {
                return false;
            }
            this.current_step = step;
        },
        submit: function(event) {
            if(!this.form.valid()) {
                event.preventDefault();
            }
            return false;
        }
    },
}
</script>
