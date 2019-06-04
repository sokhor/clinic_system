<template>
  <ul class="pagination" v-if="lastPage > 1">
    <li>
      <a
        href="#"
        class="pagination-button previous"
        :class="{ disabled: currentPage == 1 }"
        @click.prevent="previous()"
      >
        Previous
      </a>
    </li>

    <li>
      <a
        href="#"
        class="pagination-button"
        :class="{ active: 1 == currentPage }"
        @click.prevent="navigate(1)"
      >
        1
      </a>
    </li>
    <li v-if="leftRangePageStart > 2">
      <a
        href="#"
        class="pagination-button disabled"
        @click.prevent="
          {
          }
        "
      >
        …
      </a>
    </li>
    <li v-for="page in middleRangePages" :key="page">
      <a
        href="#"
        class="pagination-button"
        :class="{ active: page == currentPage }"
        @click.prevent="navigate(page)"
      >
        {{ page }}
      </a>
    </li>
    <li
      class="pagination-button disabled"
      v-if="RightRangePageEnd < lastPage - 1"
    >
      <a
        href="#"
        @click.prevent="
          {
          }
        "
        >…</a
      >
    </li>
    <li>
      <a
        href="#"
        class="pagination-button"
        :class="{ active: lastPage == currentPage }"
        @click.prevent="navigate(lastPage)"
      >
        {{ lastPage }}
      </a>
    </li>

    <li>
      <a
        href="#"
        class="pagination-button next"
        :class="{ disabled: currentPage == lastPage }"
        @click.prevent="next()"
      >
        Next
      </a>
    </li>
  </ul>
</template>

<script>
import { range } from 'lodash'

export default {
  name: 'NavPaging',
  props: {
    lastPage: {
      required: true
    },
    currentPage: {
      required: true
    },
    maxNumberButton: {
      type: Number,
      default: 5
    }
  },
  computed: {
    leftRangePageStart() {
      if (
        this.currentPage < this.maxNumberButton ||
        this.lastPage <= this.maxNumberButton
      ) {
        return 2
      } else if (this.currentPage + this.maxNumberButton > this.lastPage + 1) {
        return this.lastPage - this.maxNumberButton + 1
      }

      return this.currentPage - Math.floor(this.maxNumberButton / 2)
    },
    RightRangePageEnd() {
      if (
        this.currentPage + this.maxNumberButton > this.lastPage + 1 ||
        this.lastPage <= this.maxNumberButton
      ) {
        return this.lastPage - 1
      } else if (this.currentPage < this.maxNumberButton) {
        return this.maxNumberButton
      }

      return this.currentPage + Math.floor(this.maxNumberButton / 2)
    },
    middleRangePages() {
      return range(this.leftRangePageStart, this.RightRangePageEnd + 1)
    }
  },
  methods: {
    navigate(page) {
      if (page == this.currentPage) return

      this.$emit('navigate', page)
    },
    previous() {
      if (this.currentPage - 1 < 1) return

      this.$emit('navigate', this.currentPage - 1)
    },
    next() {
      if (this.currentPage + 1 > this.lastPage) return

      this.$emit('navigate', this.currentPage + 1)
    }
  }
}
</script>
