<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">OAuth Clients</h1>
      <base-button color="accent" @click="showNewForm()">Create</base-button>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-tr>
            <base-th>Client ID</base-th>
            <base-th>Name</base-th>
            <base-th>Secret</base-th>
            <base-th></base-th>
          </base-tr>
        </base-thead>
        <tbody>
          <base-tr v-for="client in clients">
            <base-td>
              {{ client.id }}
            </base-td>
            <base-td>
              {{ client.name }}
            </base-td>
            <base-td>
              <code>{{ client.secret }}</code>
            </base-td>
            <base-td>
              <base-button class="mr-2" flat color="primary" title="Edit client" @click="showClientForm(client)">
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button flat color="danger" :waiting="client._deleting" title="Delete client" @click="deleteClient(client)">
                <i class="fas fa-trash" v-if="!client._deleting"></i>
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
import ClientCreate from './client-create.vue'
import ClientEdit from './client-edit.vue'

export default {
  name: 'Clients',
  components: { ClientCreate, ClientEdit },
  computed: {
    ...mapState('passport', ['clients'])
  },
  created() {
    this.$store.dispatch('passport/fetchClients')
  },
  methods: {
    showNewForm() {
      this.$modal.show(ClientCreate, {}, { height: 'auto' })
    },
    showClientForm(client) {
      this.$modal.show(ClientEdit, { client: client }, { height: 'auto' })
    },
    async deleteClient(client) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      client._deleting = true
      this.$store.dispatch('passport/deleteClient', client).then(() => {
        client._deleting = false
      })
    }
  }
}
</script>
