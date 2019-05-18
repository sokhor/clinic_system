export default [
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
    url: '/companies',
    icon: 'fas fa-building'
  },
  {
    name: 'Queue Setup',
    url: '/queue-setup',
    icon: 'far fa-list-alt'
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
  }
]
