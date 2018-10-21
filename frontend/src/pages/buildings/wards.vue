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
          <BaseTr v-for="ward in building.wards" :key="ward.id">
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
    <modal name="wards-modal">
      <form @submit.prevent="attachWards">
        <ul class="list-reset">
          <li v-for="ward in wardList" :key="ward.id">
            <BaseCheckbox
              v-model="wards"
              :value="ward"
            >
              {{ ward.name_en }}
            </BaseCheckbox>
          </li>
        </ul>
        <div class="flex items-center justify-end p-4">
          <BaseButton color="primary" :waiting="saving" type="submit">
            Save change
          </BaseButton>
        </div>
      </form>
    </modal>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import { cloneDeep } from 'lodash'

export default {
  name: 'BuildingWards',
  props: ['building'],
  data() {
    return {
      wards: cloneDeep(this.building.wards),
      saving: false,
    }
  },
  computed: {
    ...mapState('buildings', { wardList: 'wards' })
  },
  created() {
    this.fetchWards()
  },
  methods: {
    ...mapActions('buildings', [ 'fetchWards' ]),
    showModal() {
      this.$modal.show('wards-modal')
    },
    async attachWards() {
      this.saving = true
      try {
        await this.$store.dispatch('buildings/syncWards', {
          id: this.building.id,
          wards: this.wards
        })
        this.$toasted.success('Wards attached successfully')
        this.$emit('input', this.wards)
      } catch (error) {
        this.$toasted.error(error.message)
        this.wards = cloneDeep(this.building.wards)
      }
      this.saving = false
    },
    async detach(ward) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      // this.saving = true
      try {
        await this.$store.dispatch('buildings/syncWards', {
          id: this.building.id,
          wards: this.wards.filter(w => w.id != ward.id)
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
