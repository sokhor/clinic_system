<template>
  <base-table :records="userRoles" :columns="columns">
    <template slot-scope="{ record: role }">
      <td>{{ role.name }}</td>
      <td class="flex">
        <base-button
          flat
          size="sm"
          color="danger"
          title="Delete role"
          :waiting="{ state: role._deleting, hideText: true }"
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
      userRoles: this.roles.map(role =>
        Object.assign({}, role, { _deleting: false })
      )
    }
  },
  methods: {
    async destroy(role) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      role._deleting = true
      try {
        let response = await this.$store.dispatch('user/detachRoles', {
          id: this.$route.params.id,
          roles: [role.name]
        })
        this.$toasted.success(response.message)
        this.userRoles.splice(this.userRoles.indexOf(role), 1)
      } catch (error) {
        this.$toasted.error(error.message)
      }
      // role._deleting = false
    }
  }
}
</script>
