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
          <BaseButton class="mr-2" flat color="primary" title="View role" @click="show(role)">
            <i class="fas fa-eye"></i>
          </BaseButton>
          <BaseButton class="mr-2" flat color="primary" title="Edit role" @click="edit(role)">
            <i class="fas fa-edit"></i>
          </BaseButton>
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
  }
}
</script>
