<template>
    <div class="text-center pb-5">
        <h1 class="text-xl bold text-gray-900">{{ title }}</h1>
        <h2 class="text-md text-gray-700">{{ location }}</h2>
        <h3 class="text-sm text-gray-700">{{ timeString }}</h3>
        <hr class="mt-5" />
    </div>
</template>

<script>
import { title, location, timeString } from "@/settings";

export default {
    name: "TheHeader",
    data() {
        return {
            title,
            location,
            timeString,
        };
    },
};
</script>

<style scoped></style>
