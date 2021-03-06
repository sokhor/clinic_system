<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-gray-900 text-xl font-bold">
        <router-link
          class="text-blue hover:text-blue-light mr-2"
          to="/buildings"
        >
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Edit Building
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
import { required } from 'vuelidate/lib/validators'
import httpClient from '@/http-client'

export default {
  name: 'BuildingEdit',
  async beforeRouteEnter(to, from, next) {
    if (to.params.building === undefined) {
      let response = await httpClient.get(
        `/api/buildings/${to.params.id}`,
        {},
        { showProgressBar: true }
      )
      to.params.building = response.data.data
    }
    next()
  },
  props: {
    building: {
      type: Object
    }
  },
  data() {
    return {
      form: {
        id: this.building.id,
        name_kh: this.building.name_kh,
        name_en: this.building.name_en,
        code: this.building.code
      },
      saving: false
    }
  },
  validations: {
    form: {
      name_kh: { required },
      name_en: { required }
    }
  },
  computed: {
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
        await this.$store.dispatch('buildings/update', this.form)
        this.$toasted.success('Building updated successfully')
        this.$router.push('/buildings')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.saving = false
    }
  }
}
</script>
