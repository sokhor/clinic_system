<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6 mt-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
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
            <BaseTd>
              <BaseButton
                flat
                color="danger"
                title="Detach ward"
                @click="detach(ward)"
              >
                <i class="fas fa-trash"></i>
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
      />
    </modal>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { cloneDeep, flatten } from 'lodash'
import WardsModal from './wards-modal.vue'

export default {
  name: 'BuildingWards',
  components: { WardsModal },
  props: ['building'],
  data() {
    return {
      wards: cloneDeep(this.building.wards)
    }
  },
  created() {
    this.fetchWards()
  },
  methods: {
    ...mapActions('buildings', ['fetchWards']),
    showModal() {
      this.$modal.show('wards-modal')
    },
    onAttachedSync(wards) {
      this.$modal.hide('wards-modal')

      this.wards = wards
      this.$emit('input', this.wards)
    },
    async detach(ward) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      // this.saving = true
      try {
        await this.$store.dispatch('buildings/syncWards', {
          id: this.building.id,
          wards: flatten(this.wards.filter(w => w.id != ward.id).map(ward => ward.id))
        })
        this.$toasted.success('Wards detached successfully')
        this.wards.splice(this.wards.indexOf(ward), 1)
        this.$emit('input', this.wards)
      } catch (error) {
        this.$toasted.error(error.message)
        this.wards = cloneDeep(this.building.wards)
      }
      // this.saving = false
    }
  }
}
</script>
