<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between mb-6">
      <base-title>
        My Company
      </base-title>
    </div>
    <form>
      <div class="w-1/2 mx-auto">
        <h3 class="text-gray-500 font-semibold mb-4 text-base">
          Company details
        </h3>
        <div class="flex mb-10">
          <base-card class="p-4 border-t-4 border-blue-500">
            <div class="flex -mx-2">
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    Name (KH)
                  </base-label>
                  <div>
                    <base-input v-model="form.company_name_kh" />
                  </div>
                </div>
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    Name (EN)
                  </base-label>
                  <div>
                    <base-input v-model="form.company_name_en" />
                    <base-validation-text v-if="errors.has('company_name_en')">
                      {{ errors.first('company_name_en') }}
                    </base-validation-text>
                  </div>
                </div>
              </div>
              <div class="w-1/2 px-2">
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
            <div class="flex -mx-2">
              <div class="flex flex-col mb-5 w-1/2 px-2">
                <base-label class="mb-1">
                  Type of Business
                </base-label>
                <div>
                  <base-input v-model="form.type_of_business" />
                </div>
              </div>
              <div class="flex flex-col mb-5 w-1/2 px-2">
                <base-label class="mb-1">
                  Website
                </base-label>
                <div>
                  <base-input v-model="form.website" />
                </div>
              </div>
            </div>
          </base-card>
        </div>
        <h3 class="text-gray-500 font-semibold mb-4 text-base">
          Contact
        </h3>
        <div class="flex mb-10">
          <base-card class="p-4 border-t-4 border-blue-500">
            <div class="flex -mx-2">
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    Telephone
                  </base-label>
                  <div>
                    <base-input v-model="form.telephone" />
                    <base-validation-text v-if="errors.has('telephone')">
                      {{ errors.first('telephone') }}
                    </base-validation-text>
                  </div>
                </div>
              </div>
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1">
                    Mobile
                  </base-label>
                  <div>
                    <base-input v-model="form.mobilephone" />
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-col mb-5">
              <base-label class="mb-1">
                Email
              </base-label>
              <div>
                <base-input type="email" v-model="form.email" />
              </div>
            </div>
          </base-card>
        </div>
        <h3 class="text-gray-500 font-semibold mb-4 text-base">
          Address
        </h3>
        <div class="flex mb-5">
          <base-card class="p-4 border-t-4 border-blue-500">
            <div class="flex -mx-2">
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    Province/City
                  </base-label>
                  <div>
                    <base-select v-model="form.province" :options="provinces" />
                    <base-validation-text v-if="errors.has('province')">
                      {{ errors.first('province') }}
                    </base-validation-text>
                  </div>
                </div>
              </div>
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    District
                  </base-label>
                  <div>
                    <base-select v-model="form.district" :options="districts" />
                    <base-validation-text v-if="errors.has('district')">
                      {{ errors.first('district') }}
                    </base-validation-text>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex -mx-2">
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    Commune
                  </base-label>
                  <div>
                    <base-select v-model="form.commune" :options="communes" />
                    <base-validation-text v-if="errors.has('commune')">
                      {{ errors.first('commune') }}
                    </base-validation-text>
                  </div>
                </div>
              </div>
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    Village
                  </base-label>
                  <div>
                    <base-select v-model="form.village" :options="villages" />
                    <base-validation-text v-if="errors.has('village')">
                      {{ errors.first('village') }}
                    </base-validation-text>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex -mx-2">
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1 required">
                    Building &amp; street
                  </base-label>
                  <div>
                    <base-input v-model="form.street" />
                    <base-validation-text v-if="errors.has('street')">
                      {{ errors.first('street') }}
                    </base-validation-text>
                  </div>
                </div>
              </div>
              <div class="w-1/2 px-2">
                <div class="flex flex-col mb-5">
                  <base-label class="mb-1">
                    Postcode
                  </base-label>
                  <div>
                    <base-input v-model="form.postcode" />
                  </div>
                </div>
              </div>
            </div>
          </base-card>
        </div>
        <div class="flex items-center justify-end">
          <base-button color="primary" :waiting="saving" @click="save">
            Save
          </base-button>
        </div>
      </div>
    </form>
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
  computed: {
    provinces() {
      return this.$store.state.provinces.map(province => {
        return {
          value: province.province_code,
          text: province.province_en
        }
      })
    },
    districts() {
      return this.$store.getters
        .districtsByProvince(this.form.province)
        .map(district => {
          return {
            value: district.id,
            text: district.district_en
          }
        })
    },
    communes() {
      return this.$store.getters
        .communesByDistict(parseInt(this.form.district))
        .map(commune => {
          return {
            value: commune.id,
            text: commune.commune_en
          }
        })
    },
    villages() {
      return this.$store.getters
        .villagesByCommune(parseInt(this.form.commune))
        .map(village => {
          return {
            value: village.id,
            text: village.village_en
          }
        })
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
