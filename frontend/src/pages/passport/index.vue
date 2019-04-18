<template>
  <div class="w-full">
    <Clients />
    <AuthorizedClients class="mt-8" />
    <PersonalAccessTokens class="mt-8" />
  </div>
</template>

<script>
import Clients from './clients.vue'
import AuthorizedClients from './authorized-clients.vue'
import PersonalAccessTokens from './personal-access-tokens.vue'

export default {
  name: 'Passport',
  components: { Clients, AuthorizedClients, PersonalAccessTokens }
}
</script>
