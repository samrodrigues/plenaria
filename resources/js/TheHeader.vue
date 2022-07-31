<template>
  <div class="text-center">
    <h1 class="text-xl">{{ title }}</h1>
    <h2 class="text-lg">{{ location }} - {{timeString}}</h2>
  </div>
</template>

<script>
import {title, location, timeString} from "@/settings";

export default {
  name: "TheHeader",
  data() {
    return {
      title, location, timeString,
    }
  },
}
</script>

<style scoped>

</style>