<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light mr-2" to="/buildings">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Building Detail
      </h1>
      <div>
        <BaseButton
          sm
          color="primary"
          title="Edit building"
          @click="edit(building)"
        >
          <i class="fas fa-edit"></i>
        </BaseButton>
        <BaseButton
          sm
          color="danger"
          title="Delete building"
          :waiting="building._deleting"
          @click="destroy(building)"
          class="ml-2"
        >
          <i class="fas fa-trash" v-show="!building._deleting"></i>
        </BaseButton>
      </div>
    </div>
    <BaseCard>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Name KH
        </BaseLabel>
        <span class="w-2/5">
          {{ building.name_kh }}
        </span>
      </div>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Name EN
        </BaseLabel>
        <span class="w-2/5">
          {{ building.name_en }}
        </span>
      </div>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Code
        </BaseLabel>
        <span class="w-2/5">
          {{ building.code }}
        </span>
      </div>
    </BaseCard>
    <BuildingWards :building="building" @input="wards => building.wards = wards" />
  </div>
</template>

<script>
import httpClient from '@/http-client'
import BuildingWards from './wards.vue'

export default {
  name: 'BuildingShow',
  components: {
    BuildingWards
  },
  async beforeRouteEnter(to, from, next) {
    if (to.params.buildingProp === undefined) {
      let response = await httpClient.get(
        `/api/buildings/${to.params.id}`,
        {},
        { showProgressBar: true }
      )
      to.params.buildingProp = Object.assign({}, response.data.data, {
        _deleting: false
      })
    }
    next()
  },
  props: {
    buildingProp: {
      type: Object
    }
  },
  data() {
    return {
      building: this.buildingProp,
      saving: false
    }
  },
  methods: {
    edit(building) {
      this.$router.push({
        name: 'buildings-edit',
        params: { id: building.id, building }
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
        this.$router.push('/buildings')
      } catch (error) {
        this.$toasted.error(error.message)
      }

      building._deleting = false
    }
  }
}
</script>
