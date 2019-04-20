<template>
  <div class="drawer bg-nav-drawer shadow">
    <NavHeader />
    <NavForm />
    <nav class="drawer-nav text-white">
      <div slot="header"></div>
      <ul class="nav list-reset">
        <template v-for="(item, index) in navItems">
          <template v-if="item.title">
            <NavTitle
              :name="item.name"
              :classes="item.class"
              :wrapper="item.wrapper"
              :key="index"
            />
          </template>
          <template v-else-if="item.divider">
            <NavDivider :classes="item.class" :key="index" />
          </template>
          <template v-else>
            <template v-if="item.children">
              <!-- First level dropdown -->
              <NavDropdown
                :name="item.name"
                :url="item.url"
                :icon="item.icon"
                :key="index"
              >
                <template v-for="(childL1, index) in item.children">
                  <template v-if="childL1.children">
                    <!-- Second level dropdown -->
                    <NavDropdown
                      :name="childL1.name"
                      :url="childL1.url"
                      :icon="childL1.icon"
                      :key="index"
                    >
                      <li
                        class="nav-item"
                        v-for="(childL2, index) in childL1.children"
                        :key="index"
                      >
                        <NavLink
                          :name="childL2.name"
                          :url="childL2.url"
                          :icon="childL2.icon"
                          :badge="childL2.badge"
                          :variant="item.variant"
                        />
                      </li>
                    </NavDropdown>
                  </template>
                  <template v-else>
                    <NavItem :classes="item.class" :key="index">
                      <NavLink
                        :name="childL1.name"
                        :url="childL1.url"
                        :icon="childL1.icon"
                        :badge="childL1.badge"
                        :variant="item.variant"
                      />
                    </NavItem>
                  </template>
                </template>
              </NavDropdown>
            </template>
            <template v-else>
              <NavItem :classes="item.class" :key="index">
                <NavLink
                  :name="item.name"
                  :url="item.url"
                  :icon="item.icon"
                  :badge="item.badge"
                  :variant="item.variant"
                />
              </NavItem>
            </template>
          </template>
        </template>
      </ul>
      <slot></slot>
    </nav>
    <NavFooter />
    <NavMinimizer />
  </div>
</template>

<script>
import NavFooter from './nav-footer'
import NavForm from './nav-form'
import NavHeader from './nav-header'
import NavMinimizer from './nav-minimizer'
import NavDivider from './nav-divider'
import NavDropdown from './nav-dropdown'
import NavLink from './nav-link'
import NavTitle from './nav-title'
import NavItem from './nav-item'
import navigations from '@/data/navigations'

export default {
  name: 'nav-drawer',
  components: {
    NavFooter,
    NavForm,
    NavHeader,
    NavMinimizer,
    NavDivider,
    NavDropdown,
    NavLink,
    NavTitle,
    NavItem
  },
  data() {
    return {
      navItems: navigations
    }
  },
  methods: {
    handleClick(e) {
      e.preventDefault()
      e.target.parentElement.classList.toggle('open')
    }
  }
}
</script>

<style lang="scss">
.drawer {
  min-width: 200px;
}
.slide-fade-enter-active {
  transition: all 0.5s ease;
}
.slide-fade-leave-active {
  transition: all 0.5s ease;
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(-100%);
}
</style>
