<template>
  <section>
    <div class="flex justify-between">
      <h3>{{ section.name }}</h3>
      <div>
        <base-button flat color="primary" class="mr-3" v-tooltip="'Edit section'"><i class="fas fa-pencil-alt"></i></base-button>
        <base-button flat color="danger" v-tooltip="'Delete section'"><i class="fas fa-trash"></i></base-button>
      </div>
    </div>
    <hr class="border-b border-grey" />
    <div class="flex flex-wrap -mx-2">
      <div v-for="queueCounter in section.counters" class="p-2">
        <queue-counter :counter="queueCounter" />
      </div>
      <div class="p-2">
        <base-button flat class="w-32 h-32 flex justify-center items-center border border-dashed border-grey text-2xl">
          <i class="fas fa-plus"></i>
        </base-button>
      </div>
    </div>
  </section>
</template>

<script>
import QueueCounter from './counter'

export default {
  name: 'QueueSection',
  components: { QueueCounter },
  props: ['section']
}
</script>
