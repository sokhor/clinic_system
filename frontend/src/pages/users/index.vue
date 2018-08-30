<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Users</h1>
    </div>
    <div class="w-full bg-white shadow">
      <base-table>
        <base-thead>
          <base-th>Id</base-th>
          <base-th>Username</base-th>
          <base-th>Email</base-th>
          <base-th>Active</base-th>
          <base-th>Created At</base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="user in users" :key="user.id">
            <base-td>{{ user.id }}</base-td>
            <base-td>{{ user.username }}</base-td>
            <base-td>{{ user.email }}</base-td>
            <base-td>{{ user.active }}</base-td>
            <base-td>{{ user.created_at }}</base-td>
          </base-tr>
        </base-tbody>
      </base-table>
    </div>
  </div>
</template>

<script>
import client from '@/http-client'

export default {
  name: 'User',
  data() {
    return {
      users: []
    }
  },
  created() {
    this.fetchUser()
  },
  methods: {
    fetchUser() {
      client.get('/api/users').then(response => {
        this.users = response.data.data
      })
    }
  }
}
</script>
