<template>
  <div>
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/queue-sections"><i class="fas fa-arrow-left"></i></router-link> / Create Queue Counter
      </h1>
    </div>
    <BaseCard class="p-4 w-3/7 mx-auto">
      <form>
        <div class="flex items-start mb-3">
          <BaseLabel class="w-2/6">
            Name
          </BaseLabel>
          <div class="w-4/6">
            <BaseInput
              v-model="form.label"
              type="text"
              autofocus
              @input="$v.form.label.$touch()"
            />
            <span class="block text-xs italic text-red" v-if="labelErrors.length > 0">
              {{ labelErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start mb-3">
          <BaseLabel class="w-2/6">
            Section
          </BaseLabel>
          <div class="w-4/6">
            <BaseSelect
              v-model="form.section_id"
              :options="[1,2,3]"
            />
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
      label: null,
      active: false,
      busy: false,
      section_id: null
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
      label: { required }
    }
  },
  computed: {
    labelErrors() {
      const errors = []
      if (!this.$v.form.label.$dirty) return errors
      !this.$v.form.label.required && errors.push('Required')
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
          'queue/queueCounters/store',
          this.form
        )
        this.$toasted.success('Queue counter created')
        return Promise.resolve(response)
      } catch (error) {
        this.$toasted.error(error.message)
        return Promise.reject(error)
      }
    },
    async save(addNew = false) {
      this.saving = true
      await this.submit()
      this.$router.push('/queue-counters')
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
