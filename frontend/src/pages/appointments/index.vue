<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Appointment</h1>
    </div>
    <div class="flex -mx-4">
      <div class="w-5/7 px-4">
        <base-card class="p-4">
          <calendar-planner
            :events="appointments.map(el => ({date: el.appointed_at, text: `${$moment(el.appointed_at, 'DD-MM-YYYY HH:mm:ss').format('HH:mm')} ${el.subject}`}))"
            @add-new-event="addEvent"
          />
        </base-card>
      </div>
      <div class="w-2/7 px-4">
        <base-button color="primary" @click="addEvent()">Make appointment</base-button>
        <div class="mt-8">
          <h4 class="text-grey-darkest mb-2">Up coming</h4>
          <base-card class="p-4">
            <ul class="list-reset">
              <li v-for="appointment in upcomingAppointments" class="leading-loose">
                <span class="font-semibold">{{ `${$moment(appointment.appointed_at, 'DD-MM-YYYY HH:mm:ss').format('HH:mm')}` }}</span>
                &nbsp;-&nbsp;
                <span>{{ `${appointment.subject}` }}</span>
              </li>
            </ul>
          </base-card>
        </div>
      </div>
    </div>
    <modal name="new-appointment-modal" height="auto" @before-close="beforeModalClose">
      <new-appointment
        :date="selectedDate"
        :doctors="doctors"
        :patients="patients"
        @appointment-created="onAppointmentCreated"
      />
    </modal>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import CalendarPlanner from '@/components/planner/index.vue'
import NewAppointment from './new-appointment.vue'
import httpClient from '@/http-client'

let doctors = [],
  patients = []

export default {
  name: 'Appointment',
  beforeRouteEnter(to, from, next) {
    Promise.all([
      httpClient.get('/api/appointments/doctors'),
      httpClient.get('/api/appointments/patients')
    ]).then(responses => {
      doctors = responses[0].data
      patients = responses[1].data
      next()
    })
  },
  components: { CalendarPlanner, NewAppointment },
  data() {
    return {
      selectedDate: null,
      loading: false
    }
  },
  computed: {
    ...mapState('appointments', { appointments: 'resources' }),
    doctors: () => doctors,
    patients: () => patients,
    upcomingAppointments() {
      return this.appointments.filter(appointment => {
        return (
          this.$moment().isSame(
            this.$moment(appointment.appointed_at, 'DD-MM-YYYY HH:mm:ss'),
            'day'
          ) &&
          this.$moment().isBefore(
            this.$moment(appointment.appointed_at, 'DD-MM-YYYY HH:mm:ss'),
            'second'
          )
        )
      })
    }
  },
  created() {
    this.listAppointments()
  },
  methods: {
    listAppointments() {
      this.loading = true

      this.$store
        .dispatch('appointments/list')
        .then(() => (this.loading = false))
    },
    addEvent(date) {
      this.selectedDate = date
      this.$modal.show('new-appointment-modal')
    },
    onAppointmentCreated() {
      this.listAppointments()
      this.$modal.hide('new-appointment-modal')
    },
    beforeModalClose() {
      this.selectedDate = this.$moment()
    }
  }
}
</script>
