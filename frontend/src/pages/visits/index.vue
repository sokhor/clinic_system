<template>
  <div class="w-full">
    <div class="flex -mx-4">
      <div class="w-1/3 p-4">
        <base-card class="bg-red-light">
          <div class="flex relative">
            <div class="flex flex-col items-center p-6">
              <span class="uppercase text-white font-semibold text-sm tracking-wide opacity-75">Today Visits</span>
              <span class="uppercase text-white font-semibold text-5xl tracking-wide">10</span>
            </div>
            <span class="flex-grow text-5xl opacity-25 absolute pin-r mr-4" style="font-size: 5rem;">
              <i class="fas fa-walking"></i>
            </span>
          </div>
        </base-card>
      </div>
      <div class="w-1/3 p-4">
        <base-card class="bg-orange-light">
          <div class="flex relative">
            <div class="flex flex-col items-center p-6">
              <span class="uppercase text-white font-semibold text-sm tracking-wide opacity-75">Total Queues</span>
              <span class="uppercase text-white font-semibold text-5xl tracking-wide">7</span>
            </div>
            <span class="flex-grow text-5xl opacity-25 absolute pin-r mr-4" style="font-size: 5rem;">
              <i class="fas fa-clipboard-list"></i>
            </span>
          </div>
        </base-card>
      </div>
      <div class="w-1/3 p-4">
        <base-card class="bg-teal-light">
          <div class="flex relative">
            <div class="flex flex-col items-center p-6">
              <span class="uppercase text-white font-semibold text-sm tracking-wide opacity-75">Total In-progresses</span>
              <span class="uppercase text-white font-semibold text-5xl tracking-wide">3</span>
            </div>
            <span class="flex-grow text-5xl opacity-25 absolute pin-r mr-4" style="font-size: 5rem;">
              <i class="fas fa-signal"></i>
            </span>
          </div>
        </base-card>
      </div>
    </div>
    <div class="flex -mx-4">
      <div class="w-2/3 p-4">
        <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
          <h1 class="inline text-grey-darkest text-xl font-bold">Visit</h1>
        </div>
        <base-card>
          <div class="p-4 flex">
            <input
              type="text"
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-64"
              v-model="search"
              placeholder="Search..."
            />
            <div class="flex-auto"></div>
            <BaseButton outline sm>
              <i class="fas fa-filter"></i>
            </BaseButton>
          </div>
          <base-table>
            <base-thead>
              <base-th>Visit ID</base-th>
              <base-th>Patient Code</base-th>
              <base-th>Patient Name</base-th>
              <base-th>Progress</base-th>
              <base-th>IPD/OPD</base-th>
            </base-thead>
            <base-tbody>
              <base-tr v-for="visit in visits" :key="visit.id">
                <base-td>{{ visit.id }}</base-td>
                <base-td>{{ visit.patient.code }}</base-td>
                <base-td>{{ visit.patient.full_name }}</base-td>
                <base-td>{{ visit.progress_text}}</base-td>
                <base-td>{{ visit.ipd ? 'IPD' : 'OPD' }}</base-td>
              </base-tr>
            </base-tbody>
          </base-table>
        </base-card>
      </div>
      <div class="w-1/3 p-4">
        <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
          <h1 class="inline text-grey-darkest text-xl font-bold">Queue</h1>
        </div>
        <base-card>
          <ul class="list-reset">
            <li class="p-4" :class="{'border-b': index+1<7}" v-for="(n, index) in 7">
              <span class="text-xl font-semibold">001</span>
            </li>
          </ul>
        </base-card>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'Visits',
  data() {
    return {
      search: ''
    }
  },
  computed: {
    ...mapState('visits', { visits: 'resources' })
  },
  created() {
    this.fetchVisits()
  },
  methods: {
    ...mapActions('visits', { fetchVisits: 'list' }),
    view(visit) {
      this.$router.push(`/visits/${visit.id}`)
    }
  }
}
</script>
