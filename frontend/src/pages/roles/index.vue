<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Roles</h1>
      <base-button color="accent" @click="$router.push('/roles/create')">Create Role</base-button>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th class="w-1">Id</base-th>
          <base-th>Name</base-th>
          <base-th class="w-1"></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="role in roles" :key="role.id">
            <base-td>{{ role.id }}</base-td>
            <base-td>{{ role.title }}</base-td>
            <base-td class="flex">
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="Edit role"
                @click="edit(role)"
              >
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button
                flat
                color="danger"
                title="Delete role"
                @click="destroy(role)"
                :waiting="role._deleting"
              >
                <i class="fas fa-trash" v-if="!role._deleting"></i>
              </base-button>
            </base-td>
          </base-tr>
        </base-tbody>
      </base-table>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'Roles',
  computed: {
    ...mapState('roles', ['roles'])
  },
  created() {
    this.fetchRoles()
  },
  methods: {
    fetchRoles() {
      this.$store.dispatch('roles/fetchRoles')
    },
    edit(role) {
      this.$router.push({
        name: 'roles-edit',
        params: { id: role.id, role: role }
      })
    },
    async destroy(role) {
      role._deleting = true
      try {
        await this.$store.dispatch('roles/deleteRole', role)
        this.fetchRoles()
      } catch (e) {}
      role._deleting = false
    }
  }
}
</script>
