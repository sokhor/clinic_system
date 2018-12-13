<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/patients"><i class="fas fa-arrow-left"></i></router-link> / Patient Registration
      </h1>
    </div>
    <div class="flex -mx-4">
      <div class="w-1/4 p-4">
        <BaseCard class="p-4">
          <div class="text-center">
            <BaseUserIcon class="h-32 w-32 rounded-full" />
          </div>
          <div>
            <table class="w-full">
              <tbody class="align-top">
                <tr class="leading-loose">
                  <td class="w-1 pr-5">Name</td>
                  <td class="font-semibold">John Doe</td>
                </tr>
                <tr class="leading-loose">
                  <td class="w-1 pr-5">Code</td>
                  <td class="font-semibold">PA001</td>
                </tr>
                <tr class="leading-loose">
                  <td class="w-1 pr-5">Gender</td>
                  <td class="font-semibold">Male</td>
                </tr>
                <tr class="leading-loose">
                  <td class="w-1 pr-5">Born</td>
                  <td class="font-semibold">
                    <span>12-Feb-1990</span>
                    <BaseBadge color="blue" class="ml-2">28 yrs</BaseBadge>
                  </td>
                </tr>
                <tr class="leading-loose">
                  <td class="w-1 pr-5">Identity</td>
                  <td class="font-semibold">
                    <span>040008655</span>
                    <BaseBadge :color="identityColor(1)" class="ml-2">National ID</BaseBadge>
                  </td>
                </tr>
                <tr class="leading-loose">
                  <td class="w-1 pr-5">Email</td>
                  <td class="font-semibold">john.doe@mail.com</td>
                </tr>
                <tr class="leading-loose">
                  <td class="w-1 pr-5">Address</td>
                  <td class="font-semibold">#23, St 130, Tuol Tumpoung, Chamkarmorn, Phnom Penh</td>
                </tr>
              </tbody>
            </table>
          </div>
        </BaseCard>
      </div>
      <div class="w-3/4 p-4">
        <div>
          <h4 class="mb-3 text-grey-dark font-bold uppercase">Last Visit</h4>
          <BaseCard class="p-4">
            <div class="flex">
              <div class="flex-1">
                <span class="block text-grey-dark leading-loose">Date</span>
                <span>20-Dec-2018</span>
              </div>
              <div class="flex-grow">
                <span class="block text-grey-dark leading-loose">Medication</span>
                <p>Paracetamol 20mg 1 tablet for 3 days during the meal</p>
              </div>
              <div class="flex-1">
                <span class="block text-grey-dark leading-loose">Weight</span>
                <span>50 Kg</span>
              </div>
            </div>
            <div class="flex mt-10">
              <div>
                <span class="block text-grey-dark leading-loose">Note</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar sic tempor. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus pronin sapien nunc accuan eget.</p>
              </div>
            </div>
          </BaseCard>
        </div>
        <div class="mt-10">
          <div class="mb-3 flex justify-between items-end">
            <h4 class="text-grey-dark font-bold uppercase">Medical Record (12)</h4>
            <BaseButton color="primary">New Record</BaseButton>
          </div>
          <BaseCard>
            <div class="mb-5 p-4">
              <input
                type="text"
                class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-64"
                placeholder="Search..."
              />
            </div>
            <ul class="list-reset">
              <li class="py-5 px-4" :class="{'border-b': index < 9-1}" v-for="(n, index) in 9">
                <div class="flex">
                  <div class="flex-1">
                    <span class="block text-grey-dark leading-loose">Date</span>
                    <span>20-Dec-2018</span>
                  </div>
                  <div class="flex-1">
                    <span class="block text-grey-dark leading-loose">Note</span>
                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                  </div>
                  <div class="flex-1">
                    <span class="block text-grey-dark leading-loose">Medication</span>
                    <p>-</p>
                  </div>
                  <div class="flex-1">
                    <span class="block text-grey-dark leading-loose">Weight</span>
                    <span>50 Kg</span>
                  </div>
                  <div class="self-center p-4">
                    <BaseButton
                      flat
                      color="primary"
                      title="View"
                    >
                      <i class="fas fa-eye"></i>
                    </BaseButton>
                  </div>
                </div>
              </li>
            </ul>
          </BaseCard>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Patient',
  computed: {
    identityColor: () => identityType => {
      switch (identityType) {
        case 1:
          return 'green'
        case 2:
          return 'red'
        case 3:
          return 'blue'
      }
    }
  }
}
</script>
