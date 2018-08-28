<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">User</h1>
    </div>
    <div class="w-full p-4 bg-white shadow">
      <table class="table w-full">
        <thead>
          <th class="p-2 uppercase text-sm text-left text-grey-darker font-semibold border-b-2 border-grey-lighter">Id</th>
          <th class="p-2 uppercase text-sm text-left text-grey-darker font-semibold border-b-2 border-grey-lighter">Username</th>
          <th class="p-2 uppercase text-sm text-left text-grey-darker font-semibold border-b-2 border-grey-lighter">Active</th>
        </thead>
        <tbody>
          <tr class="hover:bg-grey-lightest">
            <td class="p-2 border-t border-grey-lighter">1</td>
            <td class="p-2 border-t border-grey-lighter">bonnak</td>
            <td class="p-2 border-t border-grey-lighter">true</td>
          </tr>
          <tr class="hover:bg-grey-lightest">
            <td class="p-2 border-t border-grey-lighter">2</td>
            <td class="p-2 border-t border-grey-lighter">bonna</td>
            <td class="p-2 border-t border-grey-lighter">true</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'User'
}
</script>
