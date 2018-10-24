<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light mr-2" to="/rooms">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Room Detail
      </h1>
      <div>
        <BaseButton
          sm
          color="primary"
          title="Edit"
          @click="edit(room)"
        >
          <i class="fas fa-edit"></i>
        </BaseButton>
        <BaseButton
          sm
          color="danger"
          title="Delete"
          :waiting="room._deleting"
          @click="destroy(room)"
          class="ml-2"
        >
          <i class="fas fa-trash" v-show="!room._deleting"></i>
        </BaseButton>
      </div>
    </div>
    <BaseCard>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Name KH
        </BaseLabel>
        <span class="w-2/5">
          {{ room.name_kh }}
        </span>
      </div>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Name EN
        </BaseLabel>
        <span class="w-2/5">
          {{ room.name_en }}
        </span>
      </div>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Code
        </BaseLabel>
        <span class="w-2/5">
          {{ room.code }}
        </span>
      </div>
    </BaseCard>
    <!-- <BuildingWards :building="building" @input="wards => building.wards = wards" /> -->
  </div>
</template>

<script>
import httpClient from '@/http-client'
// import BuildingWards from './wards.vue'

export default {
  name: 'BuildingShow',
  components: {
    // BuildingWards
  },
  props: ['roomProp'],
  data() {
    return {
      room: this.roomProp,
      saving: false
    }
  },
  methods: {
    edit(room) {
      this.$router.push({
        name: 'rooms-edit',
        params: { id: room.id, room }
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
        this.$router.push('/rooms')
      } catch (error) {
        this.$toasted.error(error.message)
      }

      room._deleting = false
    }
  }
}
</script>
