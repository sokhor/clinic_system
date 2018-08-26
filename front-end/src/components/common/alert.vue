<template>
  <div class="border-l-4 p-4" :class="[classList]" role="alert">
    <p>
      <slot></slot>
    </p>
  </div>
</template>

<script>
export default {
  name: "Alert",
  props: {
    type: {
      type: String,
      default: ""
    }
  },
  computed: {
    classList() {
      if (this.type.toLowerCase().trim() === "danger") {
        return {
          "bg-red-lightest": true,
          "border-red": true,
          "text-red-dark": true
        };
      } else if (this.type.toLowerCase().trim() === "warning") {
        return {
          "bg-orange-lightest": true,
          "border-orange": true,
          "text-orange-dark": true
        };
      } else if (this.type.toLowerCase().trim() === "info") {
        return {
          "bg-blue-lightest": true,
          "border-blue": true,
          "text-blue-dark": true
        };
      } else if (this.type.toLowerCase().trim() === "success") {
        return {
          "bg-green-lightest": true,
          "border-green": true,
          "text-green-dark": true
        };
      } else {
        return {
          "bg-grey-lightest": true,
          "border-grey": true,
          "text-grey-dark": true
        };
      }
    }
  }
};
</script>
