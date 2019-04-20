<template>
  <router-link
    tag="li"
    :to="url"
    disabled
    class="nav-item nav-dropdown block no-underline"
  >
    <div
      @click.prevent="handleClick"
      class="group nav-link nav-dropdown-toggle relative block px-4 py-3 text-white font-hairline hover:text-white hover:bg-blue"
      :class="{ 'nav-dropdown-toggle__open': dropdownOpen }"
    >
      <i
        :class="icon"
        class="inline-block w-6 text-blue-200 opacity-50 group-hover:text-white"
      ></i>
      {{ name }}
    </div>
    <ul
      class="nav-dropdown-items list-reset ml-2"
      :class="{ 'nav-dropdown-items__open': dropdownOpen }"
    >
      <slot></slot>
    </ul>
  </router-link>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: ''
    },
    url: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      dropdownOpen: false
    }
  },
  methods: {
    handleClick() {
      this.dropdownOpen = !this.dropdownOpen
    }
  }
}
</script>

<style lang="scss">
.nav-item {
  .nav-link {
    cursor: pointer;

    &.nav-dropdown-toggle {
      &:before {
        position: absolute;
        top: 50%;
        right: 1rem;
        display: block;
        width: 8px;
        height: 8px;
        padding: 0;
        margin-top: -4px;
        content: '';
        background-image: url(data:image/svg+xml;charset=utf8;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAxMSAxNCc+PHBhdGggZmlsbD0nIzczODE4ZicgZD0nTTkuMTQ4IDIuMzUybC00LjE0OCA0LjE0OCA0LjE0OCA0LjE0OHEwLjE0OCAwLjE0OCAwLjE0OCAwLjM1MnQtMC4xNDggMC4zNTJsLTEuMjk3IDEuMjk3cS0wLjE0OCAwLjE0OC0wLjM1MiAwLjE0OHQtMC4zNTItMC4xNDhsLTUuNzk3LTUuNzk3cS0wLjE0OC0wLjE0OC0wLjE0OC0wLjM1MnQwLjE0OC0wLjM1Mmw1Ljc5Ny01Ljc5N3EwLjE0OC0wLjE0OCAwLjM1Mi0wLjE0OHQwLjM1MiAwLjE0OGwxLjI5NyAxLjI5N3EwLjE0OCAwLjE0OCAwLjE0OCAwLjM1MnQtMC4xNDggMC4zNTJ6Jy8+PC9zdmc+);
        background-repeat: no-repeat;
        background-position: 50%;
        transition: transform 0.3s;
      }
    }

    &:hover.nav-dropdown-toggle:before {
      background-image: url(data:image/svg+xml;charset=utf8;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAxMSAxNCc+PHBhdGggZmlsbD0nI2ZmZicgZD0nTTkuMTQ4IDIuMzUybC00LjE0OCA0LjE0OCA0LjE0OCA0LjE0OHEwLjE0OCAwLjE0OCAwLjE0OCAwLjM1MnQtMC4xNDggMC4zNTJsLTEuMjk3IDEuMjk3cS0wLjE0OCAwLjE0OC0wLjM1MiAwLjE0OHQtMC4zNTItMC4xNDhsLTUuNzk3LTUuNzk3cS0wLjE0OC0wLjE0OC0wLjE0OC0wLjM1MnQwLjE0OC0wLjM1Mmw1Ljc5Ny01Ljc5N3EwLjE0OC0wLjE0OCAwLjM1Mi0wLjE0OHQwLjM1MiAwLjE0OGwxLjI5NyAxLjI5N3EwLjE0OCAwLjE0OCAwLjE0OCAwLjM1MnQtMC4xNDggMC4zNTJ6Jy8+PC9zdmc+);
    }

    &.nav-dropdown-toggle__open:before {
      transform: rotate(-90deg);
    }
  }

  // &.nav-dropdown {
  //   &__open {
  //     .nav-dropdown-toggle {
  //       &:before {
  //         transform: rotate(-90deg);
  //       }
  //     }
  //   }
  // }
}

.nav-dropdown-items {
  display: none;
  // opacity: 0;
  height: 0;
  transition: all 0.5s ease;

  &__open {
    display: block;
    // opacity: 1;
    height: 100%;
  }
}
</style>

<style lang="scss">
.slide-down-enter-active {
  transition: all 0.5s ease;
}
.slide-down-leave-active {
  transition: all 0.5s ease;
}
.slide-down-enter,
.slide-down-leave-to {
  transform: translateY(-100%);
}
</style>
