<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between h-16 mb-3">
      <h1 class="inline text-grey-darkest text-xl font-bold">Queue</h1>
      <BaseButton color="primary" @click="$router.push('/queue-sections/create')">Create</BaseButton>
    </div>
    <BaseCard>
      <div class="p-4 flex">
        <input
          type="text"
          class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-64"
          v-model="search"
          placeholder="Search..."
        />
        <div class="flex-auto"></div>
        <BaseButton outline sm>
          <i class="fas fa-filter"></i>
        </BaseButton>
      </div>
      <BaseTable>
        <BaseThead>
          <BaseTh>Name</BaseTh>
          <BaseTh>Active</BaseTh>
          <BaseTh class="w-1"></BaseTh>
        </BaseThead>
        <BaseTbody>
          <BaseTr v-for="queueSection in queueSections">
            <BaseTd>{{ queueSection.name }}</BaseTd>
            <BaseTd>{{ queueSection.active }}</BaseTd>
            <BaseTd class="w-1">
              <div class="flex">
                <BaseButton
                  flat
                  color="primary"
                  title="Edit"
                  class="ml-4"
                >
                  <i class="fas fa-edit"></i>
                </BaseButton>
              </div>
            </BaseTd>
          </BaseTr>
        </BaseTbody>
      </BaseTable>
    </BaseCard>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import { debounce } from 'lodash'

export default {
  name: 'QueueSection',
  data() {
    return {
      queueSection: null,
      loading: true,
      search: ''
    }
  },
  computed: {
    ...mapState('queue/queueSections', { queueSections: 'resources' })
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
        .dispatch('queue/queueSections/list')
        .then(() => (this.loading = false))
    }
  },
  watch: {
    search: debounce(function(search) {
      this.loading = true

      this.$store
        .dispatch('queue/queueSections/list', { search })
        .then(() => (this.loading = false))
    }, 500)
  }
}
</script>
