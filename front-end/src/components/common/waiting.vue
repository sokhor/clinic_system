<style scoped>
.spin {
  animation: spin 1s linear infinite;
}
@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>

<template>
    <span class="fas fa-spinner spin" aria-hidden="true"></span>
</template>

<script>
export default {
  name: "waiting"
};
</script>
