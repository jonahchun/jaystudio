<template>
    <div class="lightbox" @click.self="closeLightbox()">
        //
        <a href="javascript:;" @click="closeLightbox()"
            ><svg class="icon icon-back">
                <use xlink:href="#icon-back"></use></svg
        ></a>
        <div class="lightbox_img position-relative" @click="closeLightbox()">
            <img :src="photos.image_url" />
            <a
                class="download-icon"
                href="javascript:;"
                @click="handledownload(photos.image_url)"
                ><svg class="icon icon-download">
                    <use xlink:href="#icon-download"></use></svg
            ></a>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Photo",
    props: ["photos"],
    computed: {},
    methods: {
        handledownload(filename) {
            let url = filename;
            axios({
                method: "get",
                url,
                responseType: "arraybuffer"
            })
                .then(response => {
                    var spilt_data = filename.split("/");
                    this.forceFileDownload(
                        response,
                        spilt_data[spilt_data.length - 1]
                    );
                })
                .catch(() => console.log("error occured"));
        },
        forceFileDownload(response, title) {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", title);
            document.body.appendChild(link);
            link.click();
        },
        closeLightbox(id) {
            this.$emit("close", false);
        }
    }
};
</script>

<style>
.position-relative {
    position: relative;
}
.teaser_title {
    float: left;
}
.teaser_download_all {
    float: right;
}
.lightbox_img {
    max-width: 90%;
    margin: 0 auto;
    height: 93%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox_img img {
    margin: 0 !important;
    width: 100%;
    max-width: 100%;
    height: 100%;
    object-fit: contain;
}
.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    text-align: center;
    z-index: 9;
}
.lightbox a {
    position: absolute;
    right: -20px;
    top: 0;
    display: flex;
    color: #ffffff;
    padding: 0;
    border-radius: 10px;
    align-items: center;
    justify-content: center;
}
.lightbox img {
    margin: 100px;
}
@media screen and (max-width: 767px) {
    .lightbox a {
        right: 0;
    }
}
</style>
