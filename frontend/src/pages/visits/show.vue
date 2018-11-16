<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Visit History</h1>
    </div>
    <div class="p-4 flex justify-center">
      <BaseCard class="flex justify-center items-center p-2">
        <svg class="h-32 w-32 rounded-full fill-current text-grey-dark" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><circle cx="16" cy="7.5" r="7.4"></circle><path d="M16,18C7.7,18,1,24.3,1,32h30C31,24.3,24.3,18,16,18z"></path></svg>
      </BaseCard>
    </div>
    <BaseCard>
      <div
        v-for="(visit, index) in patient.visits"
        :key="visit.id"
        class="w-full flex cursor-pointer group hover:bg-grey-lightest p-3"
        :class="{'border-b': index < patient.visits.length - 1}"
      >
        <div class="text-sm flex flex-grow items-center justify-center">
          <p class="flex-1">
            {{ visit.created_at }}
          </p>
          <p class="flex-1">
            {{ visit.status_text }}
          </p>
          <p class="flex-1">
            {{ visit.type_text }}
          </p>
          <div class="flex-shrink">
            <a href="#"><i class="fas fa-chevron-down"></i></a>
          </div>
        </div>
      </div>
    </BaseCard>
  </div>
</template>

<script>
export default {
  name: 'VisitShow',
  props: ['patient'],
}
</script>