<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Users</h1>
      <base-button color="accent" @click="$router.push('/users/create')">Create</base-button>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th>Id</base-th>
          <base-th>Username</base-th>
          <base-th>Email</base-th>
          <base-th>Active</base-th>
          <base-th>Created At</base-th>
          <base-th class="w-1"></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="user in users" :key="user.id">
            <base-td>{{ user.id }}</base-td>
            <base-td>{{ user.username }}</base-td>
            <base-td>{{ user.email }}</base-td>
            <base-td>{{ user.active }}</base-td>
            <base-td>{{ user.created_at }}</base-td>
            <base-td class="flex">
              <base-button class="mr-2" flat color="primary" title="Edit user" @click="edit(user)">
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button class="mr-2" flat color="primary" title="Reset password" @click="resetPassword(user)">
                <i class="fas fa-key"></i>
              </base-button>
              <base-button flat color="danger" title="Delete user" @click="deleteUser(user)">
                <waiting v-if="user._deleting"></waiting>
                <i class="fas fa-trash" v-else></i>
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
import Waiting from '@/components/waiting.vue'

export default {
  name: 'Users',
  components: { Waiting },
  computed: {
    ...mapState('users', ['users'])
  },
  created() {
    this.fetchUsers()
  },
  methods: {
    fetchUsers() {
      this.$store.dispatch('users/fetchUsers')
    },
    edit(user) {
      this.$router.push({
        name: 'users-edit',
        params: { id: user.id, user: user }
      })
    },
    resetPassword(user) {
      this.$router.push({
        name: 'users-reset-password',
        params: { id: user.id, user: user }
      })
    },
    async deleteUser(user) {
      console.log('del')
      user._deleting = true
      try {
        await this.$store.dispatch('users/deleteUser', user)
        this.fetchUsers()
      } catch (e) {}
      user._deleting = false
    }
  }
}
</script>
