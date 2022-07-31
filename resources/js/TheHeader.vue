<template>
  <div class="text-center pb-5">
    <h1 class="text-xl bold">{{ title }}</h1>
    <h2 class="text-md">{{ location }}</h2>
    <h3 class="text-sm">{{timeString}}</h3>
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