<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-gray-900 text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/users"
          ><i class="fas fa-arrow-left"></i
        ></router-link>
        / User Details
      </h1>
      <div>
        <BaseButton sm color="primary" title="Edit user" @click="edit(user)">
          <i class="fas fa-edit"></i>
        </BaseButton>
        <BaseButton
          sm
          color="danger"
          title="Delete user"
          :waiting="user._deleting"
          @click="destroy(user)"
          class="ml-2"
        >
          <i class="fas fa-trash" v-if="!user._deleting"></i>
        </BaseButton>
      </div>
    </div>
    <BaseCard>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Username
        </BaseLabel>
        <span class="w-2/5">
          {{ user.username }}
        </span>
      </div>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Email
        </BaseLabel>
        <span class="w-2/5">
          {{ user.email }}
        </span>
      </div>
      <div class="flex items-baseline p-4 border-b border-white-grey">
        <BaseLabel class="w-1/5">
          Active
        </BaseLabel>
        <span class="w-2/5">
          <div
            class="w-3 h-3 bg-green rounded-full border-2 border-green-lighter"
            v-if="user.active"
          ></div>
          <div
            class="w-3 h-3 bg-red rounded-full border-2 border-red-lighter"
            v-else
          ></div>
        </span>
      </div>
    </BaseCard>
    <div
      class="w-full flex flex-row items-center justify-between pt-4 pb-6 mt-6"
    >
      <h1 class="inline text-gray-900 text-xl font-bold">Roles</h1>
      <BaseButton color="primary" @click="attachRole(user)">
        Attach Role
      </BaseButton>
    </div>
    <BaseCard>
      <UserRoles :roles="user.roles" />
    </BaseCard>
  </div>
</template>

<script>
import httpClient from '@/http-client'
import UserRoles from './user-roles.vue'

export default {
  name: 'UserView',
  async beforeRouteEnter(to, from, next) {
    if (to.params.user === undefined) {
      let response = await httpClient.get(
        `/api/users/${to.params.id}`,
        {},
        { showProgressBar: true }
      )
      to.params.user = response.data.data
    }
    next()
  },
  components: { UserRoles },
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  methods: {
    edit(user) {
      this.$router.push({
        name: 'users-edit',
        params: { id: user.id, user: user }
      })
    },
    async destroy(user) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      user._deleting = true
      try {
        await this.$store.dispatch('users/deleteUser', user)
        this.$router.push('/users')
      } catch (e) {}
      user._deleting = false
    },
    attachRole(user) {
      this.$router.push({
        name: 'users-attach-roles',
        params: { id: user.id, user: user }
      })
    }
  }
}
</script>
