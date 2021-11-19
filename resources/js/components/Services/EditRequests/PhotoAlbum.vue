<template>
<div>
    <form :action="form_action" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="_token" :value="csrf" />

        <header class="intro-heading row">
            <div class="col-9">
                <h2>Album Edit Request</h2>
            </div>
        </header>

        <nav class="steps">
            <ol class="steps__list js-tabset">
                <li v-for="(step, index) in steps" :class="{'steps__list-item' : true, 'is-complete' : (currentStep > index), 'is-active' : (index == currentStep) }">
                    <a @click="goToStep(index)" href="">{{ step }}</a>
                </li>
            </ol>
        </nav>

        <section v-show="currentStep == 0" class="b-request">
            <div class="b-request__heading row">
                <div class="col-3">
                    <h3 class="b-request__ttl">Page Number on Draft Layout</h3>
                </div>

                <div class="col-9">
                    <h3>Description of Edits</h3>
                </div>
            </div>

            <div v-for="row in rowsCount" class="row js-request-row">
                <div class="col-3">
                    <div class="form-control-wrap">
                        <input class="form-control" :name="'detail[' + row + '][page]'" type="text" />
                    </div>
                </div>

                <div class="col-9">
                    <div class="form-control-wrap">
                        <input class="form-control" :name="'detail[' + row + '][description]'" type="text" />
                    </div>
                </div>
            </div>

            <div class="b-request__footer row">
                <div class="col-3">
                    <button @click="rowsCount++" class="btn-add js-request-clone" type="button">
                        <svg class="icon icon-plus"><use xlink:href="#icon-plus"></use></svg>
                        Add
                    </button>
                </div>

                <div class="b-request__footer-btns col-9">
                    <button class="b-request__footer-btn btn-default" @click="redirectBack" type="button">Cancel</button>
                    <button class="b-request__footer-btn btn-primary" @click="currentStep++" type="button">Next</button>
                </div>
            </div>
        </section>

        <div v-show="currentStep == 1" class="details-forms">
            <div class="form-group">
                <label for="comment">Comments</label>
                <span class="d-block mb-3 b-request__ttl-note">More orders? Any comments or concerns? Please share!</span>
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
            steps: ['Edit List', 'Additional Comments'],
            rowsCount: 1,
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
    },
}
</script>
