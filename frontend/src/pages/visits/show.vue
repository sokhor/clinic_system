<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light mr-2" to="/visits">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Patient Visit
      </h1>
    </div>
    <BaseCard class="p-4">
      <div class="flex flex-col justify-center items-center">
        <svg class="shadow-inner p-1 h-32 w-32 rounded-full fill-current text-grey-dark" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><circle cx="16" cy="7.5" r="7.4"></circle><path d="M16,18C7.7,18,1,24.3,1,32h30C31,24.3,24.3,18,16,18z"></path></svg>
        <h3>Chea Bonnak (PA1)</h3>
        <span>32 yrs, M</span>
        <span class="font-semibold">5th visit (2016-08-08)</span>
      </div>
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">
        Personal Data
      </h3>
      <div class="flex -mx-4">
        <div class="w-2/5 p-4">
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Marital Status</BaseLabel>
            <div class="w-3/5">
              <select class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full">
                <option value="">--Choose--</option>
                <option value="1">Single</option>
                <option value="2">Married</option>
                <option value="3">Divorced</option>
              </select>
            </div>
          </div>
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Number of Children</BaseLabel>
            <div class="w-3/5">
              <BaseInput/>
            </div>
          </div>
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Occupation</BaseLabel>
            <div class="w-3/5">
              <BaseInput/>
            </div>
          </div>
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Weight</BaseLabel>
            <div class="w-3/5">
              <BaseInput/>
            </div>
          </div>
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Height</BaseLabel>
            <div class="w-3/5">
              <BaseInput/>
            </div>
          </div>
        </div>
        <div class="w-2/5 p-4">
          <div class="flex items-start mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Smoking</BaseLabel>
            <div class="w-3/5">
              <div class="flex w-full">
                <BaseRadio v-model="radio" :value="true">Yes</BaseRadio>
                <BaseInput
                  class="ml-2"
                  placeholder="How many packages per day?"
                />
              </div>
              <BaseRadio v-model="radio" :value="false">No</BaseRadio>
            </div>
          </div>
          <div class="flex items-start mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Alcoholic</BaseLabel>
            <div class="w-3/5">
              <div class="flex w-full">
                <BaseRadio v-model="radio" :value="true">Yes</BaseRadio>
                <BaseInput
                  class="ml-2"
                  placeholder="How much per day?"
                />
              </div>
              <BaseRadio v-model="radio" :value="false">No</BaseRadio>
            </div>
          </div>
        </div>
      </div>
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">
        Patient Complaint
      </h3>
      <div class="flex">
        <div class="w-full p-4">
          <div class="flex items-start mb-3">
            <textarea
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              rows="5"
            ></textarea>
          </div>
        </div>
      </div>
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">
        Vital Sign
      </h3>
      <div class="flex -mx-4">
        <div class="w-2/5 p-4">
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Blood Pressure</BaseLabel>
            <div class="w-3/5 flex">
              <BaseInput class="mr-1" placeholder="Systolic"/>
              <BaseInput class="ml-1" placeholder="Diastolic"/>
            </div>
          </div>
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Pulse</BaseLabel>
            <div class="w-3/5">
              <BaseInput/>
            </div>
          </div>
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Temperature</BaseLabel>
            <div class="w-3/5">
              <BaseInput/>
            </div>
          </div>
        </div>
        <div class="w-2/5 p-4">
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">Respiratory Rate</BaseLabel>
            <div class="w-3/5">
              <BaseInput/>
            </div>
          </div>
          <div class="flex items-center mb-3">
            <BaseLabel class="w-2/5 text-right pr-6">PSO2</BaseLabel>
            <div class="w-3/5">
              <BaseInput v-model="form.pso2"/>
            </div>
          </div>
        </div>
      </div>
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">
        ANC Note
      </h3>
      <div class="flex">
        <div class="w-full p-4">
          <div class="flex items-start mb-3">
            <textarea
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              rows="5"
            ></textarea>
          </div>
        </div>
      </div>
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">
        Note
      </h3>
      <div class="flex">
        <div class="w-full p-4">
          <div class="flex items-start mb-3">
            <textarea
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              rows="5"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-end p-4">
        <BaseButton color="primary" :waiting="saving">
          Save
        </BaseButton>
      </div>
    </BaseCard>
  </div>
</template>

<script>
export default {
  name: 'VisitShow',
  props: ['patient'],
  data() {
    return {
      radio: false,
      form: {
        pso2: '44'
      },
      saving: false
    }
  }
}
</script>
