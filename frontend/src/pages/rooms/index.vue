<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Room</h1>
      <base-button color="accent" @click="$router.push('/rooms/create')">Create</base-button>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th>Name KH</base-th>
          <base-th>Name EN</base-th>
          <base-th>Price</base-th>
          <base-th>Status</base-th>
          <base-th>Floor</base-th>
          <base-th>Building</base-th>
          <base-th>Ward</base-th>
          <base-th class="w-1"></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="room in rooms" :key="room.id">
            <base-td>{{ room.name_kh }}</base-td>
            <base-td>{{ room.name_en }}</base-td>
            <base-td>{{ room.price }}</base-td>
            <base-td>{{ roomStatuses[room.status] }}</base-td>
            <base-td>{{ floors[room.floor] }}</base-td>
            <base-td>{{ room.building.name_en }}</base-td>
            <base-td>{{ room.ward.name_en }}</base-td>
            <base-td class="flex">
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="View"
                @click="view(room)"
              >
                <i class="fas fa-eye"></i>
              </base-button>
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="Edit"
                @click="edit(room)"
              >
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button
                flat
                color="danger"
                title="Delete"
                @click="destroy(room)"
                :waiting="room._deleting"
              >
                <i class="fas fa-trash" v-show="!room._deleting"></i>
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
  name: 'Rooms',
  computed: {
    ...mapState(['floors', 'roomStatuses']),
    ...mapState('rooms', { rooms: 'resources' })
  },
  created() {
    this.fetchRooms()
  },
  methods: {
    ...mapActions('rooms', { fetchRooms: 'list' }),
    edit(room) {
      this.$router.push({
        name: 'rooms-edit',
        params: { id: room.id, room }
      })
    },
    view(room) {
      this.$router.push({
        name: 'rooms-show',
        params: { id: room.id, roomProp: room }
      })
    },
    async destroy(room) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      room._deleting = true
      try {
        await this.$store.dispatch('rooms/destroy', room)
        this.$toasted.success('Room deleted successfully')
        this.fetchRooms()
      } catch (error) {
        this.$toasted.error(error.message)
      }
      room._deleting = false
    }
  }
}
</script>
