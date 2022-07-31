<template>
  <div class="container mx-auto py-5 px-3">
    <TheHeader />
    <AppCheckIn v-if="status === 0" @validated="onValidated"/>
    <AppVote v-if="status === 1" @confirmed="onConfirmed" :member="member"/>
    <AppConfirmation v-if="status > 1" :status="status"/>
  </div>
</template>

<script>
import TheHeader from "./TheHeader.vue";
import AppCheckIn from "./AppCheckIn.vue";
import AppVote from "./AppVote.vue";
import AppConfirmation from "./AppConfirmation.vue";

export default {
  name: "Index.vue",
  components: {AppConfirmation, AppVote, AppCheckIn, TheHeader},
  data() {
    return {
      status: 0,
      member: null,
    }
  },
  methods: {
    onConfirmed(status) {
      this.status = status;
    },
    onValidated(member) {
      this.status = 1;
      this.member = member;
    },
  }
}
</script>

<style scoped>

</style>