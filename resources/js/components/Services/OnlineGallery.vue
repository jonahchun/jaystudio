<template>
    <div v-if="GalleryLength != 0">
        <div class="table-responsive">
            <table class="info-table">
                <thead>
                <tr>
                    <td>Gallery Name</td>
                    <td>Access Code</td>
                    <td>Password</td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="gallery in this.online_gallery">
                    <td width="50%">{{ gallery.gallery_name }}</td>
                    <td width="25%">{{ gallery.access_code }}</td>
                    <td width="25%">{{ gallery.password }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-else>
        <div v-if="is_engagement">
            <p>It’s not ready yet! Our turnaround time for engagement photos is up to 4 weeks and we will send you an
                email once it’s uploaded.</p>
            <p>If you have not yet scheduled your engagement session, please email
                (<a href="support@jaylimstudio.com" style="color:blue; text-decoration: underline;">support@jaylimstudio.com</a>
                ) with up to 3 dates (Monday-Thursday) and your preferred location. Kindly note, engagement sessions are
                booked 3 months in advance.
            </p>
        </div>
        <div v-else>
            <p>It’s not available yet! It takes up to 12 weeks for wedding photos and we will send you an email when
                it’s ready! Thank you for your patience.</p>
        </div>
    </div>

</template>

<script>
import axios from "axios";

export default {
    props: ['online_gallery', 'online_gallery_link', 'is_engagement'],
    computed: {
        GalleryLength() {
            return this.online_gallery.length;
        }
    }

}
</script>
