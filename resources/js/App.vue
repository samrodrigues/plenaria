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
        <input type="number" v-model="dob.day" placeholder="DD" min="1" max="31">
        <input type="number" v-model="dob.month" placeholder="MM" min="1" max="12">
        <input type="number" v-model="dob.year" placeholder="YYYY" min="1900" max="2100">
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
import { v5 as uuidv5 } from 'uuid';
import {title, location, timeString, votesPerMember, candidates, UUID_NAMESPACE} from "@/settings";
import {members} from "@/members";

export default {
  name: "Index.vue",
  data() {
    return {
      title, location, timeString, votesPerMember, candidates, members,
      member: "Selecione",
      dob: {
        day: null,
        month: null,
        year: null,
      },
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
    },
  },
  methods: {
    getDob() {
      const formattedDob = `${this.dob.year}-${('0'+this.dob.month).slice(-2)}-${('0'+this.dob.day).slice(-2)}`
      console.log(formattedDob);
      return formattedDob;
    },
    validateMember() {
      if (this.getDob() === this.member?.dob) {
        this.isMemberValidated = true;
      }
    },
    sendVote() {
      const vote = {
        hash: uuidv5(`${this.member.name}${this.member.dob}`, UUID_NAMESPACE),
        voteList: [...this.vote]
      };
      try {
        axios.post('/api/vote', vote)
      }
      catch(e) {

      }
    }
  }
}
</script>

<style scoped>

</style>