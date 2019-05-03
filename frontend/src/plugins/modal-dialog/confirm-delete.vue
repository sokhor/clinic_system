<template>
  <div class="bg-white rounded shadow-lg">
    <div
      class="w-full flex flex-row items-center justify-between mb-3 border-b"
    >
      <h4 class="inline text-gray-600 text-base font-bold py-1 pl-3">
        <span class="text-red-500 mr-2 text-2xl">
          <i class="fas fa-exclamation-triangle"></i>
        </span>
        <span>{{ title }}</span>
      </h4>
      <a
        href="#"
        @click.prevent="$close(noValue)"
        class="inline-block mr-3 text-center text-gray-300 hover:text-gray-500"
      >
        <i class="fas fa-times"></i>
      </a>
    </div>
    <div class="p-3 text-base" style="min-width: 300px;">
      <span>{{ content }}</span>
    </div>
    <footer class="flex items-center justify-end p-3">
      <base-button flat color="primary" @click="$close(noValue)" class="px-5">
        {{ no }}
      </base-button>
      <base-button color="danger" @click="$close(yesValue)" class="ml-2">
        {{ yes }}
      </base-button>
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
