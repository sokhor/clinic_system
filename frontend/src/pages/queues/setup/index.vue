<template>
  <div class="w-full">
    <div class="flex -mx-6">
      <div class="w-4/5 px-6">
        <queue-section
          v-for="queueSection in queueSections"
          :key="queueSection.id"
          :section="queueSection"
          class="mb-8"
        />
      </div>
      <div class="w-1/5 px-6 relative">
        <div class="fixed">
          <div class="text-left">
            <base-button color="accent">Create Section</base-button>
          </div>
          <ul class="list-reset mt-6">
            <li v-for="queueSection in queueSections">
              <a href="#" class="no-underline text-grey-darker hover:text-blue leading-loose">
                {{ queueSection.name }}
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import { debounce } from 'lodash'
import QueueSection from './section'

export default {
  name: 'QueueSetup',
  components: { QueueSection },
  data() {
    return {
      queueSection: null,
      loading: true,
      search: ''
    }
  },
  computed: {
    ...mapState('queues', { queueSections: 'sections' })
  },
  created() {
    this.list()
  },
  methods: {
    registerNew() {
      this.queueSection = {}
    },
    list() {
      this.loading = true

      this.$store
        .dispatch('queues/listSections')
        .then(() => (this.loading = false))
    }
  }
}
</script>
