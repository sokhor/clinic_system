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
      navItems: [
        {
          name: 'Dashboard',
          url: '/',
          icon: 'fas fa-tachometer-alt'
        },
        {
          name: 'Queues',
          url: '/queues',
          icon: 'far fa-list-alt'
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
          name: 'Registration',
          url: '/patients/create',
          icon: 'fab fa-accessible-icon'
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
          name: 'Patient',
          url: '/patients',
          icon: 'fas fa-bed'
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
          name: 'Service',
          url: '/services',
          icon: 'fas fa-bolt'
        },
        {
          name: 'Employee',
          url: '/employees',
          icon: 'fas fa-people-carry'
        },
        {
          name: 'Partner',
          url: '/partners',
          icon: 'fas fa-handshake'
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
              name: 'Unit',
              url: '/units',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'Sub-unit',
              url: '/sub-units',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'Room & material',
              url: '/rooms',
              icon: 'fas fa-caret-right'
            },
            {
              name: 'Bed',
              url: '/beds',
              icon: 'fas fa-caret-right'
            }
          ]
        },
        {
          name: 'Company',
          url: '/company',
          icon: 'fas fa-building'
        },
        {
          name: 'Queue Setup',
          url: '/queue-setup',
          icon: 'far fa-list-alt'
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
