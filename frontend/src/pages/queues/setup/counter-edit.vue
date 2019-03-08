<template>
  <div>
    <div class="flex justify-between px-4 py-2">
      <h3>Edit Counter</h3>
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
        <base-button color="primary" :waiting="saving" @click="save">
          Save change
        </base-button>
      </div>
    </form>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'CounterEdit',
  props: ['counter'],
  data() {
    return {
      form: Object.assign({}, this.counter),
      saving: false
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

      this.saving = true

      try {
        let response = await this.$store.dispatch(
          'queues/updateCounter',
          this.form
        )
        this.$toasted.success(response.message)
        this.$emit('close')
      } catch (error) {
        this.$toasted.error(error)
      }

      this.saving = false
    }
  }
}
</script>
