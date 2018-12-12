<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/patients"><i class="fas fa-arrow-left"></i></router-link> / Patient Registration
      </h1>
    </div>
    <div class="flex -mx-2">
      <div class="w-2/6 p-2">
        <BaseCard>1</BaseCard>
      </div>
      <div class="w-4/6 p-2">
        <BaseCard>2</BaseCard>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Patient'
}
</script>