<template>
  <div>
    <div class="flex justify-between px-4 py-2">
      <h3 class="font-bold text-gray-800">Edit Section</h3>
      <base-button flat @click="$emit('close')">
        <i class="fas fa-times"></i>
      </base-button>
    </div>
    <hr class="border-b" />
    <form class="p-4">
      <div class="mb-4">
        <base-label class="mb-2">
          Section Name <span class="text-red-500">*</span>
        </base-label>
        <base-input v-model="form.name" />
        <span
          class="block text-xs italic text-red-500"
          v-if="nameErrors.length > 0"
        >
          {{ nameErrors[0] }}
        </span>
      </div>
      <div class="mb-4">
        <base-checkbox v-model="form.active">Active</base-checkbox>
      </div>
      <div class="flex items-center justify-end mt-4">
        <div>
          <base-button color="primary" :waiting="saving" @click="save">
            Save change
          </base-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'SectionEdit',
  props: ['section'],
  data() {
    return {
      form: Object.assign(
        {},
        {
          id: this.section.id,
          name: this.section.name,
          active: this.section.active
        }
      ),
      saving: false
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
    async save() {
      this.$v.$touch()
      if (this.$v.$error) throw 'Validation failed'

      this.saving = true

      try {
        let response = await this.$store.dispatch(
          'queues/updateSection',
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
