<template>
  <transition name="slide-fade">
    <div class="drawer relative bg-white shadow">
      <SidebarHeader/>
      <SidebarForm/>
      <nav class="drawer-nav text-grey-dark">
        <div slot="header"></div>
        <ul class="nav list-reset">
          <template v-for="(item, index) in navItems">
            <template v-if="item.title">
              <SidebarNavTitle :name="item.name" :classes="item.class" :wrapper="item.wrapper" :key="index"/>
            </template>
            <template v-else-if="item.divider">
              <SidebarNavDivider :classes="item.class" :key="index"/>
            </template>
            <template v-else>
              <template v-if="item.children">
                <!-- First level dropdown -->
                <SidebarNavDropdown :name="item.name" :url="item.url" :icon="item.icon" :key="index">
                  <template v-for="(childL1, index) in item.children">
                    <template v-if="childL1.children">
                      <!-- Second level dropdown -->
                      <SidebarNavDropdown :name="childL1.name" :url="childL1.url" :icon="childL1.icon" :key="index">
                        <li class="nav-item" v-for="(childL2, index) in childL1.children" :key="index">
                          <SidebarNavLink :name="childL2.name" :url="childL2.url" :icon="childL2.icon" :badge="childL2.badge" :variant="item.variant"/>
                        </li>
                      </SidebarNavDropdown>
                    </template>
                    <template v-else>
                      <SidebarNavItem :classes="item.class" :key="index">
                        <SidebarNavLink :name="childL1.name" :url="childL1.url" :icon="childL1.icon" :badge="childL1.badge" :variant="item.variant"/>
                      </SidebarNavItem>
                    </template>
                  </template>
                </SidebarNavDropdown>
              </template>
              <template v-else>
                <SidebarNavItem :classes="item.class" :key="index">
                  <SidebarNavLink :name="item.name" :url="item.url" :icon="item.icon" :badge="item.badge" :variant="item.variant"/>
                </SidebarNavItem>
              </template>
            </template>
          </template>
        </ul>
        <slot></slot>
      </nav>
      <SidebarFooter/>
      <SidebarMinimizer/>
    </div>
  </transition>
</template>
<script>
import SidebarFooter from './SidebarFooter'
import SidebarForm from './SidebarForm'
import SidebarHeader from './SidebarHeader'
import SidebarMinimizer from './SidebarMinimizer'
import SidebarNavDivider from './SidebarNavDivider'
import SidebarNavDropdown from './SidebarNavDropdown'
import SidebarNavLink from './SidebarNavLink'
import SidebarNavTitle from './SidebarNavTitle'
import SidebarNavItem from './SidebarNavItem'
export default {
  name: 'sidebar',
  components: {
    SidebarFooter,
    SidebarForm,
    SidebarHeader,
    SidebarMinimizer,
    SidebarNavDivider,
    SidebarNavDropdown,
    SidebarNavLink,
    SidebarNavTitle,
    SidebarNavItem
  },
  data() {
    return {
      navItems: [
        {
          name: 'Dashboard',
          url: '/',
          icon: 'fas fa-tachometer-alt',
          badge: {
            variant: 'primary',
            text: 'NEW'
          }
        },
        {
          title: true,
          name: 'Administration',
          class: '',
          wrapper: {
            element: '',
            attributes: {}
          }
        },
        {
          name: 'Passport',
          url: '/passport',
          icon: 'fas fa-passport'
        },
        {
          name: 'Users',
          url: '/users',
          icon: 'fas fa-user'
        }
      ]
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
