<template>
  <div class="mt-3">
    <p>Selecione os candidatos em quem deseja votar. Você pode escolher até {{maxAllowedCandidates}}.</p>
    <fieldset>
      <legend class="text-lg font-medium text-gray-900">Candidatos</legend>
      <div class="mt-4 border-t border-b border-gray-200 divide-y divide-gray-200">
        <div v-for="(candidate, candidateIdx) in candidates" :key="candidateIdx" class="relative flex items-start py-4">
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
import {votesPerMember, candidates} from "./settings";
import hash from "object-hash";

export default {
  name: "AppVote",
  props: ["member"],
  data() {
    return {
      votesPerMember,
      candidates,
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
    async sendVote() {
      this.loading = true;
      const {name, dob} = this.member;
      const vote = {
        hash: hash.MD5(`${name}${dob}`),
        voteList: [...this.vote]
      };
      try {
        console.log(vote)
        //await axios.post('/api/vote', vote)
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