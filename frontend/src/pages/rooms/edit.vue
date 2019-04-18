<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-gray-900 text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light mr-2" to="/rooms">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Edit Room
      </h1>
    </div>
    <BaseCard>
      <form @submit.prevent="save">
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Name KH
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.name_kh"
              type="text"
              @input="$v.form.name_kh.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="nameKhErrors.length > 0"
            >
              {{ nameKhErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Name EN
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.name_en"
              type="text"
              @input="$v.form.name_en.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="nameEnErrors.length > 0"
            >
              {{ nameEnErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Code
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.code"
              type="text"
            />
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Price
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.price"
              type="text"
            />
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Building
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.building_id"
              @input="$v.form.building_id.$touch()"
            >
              <option value="">--Choose--</option>
              <option
                v-for="building in buildings"
                :key="building.id"
                :value="building.id"
              >
                {{ building.name_en }}
              </option>
            </select>
            <span
              class="block text-xs italic text-red"
              v-if="buildingIdErrors.length > 0"
            >
              {{ buildingIdErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Floor
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.floor"
              type="text"
            >
              <option value="">--Choose--</option>
              <option v-for="(floor, key) in floors" :value="key">{{
                floor
              }}</option>
            </select>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Ward
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.ward_id"
            >
              <option value="">--Choose--</option>
              <option v-for="ward in wards" :key="ward.id" :value="ward.id">
                {{ ward.name_en }}
              </option>
            </select>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Status
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.status"
              type="text"
              @input="$v.form.status.$touch()"
            >
              <option value="">--Choose--</option>
              <option v-for="(status, key) in roomStatuses" :value="key">{{
                status
              }}</option>
            </select>
            <span
              class="block text-xs italic text-red"
              v-if="statusErrors.length > 0"
            >
              {{ statusErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button color="primary" :waiting="saving" type="submit">
            Update
          </base-button>
        </div>
      </form>
    </BaseCard>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'RoomEdit',
  props: ['room'],
  data() {
    return {
      form: {
        id: this.room.id,
        name_kh: this.room.name_kh,
        name_en: this.room.name_en,
        code: this.room.code,
        building_id: this.room.building_id,
        ward_id: this.room.ward_id,
        price: this.room.price,
        floor: this.room.floor,
        status: this.room.status
      },
      saving: false
    }
  },
  validations: {
    form: {
      name_kh: { required },
      name_en: { required },
      building_id: { required },
      status: { required }
    }
  },
  computed: {
    ...mapState(['floors', 'roomStatuses']),
    ...mapState('rooms', ['wards', 'buildings']),
    nameKhErrors() {
      const errors = []
      if (!this.$v.form.name_kh.$dirty) return errors
      !this.$v.form.name_kh.required && errors.push('Required')
      return errors
    },
    nameEnErrors() {
      const errors = []
      if (!this.$v.form.name_en.$dirty) return errors
      !this.$v.form.name_en.required && errors.push('Required')
      return errors
    },
    buildingIdErrors() {
      const errors = []
      if (!this.$v.form.building_id.$dirty) return errors
      !this.$v.form.building_id.required && errors.push('Required')
      return errors
    },
    statusErrors() {
      const errors = []
      if (!this.$v.form.status.$dirty) return errors
      !this.$v.form.status.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    async save() {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.saving = true
      try {
        await this.$store.dispatch('rooms/update', this.form)
        this.$toasted.success('Room updated successfully')
        this.$router.push('/rooms')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.saving = false
    }
  }
}
</script>
