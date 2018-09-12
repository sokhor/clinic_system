<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Personal Access Tokens</h1>
      <base-button color="accent" @click="showNewForm()">Create New Token</base-button>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-tr>
            <base-th>Name</base-th>
            <base-th></base-th>
          </base-tr>
        </base-thead>
        <tbody>
          <base-tr v-for="token in personalTokens">
            <base-td>
              {{ token.name }}
            </base-td>
            <base-td>
              <base-button
                flat
                color="danger"
                :waiting="token._revoking"
                title="Revoke token"
                @click="revoke(token)"
              >
                <i class="fas fa-trash" v-if="!token._deleting"></i>
              </base-button>
            </base-td>
          </base-tr>
        </tbody>
      </base-table>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import PersonalTokenCreate from './personal-token-create.vue'

export default {
  name: 'Clients',
  components: { PersonalTokenCreate },
  computed: {
    ...mapState('passport', ['personalTokens'])
  },
  created() {
    this.$store.dispatch('passport/fetchPersonalTokens')
  },
  methods: {
    showNewForm() {
      this.$modal.show(PersonalTokenCreate, {}, { height: 'auto' })
    },
    async revoke(token) {
      if (!(await this.$confirmDelete('Are you sure to Revoke?'))) {
        return
      }

      token._deleting = true
      this.$store.dispatch('passport/revokePersonalToken', token).then(() => {
        token._deleting = false
      })
    }
  }
}
</script>
