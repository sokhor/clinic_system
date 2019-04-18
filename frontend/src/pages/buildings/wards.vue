<template>
  <div class="w-full">
    <div
      class="w-full flex flex-row items-center justify-between pt-4 pb-6 mt-6"
    >
      <h1 class="inline text-gray-900 text-xl font-bold">
        Wards
      </h1>
      <BaseButton sm color="primary" @click="showModal">
        Attach Ward
      </BaseButton>
    </div>
    <BaseCard>
      <BaseTable>
        <BaseThead>
          <BaseTr>
            <BaseTh>Name KH</BaseTh>
            <BaseTh>Name EN</BaseTh>
            <BaseTh></BaseTh>
          </BaseTr>
        </BaseThead>
        <BaseTbody>
          <BaseTr v-for="ward in wards" :key="ward.id">
            <BaseTd>{{ ward.name_kh }}</BaseTd>
            <BaseTd>{{ ward.name_en }}</BaseTd>
            <BaseTd class="w-1">
              <BaseButton
                flat
                color="danger"
                title="Detach ward"
                @click="detach(ward)"
                :waiting="ward._deleting"
              >
                <i class="fas fa-trash" v-show="!ward._deleting"></i>
              </BaseButton>
            </BaseTd>
          </BaseTr>
        </BaseTbody>
      </BaseTable>
    </BaseCard>
    <modal name="wards-modal" height="auto" :scrollable="true">
      <WardsModal
        :wards="wards"
        :buildingId="building.id"
        @attachedSync="onAttachedSync"
        @close="$modal.hide('wards-modal')"
      />
    </modal>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { flatten } from 'lodash'
import WardsModal from './wards-modal.vue'

export default {
  name: 'BuildingWards',
  components: { WardsModal },
  props: ['building'],
  data() {
    return {
      wards: this.tranformData(this.building.wards)
    }
  },
  created() {
    this.fetchWards()
  },
  methods: {
    ...mapActions('buildings', ['fetchWards']),
    tranformData(wards) {
      return wards.map(w => Object.assign({}, w, { _deleting: false }))
    },
    showModal() {
      this.$modal.show('wards-modal')
    },
    onAttachedSync(wards) {
      this.$modal.hide('wards-modal')

      this.wards = this.tranformData(wards)
      this.$emit('input', wards)
    },
    async detach(ward) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      ward._deleting = true

      try {
        await this.$store.dispatch('buildings/syncWards', {
          id: this.building.id,
          wards: flatten(
            this.wards.filter(w => w.id != ward.id).map(ward => ward.id)
          )
        })
        this.$toasted.success('Wards detached successfully')
        this.wards.splice(this.wards.indexOf(ward), 1)
        this.$emit('input', this.wards)
      } catch (error) {
        this.$toasted.error(error.message)
      }

      ward._deleting = false
    }
  }
}
</script>
