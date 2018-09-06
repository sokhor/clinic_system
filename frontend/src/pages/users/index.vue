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
              <base-button class="mr-2" flat color="primary" @click="edit(user)"><i class="fas fa-edit"></i></base-button>
              <base-button flat color="danger"><i class="fas fa-trash"></i></base-button>
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
  name: 'Users',
  data() {
    return {
      // users: [],
      // loading: false
    }
  },
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
      this.$router.push(`/users/${user.id}/edit`)
    }
  }
}
</script>
