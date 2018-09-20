<template>
  <BaseTable>
    <BaseThead>
      <BaseTh>Id</BaseTh>
      <BaseTh>Name</BaseTh>
      <BaseTh class="w-1"></BaseTh>
    </BaseThead>
    <BaseTbody>
      <BaseTr v-for="role in userRoles" :key="role.id">
        <BaseTd>{{ role.id }}</BaseTd>
        <BaseTd>{{ role.name }}</BaseTd>
        <BaseTd class="flex">
          <BaseButton flat color="danger" title="Delete role" :waiting="role._deleting" @click="destroy(role)">
            <i class="fas fa-trash" v-if="!role._deleting"></i>
          </BaseButton>
        </BaseTd>
      </BaseTr>
    </BaseTbody>
  </BaseTable>
</template>

<script>
export default {
  name: 'UserRoles',
  props: ['roles'],
  data() {
    return {
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
      } catch (e) {}
      role._deleting = false
    }
  }
}
</script>
