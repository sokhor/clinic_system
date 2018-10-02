<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Users</h1>
      <BaseButton color="accent" @click="$router.push('/users/create')">Create User</BaseButton>
    </div>
    <BaseCard>
      <BaseTable>
        <BaseThead>
          <BaseTh>Id</BaseTh>
          <BaseTh>Username</BaseTh>
          <BaseTh>Email</BaseTh>
          <BaseTh>Active</BaseTh>
          <BaseTh>Created At</BaseTh>
          <BaseTh class="w-1"></BaseTh>
        </BaseThead>
        <BaseTbody>
          <BaseTr v-for="user in users" :key="user.id">
            <BaseTd>{{ user.id }}</BaseTd>
            <BaseTd>{{ user.username }}</BaseTd>
            <BaseTd>{{ user.email }}</BaseTd>
            <BaseTd>
              <div class="w-3 h-3 bg-green rounded-full border-2 border-green-lighter" v-if="user.active"></div>
              <div class="w-3 h-3 bg-red rounded-full border-2 border-red-lighter" v-else></div>
            </BaseTd>
            <BaseTd>{{ user.created_at }}</BaseTd>
            <BaseTd class="flex">
              <BaseButton class="mr-2" flat color="primary" title="View user" @click="show(user)">
                <i class="fas fa-eye"></i>
              </BaseButton>
              <BaseButton class="mr-2" flat color="primary" title="Edit user" @click="edit(user)">
                <i class="fas fa-edit"></i>
              </BaseButton>
              <BaseButton class="mr-2" flat color="primary" title="Reset password" @click="resetPassword(user)">
                <i class="fas fa-key"></i>
              </BaseButton>
              <BaseButton flat color="danger" title="Delete user" :waiting="user._deleting" @click="deleteUser(user)">
                <i class="fas fa-trash" v-if="!user._deleting"></i>
              </BaseButton>
            </BaseTd>
          </BaseTr>
        </BaseTbody>
      </BaseTable>
    </BaseCard>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'Users',
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
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      user._deleting = true
      try {
        await this.$store.dispatch('users/deleteUser', user)
        this.fetchUsers()
        this.$toasted.success('User deleted successfully')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      user._deleting = false
    },
    show(user) {
      this.$router.push({
        name: 'users-show',
        params: { id: user.id, user: user }
      })
    }
  }
}
</script>
