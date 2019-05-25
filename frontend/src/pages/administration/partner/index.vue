<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between mb-6">
      <base-title>Companies</base-title>
      <base-button color="primary" @click="$router.push('/companies/create')">
        New
      </base-button>
    </div>
    <base-card>
      <base-card-wrap>
        <base-input v-model="search" placeholder="Search ..." class="w-64" />
      </base-card-wrap>
      <base-table :columns="columns" :records="companies">
        <template slot-scope="{ record: company }">
          <td>{{ company.company_name_kh }}</td>
          <td>{{ company.company_name_en }}</td>
          <td>{{ company.telephone }}</td>
          <td>{{ company.mobilephone }}</td>
          <td>{{ company.email }}</td>
          <td>{{ company.website }}</td>
          <td class="flex">
            <base-button
              icon
              color="primary"
              title="Edit company"
              class="mr-4"
              @click="edit(company)"
            >
              <i class="fas fa-edit"></i>
            </base-button>
            <base-button
              icon
              color="danger"
              title="Delete company"
              @click="destroy(company)"
              :waiting="{ state: company._deleting, hideText: true }"
            >
              <i class="fas fa-trash"></i>
            </base-button>
          </td>
        </template>
      </base-table>
    </base-card>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { debounce } from 'lodash'

export default {
  name: 'Companies',
  data() {
    return {
      columns: [
        'Name (KH)',
        'Name (EN)',
        'Telephone',
        'Mobilephone',
        'Email',
        'Website',
        { name: '', style: 'width: 1px' }
      ]
    }
  },
  computed: {
    ...mapState('administration/company', { companies: 'resources' }),
    search: {
      get() {
        return this.$store.state.administration.company.search
      },
      set(value) {
        this.$store.commit('administration/company/SET_SEARCH', value)
      }
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    fetch() {
      this.$store.dispatch('administration/company/fetchCompanies', {
        search: this.search
      })
    },
    edit(company) {
      this.$router.push({
        name: 'companies-edit',
        params: { id: company.id }
      })
    },
    resetPassword(company) {
      this.$router.push({
        name: 'companies-reset-password',
        params: { id: company.id }
      })
    },
    async destroy(company) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      company._deleting = true
      try {
        let response = await this.$store.dispatch(
          'administration/company/deleteCompany',
          company
        )
        this.$toasted.success(response.message)
      } catch (error) {
        this.$toasted.error(error.message)
      }
      company._deleting = false
    },
    show(company) {
      this.$router.push({
        name: 'companies-show',
        params: { id: company.id }
      })
    }
  },
  watch: {
    search: debounce(function() {
      this.fetch()
    }, 500)
  }
}
</script>
