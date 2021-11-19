<template>
    <div v-if="this.paginator.total > this.paginator.per_page" class="paging">
        <div class="paging__status">{{ this.entityTitle }}: {{  getCurrentState() }} from {{ this.paginator.total }}</div>

        <ul class="paging__list">
            <li v-for="pageNumber in pages()" :class="[ isActive(pageNumber) ? 'is-active' : '' ]">
                <a :href="getPagerLinkUrl(pageNumber)" @click="isActive(pageNumber) ? 'javascrip:void(0);' : loadPage(pageNumber, $event)">
                    {{ pageNumber }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        entityTitle: String,
        paginator: Object,
        load: Function,
    },
    methods: {
        getCurrentState: function() {
            var currentState = this.paginator.per_page;
            if(this.paginator.current_page != 1) {
                currentState = (this.paginator.per_page * (this.paginator.current_page - 1) + 1) + ' - ';
                if(this.paginator.per_page * this.paginator.current_page > this.paginator.total) {
                    currentState += this.paginator.total;
                } else {
                    currentState += this.paginator.per_page * this.paginator.current_page;
                }
            }
            return currentState;
        },
        isActive: function(pageNumber) {
            return this.paginator.current_page == pageNumber;
        },
        pages: function() {
            var pages = [];
            for (var i = 1; i <= this.paginator.last_page; i++) {
                pages.push(i);
            }
            return pages;
        },
        getPagerLinkUrl: function(pageNumber) {
            return window.location.origin + window.location.pathname + '?page=' + pageNumber;
        },
        loadPage: function(pageNumber, event) {
            event.preventDefault();
            var url = this.getPagerLinkUrl(pageNumber);
            this.$emit('load', url);
            window.history.pushState('', '', url);
        }
    }
}
</script>