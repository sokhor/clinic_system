<template>
  <base-table :records="userRoles" :columns="columns">
    <template slot-scope="{ record: role }">
      <td>{{ role.name }}</td>
      <td class="flex">
        <base-button
          flat
          color="danger"
          title="Delete role"
          :waiting="role._deleting"
          @click="destroy(role)"
        >
          <i class="fas fa-trash" v-if="!role._deleting"></i>
        </base-button>
      </td>
    </template>
  </base-table>
</template>

<script>
export default {
  name: 'UserRoles',
  props: ['roles'],
  data() {
    return {
      columns: ['Name', { name: '', style: 'width: 1px;' }],
      userRoles: this.roles
    }
  },
  methods: {
    async destroy(role) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      role._deleting = true
      try {
        await this.$store.dispatch('users/detachRoles', {
          userId: this.$route.params.id,
          roles: [role.name]
        })
        this.userRoles.splice(this.userRoles.indexOf(role), 1)
        this.$toasted.success('Role detached successfully')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      role._deleting = false
    }
  }
}
</script>
