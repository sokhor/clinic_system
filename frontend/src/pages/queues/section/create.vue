<template>
  <div>
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/queue-sections"><i class="fas fa-arrow-left"></i></router-link> / Create Product
      </h1>
    </div>
    <BaseCard class="p-4 w-3/7 mx-auto">
      <form>
        <div class="flex items-start mb-3">
          <BaseLabel class="w-2/6">
            Full name
          </BaseLabel>
          <div class="w-4/6">
            <BaseInput
              v-model="form.name"
              type="text"
              autofocus
              @input="$v.form.name.$touch()"
            />
            <span class="block text-xs italic text-red" v-if="nameErrors.length > 0">
              {{ nameErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-center mt-4 justify-end">
          <div>
            <base-button class="mr-2" color="primary" :waiting="savingAndNew" @click="saveAndNew">
              Create &amp; New
            </base-button>
            <base-button color="primary" :waiting="saving" @click="save">
              Create
            </base-button>
          </div>
        </div>
      </form>
    </BaseCard>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'QueueSection',
  data() {
    const newForm = {
      name: null,
      active: true
    }

    return {
      newForm,
      form: Object.assign({}, newForm),
      saving: false,
      savingAndNew: false
    }
  },
  validations: {
    form: {
      name: { required }
    }
  },
  computed: {
    nameErrors() {
      const errors = []
      if (!this.$v.form.name.$dirty) return errors
      !this.$v.form.name.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    async submit() {
      this.$v.$touch()
      if (this.$v.$error) {
        this.saving = false
        this.savingAndNew = false
        throw 'Validation failed'
      }

      try {
        const response = await this.$store.dispatch(
          'queue/queueSections/store',
          this.form
        )
        this.$toasted.success('Queue section created')
        return Promise.resolve(response)
      } catch (error) {
        this.$toasted.error(error.message)
        return Promise.reject(error)
      }
    },
    async save(addNew = false) {
      this.saving = true
      await this.submit()
      this.$router.push('/queue-sections')
      this.saving = false
    },
    async saveAndNew() {
      this.savingAndNew = true
      await this.submit()
      this.clearInput()
      this.savingAndNew = false
    },
    clearInput() {
      this.form = Object.assign({}, this.newForm)
      this.$v.form.$reset()
    }
  }
}
</script>
