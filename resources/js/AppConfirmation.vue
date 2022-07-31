<template>
  <div class="text-center text-xl">
    <div class="" v-if="status === 2">
      <h2>✅</h2>
    </div>
    <div class="" v-if="status === 3">
      <h2>❌</h2>
    </div>
  </div>
</template>

<script>

export default {
  name: "AppConfirmation",
  props: ['status'],

}
</script>

<style scoped>

</style>