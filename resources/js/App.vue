<template>
  <div class="container mx-auto py-5">
    <div class="">
      <h1>{{ title }}</h1>
      <h2>{{ location }} - {{timeString}}</h2>
    </div>
    <div class="mt-3" v-if="!isMemberValidated">
      <p>Selecione seu nome e preencha sua data de nascimento</p>
      <div class="mt-1">
        <select name="member" id="member" v-model="member">
          <option disabled selected hidden>Selecione</option>
          <option :value="member" v-for="member in members">{{member.name}}</option>
        </select>
        <em v-if="member && member.dob" class="text-gray-300 italic">{{member.dob}}</em>
      </div>
      <div class="mt-1">
        <input type="text" v-model="dob" placeholder="YYYY-MM-DD">
      </div>
      <div class="mt-1">
        <button @click="validateMember" class="bg-gray-800 hover:bg-gray-400 text-white font-bold py-2 px-4">Próximo &gt;</button>
      </div>
    </div>
    <div v-if="isMemberValidated" class="mt-3">
      <p>Selecione os candidatos em quem deseja votar. Você pode escolher até {{maxAllowedCandidates}}.</p>
      <div v-for="candidate in candidates" class="mt-3">
        <label :for="candidate.id + candidate.name">
          <input type="checkbox" :id="candidate.id + candidate.name" :value="candidate.id" v-model="vote"/>
          {{candidate.name}}
        </label>
      </div>
      <div class="mt-3">
        <button @click="sendVote" class="bg-gray-800 hover:bg-gray-400 text-white font-bold py-2 px-4">Votar</button>
      </div>
    </div>
  </div>
</template>

<script>
import {title, location, timeString, votesPerMember, candidates} from "@/settings";
import {members} from "@/members";

export default {
  name: "Index.vue",
  data() {
    return {
      title, location, timeString, votesPerMember, candidates, members,
      member: "Selecione",
      dob: null,
      isMemberValidated: false,
      vote: []
    }
  },
  computed: {
    maxAllowedCandidates() {
      let maxNumVotes = 0;
      if (!this.votesPerMember) {
        maxNumVotes = this.candidates.length;
      }
      return `${maxNumVotes} candidato${maxNumVotes > 1 ? 's' : ''}`
    }
  },
  methods: {
    validateMember() {
      if (this.dob === this.member?.dob) {
        this.isMemberValidated = true;
      }
    },
    sendVote() {

    }
  }
}
</script>

<style scoped>

</style>