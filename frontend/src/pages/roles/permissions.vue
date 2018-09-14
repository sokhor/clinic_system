<template>
  <BaseCard>
    <div class="flex items-baseline p-4 border-b border-white-grey" v-for="(abilities, module) in modules">
      <span class="block text-grey-darker text-sm font-bold w-1/5">
        {{ module }}
      </span>
      <ul class="list-reset">
        <li v-for="ability in abilities" :key="ability.id">
          <base-checkbox
            v-model="selectedAbilities"
            :value="ability.name"
          >
            {{ ability.title }}
          </base-checkbox>
        </li>
      </ul>
    </div>
  </BaseCard>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import { groupBy, flatten } from 'lodash'

export default {
  name: 'Permissions',
  props: {
    abilitiesProp: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      selectedAbilities: flatten(this.abilitiesProp.map(ab => ab.name))
    }
  },
  computed: {
    ...mapState('abilities', ['abilities']),
    modules() {
      return groupBy(this.abilities, 'module')
    }
  },
  watch: {
    selectedAbilities(abilities) {
      this.$emit('input', abilities)
    }
  }
}
</script>
