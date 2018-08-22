<template>
  <div class="w-full h-full flex flex-col items-center justify-center">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-xs">
      <div class="mb-4">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
          Username
        </label>
        <input class="shadow form-input" id="username" type="text">
      </div>
      <div class="mb-6">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input class="shadow form-input" id="password" type="password">
        <!-- <p class="text-red text-xs italic">Please choose a password.</p> -->
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
          Sign In
        </button>
      </div>
    </form>
    <p class="text-center text-grey text-xs">
      ©2018 Acme Corp. All rights reserved.
    </p>
  </div>
</template>

<script>
export default {
  name: 'Login'
}
</script>