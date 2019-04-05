<template>
  <div>
    <div class="flex justify-between px-4 py-2">
      <h3>New Counter</h3>
      <base-button flat @click="$emit('close')">
        <i class="fas fa-times"></i>
      </base-button>
    </div>
    <hr class="border-b" />
    <form class="p-4">
      <div class="mb-4">
        <base-label class="mb-2">
          Counter Label <span class="text-red">*</span>
        </base-label>
        <base-input v-model="form.label" />
        <span class="block text-xs italic text-red" v-if="labelErrors.length > 0">
          {{ labelErrors[0] }}
        </span>
      </div>
      <div class="mb-4">
        <base-checkbox v-model="form.active">Active</base-checkbox>
      </div>
      <div class="flex items-center justify-end mt-4">
        <div>
          <base-button outline class="mr-5" color="primary" :waiting="savingAndNew" @click="saveAndNew">
            Create & New
          </base-button>
          <base-button color="primary" :waiting="saving" @click="saveAndClose">
            Create
          </base-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'CounterNew',
  props: ['section'],
  data() {
    const form = {
      label: null,
      active: true,
      section_id: this.section.id
    }

    return {
      newForm: form,
      form: Object.assign({}, form),
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
    async save() {
      this.$v.$touch()
      if (this.$v.$error) throw 'Validation failed'

      try {
        let response = await this.$store.dispatch(
          'queues/createCounter',
          this.form
        )
        this.$toasted.success(response.message)
        return response
      } catch (error) {
        this.$toasted.error(error)
        return Promise.reject(error)
      }
    },
    async saveAndClose() {
      this.saving = true

      try {
        await this.save()
        this.$emit('close')
      } catch (error) {}

      this.saving = false
    },
    async saveAndNew() {
      this.savingAndNew = true

      try {
        await this.save()
        this.form = Object.assign({}, this.newForm)
        this.$v.$reset()
      } catch (error) {}

      this.savingAndNew = false
    }
  }
}
</script>
