<template>
  <div>
    <div v-if="!photos.length">It’s not available yet! It takes 2-3 weeks for teaser photos and we ask that you check back.</div>
    <div class="gallery">
      <div class="gallery-panel"
           v-for="photo in photos"
           :key="photo.id">
           <img :src="photo.image_url" @click="preview(photo)">
      </div>
      <photo :photos="img" @close="close" v-if="show_preview"></photo>
    </div>
  </div>
</template>

<script>
import photo from './Photo.vue';
export default {
    name: 'TeaserPhoto',
    components: {
        photo
    },
    props: ['photos'],
    data(){
        return {show_preview:false,img:{}}
    },
  methods: {
    preview(value){
        this.show_preview = true;
        this.img = value;
    },
    close(val){
        this.show_preview = val;
    }
  },
};
</script>

<style>
  .gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
    grid-gap: 1rem;
    max-width: 80rem;
    margin: 1rem auto;
    padding: 0 3rem;
  }

  .gallery-panel img {
    width: 100%;
    height: 22vw;
    object-fit: fill;
  }
</style>
