<style lang="scss">
.file-input-container {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  color: rgba(0, 0, 0, 0.3);

  .image-wrapper {
    position: relative;
    cursor: pointer;
  }

  &.drag-enter {
    box-shadow: 1px 2px 6px 3px rgba(204, 204, 204, 0.5);
  }

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;

    &.photo {
      max-width: 100%;
    }
  }

  .svg-back {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #efefef;

    img {
      object-fit: cover;
    }
  }

  input[type='file'] {
    display: none;
  }

  .image-overlay,
  .image-overlay-bg {
    display: flex;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }

  .image-overlay {
    font-size: 4rem;
    color: #000;
    opacity: 0.7;
    justify-content: center;
    align-items: center;
  }

  .image-overlay-bg {
    opacity: 0.1;
    background-color: #000;
    width: 100%;
    height: 100%;
  }
}

svg {
  fill: currentColor;
  width: 50px;
}
</style>

<template>
  <div class="file-input-container">
    <input type="file" accept="image/*" ref="file" @change="onFileChange" />
    <div
      class="image-wrapper"
      :style="{ width: `${width}px`, height: `${height}px` }"
      ref="fileInputContainer"
      @click="fileInputClick"
      @dragenter="onDragEnter"
      @dragover="onDragHover"
      @dragleave="onDragLeave"
      @drop.prevent="onDrop"
      @mouseenter="showOverlay = true"
      @mouseleave="showOverlay = false"
    >
      <div class="svg-back" v-if="fileEmpty">
        <slot name="placeholder" :width="width" :height="height">
          <svg
            version="1.1"
            viewBox="0 0 100 100"
            xml:space="preserve"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
          >
            <polygon
              points="80.2,51.6 51.4,51.6 51.4,22.6 48.9,22.6 48.9,51.6 19.9,51.6 19.9,54.1 48.9,54.1 48.9,83.1   51.4,83.1 51.4,54.1 80.4,54.1 80.4,51.6 "
            ></polygon>
          </svg>
        </slot>
      </div>
      <img
        :src="imageUrl == '' ? ' ' : imageUrl"
        class="photo"
        @load="onImageLoaded"
      />
      <div class="image-overlay-bg" v-show="showOverlay"></div>
      <div class="image-overlay" v-show="showOverlay">
        <span>
          <i class="fa fa-camera"></i>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import { isEmpty } from 'lodash'
import CropModal from './image-input-crop.vue'

export default {
  name: 'ImageInput',
  components: { CropModal },
  model: {
    prop: 'file',
    event: 'input'
  },
  props: {
    file: {
      default: null
    },
    width: {
      default: null
    },
    height: {
      default: null
    },
    crop: {
      // type: Object,
      default: undefined
    },
    modal: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      fileReader: new FileReader(),
      imageUrl: '',
      showOverlay: false,
      cropObject: {}
    }
  },
  computed: {
    fileEmpty() {
      return (
        this.imageUrl === null ||
        this.imageUrl === undefined ||
        this.imageUrl === ''
      )
    }
  },
  methods: {
    onFileChange(event) {
      let file = event.target.files[0]

      if (file === undefined) return

      if (!this.validateExtension(file)) {
        this.showInvalideExtensionMessage()
        return
      }

      this.fileReader.readAsDataURL(file)
      this.emitFileChange(file)
    },
    fileInputClick() {
      this.$refs.file.click()
    },
    onDragEnter(e) {
      this.$refs.fileInputContainer.classList.add('drag-enter')
    },
    onDragHover(e) {
      e.preventDefault()
    },
    onDragLeave(e) {
      this.$refs.fileInputContainer.classList.remove('drag-enter')
    },
    onDrop(ev) {
      try {
        if (ev.dataTransfer.items) {
          if (ev.dataTransfer.items[0].kind === 'file') {
            let file = ev.dataTransfer.items[0].getAsFile()

            if (!this.validateExtension(file)) throw new Exception()

            this.fileReader.readAsDataURL(file)
            this.emitFileChange(file)
          }
        } else {
          if (!this.validateExtension(ev.dataTransfer.files[0]))
            throw new Exception()

          this.fileReader.readAsDataURL(ev.dataTransfer.files[0])
          this.emitFileChange(ev.dataTransfer.files[0])
        }
      } catch (e) {
        this.showInvalideExtensionMessage()
      }

      this.removeDragData(ev)
      this.$refs.fileInputContainer.classList.remove('drag-enter')
    },
    removeDragData(ev) {
      if (ev.dataTransfer.items) {
        ev.dataTransfer.items.clear()
      } else {
        ev.dataTransfer.clearData()
      }
    },
    validateExtension(file) {
      return /(\.jpg|\.jpeg|\.png|\.gif)$/i.exec(file.name)
    },
    showInvalideExtensionMessage() {
      this.$doModal.show({
        info: 'danger',
        title: 'Image input',
        message: 'File is not valid'
      })
    },
    emitFileChange(file) {
      this.$emit('input', file)
      this.$emit('filechange', file)
    },
    onImageLoaded(event) {
      if (this.crop === undefined) return

      if (
        this.cropObject.canvas === undefined &&
        this.cropObject.imageUrl === undefined
      ) {
        this.cropObject.imageUrl = this.imageUrl

        this.$modal.show(
          CropModal,
          {
            width: this.width,
            height: this.height,
            cropObject: this.cropObject
          },
          {
            width: '40%',
            height: 'auto',
            scrollable: true,
            clickToClose: false
          },
          {
            closed: event => {
              if (
                this.cropObject.canvas === null ||
                this.cropObject.canvas === undefined
              )
                return

              this.imageUrl = this.cropObject.canvas.toDataURL()
              this.cropObject.canvas.toBlob(blob => {
                this.emitFileChange(blob)
              })
            }
          }
        )
      }
    }
  },
  watch: {
    file: {
      handler(f) {
        if (typeof this.file === 'string') {
          this.imageUrl = this.file
          this.cropObject.imageUrl = this.file
        }

        this.fileReader.addEventListener(
          'load',
          progressEvent => {
            this.imageUrl = progressEvent.target.result
            this.cropObject = {}
          },
          false
        )
      },
      immediate: true
    }
  }
}
</script>
