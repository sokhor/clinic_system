<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between h-16 mb-3">
      <h1 class="inline text-grey-darkest text-xl font-bold">Queue Counter</h1>
      <BaseButton color="primary" @click="$router.push('/queue-counters/create')">Create</BaseButton>
    </div>
    <BaseCard>
      <div class="p-4 flex">
        <div class="w-64">
          <BaseInput
            type="text"
            v-model="search"
            placeholder="Search..."
          />
        </div>
        <div class="flex-auto"></div>
        <BaseButton outline sm>
          <i class="fas fa-filter"></i>
        </BaseButton>
      </div>
      <BaseTable>
        <BaseThead>
          <BaseTh>Name</BaseTh>
          <BaseTh>Active</BaseTh>
          <BaseTh>Busy</BaseTh>
          <BaseTh>Section</BaseTh>
          <BaseTh class="w-1"></BaseTh>
        </BaseThead>
        <BaseTbody>
          <BaseTr v-for="queueCounter in queueCounters">
            <BaseTd>{{ queueCounter.label }}</BaseTd>
            <BaseTd>{{ queueCounter.active }}</BaseTd>
            <BaseTd>{{ queueCounter.busy }}</BaseTd>
            <BaseTd>{{ queueCounter.section ? queueCounter.section.name : '' }}</BaseTd>
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
  name: 'QueueCounter',
  data() {
    return {
      loading: true,
      search: ''
    }
  },
  computed: {
    ...mapState('queue/queueCounters', { queueCounters: 'resources' })
  },
  created() {
    this.list()
  },
  methods: {
    list() {
      this.loading = true

      this.$store
        .dispatch('queue/queueCounters/list')
        .then(() => (this.loading = false))
    }
  },
  watch: {
    search: debounce(function(search) {
      this.loading = true

      this.$store
        .dispatch('queue/queueCounters/list', { search })
        .then(() => (this.loading = false))
    }, 500)
  }
}
</script>
