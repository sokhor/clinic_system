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
            <base-button color="accent" @click="addNewSection">Create Section</base-button>
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
import { mapState } from 'vuex'
import QueueSection from './section'
import SectionCreate from './section-create'

export default {
  name: 'QueueSetup',
  components: { QueueSection, SectionCreate },
  data() {
    return {
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
    list() {
      this.loading = true

      this.$store
        .dispatch('queues/listSections')
        .then(() => (this.loading = false))
    },
    addNewSection() {
      this.$modal.show(SectionCreate, {}, {
        height: 'auto',
        clickToClose: false
      })
    }
  }
}
</script>
