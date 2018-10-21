<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Building</h1>
      <base-button color="accent" @click="$router.push('/buildings/create')">Create</base-button>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th>Name KH</base-th>
          <base-th>Name EN</base-th>
          <base-th class="w-1"></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="building in buildings" :key="building.id">
            <base-td>{{ building.name_kh }}</base-td>
            <base-td>{{ building.name_en }}</base-td>
            <base-td class="flex">
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="View ward"
                @click="view(building)"
              >
                <i class="fas fa-eye"></i>
              </base-button>
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="Edit building"
                @click="edit(building)"
              >
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button
                flat
                color="danger"
                title="Delete building"
                @click="destroy(building)"
                :waiting="building._deleting"
              >
                <i class="fas fa-trash" v-show="!building._deleting"></i>
              </base-button>
            </base-td>
          </base-tr>
        </base-tbody>
      </base-table>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'Buildings',
  computed: {
    ...mapState('buildings', { buildings: 'resources' })
  },
  created() {
    this.fetchBuildings()
  },
  methods: {
    ...mapActions('buildings', { fetchBuildings: 'fetchResources' }),
    edit(building) {
      this.$router.push({
        name: 'buildings-edit',
        params: { id: building.id, building }
      })
    },
    view(building) {
      this.$router.push({
        name: 'buildings-show',
        params: { id: building.id, buildingProp: building }
      })
    },
    async destroy(building) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      building._deleting = true
      try {
        await this.$store.dispatch('buildings/destroy', building)
        this.$toasted.success('Building deleted successfully')
        this.fetchBuildings()
      } catch (error) {
        this.$toasted.error(error.message)
      }
      building._deleting = false
    }
  }
}
</script>
