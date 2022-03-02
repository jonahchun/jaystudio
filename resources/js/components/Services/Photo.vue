<template>
  <div class="lightbox" @click.self="closeLightbox()">
    // <a href="javascript:;" @click="closeLightbox()"><svg class="icon icon-back"><use xlink:href="#icon-back"></use></svg></a>
    <img :src="photos.image_url" />
    <a href="javascript:;" @click="handledownload(photos.image_url)"><svg class="icon icon-download"><use xlink:href="#icon-download"></use></svg></a>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: "Photo",
  props: ['photos'],
  computed: {
  },
  methods: {
    handledownload(filename) {
      let url = filename
      axios({
        method: 'get',
        url,
        responseType: 'arraybuffer',
      })
        .then((response) => {
          var spilt_data = filename.split('/')
          this.forceFileDownload(response, spilt_data[spilt_data.length - 1])
        })
        .catch(() => console.log('error occured'))
    },
    forceFileDownload(response, title) {
      const url = window.URL.createObjectURL(new Blob([response.data]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', title)
      document.body.appendChild(link)
      link.click()
    },
    closeLightbox(id) {
      this.$emit('close',false)
    }
  }
};
</script>

<style>
.lightbox {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  text-align: center;
}
.lightbox a{
    position: fixed;
    right: 171px;
    top: 8px;
    display: flex;
    color: #ffffff;
    padding: 15px 20px;
    border-radius: 10px;
    align-items: center;
    justify-content: center;
}
.lightbox img {
  margin: 100px;
}
</style>