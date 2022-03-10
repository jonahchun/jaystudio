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
                        <td width="30%">{{ gallery.gallery_name }}</td>
                        <td width="30%">{{ gallery.access_code }}</td>
                        <td width="30%">{{ gallery.password }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-else>It’s not available yet!</div>

</template>

<script>
import axios from "axios";
    
export default {
    props: ['online_gallery','online_gallery_link'],
    computed:{
      GalleryLength(){
        return this.online_gallery.length;
      }
    }

}
</script>
