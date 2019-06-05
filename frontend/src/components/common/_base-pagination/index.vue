<template>
  <div class="paging">
    <PerPage :value="perPage" @change="onChangePerPage" />
    <NavPaging
      :lastPage="lastPage"
      :currentPage="currentPage"
      @navigate="navigate"
    />
  </div>
</template>

<script>
import NavPaging from './NavPaging.vue'
import PerPage from './PerPage.vue'

export default {
  name: 'TsPagination',
  components: {
    NavPaging,
    PerPage
  },
  props: {
    value: {
      required: true
    }
  },
  data() {
    return {
      currentPage: null,
      from: null,
      to: null,
      lastPage: null,
      perPage: null,
      total: null,
      loading: false
    }
  },
  watch: {
    value: function(value) {
      this.setData(value)
    }
  },
  created() {
    this.setData(this.value)
  },
  methods: {
    navigate(page) {
      this.$emit('navigate', {
        page,
        perPage: this.perPage
      })
    },
    onChangePerPage(perPage) {
      this.currentPage = 1
      this.$emit('navigate', {
        page: this.currentPage,
        perPage
      })
    },
    setData(paging) {
      if (paging != null) {
        this.currentPage = paging.currentPage
        this.from = paging.from
        this.to = paging.to
        this.lastPage = paging.lastPage
        this.perPage = paging.perPage
        this.total = paging.total
      }
    }
  }
}
</script>
