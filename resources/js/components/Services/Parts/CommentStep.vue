<template>
<div class="details-forms">
    <div class="details-forms__comment">
        <label for="comment" class="details-forms__comment-label">Comments:</label>
        <p class="details-forms__comment-description">More orders? Any comments or concerns? Please share!</p>
        <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <file-uploader name="file"></file-uploader>
</div>
</template>
<script>
export default {

}
</script>