<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-gray-900 text-xl font-bold">Product</h1>
      <BaseButton color="accent" @click="$router.push('/products/create')"
        >Create Product</BaseButton
      >
    </div>
    <BaseCard>
      <div class="p-4 flex">
        <input
          type="text"
          class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-64"
          v-model="search"
          placeholder="Search..."
        />
        <div class="flex-auto"></div>
        <BaseButton outline sm>
          <i class="fas fa-filter"></i>
        </BaseButton>
      </div>
      <BaseTable>
        <BaseThead>
          <BaseTh>Product Name</BaseTh>
          <BaseTh>Product Code</BaseTh>
          <BaseTh class="w-1"></BaseTh>
        </BaseThead>
        <BaseTbody>
          <BaseTr v-for="product in products">
            <BaseTd>{{ product.product_name }}</BaseTd>
            <BaseTd>{{ product.product_code }}</BaseTd>
            <BaseTd class="w-1">
              <BaseButton
                flat
                color="primary"
                title="Edit"
                @click="$router.push(`/products/${product.id}`)"
              >
                <i class="fas fa-edit"></i>
              </BaseButton>
              <div class="flex">
                <BaseButton
                  flat
                  color="primary"
                  title="View"
                  class="ml-4"
                  @click="$router.push(`/products/${product.id}/edit`)"
                >
                  <i class="fas fa-eye"></i>
                </BaseButton>
              </div>
            </BaseTd>
          </BaseTr>
        </BaseTbody>
      </BaseTable>
    </BaseCard>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { debounce } from 'lodash'

export default {
  name: 'Products',
  data() {
    return {
      loading: true,
      search: ''
    }
  },
  computed: {
    ...mapState('inventory/products', { products: 'resources' })
  },
  created() {
    this.list()
  },
  methods: {
    list() {
      this.loading = true

      this.$store
        .dispatch('inventory/products/list')
        .then(() => (this.loading = false))
    }
  },
  watch: {
    search: debounce(function(search) {
      this.loading = true

      this.$store
        .dispatch('inventory/products/list', { search: this.search })
        .then(() => (this.loading = false))
    }, 500)
  }
}
</script>
