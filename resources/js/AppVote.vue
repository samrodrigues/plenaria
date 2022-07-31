<template>
  <div class="mt-3">
    <fieldset v-for="poll in polls" :key="poll.key" class="mt-3">
      <legend class="text-md mt-3 font-medium text-gray-900">{{ poll.title }}</legend>
      <p class="text-sm">Selecione os candidatos em quem deseja votar.<br>Você pode escolher até {{getMaxAllowedCandidates(poll)}}.</p>
      <div class="mt-4 border-t border-b border-gray-200 divide-y divide-gray-200">
        <div v-for="(candidate, candidateIdx) in poll.candidates" :key="candidateIdx" class="relative flex items-start py-4">
          <div class="min-w-0 flex-1 text-sm">
            <label :for="`candidate-${candidate.id}`" class="font-medium text-gray-700 select-none">{{ candidate.name }}</label>
          </div>
          <div class="ml-3 flex items-center h-5">
            <input :id="`candidate-${candidate.id}`" :name="`candidate-${candidate.id}`" v-model="vote" :value="candidate.id" type="checkbox" class="focus:ring-emerald-500 h-4 w-4 text-emerald-600 border-gray-300 rounded" />
          </div>
        </div>
      </div>
    </fieldset>

    <div class="mt-5">
      <button @click="sendVote" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">Confirmar</button>
    </div>
  </div>
</template>

<script>
import {polls} from "./settings";
import hash from "object-hash";

export default {
  name: "AppVote",
  props: ["member"],
  data() {
    return {
      polls,
      vote: []
    }
  },
  methods: {
    getMaxAllowedCandidates(poll) {
      let maxNumVotes = 0;
      if (!poll.votesPerMember) {
        maxNumVotes = poll.candidates.length;
      }
      return `${maxNumVotes} candidato${maxNumVotes > 1 ? 's' : ''}`
    },
    async sendVote() {
      this.loading = true;
      const {name, dob} = this.member;
      const vote = {
        hash: hash.MD5(`${name}${dob}`),
        voteList: [...this.vote]
      };
      try {
        await axios.post('/api/vote', vote)
        this.$emit('confirmed', 2);
        this.loading = false;
      }
      catch(e) {
        this.$emit('confirmed', 3);
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>

</style>