<template>
  <div class="w-full">
    <!-- <BaseCard>
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
    </BaseCard> -->

    <div class="flex -mx-6">
      <div class="w-4/5 px-6">
        <section v-for="s in 4" class="mb-8">
          <div class="flex justify-between">
            <h3>Section {{s}}</h3>
            <div>
              <base-button flat color="primary" class="mr-3" v-tooltip="'Edit section'"><i class="fas fa-pencil-alt"></i></base-button>
              <base-button flat color="danger" v-tooltip="'Delete section'"><i class="fas fa-trash"></i></base-button>
            </div>
          </div>
          <hr class="border-b border-grey" />
          <div class="flex flex-wrap -mx-2">
            <div v-for="n in 13" class="p-2">
              <base-card class="w-32 h-32 flex justify-center items-center">Counter #{{n}}</base-card>
            </div>
            <div class="p-2">
              <base-button flat class="w-32 h-32 flex justify-center items-center border border-dashed border-grey text-2xl">
                <i class="fas fa-plus"></i>
              </base-button>
            </div>
          </div>
        </section>
      </div>
      <div class="w-1/5 px-6 relative">
        <div class="fixed">
          <div class="text-left">
            <base-button color="accent">Create Section</base-button>
          </div>
          <ul class="list-reset mt-6">
            <li>
              <a href="#" class="no-underline text-grey-darker hover:text-blue leading-loose">Section 1</a>
            </li>
            <li>
              <a href="#" class="no-underline text-grey-darker hover:text-blue leading-loose">Section 2</a>
            </li>
            <li>
              <a href="#" class="no-underline text-grey-darker hover:text-blue leading-loose">Section 3</a>
            </li>
            <li>
              <a href="#" class="no-underline text-grey-darker hover:text-blue leading-loose">Section 4</a>
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
