<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-gray-900 text-xl font-bold">Wards</h1>
      <base-button color="accent" @click="$router.push('/wards/create')"
        >Create</base-button
      >
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th>Name KH</base-th>
          <base-th>Name EN</base-th>
          <base-th class="w-1"></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="ward in wards" :key="ward.id">
            <base-td>{{ ward.name_kh }}</base-td>
            <base-td>{{ ward.name_en }}</base-td>
            <base-td class="flex">
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="Edit ward"
                @click="edit(ward)"
              >
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button
                flat
                color="danger"
                title="Delete ward"
                @click="destroy(ward)"
                :waiting="ward._deleting"
              >
                <i class="fas fa-trash" v-show="!ward._deleting"></i>
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
  name: 'Wards',
  computed: {
    ...mapState('wards', { wards: 'resources' })
  },
  created() {
    this.fetchWards()
  },
  methods: {
    ...mapActions('wards', { fetchWards: 'fetchResources' }),
    edit(ward) {
      this.$router.push({
        name: 'wards-edit',
        params: { id: ward.id, ward: ward }
      })
    },
    async destroy(ward) {
      ward._deleting = true
      try {
        await this.$store.dispatch('wards/destroy', ward)
        this.fetchWards()
        this.$toasted.success('Ward deleted successfully')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      ward._deleting = false
    }
  }
}
</script>
