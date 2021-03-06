<template>
  <div class="h-full w-full">
    <div
      class="w-full flex flex-row items-center justify-between p-3 mb-3 border-b border-white-grey"
    >
      <h4 class="inline text-gray-900 text-base font-bold">
        <span>Select wards</span>
      </h4>
      <button
        flat
        class="focus:outline-none text-grey hover:text-grey-light"
        @click="$emit('close')"
      >
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div
      class="p-4 flex flex-col h-full w-full"
      v-if="availableWards.length > 0"
    >
      <ul class="list-reset overflow-hidden overflow-y-auto flex-auto">
        <li v-for="ward in availableWards" :key="ward.id">
          <BaseCheckbox v-model="selectedWards" :value="ward.id">
            {{ ward.name_en }} ({{ ward.name_kh }})
          </BaseCheckbox>
        </li>
      </ul>
      <div
        class="flex items-center justify-end flex-grow mt-3"
        style="height: inherits;"
      >
        <BaseButton color="primary" :waiting="saving" @click="attachWards">
          Save change
        </BaseButton>
      </div>
    </div>
    <p class="p-4 text-center" v-else>There's no ward</p>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'WardsModal',
  props: ['wards', 'buildingId'],
  data() {
    return {
      selectedWards: this.wards.map(w => w.id),
      saving: false
    }
  },
  computed: {
    ...mapState('buildings', { wardList: 'wards' }),
    availableWards() {
      return this.wardList.filter(w => {
        return !this.wards.map(w => w.id).includes(w.id)
      })
    }
  },
  methods: {
    async attachWards() {
      this.saving = true
      try {
        await this.$store.dispatch('buildings/syncWards', {
          id: this.buildingId,
          wards: this.selectedWards
        })
        this.$toasted.success('Wards attached successfully')
        this.$emit(
          'attachedSync',
          this.wardList.filter(w => this.selectedWards.includes(w.id))
        )
      } catch (error) {
        this.$toasted.error(error.message)
        this.selectedWards = this.wards.map(w => w.id)
      }
      this.saving = false
    }
  }
}
</script>
