<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between pb-6">
      <base-title>Users</base-title>
      <base-button color="primary" @click="$router.push('/users/create')">
        New User
      </base-button>
    </div>
    <base-card>
      <base-card-wrap>
        <base-input v-model="search" placeholder="Search ..." class="w-64" />
      </base-card-wrap>
      <base-table :columns="columns" :records="users">
        <template slot-scope="{ record: user }">
          <td>{{ user.username }}</td>
          <td>{{ user.email }}</td>
          <td>
            <div
              class="w-3 h-3 bg-green-500 rounded-full border-2 border-green-300"
              v-if="user.active"
            ></div>
            <div
              class="w-3 h-3 bg-red-500 rounded-full border-2 border-red-300"
              v-else
            ></div>
          </td>
          <td class="flex">
            <a
              href="#"
              class="text-blue-500 hover:text-blue-600 mr-3"
              title="Edit user"
              @click.prevent="edit(user)"
            >
              <i class="fas fa-edit"></i>
            </a>
            <a
              href="#"
              class="text-red-500 hover:text-red-600"
              title="Delete user"
              @click.prevent="destroy(user)"
              :waiting="user._deleting"
            >
              <i class="fas fa-trash" v-if="!user._deleting"></i>
            </a>
          </td>
        </template>
      </base-table>
    </base-card>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { debounce } from 'lodash'

export default {
  name: 'Users',
  data() {
    return {
      columns: [
        'Username',
        'Email',
        'Active',
        { name: '', style: 'width: 1px' }
      ]
    }
  },
  computed: {
    ...mapState('user', { users: 'resources' }),
    search: {
      get() {
        return this.$store.state.user.search
      },
      set(value) {
        this.$store.commit('user/SET_SEARCH', value)
      }
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    fetch() {
      this.$store.dispatch('user/fetchUsers', { search: this.search })
    },
    edit(user) {
      this.$router.push({
        name: 'users-edit',
        params: { id: user.id }
      })
    },
    resetPassword(user) {
      this.$router.push({
        name: 'users-reset-password',
        params: { id: user.id }
      })
    },
    async destroy(user) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      user._deleting = true
      try {
        let response = await this.$store.dispatch('user/destroy', user)
        this.$toasted.success(response.message)
      } catch (error) {
        this.$toasted.error(error.message)
      }
      user._deleting = false
    },
    show(user) {
      this.$router.push({
        name: 'users-show',
        params: { id: user.id }
      })
    }
  },
  watch: {
    search: debounce(function() {
      this.fetch()
    }, 500)
  }
}
</script>
