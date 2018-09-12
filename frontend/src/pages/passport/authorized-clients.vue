<template>
  <div class="w-full" v-if="tokens.length > 0">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Authorized Applications</h1>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-tr>
            <base-th>Name</base-th>
            <base-th>Scopes</base-th>
            <base-th></base-th>
          </base-tr>
        </base-thead>
        <tbody>
          <base-tr v-for="token in tokens">
            <base-td>
              {{ token.client.name }}
            </base-td>
            <base-td>
              {{ token.scopes.join(', ') }}
            </base-td>
            <base-td>
              <base-button color="primary" @click="revoke(token)">
                Revoke
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

export default {
  name: 'AuthorizedClients',
  computed: {
    ...mapState('passport', ['tokens'])
  },
  created() {
    this.$store.dispatch('passport/fetchTokens')
  },
  methods: {
    async revoke(token) {
      if (!(await this.$confirmDelete('Are you sure to revoke?'))) {
        return
      }

      token._revoking = true
      this.$store.dispatch('passport/revokeAuthorizedToken', token).then(() => {
        token._revoking = false
      })
    }
  }
}
</script>
