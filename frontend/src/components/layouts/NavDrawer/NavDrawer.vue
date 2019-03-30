<template>
  <transition name="slide-fade">
    <simplebar class="planner-scrollbar" data-simplebar-auto-hide="true" ref="simple-scrollbar">
      <div class="drawer bg-blue-darkest shadow">
        <SidebarHeader/>
        <SidebarForm/>
        <nav class="drawer-nav text-white">
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
    </simplebar>
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
import simplebar from '@/components/simple-scrollbar.vue'

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
    SidebarNavItem,
    simplebar
  },
  data() {
    return {
      navItems: [
        {
          name: 'Dashboard',
          url: '/',
          icon: 'fas fa-tachometer-alt'
        },
        {
          name: 'Reception',
          title: true,
          class: '',
          wrapper: {
            element: '',
            attributes: {}
          }
        },
        {
          name: 'Queue',
          icon: 'far fa-list-alt',
          children: [
            {
              name: 'Setup',
              url: '/queue-setup',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'List',
              url: '/queues',
              icon: 'fas fa-caret-right'
            }
          ]
        },
        {
          name: 'Visit',
          url: '/visits',
          icon: 'fas fa-walking',
          badge: {
            color: 'red',
            text: '10'
          }
        },
        {
          name: 'Appointment',
          url: '/appointments',
          icon: 'fas fa-calendar-check',
          badge: {
            color: 'red',
            text: '5'
          }
        },
        {
          name: 'Patient',
          url: '/patients',
          icon: 'fas fa-bed'
        },
        {
          name: 'Treatement',
          title: true,
          class: '',
          wrapper: {
            element: '',
            attributes: {}
          }
        },
        {
          name: 'Nurse',
          url: '/nurses',
          icon: 'fas fa-notes-medical'
        },
        {
          name: 'Doctor',
          url: '/doctors',
          icon: 'fas fa-user-md'
        },
        {
          name: 'Laboratory',
          url: '/laboratories',
          icon: 'fas fa-flask'
        },
        {
          name: 'Pharmacist',
          url: '/pharmacists',
          icon: 'fas fa-syringe'
        },
        {
          name: 'Inventory',
          title: true,
          class: '',
          wrapper: {
            element: '',
            attributes: {}
          }
        },
        {
          name: 'Warehouse',
          url: '/warehouses',
          icon: 'fas fa-warehouse'
        },
        {
          name: 'Product',
          url: '/products',
          icon: 'fas fa-box'
        },
        {
          name: 'Stock',
          icon: 'fas fa-boxes',
          children: [
            {
              name: 'Stock In',
              url: '/stockins',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'Stock Out',
              url: '/stockins',
              icon: 'fas fa-caret-right'
            }
          ]
        },
        {
          name: 'Purchase Order',
          url: '/purchases',
          icon: 'fas fa-shopping-cart'
        },
        {
          name: 'Corporation',
          title: true,
          class: '',
          wrapper: {
            element: '',
            attributes: {}
          }
        },
        {
          name: 'Partner',
          url: '/partners',
          icon: 'fas fa-handshake'
        },
        {
          name: 'Service',
          url: '/services',
          icon: 'fas fa-concierge-bell'
        },
        {
          name: 'Administration',
          title: true,
          class: '',
          wrapper: {
            element: '',
            attributes: {}
          }
        },
        {
          name: 'Authorization',
          icon: 'fas fa-user',
          children: [
            {
              name: 'Roles',
              url: '/roles',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'Users',
              url: '/users',
              icon: 'fas fa-caret-right'
            }
          ]
        },
        {
          name: 'Accomodation',
          icon: 'fas fa-clinic-medical',
          children: [
            {
              name: 'Wards',
              url: '/wards',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'Buildings',
              url: '/buildings',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'Room',
              url: '/rooms',
              icon: 'fas fa-caret-right'
            }
          ]
        },
        {
          name: 'Company',
          url: '/company',
          icon: 'fas fa-building'
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
