<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between mb-6">
      <base-title>
        <router-link class="text-blue-500 hover:text-blue-400" to="/users">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / User Detail
      </base-title>
      <div>
        <base-button color="primary" @click="edit" class="mr-2">
          <i class="fas fa-edit"></i>
        </base-button>
        <base-button
          color="danger"
          @click="destroy"
          :waiting="{ state: deleting, hideText: true }"
        >
          <i class="fas fa-trash"></i>
        </base-button>
      </div>
    </div>
    <base-card>
      <div class="flex items-baseline p-4">
        <base-label class="w-1/5">
          Username
        </base-label>
        <span class="w-2/5">
          {{ user.username }}
        </span>
      </div>
      <div class="flex items-baseline p-4">
        <base-label class="w-1/5">
          Email
        </base-label>
        <span class="w-2/5">
          {{ user.email }}
        </span>
      </div>
      <div class="flex items-baseline p-4">
        <base-label class="w-1/5">
          Active
        </base-label>
        <span class="w-2/5">
          <div
            class="w-3 h-3 bg-green-500 rounded-full border-2 border-green-300"
            v-if="user.active"
          ></div>
          <div
            class="w-3 h-3 bg-red-500 rounded-full border-2 border-red-300"
            v-else
          ></div>
        </span>
      </div>
    </base-card>
    <div class="w-full flex flex-row items-end justify-between mb-6 mt-10">
      <base-title>Roles</base-title>
      <base-button color="primary" @click="attachRole">
        Attach Role
      </base-button>
    </div>
    <base-card>
      <user-roles />
    </base-card>
  </div>
</template>

<script>
import UserRoles from './user-roles.vue'
import AttachRole from './attach-role.vue'
import { mapState } from 'vuex'

export default {
  name: 'UserShow',
  components: { UserRoles, AttachRole },
  props: {
    userProp: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      deleting: false
    }
  },
  computed: {
    ...mapState('user', ['user'])
  },
  beforeMount() {
    this.$store.commit('user/SET_USER', this.userProp)
  },
  methods: {
    edit() {
      this.$router.push({
        name: 'users-edit',
        params: { id: this.user.id }
      })
    },
    async destroy() {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      this.deleting = true
      try {
        let response = await this.$store.dispatch('user/deleteUser', this.user)
        this.$toasted.success(response.message)
        this.$router.push('/users')
      } catch (error) {
        this.$toasted.error(error)
      }
      this.deleting = false
    },
    attachRole() {
      this.$modal.show(
        AttachRole,
        {},
        {
          width: 300,
          height: 'auto'
        }
      )
    }
  }
}
</script>
