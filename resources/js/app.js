try {
    window.$ = window.jQuery = require('jquery');
    require('jquery-validation');
    window.moment = require('moment');
    require('tempusdominus-bootstrap-4');

    window.Swiper = require('swiper/dist/js/swiper');
    require('./bootstrap');
    require('./vendor/jquery.popup');
    require('./vendor/jquery.tabs');
    require('./vendor/jquery.open-close');
    require('./vendor/jquery.open-close');
    require('./vendor/jquery.validate.min');
    require('./vendor/inputs');
    require('./main');
} catch (e) {
    console.log(e);
}

window.Vue = require('vue');

Vue.component('pagination', require('./components/Widget/Pagination.vue').default);
Vue.component('image-with-zoom', require('./components/Widget/ImageWithZoom.vue').default);
Vue.component('image-modal', require('./components/Widget/ImageModal.vue').default);
$('<image-modal />').appendTo('#app');

Vue.component('file-uploader', require('./components/Widget/FileUploader.vue').default);

Vue.component('customer-contacts', require('./components/Customer/Contacts.vue').default);
Vue.component('customer-contact-list', require('./components/Customer/ContactList.vue').default);
Vue.component('customer-contact-form', require('./components/Customer/ContactForm.vue').default);

Vue.component('songs-list', require('./components/WeddingInformation/SongsList.vue').default);
Vue.component('newlywed-details-form', require('./components/WeddingInformation/NewlywedDetails.vue').default);
Vue.component('repeater-address', require('./components/WeddingInformation/RepeatAddress.vue').default);
Vue.component('wedding-checklist-form', require('./components/WeddingInformation/Checklist.vue').default);
Vue.component('wedding-schedule-form', require('./components/WeddingInformation/Schedule.vue').default);
Vue.component('wedding-schedule-form-address', require('./components/WeddingInformation/Schedule/Address.vue').default);
Vue.component('wedding-schedule-form-hair-makeup-address', require('./components/WeddingInformation/Schedule/HairMakeupAddress.vue').default);
Vue.component('wedding-schedule-form-start-end-time', require('./components/WeddingInformation/Schedule/StartEndTime.vue').default);
Vue.component('wedding-schedule-form-start-time', require('./components/WeddingInformation/Schedule/StartTime.vue').default);
Vue.component('wedding-schedule-form-end-time', require('./components/WeddingInformation/Schedule/EndTime.vue').default);
Vue.component('wedding-schedule-form-time', require('./components/WeddingInformation/Schedule/Time.vue').default);
Vue.component('wedding-schedule-availabilities', require('./components/WeddingInformation/Schedule/Availabilities.vue').default);
Vue.component('wedding-cinematography', require('./components/WeddingInformation/Cinematography.vue').default);

Vue.component('save-the-date-form', require('./components/Services/SaveTheDate.vue').default);
Vue.component('photo-album-form', require('./components/Services/PhotoAlbum.vue').default);
Vue.component('thank-you-card-form', require('./components/Services/ThankYouCard.vue').default);
Vue.component('order-form-images-step', require('./components/Services/Parts/ImagesStep.vue').default);
Vue.component('order-form-templates-step', require('./components/Services/Parts/TemplatesStep.vue').default);
Vue.component('order-form-comment-step', require('./components/Services/Parts/CommentStep.vue').default);
Vue.component('order-form-luxe-type-images', require('./components/Services/Parts/LuxeImages.vue').default);
Vue.component('order-form-photo-album-sizes', require('./components/Services/Parts/PhotoAlbumSizes.vue').default);
Vue.component('teaser-photo', require('./components/Services/TeaserPhoto.vue').default);
Vue.component('photo', require('./components/Services/Photo.vue').default);
Vue.component('photo', require('./components/Services/Photo.vue').default);
Vue.component('online-gallery', require('./components/Services/OnlineGallery.vue').default);

Vue.component('order-form-image-edit', require('./components/Services/Parts/ImageEdit.vue').default);
Vue.component('order-form-comment-edit', require('./components/Services/Parts/CommentEdit.vue').default);

Vue.component('engagement_session-edit-request', require('./components/Services/EditRequests/Engagement_session.vue').default);
Vue.component('photography-edit-request', require('./components/Services/EditRequests/Photography.vue').default);
Vue.component('videography-edit-request', require('./components/Services/EditRequests/Videography.vue').default);
Vue.component('card-edit-request', require('./components/Services/EditRequests/Card.vue').default);
Vue.component('photo-album-edit-request', require('./components/Services/EditRequests/PhotoAlbum.vue').default);

Vue.component('payment-invoices', require('./components/Invoices/List.vue').default);

new Vue({el:'#app'});
