<template>
  <div class="bg-white rounded">
    <div class="w-full flex flex-row items-center justify-between p-3 mb-3 border-b border-white-grey">
      <h4 class="inline text-grey-darkest text-base font-bold">
        <span class="text-red mr-2 text-2xl"><i class="fas fa-exclamation-triangle"></i></span>
        <span>{{ title }}</span>
      </h4>
      <base-button flat @click="$close(noValue)"><i class="fas fa-times"></i></base-button>
    </div>
    <div class="p-3 text-base" style="min-width: 300px;">
      <span>{{ content }}</span>
    </div>
    <footer class="flex items-center justify-end p-3">
      <base-button flat color="primary" @click="$close(noValue)" class="px-5">{{ no }}</base-button>
      <base-button color="danger" @click="$close(yesValue)" class="ml-2">{{ yes }}</base-button>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'Confirm',
  props: {
    title: String,
    content: String,
    yes: {
      type: String,
      default: 'Yes'
    },
    yesValue: {
      default: true
    },
    no: {
      type: String,
      default: 'No'
    },
    noValue: {
      default: false
    }
  }
}
</script>
