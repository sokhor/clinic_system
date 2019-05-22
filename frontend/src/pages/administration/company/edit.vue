<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between mb-6">
      <base-title>
        <router-link class="text-blue-500 hover:text-blue-400" to="/companies">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Edit Company
      </base-title>
      <base-button
        color="danger"
        @click="destroy"
        :waiting="{ state: deleting, hideText: true }"
      >
        <i class="fas fa-trash"></i>
      </base-button>
    </div>
    <base-card class="p-4">
      <form>
        <div class="flex">
          <div class="w-1/2">
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8">
                Name (KH)
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.company_name_kh" />
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                Name (EN)
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.company_name_en" />
                <base-validation-text v-if="errors.has('company_name_en')">
                  {{ errors.first('company_name_en') }}
                </base-validation-text>
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8">
                Type of Business
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.type_of_business" />
              </div>
            </div>
          </div>
          <div class="w-1/2">
            <div class="flex justify-center p-4">
              <base-image-input
                class="logo-input"
                :file="companyPhoto"
                width="100"
                height="100"
                @input="image => (form.logo = image)"
              ></base-image-input>
            </div>
          </div>
        </div>
        <h3
          class="text-gray-500 font-semibold py-2 mb-2 border-b border-gray-200 text-xs uppercase"
        >
          Contact
        </h3>
        <div class="flex">
          <div class="w-1/2">
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                Telephone
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.telephone" />
                <base-validation-text v-if="errors.has('telephone')">
                  {{ errors.first('telephone') }}
                </base-validation-text>
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8">
                Mobile
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.mobilephone" />
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8">
                Email
              </base-label>
              <div class="w-3/5">
                <base-input type="email" v-model="form.email" />
              </div>
            </div>
          </div>
          <div class="w-1/2">
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8">
                Website
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.website" />
              </div>
            </div>
          </div>
        </div>
        <h3
          class="text-gray-500 font-semibold py-2 mb-2 border-b border-gray-200 text-xs uppercase"
        >
          Address
        </h3>
        <div class="flex">
          <div class="w-1/2">
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                Province
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.province" />
                <base-validation-text v-if="errors.has('province')">
                  {{ errors.first('province') }}
                </base-validation-text>
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                District
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.district" />
                <base-validation-text v-if="errors.has('district')">
                  {{ errors.first('district') }}
                </base-validation-text>
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                Commune
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.commune" />
                <base-validation-text v-if="errors.has('commune')">
                  {{ errors.first('commune') }}
                </base-validation-text>
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                Village
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.village" />
                <base-validation-text v-if="errors.has('village')">
                  {{ errors.first('village') }}
                </base-validation-text>
              </div>
            </div>
          </div>
          <div class="w-1/2">
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                Building
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.building" />
                <base-validation-text v-if="errors.has('building')">
                  {{ errors.first('building') }}
                </base-validation-text>
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8 required">
                Street
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.street" />
                <base-validation-text v-if="errors.has('street')">
                  {{ errors.first('street') }}
                </base-validation-text>
              </div>
            </div>
            <div class="flex items-baseline p-4">
              <base-label class="w-2/5 text-right pr-8">
                Postcode
              </base-label>
              <div class="w-3/5">
                <base-input v-model="form.postcode" />
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button
            class="mr-1"
            color="primary"
            :waiting="saving"
            @click="save"
          >
            Save Change
          </base-button>
        </div>
      </form>
    </base-card>
  </div>
</template>

<script>
import { Errors } from 'form-backend-validation'
import { downloadLogo } from '@/api/administration/companies'

export default {
  name: 'UserEdit',
  props: {
    companyProp: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        company_name_kh: null,
        company_name_en: null,
        logo: null,
        type_of_business: null,
        telephone: null,
        mobilephone: null,
        email: null,
        website: null,
        postcode: null,
        building: null,
        street: null,
        village: null,
        commune: null,
        district: null,
        province: null
      },
      saving: false,
      deleting: false,
      errors: new Errors(),
      companyPhoto: null
    }
  },
  created() {
    for (let key in this.form) {
      this.form[key] = this.companyProp[key]
    }

    downloadLogo(this.companyProp.id).then(imageUrl => {
      this.companyPhoto = imageUrl
    })
  },
  methods: {
    async save() {
      this.errors.clear()

      this.saving = true

      try {
        let response = await this.$store.dispatch(
          'administration/company/editCompany',
          {
            id: this.companyProp.id,
            ...this.form
          }
        )
        this.$toasted.success(response.message)
        this.$router.push('/companies')
      } catch (error) {
        console.log(error)
        if (error.errors !== undefined) {
          this.errors = new Errors(error.errors)
        }

        this.$toasted.error(error.message)
      }
      this.saving = false
    },
    async destroy() {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      this.deleting = true
      try {
        let response = await this.$store.dispatch(
          'administration/company/deleteCompany',
          this.userProp
        )
        this.$toasted.success(response.message)
        this.$router.push('/companies')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.deleting = false
    }
  }
}
</script>

<style lang="sass" scoped>
.logo-input
  justify-content: start
</style>
