<template>
<div>
    <form :action="form_action" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="_token" :value="csrf" />

        <header class="intro-heading row">
            <div class="col-9">
                <h2>Cinema Edit Request</h2>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li v-for="(step, index) in steps" :class="{'steps__list-item' : true, 'is-complete' : (currentStep > index), 'is-active' : (index == currentStep) }">
                    <a @click="goToStep(index)" href="">{{ step }}</a>
                </li>
            </ol>
        </nav>

        <section v-for="(repeatedStep, index) in repeatedSteps" v-show="currentStep == index" class="b-request">
            <div class="b-request__heading mb-0 row" v-show="repeatedStep.rows > 0">
                <div class="col-3"><h3 class="b-request__ttl">Time Stamp</h3></div>
                <div class="col-9"><h3>Description of edits</h3></div>
            </div>

            <div v-for="row in repeatedStep.rows" class="row js-request-row">
                <div class="col-3">
                    <div class="form-control-wrap">
                        <input class="form-control" :name="'detail[' + repeatedStep.name + '][' + row + '][timestamp]'" type="text" placeholder="00:00:00" />
                    </div>
                </div>

                <div class="col-9">
                    <div class="form-control-wrap">
                        <input class="form-control" :name="'detail[' + repeatedStep.name + '][' + row + '][description]'" type="text" />
                    </div>
                </div>
            </div>

            <div class="b-request__footer row">
                <div class="col-3" v-show="repeatedStep.rows > 0">
                    <button @click="repeatedStep.rows++" class="btn-add js-request-clone" type="button">
                        <svg class="icon icon-plus"><use xlink:href="#icon-plus"></use></svg>
                        Add
                    </button>
                </div>

                <div class="mb-4 mb-md-0 col-md-4 d-flex align-items-center">
                    <input @change="updateRows" v-model="repeatedStep.no_edits" type="checkbox" :id="repeatedStep.name + '_no_edits'" :name="'detail[' + repeatedStep.name + '][no_edits]'" value="1" />
                    <label class="card__ttl" :for="repeatedStep.name + '_no_edits'">No reedit request required</label>
                </div>

                <div class="b-request__footer-btns col-9">
                    <button class="b-request__footer-btn btn-default" @click="redirectBack" type="button">Cancel</button>
                    <button class="b-request__footer-btn btn-primary" @click="currentStep++" type="button">Next</button>
                </div>
            </div>
        </section>

        <div v-show="currentStep == 2" class="details-forms">
            <div class="form-group">
                <label for="comment">Comments</label>
                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <file-uploader name="file"></file-uploader>

            <div class="row">
                <div class="col-12 text-right">
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
        'form_action', 'note', 'cancel_action'
    ],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            currentStep: 0,
            steps: ['Highlight Reel Edit List', 'Full Video Edit List', 'Additional Comments'],
            repeatedSteps: {
                0: {
                    name: 'highlight_reel',
                    rows: 1,
                    no_edits: false,
                },
                1: {
                    name: 'full_video',
                    rows: 1,
                    no_edits: false,
                },
            },
            
        };
    },
    methods: {
        goToStep: function(index) {
            if(index < this.currentStep) {
                this.currentStep = index;
            }
        },
        redirectBack: function() {
            window.location.href = this.cancel_action
        },
        updateRows: function() {
            if(this.repeatedSteps[this.currentStep].no_edits) {
                this.repeatedSteps[this.currentStep].rows = 0;
            } else {
                this.repeatedSteps[this.currentStep].rows = 1;
            }
        },
    },
}
</script>
