<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between pb-6">
      <base-title>Roles</base-title>
      <base-button color="primary" @click="$router.push('/roles/create')">
        New Role
      </base-button>
    </div>
    <base-card>
      <base-card-wrap>
        <base-input v-model="search" placeholder="Search ..." class="w-64" />
      </base-card-wrap>
      <base-table :columns="columns" :records="roles">
        <template slot-scope="{ record: role }">
          <td>{{ role.title }}</td>
          <td class="flex">
            <a
              href="#"
              class="text-blue-500 hover:text-blue-600 mr-3"
              title="Edit role"
              @click.prevent="edit(role)"
            >
              <i class="fas fa-edit"></i>
            </a>
            <a
              href="#"
              class="text-red-500 hover:text-red-600"
              title="Delete role"
              @click.prevent="destroy(role)"
              :waiting="role._deleting"
            >
              <i class="fas fa-trash" v-if="!role._deleting"></i>
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
  name: 'Roles',
  data() {
    return {
      columns: ['Name', { name: '', style: 'width: 1px;' }],
    }
  },
  computed: {
    ...mapState('role', { roles: 'resources' }),
    search: {
      get() {
        return this.$store.state.role.search
      },
      set(value) {
        this.$store.commit('role/SET_SEARCH', value)
      }
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    fetch() {
      this.$store.dispatch('role/get', { search: this.search })
    },
    edit(role) {
      this.$router.push({
        name: 'roles-edit',
        params: { id: role.id }
      })
    },
    async destroy(role) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }
      
      role._deleting = true
      try {
        let response = await this.$store.dispatch('role/destroy', role)
        this.$toasted.success(response.message)
      } catch (error) {
        this.$toasted.error(error.message)
      }
      role._deleting = false
    }
  },
  watch: {
    search: debounce(function() {
      this.fetch()
    }, 500)
  }
}
</script>
