<template>
  <div>
    <div>
      <img
        :src="cropObject.imageUrl == '' ? ' ' : cropObject.imageUrl"
        ref="photoElement"
        @load="onImageLoaded"
        style="max-width: 100%;"
      />
    </div>
    <div class="text-right p-3">
      <button type="button" class="btn btn-primary" @click="cropPhoto">
        <pt-waiting v-show="cropping"></pt-waiting>Crop Photo
      </button>
    </div>
  </div>
</template>

<script>
import Cropper from 'cropperjs'

export default {
  props: ['width', 'height', 'cropObject'],
  data() {
    return {
      cropper: null,
      cropping: false
    }
  },
  methods: {
    onImageLoaded() {
      if (this.cropper !== null) this.cropper.destroy()

      this.cropper = new Cropper(this.$refs.photoElement, {
        viewMode: 3,
        dragMode: 'move',
        aspectRatio: this.width / this.height,
        autoCropArea: 1,
        restore: false,
        guides: false,
        center: false,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
        minContainerWidth: this.width ? this.width : 200,
        minContainerHeight: this.height ? this.height : 100
      })
    },
    cropPhoto() {
      this.cropping = true
      this.cropObject.canvas = this.cropper.getCroppedCanvas()
      this.cropping = false
      this.$emit('close')
    }
  }
}
</script>

<style lang="scss">
@import 'cropperjs/dist/cropper.css';
</style>
